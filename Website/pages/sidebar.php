<style>
    .multiselect {
        display: inline-block;
        padding-right: 10px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        padding-right: 10px;
    }

    #checkboxes label {
        display: block;
    }

    #checkboxes label:hover {
        background-color: #1e90ff;
    }

    .Bundesland {
        display: innline;
    }

    .Bundesland > img {
        height: 1em;
        margin-top: auto;
        margin-bottom: auto;
        margin-right: 0.2em;
    }

    #ulFederalStates > li {
        display: flex;
        flex-direction: row;
    }

    .Landkreis {
        padding-left:20px;
    }

    .lkaToggleSpan {
        display: none;
        padding-left: 20px;
    }

    #shShow:checked ~ #sh { display: block;}
    #hhShow:checked ~ #hh { display: block;}
    #niShow:checked ~ #ni { display: block;}
    #brShow:checked ~ #br { display: block;}
    #nwShow:checked ~ #nw { display: block;}

    .bndToggleBox {
        display: none;
    }
    .bndToggleBox + label:before {
        content: "[+]";
        width: 20px;
    }
    .bndToggleBox:checked + label:before {
        content: "[-]";
        width: 20px;
    }

    .bndToggleLable {
        display: inline !important;
    }

    #secFilter {
        width: 20%;
    }

    #secContent {
        width: 80%;
        display: flex;
        justify-content: space-between;
    }

    #secContent > section {
        width: 50%;
    }
</style>

