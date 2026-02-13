(function () {
    "use strict";

    var stocks1 = {
        chart: {
            type: 'area',
            height: 40,
            width: 80,
            sparkline: {
                enabled: true
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
        stroke: {
            show: true,
            curve: 'straight',
            lineCap: 'butt',
            colors: undefined,
            width: 1.7,
            dashArray: 0,
        },
        series: [{
            name: 'Value',
            data: [20, 14, 19, 10, 23, 20, 22, 9, 12]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: ["rgb(130, 116, 255)"],
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.05,
            stops: [0, 60]
        }
    },
    
    }
    var stocks1 = new ApexCharts(document.querySelector("#total-jobs"), stocks1);
    stocks1.render();

    var stocks1 = {
        chart: {
            type: 'area',
            height: 40,
            width: 80,
            sparkline: {
                enabled: true
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
        stroke: {
            show: true,
            curve: 'straight',
            lineCap: 'butt',
            colors: undefined,
            width: 1.7,
            dashArray: 0,
        },
        series: [{
            name: 'Value',
            data: [12, 9, 22, 20, 23, 10, 19, 14, 20]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: ["rgb(130, 116, 255)"],
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.05,
            stops: [0, 60]
        }
    },
    
    }
    var stocks1 = new ApexCharts(document.querySelector("#total-applications"), stocks1);
    stocks1.render();

    var stocks1 = {
        chart: {
            type: 'area',
            height: 40,
            width: 80,
            sparkline: {
                enabled: true
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
        stroke: {
            show: true,
            curve: 'straight',
            lineCap: 'butt',
            colors: undefined,
            width: 1.7,
            dashArray: 0,
        },
        series: [{
            name: 'Value',
            data: [10, 20, 9, 22, 12, 19, 20, 14, 23]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: ["rgb(130, 116, 255)"],
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.05,
            stops: [0, 60]
        }
    },
    
    }
    var stocks1 = new ApexCharts(document.querySelector("#total-recruiter"), stocks1);
    stocks1.render();

    var stocks1 = {
        chart: {
            type: 'area',
            height: 40,
            width: 80,
            sparkline: {
                enabled: true
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
        stroke: {
            show: true,
            curve: 'straight',
            lineCap: 'butt',
            colors: undefined,
            width: 1.7,
            dashArray: 0,
        },
        series: [{
            name: 'Value',
            data: [19, 14, 22, 10, 20, 12, 23, 20, 9]
        }],
        yaxis: {
            min: 0,
            show: false,
            axisBorder: {
                show: false
            },
        },
        xaxis: {
            show: false,
            axisBorder: {
                show: false
            },
        },
        tooltip: {
            enabled: false,
        },
        colors: ["rgb(130, 116, 255)"],
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.05,
            stops: [0, 60]
        }
    },
    
    }
    var stocks1 = new ApexCharts(document.querySelector("#recruitement"), stocks1);
    stocks1.render();

    var total = {
        chart: {
            type: 'area',
            height: 70,
            sparkline: {
                enabled: true
            },
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 7,
                left: 0,
                blur: 0,
                color: 'rgba(255,255,255,0.1)',
                opacity: 1
              },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 1.5,
            dashArray: 0,
        },
        fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.4,
              opacityTo: 0.1,
              stops: [0, 90, 100],
              colorStops: [
                [
                  {
                    offset: 0,
                    color: "rgba(255,255,255,0.05)",
                    opacity: 1
                  },
                  {
                    offset: 75,
                    color: "rgba(255,255,255,0.05)",
                    opacity: 1
                  },
                  {
                    offset: 100,
                    color: "rgba(255,255,255,0.05)",
                    opacity: 1
                  }
                ]
              ]
            }
          },
        series: [{
            name: 'Value',
            data: [46, 34, 40, 35, 21, 46, 37, 22, 34, 34, 40, 44, 28, 23, 18, 17, 18, 16, 17, 15, 17]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            axisBorder: {
                show: false
            },
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ["rgba(255,255,255,0.3)"],
        tooltip: {
            enabled: false,
        }
    }
    document.getElementById('impressions').innerHTML = '';
    var total = new ApexCharts(document.querySelector("#impressions"), total);
    total.render();

    /* application statistics */
    var options = {
        series: [{
            name: 'Total Applications',
            data: [44, 55, 41, 67, 22, 43, 44, 55, 41, 67, 22, 43]
        }, {
            name: 'Rejected',
            data: [13, 23, 20, 8, 13, 27, 13, 23, 20, 8, 13, 27]
        }, {
            name: 'Shortlisted',
            data: [11, 17, 15, 15, 21, 14, 11, 17, 15, 15, 21, 14]
        }],
        chart: {
            type: 'bar',
            height: 340,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 3
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        colors: ["var(--primary-color)", "var(--primary05)", "var(--primary02)"],
        legend: {
            show: true,
            position: 'top'
        },
        plotOptions: {
            bar: {
                columnWidth: "25%",
                borderRadius: 2,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        fill: {
            opacity: 1
        }
    };
    document.getElementById('application-statistics').innerHTML = '';
    var chart1 = new ApexCharts(document.querySelector("#application-statistics"), options);
    chart1.render();
    function hrmperformanceReport() {
        chart1.updateOptions({
            colors: ["rgba(" + myVarVal + ", 1)", "rgba(" + myVarVal + ", 0.5)", "rgba(" + myVarVal + ", 0.2)"],
        })
    }
    /* application statistics */

    /* job statistics */
    var options = {
        series: [{
            name: 'Male',
            data: [20, 30, 40, 80, 20, 80],
        }, {
            name: 'Female',
            data: [44, 76, 78, 13, 43, 10],
        }],
        chart: {
            height: 290,
            type: 'radar',
            toolbar: {
                show: false,
            }
        },
        title: {
            align: 'left',
            style: {
                fontSize: '13px',
                fontWeight: 'bold',
                color: '#8c9097'
            },
        },
        plotOptions: {
            radar: {
                size: 80,
                polygons: {
                    fill: {
                        colors: ['var(--primary005)', 'var(--primary01)']
                    },

                }
            }
        },
        colors: ["var(--primary08)", "var(--primary02)"],
        stroke: {
            width: 0
        },
        fill: {
            opacity: 0.1
        },
        legend: {
            show: true,
            fontSize: "12px",
            position: 'top',
            horizontalAlign: 'center',
            fontFamily: "Montserrat",
            fontWeight: 500,
            offsetX: 0,
            offsetY: -8,
            height: 50,
            labels: {
                colors: '#9ba5b7',
            },
            markers: {
                width: 7,
                height: 7,
                strokeWidth: 0,
                strokeColor: '#fff',
                fillColors: undefined,
                radius: 7,
                offsetX: 0,
                offsetY: 0
            },
        },
        markers: {
            size: 0
        },
        xaxis: {
            categories: ['2011', '2012', '2013', '2014', '2015', '2016']
        },
        yaxis: {
            tickAmount: 6,
            labels: {
                formatter: function (val, i) {
                    if (i % 5 === 0) {
                        return val
                    }
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#job-applicants"), options);
    chart.render();
    /* job statistics */

})();