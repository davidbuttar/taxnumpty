'use strict';

angular.module('taxnumptyApp', [
  'ngRoute',
  'taxCalculator',
  'LocalStorageModule',
  'td.easySocialShare'
])
  .config(function ($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'Calculator'
      }).when('/about', {
        templateUrl: 'views/about.html',
        controller: 'Calculator'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
