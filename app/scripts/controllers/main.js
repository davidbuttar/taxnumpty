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
      }else if ($scope.payPeriod === 'Daily'){
        $scope.salary = $scope.salary * 5 * 52;
      }else if ($scope.payPeriod === 'Hourly'){
        $scope.salary = $scope.salary * 37.5 * 52;
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

        $scope.ruleSet[0].calculateIncomeByPerc();

        $(window).resize(function(){
          sizeElements();
        });
        console.log($scope.ruleSet[0].incomeDistByPerc);
        chart('#wealth-dis-chart',{
          title:'UK Wealth Distribution',
          unit:'%',
          prefixUnit:true,
          animate:true,
          yaxis:[
            {
              showUnit:true
            }
          ],
          labels:{
            values:[8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,42,43,44,45,47,49,51,54,57,61,67,75,86,104,147]
          },
          series:[
            {
              type:'bar',
              name:'2013',
              data:$scope.ruleSet[0].incomeDistByPerc,
              className:'series1'
            }
          ]
        });

      });
    }

  }]);
