/*global $:false */
'use strict';

angular.module('taxnumptyApp')
  .controller('Calculator',['$scope', 'localStorageService', 'processRules', function ($scope, localStorageService, processRules) {

    // Only add elements to the history log if nothing has changed for 10 seconds
    var historyAddTimer;

    $scope.ages = [
      {name:'Under 65', id:'1'},
      {name:'65 - 74', id:'2'},
      {name:'Over 75', id:'3'}
    ];

    $scope.availableRules = processRules.ruleSets;
    $scope.calculatorState = processRules;
    $scope.selectedAge = $scope.ages[0];
    $scope.visSalary = 20000;
    $scope.showMoreSettings = false;
    $scope.pensionPercentage = null;
    $scope.payPeriod = 'Yearly';
    $scope.summaryPeriods ={
      yearly:true,
      monthly:true,
      weekly:false,
      daily:false,
      hourly:false,
      yearlyTotal:true
    };

    $scope.detailsPeriods = {
      yearly:true,
      monthly:true,
      weekly:true,
      twoWeekly:false,
      daily:false,
      hourly:false
    };

    // Use to flick the screen to help make users aware it's dynamically updating
    $scope.updating = false;
    var updateTimer;
    // Show only a certain amount of flicks and then assume people have noticed it updates itself
    var flickCount = 0;

    $scope.previousEntries = localStorageService.get('prevEntries') || [];

    // Attempts to size the settings menu to full page height, shouldn't really be in a controller
    // not sure how else to do it.
    function sizeElements(){
      var $settings = $('.salary-settings');
      $settings.height('auto');
      if($(document).width() > 940){
        var docH = $(document).height();
        $settings.height(docH);
      }
    }

    // Look at history log and update the setting to match the last entry if possible
    function applySettingsFromHistory(){
      if($scope.previousEntries.length){
        var latestEntry = $scope.previousEntries[$scope.previousEntries.length - 1];
        // salary indicates a legacy entry so clear it and move on
        if(latestEntry.salary){
          localStorageService.clearAll();
          return;
        }
        $scope.visSalary = latestEntry.visSalary || 20000;
        $scope.payPeriod = latestEntry.payPeriod || 'Yearly';
        $scope.calculatorState.student = latestEntry.student || false;
        $scope.calculatorState.married = latestEntry.married || false;
        $scope.calculatorState.blind = latestEntry.blind || false;
        $scope.calculatorState.noNI = latestEntry.noNI || false;
        if(latestEntry.selectedAge){
          $scope.selectedAge = $scope.ages[latestEntry.selectedAge.id - 1] || $scope.ages[0];
        }
      }
    }

    applySettingsFromHistory();

    // Different pay periods will be more interested in particular summmaries
    function summaryPeroidPayPeriodSync(){
      var curPayPeriod = $scope.payPeriod;
      $scope.summaryPeriods = {
        yearly:true ,
        monthly:curPayPeriod === 'Yearly' || curPayPeriod === 'Monthly' ,
        weekly:curPayPeriod === 'Weekly',
        daily:curPayPeriod === 'Daily' || curPayPeriod === 'Hourly',
        hourly:curPayPeriod === 'Hourly',
        yearlyTotal:curPayPeriod !== 'Yearly'
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

    function addToLocalHistory(salary){
      clearTimeout(historyAddTimer);
      historyAddTimer = setTimeout(function(){
        // Don't re add the same entry
        removeLogDuplicates($scope.calculatorState.totalTakeHome, $scope.calculatorState.ruleSetName);

        // Ten items at most
        if($scope.previousEntries.length > 10){
          $scope.previousEntries.shift();
        }

        $scope.previousEntries.push({
          entered:new Date(),
          visSalary:salary,
          takeHome:$scope.calculatorState.totalTakeHome,
          year:$scope.calculatorState.ruleSetName,
          payPeriod:$scope.payPeriod,
          student:$scope.calculatorState.student,
          married:$scope.calculatorState.married,
          blind:$scope.calculatorState.blind,
          noNI:$scope.calculatorState.noNI,
          selectedAge:$scope.selectedAge
        });

        localStorageService.set('prevEntries', $scope.previousEntries);
        $scope.$digest();
        sizeElements();

      },5000);
    }

    // Flick the screen to show an update.
    function showUpdate(){
      clearTimeout(updateTimer);
      updateTimer = setTimeout(function(){
        if(flickCount === 0){
          flickCount = 1;
          return;
        }else if (flickCount > 4){ // Hopefully users will have notice it update automatically
          return;
        }
        $scope.updating = true;
        setTimeout(function(){
          flickCount++;
          $scope.updating = false;
          $scope.$digest();
        }, 300);
        $scope.$digest();
      },1200);
    }

    // Find any previous log entries and remove them
    function removeLogDuplicates(takeHome, year){
      var ii = $scope.previousEntries.length;
      for(var i= 0; i<ii; i++){
        if($scope.previousEntries[i].takeHome === takeHome && $scope.previousEntries[i].year === year){
          $scope.previousEntries.splice(i, 1);
          return;
        }
      }
    }

    $scope.$watchCollection('[visSalary, selectedAge, pensionPercentage, calculatorState.student, calculatorState.blind, calculatorState.noNI, calculatorState.married, calculatorState.addAllowance, payPeriod, calculatorState.ruleSetName]', function() {
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

      // Convert for input percentage to a pension value
      if($scope.pensionPercentage){
        $scope.calculatorState.pension = $scope.pensionPercentage/100 * salary;
      }else{
        $scope.calculatorState.pension = null;
      }

      summaryPeroidPayPeriodSync();
      processRules.setSalary(salary);
      processRules.setAge($scope.age);
      processRules.update();
      addToLocalHistory($scope.visSalary);
      showUpdate();
    });


    $scope.submitForm = function(){
      $scope.showMoreSettings = false;
      return false;
    };

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
