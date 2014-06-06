<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Calculate your take home salary after tax</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- build:css styles/vendor.css -->
    <!-- bower:css -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" />
    <!-- endbower -->
    <!-- endbuild -->
    <!-- build:css({.tmp,app}) styles/main.css -->
    <link rel="stylesheet" href="styles/default.css">
    <link rel="stylesheet" href="styles/main.css">
    <!-- endbuild -->
    <script>
      document.documentElement.className = document.documentElement.className.replace("no-js","");
    </script>
  </head>
  <body ng-app="taxnumptyApp">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Add your site or application content here -->
    <div class="header clearfix">
      <h1 class="site">Taxed <span>planet</span></h1>
      <h2 class="page-title">Tax Calculator</h2>
      <div ng-controller="Calculator" class="selected-calculator dropdown">
        <div class="selected-calculator-inner" data-toggle="dropdown">
          <div class="selected" ng-bind="calculatorState.ruleSetName"></div>
          <div class="world"></div>
        </div>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
          <li role="presentation" ng-repeat="ruleSet in availableRules" ng-click="selectYear(ruleSet)"><a role="menuitem" >{{ruleSet.name}}</a></li>
        </ul>
      </div>
    </div>
    <div class="results-container">
      <div class="results" ng-view="">
        <div class="no-js-content">
        <img id="campaign-icon" src="images/taxedplanetlogo.png" src="taxplanet.com" />
        <p>Salary Calculator: calculate your take home pay after tax. See a detailed break down and comparisons with different salary options.</p>
          <div class="salary-settings " style="height: 1200px;">
            <div class="salary-settings-inner">
              <form role="form" class="ng-pristine ng-valid">
                <div class="form-group">
                  <label for="salaryInput">Salary</label>
                  <div class="input-group">
                    <input type="text" class="form-control ng-pristine ng-valid" placeholder="Enter salary" id="salaryInput" ng-model="visSalary">
                    <div class="input-group-btn open">
                      <button type="button" class="btn btn-default dropdown-toggle " data-toggle="dropdown">Yearly <span class="caret"></span></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a >Yearly</a></li>
                        <li><a >Monthly</a></li>
                        <li><a >Weekly</a></li>
                        <li><a >Daily (5 days a week)</a></li>
                        <li><a >Hourly (37.5 hrs a week)</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                  </div><!-- /input-group -->
                </div>
                <h4 class="hide-toggle" ng-click="setViewSettings()">
                  More Options <i class="pull-right glyphicon glyphicon-chevron-left glyphicon-chevron-down" ng-class="{'glyphicon-chevron-down':showMoreSettings, 'glyphicon-chevron-left':!showMoreSettings}"></i></h4>
                <div class="more-settings selected" ng-class="{'selected':showMoreSettings}">
                  <div class="form-group">
                    <label for="age">Age</label>
                    <select ng-model="selectedAge" id="age" class="form-control ng-pristine ng-valid" ng-options="c.name for c in ages"><option value="0" selected="selected">Under 65</option><option value="1">65 - 74</option><option value="2">Over 75</option></select>
                  </div>
                  <div class="form-group">
                    <div class="checkbox">
                      <label>
                        Include Student Loan <input type="checkbox" ng-model="calculatorState.student" class="ng-pristine ng-valid">
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        Married <input type="checkbox" ng-model="calculatorState.married" class="ng-pristine ng-valid">
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        Blind <input type="checkbox" ng-model="calculatorState.blind" class="ng-pristine ng-valid">
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        No N.I. <input type="checkbox" ng-model="calculatorState.noNI" class="ng-pristine ng-valid">
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="pensionInput">Pension Contribution</label>
                    <input type="text" class="form-control ng-pristine ng-valid" id="pensionInput" placeholder="Enter pension" ng-model="calculatorState.pension">
                  </div>
                  <div class="form-group">
                    <label for="addAllowanceInput">Added Allowance</label>
                    <input type="text" class="form-control ng-pristine ng-valid" id="addAllowanceInput" placeholder="Enter Allowance or subtraction" ng-model="calculatorState.addAllowance">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="row result-block ">
            <div class="result-hd">
              <h4>Summary</h4>
              <div class="time-period-options">
                <ul>
                  <li ng-class="{selected: summaryPeriods.yearly}" ng-click="toggleSummaryPeriod('yearly')" title="Yearly" class="selected">YR</li>
                  <li ng-class="{selected: summaryPeriods.monthly}" ng-click="toggleSummaryPeriod('monthly')" title="Monthly" class="selected">MN</li>
                  <li ng-class="{selected: summaryPeriods.weekly}" ng-click="toggleSummaryPeriod('weekly')" title="Weekly">WK</li>
                  <li ng-class="{selected: summaryPeriods.daily}" ng-click="toggleSummaryPeriod('daily')" title="Daily">DY</li>
                  <li ng-class="{selected: summaryPeriods.hourly}" ng-click="toggleSummaryPeriod('hourly')" title="Hourly">HR</li>
                </ul>
              </div>
            </div>
            <div class="results-summary-data clearfix">
              <div class="result-summary-ctr">
                <p class="result-summary ng-hide" ng-show="summaryPeriods.hourly"><span class="result-label">Hourly take home pay</span> <span class="result-highlight ">£15.75</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.hourly"><span class="result-label-deduction">Hourly Deductions</span> <span class="result-highlight-red ">£7.32</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.daily"><span class="result-label">Daily take home pay</span> <span class="result-highlight ">£118.16</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.daily"><span class="result-label-deduction">Daily Deductions</span> <span class="result-highlight-red ">£54.92</span></p>
              </div>
              <div chart-donut="" salary-values="[calculatorState.totalTakeHome, calculatorState.totalDeductions]" chart-id="pieChart" class="result-summary-chart ng-isolate-scope">
                <div id="pieChart" class="cbc-chart"><div class="cbc-da" id="cbc-da-1" style="width:100%; height:100%; position:absolute; top:0; left:0;"><canvas width="300" height="180" class="cbc-canvas" style="text-align: left; display: inline-block; overflow: hidden;">&nbsp;</canvas><canvas width="300" height="180" class="cbc-canvas" style="text-align: left; display: inline-block; overflow: hidden;">&nbsp;</canvas></div><div class="cbc-ha" id="cbc-ha-1" style="width:100%; height:100%; position:absolute; top:0; left:0;z-index:1"></div><div class="cbc-has" id="cbc-has-1" style="width:100%; height:100%; position:absolute; top:0; left:0; z-index:1"></div><div class="cbc-yaxis-container" id="cbc-yaxis-1"></div><div class="cbc-error" id="cbc-error-1" style="display: none;"></div><div class="cbc-tooltips"></div></div>
                <div class="result-summary-percentage  " ng-if="calculatorState.salary">68.27%</div>
              </div>
            </div>

          </div>
          <div class="row result-block ">
            <div class="result-hd details-hd">
              <h4>Details</h4>
              <div class="time-period-options">
                <ul>
                  <li title="Yearly" class="selected">YR</li>
                  <li title="Monthly" class="selected">MN</li>
                  <li title="Weekly" class="selected">WK</li>
                  <li title="Daily">DY</li>
                  <li title="Hourly">HR</li>
                </ul>
              </div>
            </div>
            <div class="col-md-4">
              <div my-stack="" salary-values="[calculatorState.totalTakeHome, calculatorState.nationalInsurance, calculatorState.incomeTax, calculatorState.studentLoan ]" id="bar-chart" chart-id="bar-chart" class="cbc-chart ng-isolate-scope"><div class="cbc-da" id="cbc-da-2" style="width:100%; height:100%; position:absolute; top:0; left:0;"><canvas width="408" height="280" class="cbc-canvas" style="text-align: left; display: inline-block; overflow: hidden;">&nbsp;</canvas><canvas width="408" height="280" class="cbc-canvas" style="text-align: left; display: inline-block; overflow: hidden;">&nbsp;</canvas></div><div class="cbc-ha" id="cbc-ha-2" style="width:100%; height:100%; position:absolute; top:0; left:0;z-index:1"></div><div class="cbc-has" id="cbc-has-2" style="width:100%; height:100%; position:absolute; top:0; left:0; z-index:1"></div><div class="cbc-yaxis-container" id="cbc-yaxis-2"></div><div class="cbc-error" id="cbc-error-2" style="display: none;"></div><div class="cbc-tooltips" style="display: none;"></div></div>
            </div>
            <div class="col-md-8" id="tax-report">
              <table class="table">
                <thead>
                <tr>
                  <th></th>
                  <th  class="">Yearly</th>
                  <th  class="">Monthly</th>
                  <th  class="">Weekly</th>


                </tr>
                </thead>
                <tbody>
                <tr class="success">
                  <td>Salary</td>
                  <td  class=" ">45,000.00</td>
                  <td  class=" ">3,750.00</td>
                  <td  class=" ">865.38</td>


                </tr>
                <tr>
                  <td>Taxable</td>
                  <td class=" ">35,000.00</td>
                  <td class=" ">2,916.67</td>
                  <td class=" ">673.08</td>


                </tr>
                <tr>
                  <td>Allowance</td>
                  <td class=" ">10,000.00</td>
                  <td class=" ">833.33</td>
                  <td class=" ">192.31</td>


                </tr>
                <tr>
                  <td>Income Tax</td>
                  <td class=" ">7,627.00</td>
                  <td class=" ">635.58</td>
                  <td class=" ">146.67</td>


                </tr>
                <tr>
                  <td>N.I.</td>
                  <td class=" ">4,131.78</td>
                  <td class=" ">344.32</td>
                  <td class=" ">79.46</td>


                </tr>
                <tr class="warning ">
                  <td>Student Loan</td>
                  <td class=" ">2,520.00</td>
                  <td class=" ">210.00</td>
                  <td class=" ">48.46</td>


                </tr>
                <tr class="info ng-hide">
                  <td>Pension</td>
                  <td class=" ">0.00</td>
                  <td class=" ">0.00</td>
                  <td class=" ">0.00</td>
                </tr>
                <tr class="info ng-hide">
                  <td>Pension HMRC</td>
                  <td class=" ">0.00</td>
                  <td class=" ">0.00</td>
                  <td class=" ">0.00</td>
                </tr>
                <tr class="deduction">
                  <td>Total Deductions</td>
                  <td class=" ">14,278.78</td>
                  <td class=" ">1,189.90</td>
                  <td class=" ">274.59</td>
                </tr>
                <tr class="success">
                  <td>Take Home Pay</td>
                  <td class=" ">30,721.22</td>
                  <td class=" ">2,560.10</td>
                  <td class=" ">590.79</td>
                </tr>
                <tr class="">
                  <td>Take Home Last Year</td>
                  <td class=" ">30,495.36</td>
                  <td class=" ">2,541.28</td>
                  <td class=" ">586.45</td>


                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row result-block ">
            <h4>Calculation Log</h4>
            <p ng-repeat="entry in previousEntries" class="result-summary-2"><span class="result-summary-2-date ">6/2/14 11:34 PM</span>
            <span class="result-summary-2-year ">| Tax Year: UK 2013/14 |</span>
            <span class="result-summary-2-salary ">Salary: £41,500.00 Yearly |</span>
            <span class="result-summary-2-salary" >Student |</span>
            <span class="result-summary-2-takehome ">Take Home: £28,777.36</span>
            <span class="result-summary-2-takehome-down " >| £1,943.86 less income than current</span>
            </p>
            <p ng-repeat="entry in previousEntries" class="result-summary-2"><span class="result-summary-2-date ">6/2/14 11:47 PM</span>
            <span class="result-summary-2-year ">| Tax Year: UK 2013/14 |</span>
            <span class="result-summary-2-salary ">Salary: £45,000.00 Yearly |</span>
            <span class="result-summary-2-salary ">Student |</span>
            <span class="result-summary-2-takehome ">Take Home: £30,495.36</span>
            <span class="result-summary-2-takehome-down">| £225.86 less income than current</span></p>
            <p class="result-summary-2"><span class="result-summary-2-date">6/2/14 11:53 PM</span>
            <span class="result-summary-2-year ">| Tax Year: UK 2014/15 |</span>
            <span class="result-summary-2-salary ">Salary: £55,000.00 Yearly |</span>
            <span class="result-summary-2-salary">Student |</span>
            <span class="result-summary-2-takehome ">Take Home: £35,621.22</span>
            <span class="result-summary-2-takehome-up">| £4,900.00 more income than current</span>
            </p><p class="result-summary-2"><span class="result-summary-2-date">6/3/14 12:21 AM</span>
            <span class="result-summary-2-year">| Tax Year: UK 2014/15 |</span>
            <span class="result-summary-2-salary">Salary: £45,000.00 Yearly |</span>
            <span class="result-summary-2-takehome">Take Home: £30,721.22</span></p>
          </div>

        </div>
      </div>
      <a href="https://plus.google.com/+davidbuttar?
       rel=author" style="display:none">Google</a>
    </div>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID -->
     <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48692124-1', 'taxedplanet.com');
      ga('send', 'pageview');
    </script>

    <!--[if lt IE 9]>
    <script src="bower_components/es5-shim/es5-shim.js"></script>
    <script src="bower_components/json3/lib/json3.min.js"></script>
    <![endif]-->

    <!-- build:js scripts/vendor.js -->
    <!-- bower:js -->
    <script src="bower_components/jquery/jquery.js"></script>
    <script src="bower_components/angular/angular.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="bower_components/angular-route/angular-route.js"></script>
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:js({.tmp,app}) scripts/scripts.js -->
    <script src="scripts/angular-local-storage.js"></script>
    <script src="scripts/app.js"></script>
    <script src="scripts/services/processRules.js"></script>
    <script src="scripts/services/rules/ukRuleFactory.js"></script>
    <script src="scripts/controllers/main.js"></script>
    <script src="scripts/directives/stackDirective.js"></script>
    <script src="scripts/directives/donutDirective.js"></script>
    <script src="scripts/directives/easy-social-share.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.setup.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.animateSeries.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.array.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.canvas.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.line.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.step.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.spline.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.area.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.stackedArea.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.splineArea.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.bar.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.barStacked.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.stack.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.pie.js"></script>
    <script type="text/javascript" src="scripts/pl/types/cbv.donut.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.collisionDetection.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.dataAxes.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.dataPoint.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.date.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.dateLabels.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.debug.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.events.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.attachEvents.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.heading.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.grid.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.timeline.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.guides.js"></script>
    <script type="text/javascript" src="scripts/pl/axis/cbv.axis.js"></script>
    <script type="text/javascript" src="scripts/pl/axis/cbv.leftAxis.js"></script>
    <script type="text/javascript" src="scripts/pl/axis/cbv.rightAxis.js"></script>
    <script type="text/javascript" src="scripts/pl/axis/cbv.bottomAxis.js"></script>
    <script type="text/javascript" src="scripts/pl/axis/cbv.topAxis.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.highlight.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.legend.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.mapping.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.numberFormatter.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.series.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.circularSeries.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.shapes.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.stack.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.style.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.tools.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.tooltips.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.valueDisplay.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.xaxis.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.timeaxis.js"></script>
    <script type="text/javascript" src="scripts/pl/cbv.zoom.js"></script>
    <!-- endbuild -->
</body>
</html>