<div class="sidebar" style="">
        <div class="sidebar-inner">
          <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
              <div class="peer peer-greed">
                <a class="sidebar-link td-n" href="">
                  <div class="peers ai-c fxw-nw">
                    <div class="peer">
                      <div class="logo"> <img src="<?php echo $config["site_url"]; ?>/assets/static/images/logo.png" alt=""></div>
                    </div>
                    <div class="peer peer-greed">
                      <h5 class="lh-1 mB-0 logo-text"><?php echo $config["site_name"]; ?></h5>
                    </div>
                  </div>
                </a>
              </div>
              <div class="peer">
                <div class="mobile-toggle sidebar-toggle"><a href="" class="td-n"><i class="ti-arrow-circle-left"></i></a></div>
              </div>
            </div>
          </div>
            <div style="margin-top: 10px;"></div>
          <ul class="sidebar-menu scrollable pos-r">
            <!-- <li class="nav-item mT-30 active"><a class="sidebar-link" href="index.php?page=dashboard"><span class="icon-holder"><i class="c-red-500 ti-home"></i> </span><span class="title">Dashboard</span></a></li> -->
              <?php if($_GET['page'] == "dashboard") { ?>
              <form>
                  <div class="multiselect">
                      <div class="selectBox" onclick="showCheckboxes()">
                          <div class="overSelect"></div>
                      </div>
                      <div id="checkboxes">

                          <?php $checkBoxCounter = 0; ?>

                          <ul id="ulFederalStates">
                              <li>
                                  <!-- +/- Menu (Treelist) -->
                                  <input checked onclick="sendsql()" type="checkbox" id="shShow" class="bndToggleBox"/><label for="shShow" class="bndToggleLable"></label>

                                  <?php
                                    /* <!-- <li class="nav-item mT-30 active"><a class="sidebar-link" href="index.php?page=dashboard"><span class="icon-holder"><i class="c-red-500 ti-home"></i> </span><span class="title">Dashboard</span></a></li> --> */
                                      //schleswigHolstein
                                      echo "<label for='{$checkBoxCounter}' class='Bundesland'><img src=\"assets/bundeslaender/Schleswig-Holstein.png\" alt=\"Schleswig-Holsteins Logo\"><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />Schleswig-Holstein</label>";
                                      $checkBoxCounter++;
                                      ?>
                                      <span id="sh" class="lkaToggleSpan">
								<?php
                                foreach ($arraySchleswigHolstein as $landkreis) {
                                    echo "<label for='{$checkBoxCounter}' class='Landkreis'><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />{$landkreis}</label>";
                                    $checkBoxCounter++;
                                }
                                ?>
							</span>
                              </li>
                              <li>
                                  <input onclick="sendsql()" type="checkbox" id="hhShow" class="bndToggleBox"/><label for="hhShow" class="bndToggleLable"></label>
                                  <?php
                                      //Hamburg
                                      echo "<label for='{$checkBoxCounter}' class='Bundesland'><img src=\"assets/bundeslaender/Hamburg.png\" alt=\"Hamburg Logo\"><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />Hamburg</label>";
                                      $checkBoxCounter++;
                                  ?>
                                  <span id="hh" class="lkaToggleSpan">
								<?php
                                foreach ($arrayHamburg as $landkreis) {
                                    echo "<label for='{$checkBoxCounter}' class='Landkreis'><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />{$landkreis}</label>";
                                    $checkBoxCounter++;
                                }
                                ?>
							</span>
                              </li>
                              <li>
                                  <input onclick="sendsql()" type="checkbox" id="niShow" class="bndToggleBox"/><label for="niShow" class="bndToggleLable"></label>
                                  <?php
                                  //Niedersachsen
                                  echo "<label for='{$checkBoxCounter}' class='Bundesland'><img src=\"assets/bundeslaender/Niedersachsen.png\" alt=\"Niedersachsen Logo\"><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />Niedersachsen</label>";
                                  $checkBoxCounter++;
                                  ?>
                                  <span id="ni" class="lkaToggleSpan">
								<?php
                                foreach ($arrayNiedersachsen as $landkreis) {
                                    echo "<label for='{$checkBoxCounter}' class='Landkreis'><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />{$landkreis}</label>";
                                    $checkBoxCounter++;
                                }
                                ?>
							</span>
                              </li>
                              <li>
                                  <input onclick="sendsql()" type="checkbox" id="brShow" class="bndToggleBox"/> <label for="brShow" class="bndToggleLable"></label>
                                  <?php
                                  //Bremen
                                  echo "<label for='{$checkBoxCounter}' class='Bundesland'><img src=\"assets/bundeslaender/Bremen.png\" alt=\"Bremen Logo\"><input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />Bremen</label>";
                                  $checkBoxCounter++;
                                  ?>
                                  <span id="br" class="lkaToggleSpan">
								<?php
                                foreach ($arrayBremen as $landkreis) {
                                    echo "<label for='{$checkBoxCounter}' class='Landkreis'> <input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />{$landkreis}</label>";
                                    $checkBoxCounter++;
                                }
                                ?>
							</span>
                              </li>
                              <li>
                                  <input onclick="sendsql()" type="checkbox" id="nwShow" class="bndToggleBox"/><label for="nwShow" class="bndToggleLable"></label>
                                  <?php
                                  //Mecklenburg-Vorpommern
                                  echo "<label for='{$checkBoxCounter}' class='Bundesland'><img src=\"assets/bundeslaender/Mecklenburg-Vorpommern.png\" alt=\"Mecklenburg-Vorpommern Logo\"><input type='checkbox' id='{$checkBoxCounter}' />Mecklenburg-Vorpommern</label>";
                                  $checkBoxCounter++;
                                  ?>
                                  <span id="nw" class="lkaToggleSpan">
								<?php
                                foreach ($arrayMecklenburgVorpommern as $landkreis) {
                                    echo "<label for='{$checkBoxCounter}' class='Landkreis'> <input onclick=\"sendsql()\" type='checkbox' id='{$checkBoxCounter}' />{$landkreis}</label>";
                                    $checkBoxCounter++;
                                }
                                ?>
							</span>
                              </li>
                          </ul>
                      </div>
                  </div>
              </form>
              <button type="button" onclick="sendsql()" class="btn btn-danger btn-lg">Ausrechnen</button>
              <?php } else if($_GET['page'] == "map") {

              } ?>
              <?php /* ?>
              <!-- Bremen -->
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><img src="<?php echo $config["site_url"]; ?>/assets/bundeslaender/Bremen.png"> </span><span class="title">Bremen</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
              <ul class="dropdown-menu">
                <li><a class="sidebar-link" href="index.php?page=showsummary&state=bremen&resolution=month">Übersicht</a></li>
                <li><a class="sidebar-link" href="">Vergleichen mit...</a></li>
              </ul>
            </li>
            <!-- Hamburg -->
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><img src="<?php echo $config["site_url"]; ?>/assets/bundeslaender/Hamburg.png"> </span><span class="title">Hamburg</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
              <ul class="dropdown-menu">
                <li><a class="sidebar-link" href="index.php?page=showsummary&state=hamburg&resolution=month">Übersicht</a></li>
                <li><a class="sidebar-link" href="">Vergleichen mit...</a></li>
              </ul>
            </li>
            <!-- Mecklenburg-Vorpommern -->
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><img src="<?php echo $config["site_url"]; ?>/assets/bundeslaender/Mecklenburg-Vorpommern.png"> </span><span class="title">Mecklenburg Vorp.</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
              <ul class="dropdown-menu">
                <li><a class="sidebar-link" href="index.php?page=showsummary&state=mecklenburgVorpommern&resolution=month">Übersicht</a></li>
                <li><a class="sidebar-link" href="">Vergleichen mit...</a></li>
              </ul>
            </li>
            <!-- Niedersachsen -->
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><img src="<?php echo $config["site_url"]; ?>/assets/bundeslaender/Niedersachsen.png"> </span><span class="title">Niedersachsen</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
              <ul class="dropdown-menu">
                <li><a class="sidebar-link" href="index.php?page=showsummary&state=niedersachsen&resolution=month">Übersicht</a></li>
                <li><a class="sidebar-link" href="">Vergleichen mit...</a></li>
              </ul>
            </li>
            <!-- Schleswig-Holstein -->
            <li class="nav-item dropdown">
              <a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><img src="<?php echo $config["site_url"]; ?>/assets/bundeslaender/Schleswig-Holstein.png"> </span><span class="title">Schleswig Holstein</span> <span class="arrow"><i class="ti-angle-right"></i></span></a>
              <ul class="dropdown-menu">
                <li><a class="sidebar-link" href="index.php?page=showsummary&state=schleswigHolstein&resolution=month">Übersicht</a></li>
                <li><a class="sidebar-link" href="">Vergleichen mit...</a></li>
              </ul>
            </li>
              <?php */ ?>

              <li class="nav-item mT-30 active"><a class="sidebar-link" href="index.php?page=credits"><span class="icon-holder"><i class="c-red-500 ti-crown"></i> </span><span class="title">Credits</span></a></li>
          </ul>
        </div>
      </div>