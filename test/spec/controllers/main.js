'use strict';

describe('Controller: Calculator', function () {

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

  it('should alter depending on age', function () {
    scope.salary = 20000;
    scope.$digest();
    var prevIncomeTax = scope.incomeTax;
    scope.selectedAge = scope.ages[2];
    scope.$digest();
    expect(scope.incomeTax).not.toBe(prevIncomeTax);
  });

  it('Over 65s should not pay nationalInsurance', function () {
    scope.salary = 20000;
    scope.selectedAge = scope.ages[2];
    scope.$digest();
    expect(scope.nationalInsurance).toBe(0);
  });

  it('should make national insurance optional', function () {
    scope.salary = 20000;
    scope.noNI = true;
    scope.$digest();
    expect(scope.nationalInsurance).toBe(0);
  });

  it('should have student loan payment if selected and over the threshold', function () {
    scope.salary = 40000;
    scope.student = false;
    scope.$digest();
    expect(scope.studentTax).toBe(0);
    scope.student = true;
    scope.$digest();
    expect(scope.studentTax).not.toBe(0);
  });

  it('should have student apply 9% student loan', function () {
    scope.salary = 17000;
    scope.student = false;
    scope.$digest();
    expect(scope.studentTax).toBe(0);
    scope.student = true;
    scope.$digest();
    expect(scope.studentTax).toBe(57);
    scope.salary = 30000;
    scope.$digest();
    expect(scope.studentTax).toBe(1227);
    scope.salary = 16365;
    scope.$digest();
    expect(scope.studentTax).toBe(0);
  });

  it('over 65s dont pay student loan', function () {
    scope.salary = 40000;
    scope.student = true;
    scope.selectedAge = scope.ages[2];
    scope.$digest();
    expect(scope.studentTax).toBe(0);
  });

  it('should increase your allowance correctly if you are blind', function () {
    scope.salary = 16375;
    scope.blind = true;
    scope.$digest();
    expect(scope.incomeTax).toBe(955);
  });

  it('should increase your allowance correctly if you over 75 and married', function () {
    scope.salary = 16000;
    scope.married = true;
    scope.selectedAge = scope.ages[2];
    scope.$digest();
    expect(scope.incomeTax).toBe(276.5);
  });

});
