'use strict';
// Generic class to process generic tax rules such as applying tax
// at different band and taking into account an allowance
angular.module('taxCalculator', []).factory('processRules', function() {
  var that = {};


  // Apply taxation band to salary, band will have
  // from, to and rate to apply.
  that.applyBand = function(salary, band){
    var maxTaxable = Math.min(band.to, salary);
    var taxable = maxTaxable - band.from;
    // salary not taxable at this band
    if (taxable < 0){
     return 0;
    }
    // apply rate to salary
    return taxable * band.rate/100;
  };

  // Apply several taxation bands.
  that.applyBands = function(salary, bands, allowance){
    var total = 0
    var band1From = bands[0].from;
    if(allowance){
      salary = salary - allowance();
    }
    for(var i =0, ii=bands.length; i<ii; i++){
      total += that.applyBand(salary, bands[i]);
    }
    return total;
  };

  return that;

});
