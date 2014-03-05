'use strict';

describe('Service: taxCalculator', function () {

  // load the controller's module
  beforeEach(module('taxCalculator'));

  var processTaxRules;

  // Initialize the controller and a mock scope
  beforeEach(
    inject(function($injector) {
      processTaxRules = $injector.get('processRules');
    })
  );

  it('should calculate tax due in a particular band range e.g. 20% from 30,000 to 50,000', function () {
    expect(processTaxRules.applyBand(60000, {
      from : 0,
      to : 30000,
      rate : 20
    })).toBe(6000);

    expect(processTaxRules.applyBand(60000, {
      from : 50000,
      to : Infinity,
      rate : 40
    })).toBe(4000);

    expect(processTaxRules.applyBand(60000, {
      from : 3870,
      to : 10000,
      rate : 12
    })).toBe(735.6);

    expect(processTaxRules.applyBand(10000, {
      from : 31870,
      to : Infinity,
      rate : 12
    })).toBe(0);

  });


  it('should be able to apply tax at a range of bands.', function () {

    var bands = [{
      from : 7748,
      to : 41444,
      rate : 12
    }, {
      from : 41444,
      to : Infinity,
      rate : 2
    }];

    expect(processTaxRules.applyBands(17748, bands)).toBe(1200);
    expect(processTaxRules.applyBands(40000, bands)).toBe(3870.24);
    expect(processTaxRules.applyBands(60000, bands)).toBe(4414.64);

  });


  it('should be able to have a custom allowance value', function () {

    var bands = [{
      from : 0,
      to : 32010,
      rate : 20
    }, {
      from : 32010,
      to : 150000,
      rate : 40
    }, {
      from : 150001,
      to : Infinity,
      rate : 45
    }];

    expect(processTaxRules.applyBands(43000, bands, 9440)).toBe(7022.00);

  });


});
