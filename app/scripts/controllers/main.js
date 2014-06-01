/*global $:false */
'use strict';

angular.module('taxnumptyApp')
  .controller('Calculator',['$scope', 'localStorageService', 'processRules', function ($scope, localStorageService, processRules) {

    var historyAddTimer;

    $scope.ages = [
      {name:'Under 65', id:'1'},
      {name:'65 - 74', id:'2'},
      {name:'Over 75', id:'3'}
    ];

    $scope.availableRules = processRules.ruleSets;
    $scope.calculatorState = processRules;
    $scope.selectedAge = $scope.ages[0];
    $scope.visSalary = localStorageService.get('visSalary') || 20000;
    $scope.showMoreSettings = false;
    $scope.payPeriod = 'Yearly';
    $scope.summaryPeriods ={
      yearly:true,
      monthly:true,
      weekly:false,
      daily:false,
      hourly:false
    };

    $scope.detailsPeriods = {
      yearly:true,
      monthly:true,
      weekly:true,
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

    $scope.toggleDetailsPeriod = function(peroid){
      $scope.detailsPeriods[peroid] = !$scope.detailsPeriods[peroid];
    };

    $scope.selectYear = function(data){
      processRules.selectRule(data.name);
    };

    $scope.previousEntries = localStorageService.get('prevEntries') || [];

    function addToLocalHistory(salary){
      clearTimeout(historyAddTimer);
      historyAddTimer = setTimeout(function(){
        // Don't re add the same entry
        if(historyContains($scope.calculatorState.totalTakeHome, $scope.calculatorState.ruleSetName)){
          return;
        }
        // Ten items at most
        if($scope.previousEntries.length > 10){
          $scope.previousEntries.shift();
        }
        $scope.previousEntries.push({
          entered:new Date(),
          salary:salary,
          takeHome:$scope.calculatorState.totalTakeHome,
          year:$scope.calculatorState.ruleSetName
        });
        localStorageService.set('prevEntries', $scope.previousEntries);
        $scope.$digest();
      },10000);
    }

    function historyContains(takeHome, year){
      var ii = $scope.previousEntries.length;
      for(var i= 0; i<ii; i++){
        if($scope.previousEntries[i].takeHome === takeHome && $scope.previousEntries[i].year === year){
          return true;
        }
      }
      return false;
    }


    $scope.$watchCollection('[visSalary, selectedAge, calculatorState.student, calculatorState.blind, calculatorState.noNI, calculatorState.married, calculatorState.addAllowance, calculatorState.pension, payPeriod]', function() {
      $scope.age = $scope.selectedAge.id;
      localStorageService.set('visSalary', $scope.visSalary);
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
      addToLocalHistory(salary);

    });

    function sizeElements(){
      var $settings = $('.salary-settings');
      $settings.height('auto');
      if($(document).width() > 960){
        var docH = $(document).height();
        $settings.height(docH);
      }
    }

    /**
     *  Some jQuery to handle making divs full browser height
     *  @todo : something about this hackyness!
     */
    if(typeof $ !== 'undefined'){
      $(function() {
        setTimeout(sizeElements, 10);
        $(window).resize(function(){
          sizeElements();
        });
      });
    }

  }]);
