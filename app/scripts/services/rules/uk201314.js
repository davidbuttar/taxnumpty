'use strict';
// Generic class to process generic tax rules such as applying tax
// at different band and taking into account an allowance
angular.module('taxCalculatorRules', []).factory('uk201314', function() {
  var that = {};
  var taxTypes = [{
    name : 'Income Tax',
    id:'Tax',
    allowance : function(opts) { // should just be getAllowance
      var salary = opts.salary;
      var ageOpts = opts.age;
      var allowance = 9440;
      if(ageOpts == 2 || ageOpts == 3){
        var localAllowance = ageOpts == 2 ? 10500 : 10660;
        var localDeduction = Math.max(0,((salary - 26100) * 0.5));
        if (localDeduction > (localAllowance - allowance)) {
          allowance = allowance;
        } else {
          allowance = localAllowance - localDeduction;
        }
      }
      if(opts.blind){
        allowance = allowance + 2160;
      }
      var deduction = ((salary - 100000) * 0.5);
      if (deduction > allowance) {
        return 0;
      } else if (salary >= 100001) {
        return allowance - deduction;
      } else
      return allowance;
    },
    bands : [{
      from : 0,
      to : 32010,
      rate : 20
    }, {
      from : 32010,
      to : 150000,
      rate : 40
    }, {
      from : 150001,
      to : Infinity,
      rate : 45
    }]
    ,relief:function(opts){
        //calculate any tax relief on this tax this person is due
        var salary = opts.salary;
        var ageOpts = opts.age;
        var married = opts.married;
        if(!married || (ageOpts != 2 && ageOpts != 3)){
          return 0;
        }else{
          var relief = 7915;
          if(salary>=28540){
            relief = Math.max(3040, relief - ((salary - 28540)/2))
          }
          return relief/10;
        }
      }
    }, {
      name : 'National Insurance',
      id:'nationalInsurance',
      allowance : function(){ return 0; },
      skip : function(opts){
        if(opts.age == 2 || opts.age == 3) return true;
      },
      bands : [{
        from : 7748,
        to : 41444,
        rate : 12
      }, {
        from : 41444,
        to : Infinity,
        rate : 2
      }]
    }, {
      allowance : function(){ return 16365; },
      skip : function(opts){return !opts.student;},
      name : 'Student Loan',
      id:'studentLoan',
      bands : [{
        from : 0,
        to : Infinity,
        rate : 9
      }]
    }];

  return taxTypes;

});
