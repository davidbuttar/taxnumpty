'use strict';

angular.module('taxnumptyApp')
  .controller('Calculator',['$scope', 'processRules', 'uk201314', function ($scope, processRules, rules) {

    $scope.ages = [
      {name:'Under 65', id:'1'},
      {name:'65 - 74', id:'2'},
      {name:'Over 75', id:'3'}
    ];
    $scope.selectedAge = $scope.ages[2];

    $scope.salary = 0;
    $scope.incomeTax = 0;
    $scope.nationalInsurance = 0;
    $scope.totalTax = 0;
    $scope.studentTax = 0;
    $scope.student = true;
    $scope.age = $scope.selectedAge.id;
    $scope.blind = false;

    $scope.$watchCollection('[salary, selectedAge]', function() {
      $scope.age = $scope.selectedAge.id;
      $scope.nationalInsurance = processRules.applyBands($scope.salary, rules[1].bands);
      $scope.incomeTax = processRules.applyBands($scope.salary, rules[0].bands, rules[0].allowance($scope));
      $scope.studentTax = processRules.applyBands($scope.salary, rules[2].bands, rules[2].allowance($scope));
      $scope.totalTax = $scope.nationalInsurance + $scope.incomeTax;
    });

  }]);
