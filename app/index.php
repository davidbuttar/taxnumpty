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
  </head>
  <body ng-app="taxnumptyApp">
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->



    <!-- Add your site or application content here -->
    <div class="header">
      <h3>Taxedplanet | UK Tax Calculator</h3>
    </div>
    <div class="results-container">
        <div class="results" ng-view="">
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
    <script src="scripts/services/rules/uk201314.js"></script>
    <script src="scripts/controllers/main.js"></script>
    <!-- endbuild -->

    <!-- build:js({app,.tmp}) scripts/pl.js -->
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
    <script type="text/javascript" src="scripts/pl/types/cbv.pie.js"></script>
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
