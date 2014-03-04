'use strict';

angular.module('taxnumptyApp')
  .controller('Calculator',['$scope', 'processRules', function ($scope, processRules) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    $scope.salary = 43000;
    $scope.totalTax = 0;

    var niBands = [{
      from : 7755,
      to : 41450,
      rate : 12
    },{
      from : 41450,
      to : -1,
      rate : 2
    }];

    $scope.total = function(){
      console.log('here');
      $scope.totalTax = processRules.applyBands($scope.salary, niBands);
    };

  }]);
