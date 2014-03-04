'use strict';

angular.module('taxnumptyApp', [
  'ngCookies',
  'ngResource',
  'ngSanitize',
  'ngRoute',
  'ngAnimate',
  'taxCalculator'
])
  .config(function ($routeProvider) {
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
