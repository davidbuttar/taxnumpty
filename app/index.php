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
    <meta name="viewport" content="width=device-width">
    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- build:css styles/vendor.css -->
    <!-- bower:css -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.css" />
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

          <div class="salary-settings ng-scope" style="height: 1200px;">
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
                <p class="result-summary ng-hide" ng-show="summaryPeriods.hourly"><span class="result-label">Hourly take home pay</span> <span class="result-highlight ng-binding">£15.75</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.hourly"><span class="result-label-deduction">Hourly Deductions</span> <span class="result-highlight-red ng-binding">£7.32</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.daily"><span class="result-label">Daily take home pay</span> <span class="result-highlight ng-binding">£118.16</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.daily"><span class="result-label-deduction">Daily Deductions</span> <span class="result-highlight-red ng-binding">£54.92</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.weekly"><span class="result-label">Weekly take home pay</span> <span class="result-highlight ng-binding">£590.79</span></p>
                <p class="result-summary ng-hide" ng-show="summaryPeriods.weekly"><span class="result-label-deduction">Weekly Deductions</span> <span class="result-highlight-red ng-binding">£274.59</span></p>
                <p class="result-summary" ng-show="summaryPeriods.monthly"><span class="result-label">Monthly take home pay</span> <span class="result-highlight ng-binding">£2,560.10</span></p>
                <p class="result-summary" ng-show="summaryPeriods.monthly"><span class="result-label-deduction">Monthly Deductions</span> <span class="result-highlight-red ng-binding">£1,189.90</span></p>
                <p class="result-summary" ng-show="summaryPeriods.yearly"><span class="result-label">Yearly take home pay</span> <span class="result-highlight ng-binding">£30,721.22</span><span class="result-highlight"></span></p>
                <p class="result-summary" ng-show="summaryPeriods.yearly"><span class="result-label-deduction">Yearly Deductions</span> <span class="result-highlight-red ng-binding">£14,278.78</span></p>
              </div>
              <div chart-donut="" salary-values="[calculatorState.totalTakeHome, calculatorState.totalDeductions]" chart-id="pieChart" class="result-summary-chart ng-isolate-scope">
                <div id="pieChart" class="cbc-chart"><div class="cbc-da" id="cbc-da-1" style="width:100%; height:100%; position:absolute; top:0; left:0;"><canvas width="300" height="180" class="cbc-canvas" style="text-align: left; display: inline-block; overflow: hidden;">&nbsp;</canvas><canvas width="300" height="180" class="cbc-canvas" style="text-align: left; display: inline-block; overflow: hidden;">&nbsp;</canvas></div><div class="cbc-ha" id="cbc-ha-1" style="width:100%; height:100%; position:absolute; top:0; left:0;z-index:1"></div><div class="cbc-has" id="cbc-has-1" style="width:100%; height:100%; position:absolute; top:0; left:0; z-index:1"></div><div class="cbc-yaxis-container" id="cbc-yaxis-1"></div><div class="cbc-error" id="cbc-error-1" style="display: none;"></div><div class="cbc-tooltips"></div></div>
                <!-- ngIf: calculatorState.salary --><div class="result-summary-percentage ng-scope ng-binding" ng-if="calculatorState.salary">68.27%</div><!-- end ngIf: calculatorState.salary -->
              </div>
            </div>

          </div>
          <div class="row result-block ng-scope">
            <div class="result-hd details-hd">
              <h4>Details</h4>
              <div class="time-period-options">
                <ul>
                  <li ng-class="{selected: detailsPeriods.yearly}" ng-click="toggleDetailsPeriod('yearly')" title="Yearly" class="selected">YR</li>
                  <li ng-class="{selected: detailsPeriods.monthly}" ng-click="toggleDetailsPeriod('monthly')" title="Monthly" class="selected">MN</li>
                  <li ng-class="{selected: detailsPeriods.weekly}" ng-click="toggleDetailsPeriod('weekly')" title="Weekly" class="selected">WK</li>
                  <li ng-class="{selected: detailsPeriods.daily}" ng-click="toggleDetailsPeriod('daily')" title="Daily">DY</li>
                  <li ng-class="{selected: detailsPeriods.hourly}" ng-click="toggleDetailsPeriod('hourly')" title="Hourly">HR</li>
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
                  <!-- ngIf: detailsPeriods.yearly --><th ng-if="detailsPeriods.yearly" class="ng-scope">Yearly</th><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><th ng-if="detailsPeriods.monthly" class="ng-scope">Monthly</th><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><th ng-if="detailsPeriods.weekly" class="ng-scope">Weekly</th><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                </thead>
                <tbody>
                <tr class="success">
                  <td>Salary</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">45,000.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">3,750.00</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">865.38</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr>
                  <td>Taxable</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">35,000.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">2,916.67</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">673.08</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr>
                  <td>Allowance</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">10,000.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">833.33</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">192.31</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr>
                  <td>Income Tax</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">7,627.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">635.58</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">146.67</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr>
                  <td>N.I.</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">4,131.78</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">344.32</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">79.46</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <!-- ngIf: calculatorState.student --><tr ng-if="calculatorState.student" class="warning ng-scope">
                  <td>Student Loan</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">2,520.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">210.00</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">48.46</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr><!-- end ngIf: calculatorState.student -->
                <tr ng-show="calculatorState.pension > 0" class="info ng-hide">
                  <td>Pension</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">0.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">0.00</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">0.00</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr ng-show="calculatorState.pension > 0" class="info ng-hide">
                  <td>Pension HMRC</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">0.00</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">0.00</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">0.00</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr class="deduction">
                  <td>Total Deductions</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">14,278.78</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">1,189.90</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">274.59</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr class="success">
                  <td>Take Home Pay</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">30,721.22</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">2,560.10</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">590.79</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                <tr ng-show="calculatorState.prevRuleSet" class="">
                  <td>Take Home Last Year</td>
                  <!-- ngIf: detailsPeriods.yearly --><td ng-if="detailsPeriods.yearly" class="ng-scope ng-binding">30,495.36</td><!-- end ngIf: detailsPeriods.yearly -->
                  <!-- ngIf: detailsPeriods.monthly --><td ng-if="detailsPeriods.monthly" class="ng-scope ng-binding">2,541.28</td><!-- end ngIf: detailsPeriods.monthly -->
                  <!-- ngIf: detailsPeriods.weekly --><td ng-if="detailsPeriods.weekly" class="ng-scope ng-binding">586.45</td><!-- end ngIf: detailsPeriods.weekly -->
                  <!-- ngIf: detailsPeriods.daily -->
                  <!-- ngIf: detailsPeriods.hourly -->
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row result-block ng-scope">
            <h4>Calculation Log</h4>
            <!-- ngRepeat: entry in previousEntries --><p ng-repeat="entry in previousEntries" class="result-summary-2 ng-scope"><span class="result-summary-2-date ng-binding">6/2/14 11:33 PM</span>
            <span class="result-summary-2-year ng-binding">| Tax Year: UK 2014/15 |</span>
            <span class="result-summary-2-salary ng-binding">Salary: £20,000.00 Yearly |</span>
            <!-- ngIf: entry.student -->
            <span class="result-summary-2-takehome ng-binding">Take Home: £16,554.72</span>
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 -->
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --><span class="result-summary-2-takehome-down ng-scope ng-binding" ng-if="(entry.takeHome - calculatorState.totalTakeHome) < 0">| £14,166.50 less income than current</span><!-- end ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --></p><!-- end ngRepeat: entry in previousEntries --><p ng-repeat="entry in previousEntries" class="result-summary-2 ng-scope"><span class="result-summary-2-date ng-binding">6/2/14 11:34 PM</span>
            <span class="result-summary-2-year ng-binding">| Tax Year: UK 2013/14 |</span>
            <span class="result-summary-2-salary ng-binding">Salary: £41,500.00 Yearly |</span>
            <!-- ngIf: entry.student --><span class="result-summary-2-salary ng-scope" ng-if="entry.student">Student |</span><!-- end ngIf: entry.student -->
            <span class="result-summary-2-takehome ng-binding">Take Home: £28,777.36</span>
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 -->
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --><span class="result-summary-2-takehome-down ng-scope ng-binding" ng-if="(entry.takeHome - calculatorState.totalTakeHome) < 0">| £1,943.86 less income than current</span><!-- end ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --></p><!-- end ngRepeat: entry in previousEntries --><p ng-repeat="entry in previousEntries" class="result-summary-2 ng-scope"><span class="result-summary-2-date ng-binding">6/2/14 11:34 PM</span>
            <span class="result-summary-2-year ng-binding">| Tax Year: UK 2013/14 |</span>
            <span class="result-summary-2-salary ng-binding">Salary: £45,000.00 Yearly |</span>
            <!-- ngIf: entry.student -->
            <span class="result-summary-2-takehome ng-binding">Take Home: £33,063.36</span>
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 --><span class="result-summary-2-takehome-up ng-scope ng-binding" ng-if="(entry.takeHome - calculatorState.totalTakeHome) > 0">| £2,342.14 more income than current</span><!-- end ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 -->
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --></p><!-- end ngRepeat: entry in previousEntries --><p ng-repeat="entry in previousEntries" class="result-summary-2 ng-scope"><span class="result-summary-2-date ng-binding">6/2/14 11:47 PM</span>
            <span class="result-summary-2-year ng-binding">| Tax Year: UK 2013/14 |</span>
            <span class="result-summary-2-salary ng-binding">Salary: £45,000.00 Yearly |</span>
            <!-- ngIf: entry.student --><span class="result-summary-2-salary ng-scope" ng-if="entry.student">Student |</span><!-- end ngIf: entry.student -->
            <span class="result-summary-2-takehome ng-binding">Take Home: £30,495.36</span>
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 -->
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --><span class="result-summary-2-takehome-down ng-scope ng-binding" ng-if="(entry.takeHome - calculatorState.totalTakeHome) < 0">| £225.86 less income than current</span><!-- end ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --></p><!-- end ngRepeat: entry in previousEntries --><p ng-repeat="entry in previousEntries" class="result-summary-2 ng-scope"><span class="result-summary-2-date ng-binding">6/2/14 11:53 PM</span>
            <span class="result-summary-2-year ng-binding">| Tax Year: UK 2014/15 |</span>
            <span class="result-summary-2-salary ng-binding">Salary: £55,000.00 Yearly |</span>
            <!-- ngIf: entry.student --><span class="result-summary-2-salary ng-scope" ng-if="entry.student">Student |</span><!-- end ngIf: entry.student -->
            <span class="result-summary-2-takehome ng-binding">Take Home: £35,621.22</span>
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 --><span class="result-summary-2-takehome-up ng-scope ng-binding" ng-if="(entry.takeHome - calculatorState.totalTakeHome) > 0">| £4,900.00 more income than current</span><!-- end ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 -->
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --></p><!-- end ngRepeat: entry in previousEntries --><p ng-repeat="entry in previousEntries" class="result-summary-2 ng-scope"><span class="result-summary-2-date ng-binding">6/3/14 12:21 AM</span>
            <span class="result-summary-2-year ng-binding">| Tax Year: UK 2014/15 |</span>
            <span class="result-summary-2-salary ng-binding">Salary: £45,000.00 Yearly |</span>
            <!-- ngIf: entry.student --><span class="result-summary-2-salary ng-scope" ng-if="entry.student">Student |</span><!-- end ngIf: entry.student -->
            <span class="result-summary-2-takehome ng-binding">Take Home: £30,721.22</span>
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) > 0 -->
            <!-- ngIf: (entry.takeHome - calculatorState.totalTakeHome) < 0 --></p><!-- end ngRepeat: entry in previousEntries -->
            <!-- ngIf: !previousEntries.length -->
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
    <script src="bower_components/angular-easy-social-share/easy-social-share.js"></script>
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
