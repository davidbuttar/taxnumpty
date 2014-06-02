'use strict';
// Generic class to process generic tax rules such as applying tax
// at different band and taking into account an allowance
angular.module('taxCalculator', []).factory('processRules',['ukRuleFactory', function(ukRuleFactory) {
  var that = {};

  that.ages = [
    {name:'Under 65', id:'1'},
    {name:'65 - 74', id:'2'},
    {name:'Over 75', id:'3'}
  ];

  // Fetch a list of available rules
  that.ruleSets = ukRuleFactory.getAvailableRules();
  var currentRuleIndex = 0;

  that.selectedAge = that.ages[0];
  that.salary = null;
  that.incomeTax = 0;
  that.taxableIncome = 0;
  that.nationalInsurance = 0;
  that.totalDeductions = 0;
  that.incomeTaxAllowance = 0;
  that.studentLoan = 0;
  that.age = that.selectedAge.id;
  that.student = false;
  that.blind = false;
  that.noNI = false;
  that.married = false;
  that.addAllowance = null;
  that.pension = null;
  that.pensionHMRC = 0;
  that.totalTakeHome = 0;
  that.lastTakeHome = 0;

  function setRuleSet(index){
    currentRuleIndex = index;
    that.ruleSet = that.ruleSets[currentRuleIndex].rules;
    that.ruleSetName = that.ruleSets[currentRuleIndex].name;
    that.prevRuleSet = that.ruleSets[currentRuleIndex+1] ? that.ruleSets[currentRuleIndex+1].rules : false;
  }

  // Set to first and therefore latest rule set by default
  setRuleSet(currentRuleIndex);

  function getIncomeTaxAllowance(yearRules){
    return yearRules[0].allowance(that);
  }

  function calculateIncomeTaxValues(yearRules){
    return that.applyBands(that.salary,
      yearRules[0].bands, getIncomeTaxAllowance(yearRules)) - yearRules[0].relief(that);
  }

  function calculateStudentLoan(yearRules){
    if(yearRules[2].eligible(that)){
      var value = Math.floor(that.applyBands(that.salary, yearRules[2].bands,
        yearRules[2].allowance(that)) / 12 ) * 12 ;
      return value;
    }
    return 0;
  }

  function calculateNationalInsurance(yearRules){
    if(yearRules[1].eligible(that)){
      return that.applyBands(that.salary, yearRules[1].bands);
    }else{
      return 0;
    }
  }

  function calculatePensonHMRC(yearRules, incomeTax){
    if(that.pension){
      return incomeTax - that.applyBands(that.salary,
        yearRules[0].bands, yearRules[0].allowance(that, true)) - yearRules[0].relief(that);
    }else{
      return 0;
    }
  }

  function calculateTaxableIncome(incomeTaxAllowance){
    if(that.salary){
      return Math.max(0, that.salary - incomeTaxAllowance);
    }else{
      return 0;
    }
  }

  function calculateTotalDeductions(){
    that.totalDeductions = that.nationalInsurance + that.incomeTax;
    if(that.studentLoan){
      that.totalDeductions += parseFloat(that.studentLoan);
    }
    if(that.pension){
      that.totalDeductions += parseFloat(that.pension);
    }
  }

  function calculateTakeHome(){
    if(that.salary){
      that.totalTakeHome = parseFloat(that.salary) - that.totalDeductions;
    }else{
      that.totalTakeHome = 0;
    }
  }

  function calculateLastYearsDeductions(){
    var totalDeductions = calculateNationalInsurance(that.prevRuleSet) + calculateIncomeTaxValues(that.prevRuleSet);
    totalDeductions += parseFloat(calculateStudentLoan(that.prevRuleSet));
    if(that.pension){
      totalDeductions += parseFloat(that.pension);
    }
    return totalDeductions;
  }

  function calculateLastYearsTakeHome(){
    if (!that.prevRuleSet){
      return;
    }
    var takeHome = 0;
    if(that.salary){
      takeHome = parseFloat(that.salary) - calculateLastYearsDeductions();
    }else{
      takeHome = 0;
    }
    return takeHome;
  }

  that.setSalary = function(inSalary){
    that.salary = inSalary;
  };

  that.setAge = function(inAge){
    that.age = inAge;
  };

  that.update = function(){
    that.incomeTaxAllowance = getIncomeTaxAllowance(that.ruleSet);
    that.incomeTax = calculateIncomeTaxValues(that.ruleSet);
    that.taxableIncome = calculateTaxableIncome(that.incomeTaxAllowance);
    that.studentLoan = calculateStudentLoan(that.ruleSet);
    that.pensionHMRC = calculatePensonHMRC(that.ruleSet, that.incomeTax);
    that.nationalInsurance = calculateNationalInsurance(that.ruleSet);
    calculateTotalDeductions();
    calculateTakeHome();
    that.lastTakeHome = calculateLastYearsTakeHome();
  };

  // Given a rule name set that rule as the current selected rule.
  that.selectRule = function(name){
    for(var i = 0,ii=that.ruleSets.length; i<ii; i++){
      if(that.ruleSets[i].name === name){
        setRuleSet(i);
        break;
      }
    }
  };
  
  // Apply taxation band to salary, band will have
  // from, to and rate to apply.
  that.applyBand = function(salary, band){
    var maxTaxable = Math.min(band.to, salary);
    var taxable = maxTaxable - band.from;
    // salary not taxable at this band
    if (taxable < 0){
      return 0;
    }
    // apply rate to salary
    return taxable * band.rate/100;
  };

  // Apply several taxation bands.
  that.applyBands = function(salary, bands, allowance){
    var total = 0;
    if(allowance){
      salary = salary - allowance;
    }
    for(var i =0, ii=bands.length; i<ii; i++){
      total += that.applyBand(salary, bands[i]);
    }
    return total;
  };

  return that;
}
]);
