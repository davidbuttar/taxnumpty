'use strict';

angular.module('taxnumptyApp')
  .controller('Calculator',['$scope', 'processRules', 'rulesCollection', function ($scope, processRules, rules) {

    $scope.ages = [
      {name:'Under 65', id:'1'},
      {name:'65 - 74', id:'2'},
      {name:'Over 75', id:'3'}
    ];

    $scope.selectedAge = $scope.ages[0];

    $scope.availableRules = rules;
    $scope.ruleSet = $scope.availableRules.uk201314.rules;

    $scope.salary = null;
    $scope.incomeTax = 0;
    $scope.taxableIncome = 0;
    $scope.nationalInsurance = 0;
    $scope.totalDeductions = 0;
    $scope.incomeTaxAllowance = 0;
    $scope.studentLoan = 0;
    $scope.student = false;
    $scope.age = $scope.selectedAge.id;
    $scope.blind = false;
    $scope.noNI = false;
    $scope.married = false;
    $scope.addAllowance = null;
    $scope.pension = null;
    $scope.pensionHMRC = 0;
    $scope.totalTakeHome = 0;

    function setIncomeTaxValues(){
      $scope.incomeTaxAllowance = $scope.ruleSet[0].allowance($scope);
      $scope.incomeTax = processRules.applyBands($scope.salary,
        $scope.ruleSet[0].bands, $scope.incomeTaxAllowance) - $scope.ruleSet[0].relief($scope);
    }

    function calculateStudentLoan(){
      if($scope.ruleSet[2].eligible($scope)){
        $scope.studentLoan = Math.round(processRules.applyBands($scope.salary, $scope.ruleSet[2].bands,
          $scope.ruleSet[2].allowance($scope)));
      }else{
        $scope.studentLoan = 0;
      }
    }

    function calculateNationalInsurance(){
      if($scope.ruleSet[1].eligible($scope)){
        $scope.nationalInsurance = processRules.applyBands($scope.salary, $scope.ruleSet[1].bands);
      }else{
        $scope.nationalInsurance = 0;
      }
    }

    function calculatePensonHMRC(){
      if($scope.pension){
        $scope.pensionHMRC = $scope.incomeTax - processRules.applyBands($scope.salary,
        $scope.ruleSet[0].bands, $scope.ruleSet[0].allowance($scope, true)) - $scope.ruleSet[0].relief($scope);
      }else{
        $scope.pensionHMRC = 0;
      }
    }

    function calculateTaxableIncome(){
      if($scope.salary){
        $scope.taxableIncome = Math.max(0, $scope.salary - $scope.incomeTaxAllowance);
      }else{
        $scope.taxableIncome = 0;
      }
    }

    function calculateTotalDeductions(){
      $scope.totalDeductions = $scope.nationalInsurance + $scope.incomeTax;
      if($scope.studentLoan){
        $scope.totalDeductions += parseFloat($scope.studentLoan);
      }
      if($scope.pension){
        $scope.totalDeductions += parseFloat($scope.pension);
      }
    }

    function calculateTakeHome(){
      if($scope.salary){
        $scope.totalTakeHome = parseFloat($scope.salary) - $scope.totalDeductions;
      }else{
        $scope.totalTakeHome = 0;
      }
    }


    $scope.$watchCollection('[salary, selectedAge, student, blind, noNI, married, addAllowance, pension]', function() {
      $scope.age = $scope.selectedAge.id;
      setIncomeTaxValues();
      calculateTaxableIncome();
      calculateStudentLoan();
      calculatePensonHMRC();
      calculateNationalInsurance();
      calculateTotalDeductions();
      calculateTakeHome();
    });

  }]);
