'use strict';
// Generic class to process generic tax rules such as applying tax
// at different band and taking into account an allowance
angular.module('taxCalculatorRules', []).factory('rulesCollection', function () {
  var taxTypes = {'uk201314': {
    'Name': 'UK 2013/14',
    rules: [
      {
        name: 'Income Tax',
        id: 'Tax',
        taxAllowance: 9440,
        maxPensionRelief: 50000,
        incomeDistribution: [7740, 8000, 8280, 8560, 8840, 9150, 9450, 9740, 10000, 10200, 10400, 10700, 10900, 11100, 11300, 11500, 11700, 12000, 12200, 12400, 12600, 12900, 13100, 13300, 13500, 13800, 14000, 14300, 14500, 14700, 15000, 15200, 15500, 15800, 16000, 16300, 16600, 16800, 17100, 17400, 17600, 17900, 18200, 18500, 18800, 19100, 19400, 19700, 20000, 20300, 20700, 21000, 21300, 21700, 22100, 22400, 22800, 23200, 23600, 24000, 24400, 24900, 25300, 25800, 26300, 26800, 27300, 27800, 28400, 29000, 29500, 30100, 30800, 31400, 32100, 32800, 33600, 34400, 35200, 36000, 36900, 37900, 39000, 40000, 41100, 42200, 43400, 44800, 46400, 48300, 50500, 53200, 56500, 60700, 66200, 74100, 85500, 104000, 147000],
        allowance: function (opts, subtractPension) { // should just be getAllowance
          var salary = opts.salary ? parseInt(opts.salary) : 0;
          var addAllowance = opts.addAllowance ? parseInt(opts.addAllowance) : 0;
          var pension = opts.pension ? parseInt(opts.pension) : 0;
          var ageOpts = parseInt(opts.age);
          var allowance = this.taxAllowance + addAllowance;

          if (subtractPension) {
            var curPension = Math.min(pension, this.maxPensionRelief);
            allowance = allowance + curPension;
          }

          if (ageOpts === 2 || ageOpts === 3) {
            var localAllowance = (ageOpts === 2) ? 10500 : 10660;
            var localDeduction = Math.max(0, ((salary - 26100) * 0.5));
            if (localDeduction <= (localAllowance - allowance)) {
              allowance = localAllowance - localDeduction;
            }
          }
          if (opts.blind) {
            allowance = allowance + 2160;
          }
          var deduction = ((salary - 100000) * 0.5);
          if (deduction > allowance) {
            allowance = 0;
          } else if (salary >= 100001) {
            allowance = allowance - deduction;
          }

          return allowance;

        },
        bands: [
          {
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
          }
        ],
        relief: function (opts) {
          //calculate any tax relief on this tax this person is due
          var salary = opts.salary;
          var ageOpts = parseInt(opts.age);
          var married = opts.married;
          if (!married || (ageOpts !== 3)) {
            return 0;
          } else {
            var relief = 7915;
            if (salary >= 28540) {
              relief = Math.max(3040, relief - ((salary - 28540) / 2));
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
        bands: [
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
        ]
      },
      {
        allowance: function () {
          return 16365;
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
            rate: 9
          }
        ]
      }
    ]
  },


    'uk201415': {
      'Name': 'UK 2014/15',
      rules: [
        {
          name: 'Income Tax',
          id: 'Tax',
          allowance: function (opts, subtractPension) { // should just be getAllowance
            var salary = opts.salary;
            var ageOpts = parseInt(opts.age);
            var allowance = 9440 + opts.addAllowance;
            if (subtractPension){ allowance = allowance + opts.pension; }
            if (ageOpts === 2 || ageOpts === 3) {
              var localAllowance = ageOpts === 2 ? 10500 : 10660;
              var localDeduction = Math.max(0, ((salary - 26100) * 0.5));
              if (localDeduction <= (localAllowance - allowance)) {
                allowance = localAllowance - localDeduction;
              }
            }
            if (opts.blind) {
              allowance = allowance + 2160;
            }
            var deduction = ((salary - 100000) * 0.5);
            if (deduction > allowance) {
              allowance = 0;
            } else if (salary >= 100001) {
              allowance = allowance - deduction;
            }
            return allowance;
          },
          bands: [
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
          relief: function (opts) {
            //calculate any tax relief on this tax this person is due
            var salary = opts.salary;
            var ageOpts = parseInt(opts.age);
            var married = opts.married;
            if (!married || (ageOpts !== 3)) {
              return 0;
            } else {
              var relief = 7915;
              if (salary >= 28540) {
                relief = Math.max(3040, relief - ((salary - 28540) / 2));
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
          bands: [
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
        },
        {
          allowance: function () {
            return 16910;
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
              rate: 9
            }
          ]
        }
      ]
    }};

  return taxTypes;

});
