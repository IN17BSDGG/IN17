<?php
require_once("system/config.inc.php");
require_once("system/functions.inc.php");
require_once("system/landkreise.inc.php");
require_once("system/geoPHP.inc");

if(!isset($_SESSION["UID"])) {
  header("Location: login/index.php");
}

define('allowed', true);
if(!isset($_GET["page"])) {
  header("Location: index.php?page=dashboard");
}

$heute = [
    "tag"   => date("d"),
    "monat" => date("m"),
    "jahr"  => date("y")
];
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Dashboard</title>
    <style>#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}</style>
    <link href="<?php echo $config["site_url"]; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo $config["site_url"]; ?>css/bootstrap-datepicker.min.css" rel="stylesheet">
      <script type="text/javascript" src="<?php echo $config["site_url"]; ?>/js/jquery-3.3.1.min.js"></script>
      <!-- Diagramme!!! <3 -->
      <script type="text/javascript" src="<?php echo $config["site_url"]; ?>/js/Chart.bundle.min.js"></script>
      <script type="text/javascript" src="<?php echo $config["site_url"]; ?>/js/Chart.utils.js"></script>
      <script type="text/javascript" src="<?php echo $config["site_url"]; ?>/js/bootstrap-datepicker.min.js"></script>
  </head>
  <style>
      .header {
          height: 66px !important;
      }
  </style>
  <script>
      var expanded = false;

      function showCheckboxes() {
          var checkboxes = document.getElementById("checkboxes");
          if (!expanded) {
              checkboxes.style.display = "block";
              expanded = true;
          } else {
              checkboxes.style.display = "none";
              expanded = false;
          }
      }

      function getSelectedLka() {
          const inputs = document.getElementsByTagName('input');
          let selected = [];
          for (let value of inputs) {
              if (value.type == "checkbox")
              {

                  if (value.checked)
                  {

                      if (value.parentElement.classList.contains("Landkreis")) {
                          selected.push(value.parentElement.innerText);
                      }
                  }
              }
          }
          return selected;
      }

      function getSelectedBnd() {
          const inputs = document.getElementsByTagName('input');
          let selected = [];
          for (let value of inputs) {
              if (value.type == "checkbox") {
                  if (value.checked) {
                      if (value.parentElement.classList.contains("Bundesland")) {
                          selected.push(value.parentElement.innerText);
                      }
                  }
              }
          }
          return selected;
      }

      function sqlPost(params) {
          var url = '<?php echo $config["site_url"].$config["api_url"]; ?>';

          var xhr = new XMLHttpRequest();
          xhr.open('POST', url, true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xhr.onload = function () {
              //console.log(this.responseText);#
              updateChart(this.responseText);
          };
          xhr.send(params);

      }

      function sendsql(){
          let lkas = getSelectedLka();
          let bnds = getSelectedBnd();

          let startDate = document.getElementById("startDate").value;
          let endDate   = document.getElementById("endDate").value;

          if(startDate == "" || endDate == "") {
                startDate = "01/2009";
                endDate = "01/2010";
          }

          if(lkas.length <= 0 && bnds.length <= 0) {
              alert("Bitte mindestens ein Bundesland oder Landkreis auswählen")
              return;
          }

          let arrayLength = lkas.length;
          let lkasString = "";
          for (var i = 0; i < arrayLength; i++) {
              lkasString += lkas[i] + ","
          }
          lkasString = lkasString.substr(0, lkasString.length-1);
          arrayLength = bnds.length;

          let bndsString = "";
          for (var i = 0; i < arrayLength; i++) {
              bndsString += bnds[i] + ",";
          }
          bndsString = bndsString.substr(0, bndsString.length-1);
          params = "lkas="+lkasString+"&bnds="+bnds+"&sdate="+startDate+"&edate="+endDate;

          sqlPost(params);
      }
      /* Please forgive me Jesus */

      $( document ).ready(function() {
          console.log( "Website vollständig Geladen! AMK!!" );
          //var ctx = document.getElementById('myChart').getContext('2d');
          //window.myLine = new Chart(ctx, config);
      });

      function updateChart(data) {

          jsonData = JSON.parse(data);

          let jsonDataLength = jsonData.length;

          let sortedArrayByDate = {};

          let yearList = [];
          let monthList = [];
          let lableList = [];


          let startDate = document.getElementById("startDate").value;
          let endDate   = document.getElementById("endDate").value;

          if(startDate == "" || endDate == "") {
              startDate = "01/2009";
              endDate = "01/2010";
          }

          startDate = startDate.split("/");
          endDate = endDate.split("/");

          for (let i = 0; i < jsonDataLength;i++) {

              let tempMonth = jsonData[i]["monat"];
              let tempYear= jsonData[i]["jahr"];
              let tempName= jsonData[i]["name"];

              let skip = false;

              //start jahr
              if(startDate[1] == Number(tempYear)) {
                  if(Number(tempMonth) < startDate[0]) {
                      skip = true;
                  }
              }

              if(endDate[1] == Number(tempYear)) {
                  if(Number(tempMonth) > endDate[0]) {
                      skip = true;
                  }
              }


              if(!skip) {
                  let tempIntYear = parseInt(tempYear);
                  if (yearList.indexOf(tempIntYear) == -1) {
                      yearList.push(tempIntYear);
                  }

                  if (monthList.indexOf(tempMonth) == -1) {
                      monthList.push(tempMonth);
                  }

                  let templabel = tempMonth + " - " + tempYear;
                  if (lableList.indexOf(templabel) == -1) {
                      lableList.push(templabel);
                  }

                  let tempNameObj = {
                      ankuenfte: parseInt(jsonData[i]["ankuenfte"]),
                      uebernachtungen: parseInt(jsonData[i]["uebernachtungen"])
                  };

                  if (typeof sortedArrayByDate[tempYear] == 'undefined') {
                      sortedArrayByDate[tempYear] = {};
                  }

                  if (typeof sortedArrayByDate[tempYear][tempMonth] == 'undefined') {
                      sortedArrayByDate[tempYear][tempMonth] = {};
                  }

                  if (typeof sortedArrayByDate[tempYear][tempMonth][tempName] == 'undefined') {
                      sortedArrayByDate[tempYear][tempMonth][tempName] = {};
                  }

                  sortedArrayByDate[tempYear][tempMonth][tempName] = tempNameObj;
              }
          }

          lableList.sort(function(a, b){

              a = a.split("-");
              b = b.split("-")
              return new Date(a[1], a[0], 1) - new Date(b[1], b[0], 1)

          });

          monthList.sort(function(a, b){

              aInt = parseInt(a);
              bInt = parseInt(b);

              return aInt-bInt;

          });

          yearList.sort();

          let sortedObj = {};
          let sortedObjUebernachtungen = {};

          for (let i = 0; i < yearList.length; i++) {

              let currentYear = sortedArrayByDate[yearList[i]];

              for (let ix = 0; ix < monthList.length; ix++) {

                  let currentMonth = currentYear[monthList[ix]];

                  for (let name in currentMonth) {

                      if(typeof sortedObj[name]  == 'undefined') {
                          sortedObj[name] = [];
                      }

                      if(typeof sortedObjUebernachtungen[name]  == 'undefined') {
                          sortedObjUebernachtungen[name] = [];
                      }

                      if(currentMonth[name]["ankuenfte"] == null) {
                          currentMonth[name]["ankuenfte"] = 0;
                      }

                      if(currentMonth[name]["uebernachtungen"] == null) {
                          currentMonth[name]["uebernachtungen"] = 0;
                      }

                      sortedObj[name].push(currentMonth[name]["ankuenfte"]);
                      sortedObjUebernachtungen[name].push(currentMonth[name]["uebernachtungen"]);

                  }
              }
          }

          //Erstellt das die datensätze für ankuenfte
          datasets = [];
          datasets = createDatasets(sortedObj, "Ankünfte ");

          datasetsuebernachtungen = [];
          datasetsuebernachtungen = createDatasets(sortedObjUebernachtungen, "Übernachtungen ");



          myChart.data.labels = lableList;

          if(document.getElementById("selectUebernachtungenCheckbox").checked && document.getElementById("selectAnkuenfteCheckbox").checked) {
              //Wenn beide, you know
              var bigChungus = datasets.concat(datasetsuebernachtungen);
              myChart.data.datasets = bigChungus;
          } else if(document.getElementById("selectUebernachtungenCheckbox").checked) {
              myChart.data.datasets = datasetsuebernachtungen;
          } else if(document.getElementById("selectAnkuenfteCheckbox").checked) {
              myChart.data.datasets = datasets;
          } else {
              alert("Bitte wählen Sie zuerst einen Datensatz aus.");
          }



          myChart.update();

          myChart.render({
              duration: 0,
              lazy: false,
              easing: ''
          });

          //window.myLine.update();
      }

      function createDatasets(passedObj, preLable) {

          let tempDataArray = [];

          for (let key in passedObj) {

              let tempData = passedObj[key];

              let colorArray = randomColor();

              console.log(key + " : " + colorArray);

              let tempObj = 	{
                  label:	preLable + key,
                  data: 	tempData,
                  fill: 	false,
                  backgroundColor: `rgba(${colorArray[0]},${colorArray[1]},${colorArray[2]},0.5)`,
                  borderColor: `rgba(${colorArray[0]},${colorArray[1]},${colorArray[2]},1)`,
                  borderWidth: 3
              }

              tempDataArray.push(tempObj);

          }

          return tempDataArray;
      }

      colorList = {
          aqua: [0,255,255],
          aquamarine: [127,255,212],
          black:  [0,0,0],
          blue: [0,0,255],
          blueviolet: [138,43,226],
          brown:  [165,42,42],
          burlywood:  [222,184,135],
          cadetblue:  [95,158,160],
          chartreuse: [127,255,0],
          chocolate:  [210,105,30],
          coral:  [255,127,80],
          cornflowerblue: [100,149,237],
          crimson:  [220,20,60],
          cyan: [0,255,255],
          darkblue: [0,0,139],
          darkcyan: [0,139,139],
          darkgoldenrod:  [184,134,11],
          darkgray: [169,169,169],
          darkgreen:  [0,100,0],
          darkgrey: [169,169,169],
          darkkhaki:  [189,183,107],
          darkmagenta:  [139,0,139],
          darkolivegreen: [85,107,47],
          darkorange: [255,140,0],
          darkorchid: [153,50,204],
          darkred:  [139,0,0],
          darksalmon: [233,150,122],
          darkseagreen: [143,188,143],
          darkslateblue:  [72,61,139],
          darkslategray:  [47,79,79],
          darkslategrey:  [47,79,79],
          darkturquoise:  [0,206,209],
          darkviolet: [148,0,211],
          deeppink: [255,20,147],
          deepskyblue:  [0,191,255],
          dimgray:  [105,105,105],
          dimgrey:  [105,105,105],
          dodgerblue: [30,144,255],
          firebrick:  [178,34,34],
          forestgreen:  [34,139,34],
          fuchsia:  [255,0,255],
          gold: [255,215,0],
          goldenrod:  [218,165,32],
          gray: [128,128,128],
          green:  [0,128,0],
          greenyellow:  [173,255,47],
          grey: [128,128,128],
          hotpink:  [255,105,180],
          indianred:  [205,92,92],
          indigo: [75,0,130],
          lawngreen:  [124,252,0],
          lightblue:  [173,216,230],
          lightcoral: [240,128,128],
          lightgreen: [144,238,144],
          lightpink:  [255,182,193],
          lightsalmon:  [255,160,122],
          lightseagreen:  [32,178,170],
          lightskyblue: [135,206,250],
          lightslategray: [119,136,153],
          lightslategrey: [119,136,153],
          lightsteelblue: [176,196,222],
          lime: [0,255,0],
          limegreen:  [50,205,50],
          magenta:  [255,0,255],
          maroon: [128,0,0],
          mediumaquamarine: [102,205,170],
          mediumblue: [0,0,205],
          mediumorchid: [186,85,211],
          mediumpurple: [147,112,219],
          mediumseagreen: [60,179,113],
          mediumslateblue:  [123,104,238],
          mediumspringgreen:  [0,250,154],
          mediumturquoise:  [72,209,204],
          mediumvioletred:  [199,21,133],
          midnightblue: [25,25,112],
          navy: [0,0,128],
          olive:  [128,128,0],
          olivedrab:  [107,142,35],
          orange: [255,165,0],
          orangered:  [255,69,0],
          orchid: [218,112,214],
          palegreen:  [152,251,152],
          paleturquoise:  [175,238,238],
          palevioletred:  [219,112,147],
          peru: [205,133,63],
          pink: [255,192,203],
          plum: [221,160,221],
          powderblue: [176,224,230],
          purple: [128,0,128],
          rebeccapurple: [102, 51, 153],
          red:  [255,0,0],
          rosybrown:  [188,143,143],
          royalblue:  [65,105,225],
          saddlebrown:  [139,69,19],
          salmon: [250,128,114],
          sandybrown: [244,164,96],
          seagreen: [46,139,87],
          sienna: [160,82,45],
          silver: [192,192,192],
          skyblue:  [135,206,235],
          slateblue:  [106,90,205],
          slategray:  [112,128,144],
          slategrey:  [112,128,144],
          springgreen:  [0,255,127],
          steelblue:  [70,130,180],
          tan:  [210,180,140],
          teal: [0,128,128],
          thistle:  [216,191,216],
          tomato: [255,99,71],
          turquoise:  [64,224,208],
          violet: [238,130,238],
          yellow: [255,255,0],
          yellowgreen:  [154,205,50]
      };


      function randomColor() {
          var keys = Object.keys(colorList)
          return colorList[keys[ keys.length * Math.random() << 0]];
      };
  </script>
  <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>
    <script>window.addEventListener('load', () => {
      const loader = document.getElementById('loader');
      setTimeout(() => {
        loader.classList.add('fadeOut');
      }, 300);
      });
    </script>
    <style>
        .datepicker table tr td span {
            display: block;
            width: 23%;
            height: 54px;
            line-height: 54px;
            float: left;
            margin: 1%;
            cursor: pointer;
            border-radius: 4px;
        }

    </style>
    <div>
      <?php include("pages/sidebar.php"); ?>
      <div class="page-container">
        <div class="header navbar">
          <div class="header-container">
            <ul class="nav-left">
                <li class="">
                    <a class="no-pdd-right" >
                        <label for="selectUebernachtungenCheckbox">
                            <input type="checkbox" id="selectUebernachtungenCheckbox" checked onclick="sendsql()">
                            Übernachtungen
                        </label>
                        <label for="selectAnkuenfteCheckbox">
                            <input type="checkbox" id="selectAnkuenfteCheckbox" checked onclick="sendsql()">
                            Ankünfte
                        </label>
                        <label>
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="start" id="startDate" />
                            <span class="input-group-addon">bis</span>
                            <input type="text" class="input-sm form-control" name="end" id="endDate"/>
                        </div>
                        </label>
                    </a>
                </li>
            </ul>
              <!-- NAVBAR -->
            <ul class="nav-right">
              <li class="dropdown">
                <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                  <div class="peer mR-10"><img class="w-2r bdrs-50p" src="<?php echo $config["site_url"]."/assets/avatar/".getAvatar($_SESSION["UID"]); ?>" alt=""></div>
                  <div class="peer"><span class="fsz-sm c-grey-900"><?php echo getDisplayName($_SESSION["UID"]); ?></span></div>
                </a>
                <ul class="dropdown-menu fsz-sm">
                  <!--
                  <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-settings mR-10"></i> <span>Einstellungen</span></a></li>
                  <li><a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-user mR-10"></i> <span>Mein Profil</span></a></li>
                  <li role="separator" class="divider"></li>
    -->
                  <li><a href="logout/index.php" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-power-off mR-10"></i> <span>Ausloggen</span></a></li>
                </ul>
              </li>
            </ul>
              <!-- / END NAVBAR -->
          </div>
        </div>
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
          <?php
          if(defined("dberror")) {
              //include "module/error.php?errtype=sqlcon";
              include "pages/error.php";
          } else {
              if(isset($_GET['page'])){
                  $page = htmlspecialchars($_GET['page']);
                  if(file_exists("pages/$page.php")){
                      include("pages/".$page.".php");
                  }else{
                      $_GET['page'] = "404";
                      include "errpages/404.php";
                  }
              }else{
                  $_GET['page'] = "dashboard";
                  include "pages/dashboard.php";
              }
          }
          ?>
          </div>
        </main>
        <?php include("pages/footer.php"); ?>
      </div>
    </div>

    <script type="text/javascript" src="<?php echo $config["site_url"]; ?>/js/vendor.js"></script>
    <script type="text/javascript" src="<?php echo $config["site_url"]; ?>/js/bundle.js"></script>

  <script>
      $('#datepicker').datepicker({
          format: "mm/yyyy",
          language: "de",
          startDate: new Date("2009/01/01"),
          startView: 2,
          minViewMode: 1
      });
  </script>
  </body>
</html>

