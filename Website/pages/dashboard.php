<?php
/**
 * Created by PhpStorm.
 * User: böltesy
 * Date: 29.03.2019
 * Time: 10:20
 */
?>
<canvas id="myChart" ></canvas>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            /* TODO: Funktion für Bundesländer/Daten */
            labels: [],
            borderColor: window.chartColors.red,
            datasets: [{
                label: '',
                data: [],
                borderColor: [],
                borderWidth: 0
            }]
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
                        labelString: 'Zeit'
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
    });
</script>

<script>
/*
    $( document ).ready(function() {
        console.log( "Website vollständig Geladen! AMK!!" );
        //var ctx = document.getElementById('myChart').getContext('2d');
        //window.myLine = new Chart(ctx, config);
    });

    function updateChart(data) {
        var ankuenfteArray = [];
        for(let i = 0; i >= data.length-1; i++) {
            ankuenfteArray[i] = data[i][ankuenfte];
            console.log("AFD");
        }
        myChart.update({
            duration: 800,
            easing: 'easeOutBounce',
            data: ankuenfteArray
        });

        //window.myLine.update();
    }
    */
</script>