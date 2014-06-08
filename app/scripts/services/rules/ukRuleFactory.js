'use strict';
// Generic class to process generic tax rules such as applying tax
// at different band and taking into account an allowance
angular.module('taxCalculator').factory('ukRuleFactory', function () {
  var that = {};

  // General function to produce uk tax rules for given parameters
  function generateTaxYear(yearName, opts){
    opts = opts || {};
    var taxAllowance = opts.incomeTaxAllowance || 9440;
    var marriedAllowance = opts.marriedAllowance || 7915;
    var marriedAllowanceMin = opts.marriedAllowanceMin || 3040;
    var incomeLimit1945 = opts.incomeLimit1945 || 26100;
    var blindAllowance =  opts.blindAllowance || 2160;
    var incomeTaxBands = opts.incomeTaxBands || [{
      from: 0,
      to: 32010,
      rate: 20
    },
      {
        from: 32010,
        to: 150000,
        rate: 40
      },
      {
        from: 150001,
        to: Infinity,
        rate: 45
      }];
    var niTaxBands = opts.niTaxBands || [
      {
        from: 7748,
        to: 41444,
        rate: 12
      },
      {
        from: 41444,
        to: Infinity,
        rate: 2
      }
    ];
    var studentAllowance = opts.studentAllowance || 16365;
    var maxPensionRelief = opts.maxPensionRelief || 50000;
    var studentLoanPerc = opts.studentLoanPerc || 9;

    return {
      'name': yearName,
      rules: [
        {
          name: 'Income Tax',
          id: 'Tax',
          allowance: function (opts, subtractPension) { // should just be getAllowance
            var salary = opts.salary ? parseInt(opts.salary) : 0;
            var addAllowance = opts.addAllowance ? parseInt(opts.addAllowance) : 0;
            var pension = opts.pension ? parseInt(opts.pension) : 0;
            var ageOpts = parseInt(opts.age);
            var allowance = taxAllowance + addAllowance;

            if (subtractPension) {
              var curPension = Math.min(pension, maxPensionRelief);
              allowance = allowance + curPension;
            }

            if (ageOpts === 2 || ageOpts === 3) {
              var localAllowance = (ageOpts === 2) ? 10500 : 10660;
              var localDeduction = Math.max(0, ((salary - incomeLimit1945) * 0.5));
              if (localDeduction <= (localAllowance - allowance)) {
                allowance = localAllowance - localDeduction;
              }
            }
            if (opts.blind) {
              allowance = allowance + blindAllowance;
            }
            var deduction = ((salary - 100000) * 0.5);
            if (deduction > allowance) {
              allowance = 0;
            } else if (salary >= 100001) {
              allowance = allowance - deduction;
            }

            return allowance;

          },
          bands: incomeTaxBands,
          relief: function (opts) {
            //calculate any tax relief on this tax this person is due
            var salary = opts.salary;
            var ageOpts = parseInt(opts.age);
            var married = opts.married;
            if (!married || (ageOpts !== 3)) {
              return 0;
            } else {
              var relief = marriedAllowance;
              if (salary >= incomeLimit1945) {
                relief = Math.max(marriedAllowanceMin, relief - ((salary - incomeLimit1945) / 2));
              }
              return relief / 10;
            }
          }
        },
        {
          name: 'National Insurance',
          id: 'nationalInsurance',
          allowance: function () {
            return 0;
          },
          eligible: function (opts) {
            return (parseInt(opts.age) === 1 && !opts.noNI);
          },
          bands: niTaxBands
        },
        {
          allowance: function () {
            return studentAllowance;
          },
          eligible: function (opts) {
            return opts.student && parseInt(opts.age) === 1;
          },
          name: 'Student Loan',
          id: 'studentLoan',
          bands: [
            {
              from: 0,
              to: Infinity,
              rate: studentLoanPerc
            }
          ]
        }
      ]
    };
  }

  var rules = [generateTaxYear('UK 2014/15',{
      incomeTaxAllowance:10000,
      maxPensionRelief:40000,
      studentAllowance:16910,
      marriedAllowance:8165,
      incomeLimit1945:27000,
      marriedAllowanceMin:3140,
      blindAllowance:2230,
      incomeTaxBands:[
        {
          from: 0,
          to: 31865,
          rate: 20
        },
        {
          from: 31865,
          to: 150000,
          rate: 40
        },
        {
          from: 150001,
          to: Infinity,
          rate: 45
        }
      ],
      niTaxBands:[
        {
          from: 7956,
          to: 41865,
          rate: 12
        },
        {
          from: 41865,
          to: Infinity,
          rate: 2
        }
      ]
    }),
  generateTaxYear('UK 2013/14')
  ];

  that.getAvailableRules = function(){
    return rules;
  };

  return that;

});
