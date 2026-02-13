(function () {
    "use strict";

    /* patients analysis */
    var options = {
        series: [
            {
                name: "Patients",
                data: [
                    {
                        x: 'Sun',
                        y: [2800]
                    },
                    {
                        x: 'Mon',
                        y: [3200]
                    },
                    {
                        x: 'Tue',
                        y: [2950]
                    },
                    {
                        x: 'Wed',
                        y: [3000]
                    },
                    {
                        x: 'Thu',
                        y: [3500]
                    },
                    {
                        x: 'Fri',
                        y: [4500]
                    },
                    {
                        x: 'Sat',
                        y: [4100]
                    }
                ]
            },
            {
                name: "InPatients",
                data: [
                    {
                        x: 'Sun',
                        y: [2300]
                    },
                    {
                        x: 'Mon',
                        y: [2800]
                    },
                    {
                        x: 'Tue',
                        y: [2450]
                    },
                    {
                        x: 'Wed',
                        y: [2500]
                    },
                    {
                        x: 'Thu',
                        y: [3000]
                    },
                    {
                        x: 'Fri',
                        y: [4000]
                    },
                    {
                        x: 'Sat',
                        y: [3900]
                    }
                ]
            }
        ],
        chart: {
            height: 365,
            type: 'bar',
            zoom: {
                enabled: false
            },
        },
        colors: ['var(--primary-color)','var(--primary03)'],
        plotOptions: {
            bar: {
                columnWidth: "38%",
                borderRadius: 2
            }
        },
        legend: {
            show: true,
            showForSingleSeries: true,
            position: 'top',
            horizontalAlign: 'center',
            customLegendItems: ['Patients','InPatients']
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: [5, 5]
        },
        grid: {
            borderColor: "#f1f1f1",
            strokeDashArray: 2,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        tooltip: {
            enabled: true,
            theme: "dark",
        }
    };
    var chart = new ApexCharts(document.querySelector("#patients-analysis"), options);
    chart.render();
    /* patients analysis */

    var options = {
        series: [{
          name: 'Male',
          type: 'line',
          data: [45, 55, 40, 65, 20, 45, 25]
        }, {
          name: 'Female',
          type: 'line',
          data: [30, 25, 35, 30, 45, 35, 65]
        }],
        chart: {
          height: 360,
          type: 'line',
          stacked: false,
          toolbar: {
            show: false
          },
          dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 8,
            left: 0,
            blur: 0,
            color: 'var(--primary-color)',
            opacity: 0.05
          },
        },
        colors: ["var(--primary07)", "var(--primary-color)"],
        grid: {
          show: true,
          borderColor: 'rgba(119, 119, 142, 0.1)',
          strokeDashArray: 4,
        },
        stroke: {
          width: [2, 2],
          curve: 'straight',
          dashArray:[5,0]
        },
        plotOptions: {
          bar: {
            columnWidth: '25%',
            borderRadius: 5,
          }
        },
        labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        markers: {
          size: 0,
        },
        legend: {
          show: true,
          position: 'top',
          fontFamily: "Montserrat",
          markers: {
            width: 10,
            height: 10,
          }
        },
        xaxis: {
          categories: ['10-20', '20-30', '30-40', '40-50', '50-60', '60-70', '70-80'],
          fontFamily: "Montserrat",
          axisBorder: {
            show: true,
            color: 'rgba(119, 119, 142, 0.05)',
            offsetX: 0,
            offsetY: 0,
          },
          axisTicks: {
            show: true,
            borderType: 'solid',
            color: 'rgba(119, 119, 142, 0.05)',
            width: 6,
            offsetX: 0,
            offsetY: 0
          },
          labels: {
            rotate: -90
          }
        },
        yaxis: {
          title: {
            style: {
              color: '	#adb5be',
              fontSize: '14px',
              fontFamily: 'Montserrat, sans-serif',
              fontWeight: 600,
              cssClass: 'apexcharts-yaxis-label',
            },
          },
          labels: {
            formatter: function (y) {
              return y.toFixed(0) + "";
            }
          }
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function (y) {
              if (typeof y !== "undefined") {
                return y.toFixed(0) + " Hours";
              }
              return y;
    
            }
          }
        }
      };
      var chart = new ApexCharts(document.querySelector("#patience-age"), options);
      chart.render();

})();