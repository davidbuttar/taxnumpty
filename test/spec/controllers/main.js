'use strict';

describe('Controller: MainCtrl', function () {

  // load the controller's module
  beforeEach(module('taxnumptyApp'));

  var MainCtrl, scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    MainCtrl = $controller('Calculator', {
      $scope: scope
    });
  }));

  it('should have a starting salary of 43000', function () {
    expect(scope.salary).toBe(43000);
  });


});
