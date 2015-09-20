/*global chart */
/**
 * Created by david on 28/05/14.
 *
 * Draws a stacked percentage chart.
 *
 */
'use strict';
angular.module('taxnumptyApp')
  .directive('myStack', function() {
  return {
    restrict: 'EA',
    scope: {
      salaryValues: '='
    },
    link:function(scope, element, attrs){
      var taxValues;
      var chartInstance = false;
      function updateDom(){
        if(!chartInstance){
          console.log(attrs.chartId);
          chartInstance = chart(document.getElementById(attrs.chartId),{
            unit:'&pound',
            prefixUnit:true,
            series:[
              {
                type:'stack',
                donutWidth:13,
                data:[{
                  value:taxValues[0],
                  label:'Take Home',
                  className:'stack1'
                }, {
                  value:taxValues[1],
                  label:'National Insurance',
                  className:'stack2'
                },{
                  value:taxValues[2],
                  label:'Income Tax',
                  className:'stack3'
                },{
                  value:taxValues[3],
                  label:'Student Loan',
                  className:'stack4'
                }]
              }
            ]
          });
        }else{
          chartInstance.set({series:[
            {
              type:'stack',
              donutWidth:13,
              data:[{
                value:taxValues[0],
                label:'Take Home',
                className:'stack1'
              }, {
                value:taxValues[1],
                label:'National Insurance',
                className:'stack2'
              },{
                value:taxValues[2],
                label:'Income Tax',
                className:'stack3'
              },{
                value:taxValues[3],
                label:'Student Loan',
                className:'stack4'
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
