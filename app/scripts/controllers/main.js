/*global $:false */
'use strict';

angular.module('taxnumptyApp')
  .controller('Calculator',['$scope', '$cookies', 'processRules', function ($scope, $cookies, processRules) {

    $scope.ages = [
      {name:'Under 65', id:'1'},
      {name:'65 - 74', id:'2'},
      {name:'Over 75', id:'3'}
    ];

    $scope.availableRules = processRules.ruleSets;
    $scope.calculatorState = processRules;
    $scope.selectedAge = $scope.ages[0];
    $scope.visSalary = $cookies.visSal || 20000;
    $scope.showMoreSettings = false;
    $scope.payPeriod = 'Yearly';
    $scope.summaryPeriods ={
      yearly:true,
      monthly:true,
      weekly:false,
      daily:false,
      hourly:false
    };

    // Different pay periods will be more interested in particular summmaries
    function summaryPeroidPayPeriodSync(){
      var curPayPeriod = $scope.payPeriod;
      $scope.summaryPeriods = {
        yearly:true ,
        monthly:curPayPeriod === 'Yearly' || curPayPeriod === 'Monthly' ,
        weekly:curPayPeriod === 'Weekly',
        daily:curPayPeriod === 'Daily' || curPayPeriod === 'Hourly',
        hourly:curPayPeriod === 'Hourly'
      };
    }

    $scope.setViewSettings = function(){
      $scope.showMoreSettings = !$scope.showMoreSettings;
    };

    $scope.setPayPeriod = function(period){
      $scope.payPeriod = period;
    };

    $scope.toggleSummaryPeriod = function(peroid){
      $scope.summaryPeriods[peroid] = !$scope.summaryPeriods[peroid];
    };

    $scope.selectYear = function(data){
      processRules.selectRule(data.name);
    };

    $scope.$watchCollection('[visSalary, selectedAge, calculatorState.student, calculatorState.blind, calculatorState.noNI, calculatorState.married, calculatorState.addAllowance, calculatorState.pension, payPeriod]', function() {
      $scope.age = $scope.selectedAge.id;
      $cookies.visSal = $scope.visSalary;
      var salary = $scope.visSalary;
      if($scope.payPeriod === 'Monthly'){
        salary = salary * 12;
      }else if ($scope.payPeriod === 'Weekly'){
        salary = salary * 52;
      }else if ($scope.payPeriod === 'Daily'){
        salary = salary * 5 * 52;
      }else if ($scope.payPeriod === 'Hourly'){
        salary = salary * 37.5 * 52;
      }
      summaryPeroidPayPeriodSync();
      processRules.setSalary(salary);
      processRules.setAge($scope.age);
      processRules.update();
    });

    /**
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
      });
    }

  }]);
