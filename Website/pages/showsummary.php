<?php
/**
 * Created by PhpStorm.
 * User: böltesy
 * Date: 05.03.2019
 * Time: 08:58
 */

$error = "0";
$n = 0;
$heute = [
    "tag"   => date("d"),
    "monat" => date("m"),
    "jahr"  => date("y")
];
if(!isset($_GET["state"]) || empty($_GET["state"])) {
    echo '<script>alert("Es wurde kein Bundesland angewählt!");</script>';
    redirect("dashboard");
} else {
    $bundesland = $_GET["state"];
    $niceBundesland = ucwords($bundesland);
}

if(!isset($_GET["resolution"]) || empty($_GET["resolution"])) {
    $resolution = "month";
} else {
    switch ($_GET["resolution"]) {
        case "day":
            $resolution = $_GET["resolution"];
            break;
        case "month":
            $resolution = $_GET["resolution"];
            break;
        case "year":
            $resolution = $_GET["resolution"];
            break;
        default:
            $error = "Ungültige Auflösung";
            $resolution = "month";
            break;
    }
}

if($resolution = "month") {
    if(isset($_GET["start"])) {
        $startyear = substr($_GET["start"], 0, 4);
        $startmonth = str_replace("0", "",substr($_GET["start"], 5, 2));
    } else {
        $startyear = getNewestYearByState(getLandKreisID($bundesland))-1;
        $startmonth = "1";
    }
    if(isset($_GET["ende"])) {
        $endyear = substr($_GET["ende"], 0, 4);
        $endmonth = str_replace("0", "",substr($_GET["ende"], 5, 2));
    } else {
        getLandKreisID($bundesland);
        $endyear = getNewestYearByState(getLandKreisID($bundesland));
        $endmonth = getNewestMonthByState(getLandKreisID($bundesland), $endyear);
    }
}

if($error != "0") { ?>
    <div class="alert alert-danger"><strong>FEHLER: </strong> <?php echo $error; ?></div>
<?php } ?>

<h1>Übersicht für Bundesland <span style="text-transform: capitalize;"><?php echo $bundesland; ?></span></h1>
<h4>Auflösung: <?php echo getResolutionNiceName($resolution); ?> ( <?= $startmonth.".".$startyear." - ".$endmonth.".".$endyear; ?> )</h4>
<button type="button" class="btn cur-p btn-outline-info" data-toggle="modal" data-target="#changeResolutionModal">Auflösung ändern</button>
<hr>


<div style="width:100%;">
    <canvas id="canvas"></canvas>
