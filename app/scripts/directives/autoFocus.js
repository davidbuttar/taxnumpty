'use strict';
angular.module('taxnumptyApp')
  .directive('autoFocus', function($timeout) {
  return {
    restrict: 'AC',
    link: function(_scope, _element) {
      $timeout(function(){
        _element[0].focus();
        _element[0].select();
      }, 0);
    }
  };
});