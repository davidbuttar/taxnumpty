/*global chart */
/**
 * Created by david on 28/05/14.
 *
 * Draws a donut chart
 *
 */
'use strict';
angular.module('taxnumptyApp')
  .directive('chartDonut', function() {
  return {
    restrict: 'EA',
    scope: {
      salaryValues: '='
    },
    link:function(scope, element){
      var taxValues;
      var chartInstance = false;
      function updateDom(){
        if(!chartInstance){
          chartInstance = chart(element[0],{
            unit:'&pound',
            prefixUnit:true,
            series:[
              {
                type:'donut',
                donutWidth:13,
                data:[{
                  value:taxValues[0],
                  label:'Take Home',
                  className:'donutActive'
                }, {
                  value:taxValues[1],
                  label:'Deductions',
                  className:'donutInactive'
                }]
              }
            ]
          });
        }else{
          chartInstance.set({series:[
            {
              type:'donut',
              donutWidth:13,
              data:[{
                value:taxValues[0],
                label:'Take Home',
                className:'donutActive'
              }, {
                value:taxValues[1],
                label:'Deductions',
                className:'donutInactive'
              }]
            }
          ]});
        }
      }
      scope.$watch('salaryValues', function(value) {
        taxValues = value;
        updateDom();
      });
    },
    template: ''
  };
});
