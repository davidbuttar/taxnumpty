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
    $scope.ruleSet = $scope.availableRules[0].rules;

    $scope.salary = 0;
    $scope.incomeTax = 0;
    $scope.nationalInsurance = 0;
    $scope.totalTax = 0;
    $scope.studentTax = 0;
    $scope.student = false;
    $scope.age = $scope.selectedAge.id;
    $scope.blind = false;
    $scope.noNI = false;
    $scope.married = false;

    $scope.$watchCollection('[salary, selectedAge, student, blind, noNI, married]', function() {
      $scope.age = $scope.selectedAge.id;

      $scope.incomeTax = processRules.applyBands($scope.salary,
        $scope.ruleSet[0].bands, $scope.ruleSet[0].allowance($scope)) - $scope.ruleSet[0].relief($scope);

      if($scope.ruleSet[1].eligible($scope)){
        $scope.nationalInsurance = processRules.applyBands($scope.salary, $scope.ruleSet[1].bands);
      }else{
        $scope.nationalInsurance = 0;
      }

      if($scope.ruleSet[2].eligible($scope)){
        $scope.studentTax = Math.round(processRules.applyBands($scope.salary, $scope.ruleSet[2].bands,
          $scope.ruleSet[2].allowance($scope)));
      }else{
        $scope.studentTax = 0;
      }

      $scope.totalTax = $scope.nationalInsurance + $scope.incomeTax;

    });

  }]);
