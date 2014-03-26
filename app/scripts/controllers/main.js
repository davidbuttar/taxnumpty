/*global $:false */
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
    $scope.visSalary = null;
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
    $scope.showMoreSettings = false;
    $scope.payPeriod = 'Yearly';

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

    $scope.setViewSettings = function(){
      $scope.showMoreSettings = !$scope.showMoreSettings;
    };

    $scope.setPayPeriod = function(period){
      $scope.payPeriod = period;
    };

    $scope.$watchCollection('[visSalary, selectedAge, student, blind, noNI, married, addAllowance, pension, payPeriod]', function() {
      $scope.age = $scope.selectedAge.id;
      $scope.salary = $scope.visSalary;
      if($scope.payPeriod === 'Monthly'){
        $scope.salary = $scope.salary * 12;
      }else if ($scope.payPeriod === 'Weekly'){
        $scope.salary = $scope.salary * 52;
      }
      setIncomeTaxValues();
      calculateTaxableIncome();
      calculateStudentLoan();
      calculatePensonHMRC();
      calculateNationalInsurance();
      calculateTotalDeductions();
      calculateTakeHome();
    });

    /*
     *  Some jQuery to handle making divs full browser height
     *  @todo : something about this hackyness!
     */
    if(typeof $ !== 'undefined'){
      $(function() {
        function sizeElements(){
          var $settings = $('.salary-settings');
          $settings.height('auto');
          if($(document).width() > 960){
            var docH = $(document).height();
            $settings.height(docH);
          }
        }
        setTimeout(sizeElements, 10);
        $(window).resize(function(){
          sizeElements();
        });

        chart('#wealth-dis-chart',{
          title:'UK Wealth Distribution',
          unit:'£',
          prefixUnit:true,
          animate:true,
          yaxis:[
            {
              label:'Revenue',
              showUnit:true
            }
          ],
          series:[
            {
              type:'line',
              name:'2013',
              data:[7740, 8000, 8280, 8560, 8840, 9150, 9450, 9740, 10000, 10200, 10400, 10700, 10900, 11100, 11300, 11500, 11700, 12000, 12200, 12400, 12600, 12900, 13100, 13300, 13500, 13800, 14000, 14300, 14500, 14700, 15000, 15200, 15500, 15800, 16000, 16300, 16600, 16800, 17100, 17400, 17600, 17900, 18200, 18500, 18800, 19100, 19400, 19700, 20000, 20300, 20700, 21000, 21300, 21700, 22100, 22400, 22800, 23200, 23600, 24000, 24400, 24900, 25300, 25800, 26300, 26800, 27300, 27800, 28400, 29000, 29500, 30100, 30800, 31400, 32100, 32800, 33600, 34400, 35200, 36000, 36900, 37900, 39000, 40000, 41100, 42200, 43400, 44800, 46400, 48300, 50500, 53200, 56500, 60700, 66200, 74100, 85500, 104000, 147000],
              className:'series1'
            }
          ]
        });

      });
    }

  }]);
