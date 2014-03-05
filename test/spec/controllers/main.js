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

  it('should have a starting salary of 0', function () {
    expect(scope.salary).toBe(0);
  });


  it('should apply multiple types of tax', function () {
    scope.salary = 40000;
    scope.$digest();
    expect(scope.nationalInsurance).not.toBe(0);
    expect(scope.incomeTax).not.toBe(0);
  });

});
