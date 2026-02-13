(function () {
    "use strict";

    /* overall-attendance */
    var options = {
        series: [185, 54,38],
        labels: ["Male", "Female","other"],
        chart: {
            height: 245 ,
            type: 'donut',
        },
        dataLabels: {
            enabled: false,
        },
    
        legend: {
            show: true,
            position: 'top',
            markers: {
              width: 8,
              height: 8,
            }
          },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: "#fff",
            width: 0,
            dashArray: 0,
        },
        plotOptions: {
    
            pie: {
                expandOnClick: false,
                donut: {
                    size: '85%',
                    background: 'transparent',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '20px',
                            color: '#495057',
                            offsetY: -4
                        },
                        value: {
                            show: true,
                            fontSize: '18px',
                            color: undefined,
                            offsetY: 8,
                            formatter: function (val) {
                                return val + "%"
                            }
                        },
                        total: {
                            show: true, 
                            showAlways: true,
                            label: 'Total',
                            fontSize: '22px',
                            fontWeight: 600,
                            color: '#495057',
                        }
    
                    }
                }
            }
        },
        colors: ["var(--primary-color)","var(--primary05)", "var(--primary02)"],
    };
    document.querySelector("#students").innerHTML = " ";
    var chart = new ApexCharts(document.querySelector("#students"), options);
    chart.render();
    /* overall-attendance */

     /* attendance overview */
    var options = {
        series: [{
            name: 'Total Present',
            type: "column",
            data:  [44, 30, 57, 80, 90, 55, 70, 43, 23, 54, 77, 34]
        }, {
            name: 'Total Absent',
            type: "area",
            data: [30, 25, 36, 30, 45, 35, 64, 51, 59, 36, 39, 51]
        }],
        chart: {
            fontFamily: 'Montserrat',
            height: 290,
            type: 'line',
            stacked: !1,
            toolbar: {
                show: !1
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 6,
                left: 0,
                blur: 0,
                color: 'var(--primary-color)',
                opacity: 0.05
              },
        },
        grid: {
            borderColor: '#f2f6f7',
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
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top'
        },
        colors: ["var(--primary-color)", "var(--primary-color)"],
        fill: {
            type: ['solid', 'gradient', 'solid'],
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.4,
              opacityTo: 0.1,
              stops: [0, 90, 100],
              colorStops: [
                [
                  {
                    offset: 0,
                    color: "var(--primary-color)",
                    opacity: 1
                  },
                  {
                    offset: 75,
                    color: "var(--primary-color)",
                    opacity: 1
                  },
                  {
                    offset: 100,
                    color: 'var(--primary-color)',
                    opacity: 1
                  }
                ],
                [
                  {
                    offset: 0,
                    color: "var(--primary01)",
                    opacity: 0.1
                  },
                  {
                    offset: 75,
                    color: "var(--primary01)",
                    opacity: 1
                  },
                  {
                    offset: 100,
                    color: 'var(--primary02)',
                    opacity: 1
                  }
                ],
              ]
            }
          },
        stroke: {
            width: [1.5, 1.5],
            curve: ['straight', 'straight'],
            dashArray:[0, 4]
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        legend: {
            show: true,
            position: 'top'
        },
        plotOptions: {
            bar: {
                columnWidth: "25%",
                borderRadius: 2
            }
        },
        tooltip: {
          enabled: true,
          theme: "dark",
        }
    };
    var chart1 = new ApexCharts(document.querySelector("#school-earnings"), options);
    chart1.render();
     /* attendance overview */

})();