</div>
<script>
    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var config = {
        type: 'line',
        data: {
            <?php
                if($resolution == "day") {
                    echo "labels: ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'],";
                } else if($resolution == "month") {
                   /* $sp1 = "labels: ['";
                    $m = $startmonth;
                    $j = $startyear;
                    if($startyear == $endyear) {
                        while($m != $endmonth+1 OR $j != $endyear) {
                            if($m == "12") {
                                $m = "1";
                                $j++;
                            }
                            $sp1 = $sp1.$monateLang[$m]." - ".$j."',";
                            $m++;
                        }
                        echo $sp1."],";
                    } else {
                        while($m != $endmonth+1 AND $j != $endyear) {
                            if($m == "12") {
                                $m = "1";
                                $j++;
                            }
                            $sp1 = $sp1.$monateLang[$m]." - ".$j."',";
                            $m++;
                        }
                        echo $sp1."],";
                    }*/
                    echo "labels: ['Januar - JAHR', 'Feburar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'Septemper', 'Oktober', 'Dezember'],";
                }
            ?>

            <?php if($resolution == "day") { ?>
            datasets: [{
                label: 'Besucherzahlen des Bundesland <?php echo $niceBundesland; ?>',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                label: 'Besucherzahlen des Bundesland <?php echo $niceBundesland; ?>',
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                fill: false,
            }],
            datasets: [{
                label: 'Besucherzahlen des Bundesland <?php echo $niceBundesland; ?>',
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                fill: false,
            }]
            <?php } else if($resolution == "month") { ?>
            datasets: [
                <?php
                    if($bundesland == "bremen") {
                        foreach ($arrayBremen as $stateArray) { ?>
                        {
                    label: 'Ankünfte des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        <?php
                            $m = $startmonth;
                            $j = $startyear;
                            if($startyear == $endyear) {
                                while($m != $endmonth+1 OR $j != $endyear) {
                                    if($m == "12") {
                                        $m = "1";
                                        $j++;
                                    }
                                    echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                    $m++;
                                }
                            } else {
                                while($m != $endmonth+1 AND $j != $endyear) {
                                    if($m == "12") {
                                        $m = "1";
                                        $j++;
                                    }
                                    echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                    $m++;
                                }
                            }
                        ?>

                        <?php /* echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $startmonth, $startyear) ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $endmonth, $endyear) ?>
                        <?php  echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "3", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "4", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "5", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "6", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "7", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "8", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "9", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "10", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "11", "2017") ?>,
                        <?php echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), "12", "2017") */?>
                    ],
                    fill: false,
                },
                {
                    label: 'Übernachtungen des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                        <?php /* echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $startmonth, $startyear) ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $endmonth, $endyear) ?>,
                        <?php  echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "3", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "4", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "5", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "6", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "7", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "8", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "9", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "10", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "11", "2017") ?>,
                        <?php echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), "12", "2017") */ ?>
                    ],
                    fill: false,
                },
                    <?php }
               } else if($bundesland == "hamburg") {
                foreach ($arrayHamburg as $stateArray) { ?>
                {
                    label: 'Ankünfte des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                {
                    label: 'Übernachtungen des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                <?php }

                } else if($bundesland == "mecklenburgVorpommern") {
                foreach ($arrayMecklenburgVorpommern as $stateArray) { ?>
                {
                    label: 'Ankünfte des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                {
                    label: 'Übernachtungen des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                <?php }

                } else if($bundesland == "niedersachsen") {
                foreach ($arrayNiedersachsen as $stateArray) { ?>
                {
                    label: 'Ankünfte des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                {
                    label: 'Übernachtungen des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                <?php }

                } else if($bundesland == "schleswigHolstein") {
                foreach ($arraySchleswigHolstein as $stateArray) { ?>
                {
                    label: 'Ankünfte des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        /* TODO: Bug bei gleichem Jahr! Beheben sonst steinigung */
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getAnkuenfteDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                {
                    label: 'Übernachtungen des Bundesland <?php echo $stateArray; ?>',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        <?php
                        $m = $startmonth;
                        $j = $startyear;
                        if($startyear == $endyear) {
                            while($m != $endmonth+1 OR $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        } else {
                            while($m != $endmonth+1 AND $j != $endyear) {
                                if($m == "12") {
                                    $m = "1";
                                    $j++;
                                }
                                echo getUebernachtungenDataMonthly(getLandKreisID($stateArray), $m, $j).",";
                                $m++;
                            }
                        }
                        ?>
                    ],
                    fill: false,
                },
                <?php }

                }
            }?>
       ]


        },
        options: {
            responsive: true,
            title: {
                display: true,
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Monat'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Besucherzahl'
                    }
                }]
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
    };

    var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
        var colorName = colorNames[config.data.datasets.length % colorNames.length];
        var newColor = window.chartColors[colorName];
        var newDataset = {
            label: 'Dataset ' + config.data.datasets.length,
            backgroundColor: newColor,
            borderColor: newColor,
            data: [],
            fill: false
        };

        for (var index = 0; index < config.data.labels.length; ++index) {
            newDataset.data.push(randomScalingFactor());
        }

        config.data.datasets.push(newDataset);
        window.myLine.update();
    });
</script>

<!-- Modal -->
<div class="modal fade" id="changeResolutionModal" tabindex="-1" role="dialog" aria-labelledby="changeResolutionModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Auflösung ändern</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schließen">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="index.php">
                <input type="hidden" name="page" value="showsummary">
                <input type="hidden" name="state" value="<?= $bundesland; ?>">
                <div class="modal-body">
                    <h5>Gegenwärtige Auflösung: <?php echo getResolutionNiceName($resolution); ?></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <center><label>START</label></center>
                            <input type="date" name="start" max="3000-12-31"
                                   min="2008-01-01" class="form-control" value="<?php echo $heute["jahr"]."-".$heute["monat"]."-".$heute["tag"]; ?>">
                        </div>
                        <div class="col-md-6">
                            <center><label>ENDE</label></center>
                            <input type="date" name="ende" max="3000-12-31"
                                   min="2008-01-01" class="form-control" value="<?php echo $heute["jahr"]."-".$heute["monat"]."-".$heute["tag"]; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Auflösung ändern</button>
                </div>
            </form>
        </div>
    </div>
</div>

