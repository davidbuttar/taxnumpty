<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TAXEDPLANET | UK tax calculator</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- build:css styles/vendor.css -->
    <!-- bower:css -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" />
    <!-- endbower -->
    <!-- endbuild -->
    <!-- build:css({.tmp,app}) styles/main.css -->
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/default.css">
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
    <div class="header">
      <h3 class="info1">Taxed <span>planet</span></h3>
      <div class="page-title">Calculations</div>
      <div ng-controller="Calculator" class="selected-calculator dropdown">
        <div class="selected-calculator-inner" data-toggle="dropdown">
          <div class="selected">UK 2014/15</div>
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
            <div class="salary-settings ng-scope no-js-content" style="height: 979px;">
            <div class="salary-settings-inner">
              <form role="form" class="ng-pristine ng-valid">
                <div class="form-group">
                  <label for="salaryInput">Salary</label>
                  <div class="input-group">
                    <input type="text" class="form-control ng-pristine ng-valid" placeholder="Enter salary" id="salaryInput" ng-model="visSalary">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle ng-binding" data-toggle="dropdown">Yearly <span class="caret"></span></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a ng-click="setPayPeriod('Yearly')">Yearly</a></li>
                        <li><a ng-click="setPayPeriod('Monthly')">Monthly</a></li>
                        <li><a ng-click="setPayPeriod('Weekly')">Weekly</a></li>
                        <li><a ng-click="setPayPeriod('Daily')">Daily (5 days a week)</a></li>
                        <li><a ng-click="setPayPeriod('Hourly')">Hourly (37.5 hrs a week)</a></li>
                      </ul>
                    </div><!-- /btn-group -->
                  </div><!-- /input-group -->
                </div>
                <h4 class="hide-toggle" ng-click="setViewSettings()">
                  More Options <i class="pull-right glyphicon glyphicon-chevron-left" ng-class="{'glyphicon-chevron-down':showMoreSettings, 'glyphicon-chevron-left':!showMoreSettings}"></i></h4>
                <div class="more-settings" ng-class="{'selected':showMoreSettings}">
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
            <div class="row result-block ng-scope">
              <div class="result-hd">
                <h4>Summary</h4>
                <div class="time-period-options">
                  <ul>
                    <li ng-class="{selected: summaryPeriods.yearly}" ng-click="toggleSummaryPeriod('yearly')" class="selected">YR</li>
                    <li ng-class="{selected: summaryPeriods.monthly}" ng-click="toggleSummaryPeriod('monthly')" class="selected">MN</li>
                    <li ng-class="{selected: summaryPeriods.weekly}" ng-click="toggleSummaryPeriod('weekly')">WK</li>
                    <li ng-class="{selected: summaryPeriods.daily}" ng-click="toggleSummaryPeriod('daily')">DY</li>
                    <li ng-class="{selected: summaryPeriods.hourly}" ng-click="toggleSummaryPeriod('hourly')">HR</li>
                  </ul>
                </div>
              </div>
              <div class="result-summary-ctr">
                <p class="result-summary ng-hide" ng-show="summaryPeriods.hourly"><span class="result-label">Hourly take home pay</span> <span class="result-highlight ng-binding">£17.05</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.hourly"><span class="result-label">Hourly Deductions</span> <span class="result-highlight-red ng-binding">£6.03</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.daily"><span class="result-label">Daily take home pay</span> <span class="result-highlight ng-binding">£127.85</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.daily"><span class="result-label">Daily Deductions</span> <span class="result-highlight-red ng-binding">£45.23</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.weekly"><span class="result-label">Weekly take home pay</span> <span class="result-highlight ng-binding">£639.25</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.weekly"><span class="result-label">Weekly Deductions</span> <span class="result-highlight-red ng-binding">£226.13</span></p>
                <p class="result-summary" ng-show="summaryPeriods.monthly"><span class="result-label">Monthly take home pay</span> <span class="result-highlight ng-binding">£2,770.10</span></p>
                <p class="result-summary" ng-show="summaryPeriods.monthly"><span class="result-label">Monthly Deductions</span> <span class="result-highlight-red ng-binding">£979.90</span></p>
                <p class="result-summary" ng-show="summaryPeriods.yearly"><span class="result-label">Yearly take home pay</span> <span class="result-highlight ng-binding">£33,241.22</span><span class="result-highlight"></span></p>
                <p class="result-summary" ng-show="summaryPeriods.yearly"><span class="result-label">Yearly Deductions</span> <span class="result-highlight-red ng-binding">£11,758.78</span></p>
              </div>
            </div>
            <div class="row result-block ng-scope">
              <h4>Details</h4>
              <table class="table table-bordered">
                <thead>
                <tr>
                  <th></th>
                  <th>Yearly</th>
                  <th>Monthly</th>
                  <th>Weekly</th>
                </tr>
                </thead>
                <tbody>
                <tr class="warning">
                  <td>Salary</td>
                  <td class="ng-binding">45,000.00</td>
                  <td class="ng-binding">3,750.00</td>
                  <td class="ng-binding">865.38</td>
                </tr>
                <tr class="danger">
                  <td>Taxable</td>
                  <td class="ng-binding">35,000.00</td>
                  <td class="ng-binding">2,916.67</td>
                  <td class="ng-binding">673.08</td>
                </tr>
                <tr>
                  <td>Allowance</td>
                  <td class="ng-binding">10,000.00</td>
                  <td class="ng-binding">833.33</td>
                  <td class="ng-binding">192.31</td>
                </tr>
                <tr>
                  <td>Income Tax</td>
                  <td class="ng-binding">7,627.00</td>
                  <td class="ng-binding">635.58</td>
                  <td class="ng-binding">146.67</td>
                </tr>
                <tr>
                  <td>N.I.</td>
                  <td class="ng-binding">4,131.78</td>
                  <td class="ng-binding">344.32</td>
                  <td class="ng-binding">79.46</td>
                </tr>
                <tr class="active ng-hide" ng-show="calculatorState.student">
                  <td>Student Loan</td>
                  <td class="ng-binding">0.00</td>
                  <td class="ng-binding">0.00</td>
                  <td class="ng-binding">0.00</td>
                </tr>
                <tr ng-show="calculatorState.pension > 0" class="ng-hide">
                  <td>Pension</td>
                  <td class="ng-binding">0.00</td>
                  <td class="ng-binding">0.00</td>
                  <td class="ng-binding">0.00</td>
                </tr>
                <tr ng-show="calculatorState.pension > 0" class="ng-hide">
                  <td>Pension HMRC</td>
                  <td class="ng-binding">0.00</td>
                  <td class="ng-binding">0.00</td>
                  <td class="ng-binding">0.00</td>
                </tr>
                <tr class="danger">
                  <td>Total Deductions</td>
                  <td class="ng-binding">11,758.78</td>
                  <td class="ng-binding">979.90</td>
                  <td class="ng-binding">226.13</td>
                </tr>
                <tr class="success">
                  <td>Take Home Pay</td>
                  <td class="ng-binding">33,241.22</td>
                  <td class="ng-binding">2,770.10</td>
                  <td class="ng-binding">639.25</td>
                </tr>
                <tr ng-show="calculatorState.prevRuleSet" class="">
                  <td>Take Home Last Year</td>
                  <td class="ng-binding">33,063.36</td>
                  <td class="ng-binding">2,755.28</td>
                  <td class="ng-binding">635.83</td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="row result-block ng-scope">
              <h4>Analysis</h4>
              <p class="result-summary-2">Over a working lifetime at the current salary you will take home
                <span class="result-highlight ng-binding">£1,495,854.90</span> and pay
                <span class="result-highlight-red ng-binding">£529,145.10</span> in tax.</p>
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
    <script src="bower_components/angular-resource/angular-resource.js"></script>
    <script src="bower_components/angular-cookies/angular-cookies.js"></script>
    <script src="bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="bower_components/angular-route/angular-route.js"></script>
    <script src="bower_components/angular-animate/angular-animate.js"></script>
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:js({.tmp,app}) scripts/scripts.js -->
    <script src="scripts/app.js"></script>
    <script src="scripts/services/processRules.js"></script>
    <script src="scripts/services/rules/ukRuleFactory.js"></script>
    <script src="scripts/controllers/main.js"></script>
    <script src="scripts/directives/stackDirective.js"></script>
    <script src="scripts/directives/donutDirective.js"></script>
    <!-- endbuild -->

    <!-- build:js({app,.tmp}) scripts/plot.js -->
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
