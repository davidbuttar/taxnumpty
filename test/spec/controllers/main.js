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
    // Tests assume this year for calculations
    scope.ruleSet = scope.availableRules.uk201314.rules;
  }));

  it('should have a null starting salary', function () {
    expect(scope.salary).toBe(null);
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
    expect(scope.studentLoan).toBe(0);
    scope.student = true;
    scope.$digest();
    expect(scope.studentLoan).toBe(2127);
  });

  it('should have student apply 9% student loan', function () {
    scope.salary = 17000;
    scope.student = false;
    scope.$digest();
    expect(scope.studentLoan).toBe(0);
    scope.student = true;
    scope.$digest();
    expect(scope.studentLoan).toBe(57);
    scope.salary = 30000;
    scope.$digest();
    expect(scope.studentLoan).toBe(1227);
    scope.salary = 16365;
    scope.$digest();
    expect(scope.studentLoan).toBe(0);
  });

  it('over 65s dont pay student loan', function () {
    scope.salary = 40000;
    scope.student = true;
    scope.selectedAge = scope.ages[2];
    scope.$digest();
    expect(scope.studentLoan).toBe(0);
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

  it('should allow you to specify allowances', function () {
    scope.salary = 40000;
    scope.married = true;
    scope.addAllowance = 1000;
    scope.$digest();
    expect(scope.incomeTax).toBe(5912);
    scope.salary = 120000;
    scope.$digest();
    expect(scope.incomeTax).toBe(41422);
    scope.blind = true;
    scope.$digest();
    expect(scope.incomeTax).toBe(40558);
  });

  it('should calculate the pension contribution of the HMRC', function () {

    scope.salary = 41500;
    scope.pension = 1000;
    scope.$digest();
    expect(scope.pensionHMRC).toBe(210);

    scope.pension = 6000;
    scope.$digest();
    expect(scope.pensionHMRC).toBe(1210);

    scope.salary = 43000;
    scope.pension = 43000;
    scope.$digest();
    expect(scope.pensionHMRC).toBe(7022);

  });


  it('should give no pensions tax relief over 50000', function () {

    scope.salary = 100000;
    scope.pension = 50000;
    scope.$digest();
    expect(scope.pensionHMRC).toBe(20000);

    scope.salary = 100000;
    scope.pension = 60000;
    scope.$digest();
    expect(scope.pensionHMRC).toBe(20000);

  });


});
