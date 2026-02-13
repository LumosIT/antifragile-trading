(function () {
    'use strict';

    /* Total Sales */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        },
                        {
                            offset: 90,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-1"), spark1);
    spark1.render();
    /* Total Sales */

    /* Profit By Sale */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        },
                        {
                            offset: 90,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-2"), spark1);
    spark1.render();
    /* Profit By Sale */

    /* Total Revenue */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        },
                        {
                            offset: 90,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-3"), spark1);
    spark1.render();
    /* Total Revenue */

    /* Total Customers */
    var spark1 = {
        chart: {
            type: 'area',
            height: 60,
            width: 120,
            sparkline: {
                enabled: true
            },
        },
        grid: {
            show: false,
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'butt',
            colors: undefined,
            width: 2,
            dashArray: 0,
            fill: {
                type: "gradient",
                gradient: {
                    type: "horizontal",
                    colorStops: [
                        [
                            {
                                offset: 0,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                            {
                                offset: 100,
                                color: "var(--primary-color)",
                                opacity: 1
                            },
                        ]
                    ]
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                type: "horizontal",
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        },
                        {
                            offset: 90,
                            color: "var(--primary-color)",
                            opacity: 0.05
                        }
                    ]
                ]
            }
        },
        series: [{
            name: 'Value',
            data: [14, 38, 26, 44, 20, 65, 35, 40]
        }],
        yaxis: {
            min: 0,
            show: false
        },
        xaxis: {
            show: false,
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
        },
        colors: ['var(--primary-color)'],

    }
    var spark1 = new ApexCharts(document.querySelector("#chart-4"), spark1);
    spark1.render();
    /* Total Customers */

    /* Revenue Analytics Chart */
    var options = {
        series: [{
            name: "Sales",
            data: [30, 38, 25, 42, 35, 13, 63,25,53],
            type: 'area',
        },
        {
            name: "Revenue",
            data: [20, 38, 38, 72, 55, 63, 43,55,33],
            type: 'line',
        }],
        chart: {
            height: 265,
            zoom: {
                enabled: false
            },
            // dropShadow: {
            //     enabled: true,
            //     enabledOnSeries: undefined,
            //     top: 10,
            //     left: 0,
            //     blur: 0,
            //     color: 'var(--primary-color)',
            //     opacity: 0.05
            //   },
            toolbar: { show: false }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: true,
            position: "bottom",
            offsetX: 0,
            offsetY: 8,
            markers: {
                width: 7,
                height: 7,
                strokeWidth: 0,
                strokeColor: '#fff',
                fillColors: undefined,
                radius: 12,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
        },
        stroke: {
            curve: 'smooth',
            width: [2,2],
            dashArray:[0,4]
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                type:'vertical',
                opacityTo: 0.1,
                stops: [0, 90, 100],
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: "var(--primary-color)",
                            opacity: 0.2
                        },
                        {
                            offset: 50,
                            color: "var(--primary-color)",
                            opacity: 0.2
                        },
                        {
                            offset: 100,
                            color: "var(--primary02)",
                            opacity: 0.1
                        }
                    ],
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
                            color: "var(--primary-color)",
                            opacity: 1
                        }
                    ],
                   
                ]
            }
        },
        grid: {
            borderColor: '#f5f4f4',
            strokeDashArray: 3
        },
        colors: ["var(--primary-color)","rgba(72, 150, 254,0.8)"],
        yaxis: {
            labels: {
                formatter: function (y) {
                    return y.toFixed(0) + "";
                }
            }
        },
        xaxis: {
            type: 'week',
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun','sun'],
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
        }
    };
    var chart = new ApexCharts(document.querySelector("#crm-revenue-analytics"), options);
    chart.render();
    
/* Revenue Analytics Chart */

/* Total Sales */
var spark1 = {
    chart: {
        type: 'line',
        height: 40,
        width: 120,
        sparkline: {
            enabled: true
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 5,
            left: 0,
            blur: 3,
            color: 'var(--primary-color)',
            opacity: 0.5
        }
    },
    grid: {
        show: false,
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
    stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        gradient: {
            enabled: false
        }
    },
    series: [{
        name: 'Value',
        data: [54, 38, 56, 24, 65,55,45]
    }],
    yaxis: {
        min: 0,
        show: false
    },
    xaxis: {
        show: false,
        axisTicks: {
            show: false
        },
        axisBorder: {
            show: false
        }
    },
    yaxis: {
        axisBorder: {
            show: false
        },
    },
    colors: ['var(--primary-color)'],

}
var spark1 = new ApexCharts(document.querySelector("#total-sales"), spark1);
spark1.render();
/* Total Sales */

/* Total Expenses */
var spark1 = {
    chart: {
        type: 'line',
        height: 40,
        width: 120,
        sparkline: {
            enabled: true
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 5,
            left: 0,
            blur: 3,
            color: 'var(--primary-color)',
            opacity: 0.5
        }
    },
    grid: {
        show: false,
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
    stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        gradient: {
            enabled: false
        }
    },
    series: [{
        name: 'Value',
        data: [54, 38, 56, 24, 65,55,45]
    }],
    yaxis: {
        min: 0,
        show: false
    },
    xaxis: {
        show: false,
        axisTicks: {
            show: false
        },
        axisBorder: {
            show: false
        }
    },
    yaxis: {
        axisBorder: {
            show: false
        },
    },
    colors: ['var(--primary-color)'],

}
var spark1 = new ApexCharts(document.querySelector("#total-expenses"), spark1);
spark1.render();
/* Total Expenses */

/* Total Visitors*/
var spark1 = {
    chart: {
        type: 'line',
        height: 40,
        width: 120,
        sparkline: {
            enabled: true
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 5,
            left: 0,
            blur: 3,
            color: 'var(--primary-color)',
            opacity: 0.5
        }
    },
    grid: {
        show: false,
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
    stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        gradient: {
            enabled: false
        }
    },
    series: [{
        name: 'Value',
        data: [54, 38, 56, 24, 65,55,45]
    }],
    yaxis: {
        min: 0,
        show: false
    },
    xaxis: {
        show: false,
        axisTicks: {
            show: false
        },
        axisBorder: {
            show: false
        }
    },
    yaxis: {
        axisBorder: {
            show: false
        },
    },
    colors: ['var(--primary-color)'],

}
var spark1 = new ApexCharts(document.querySelector("#total-visitors"), spark1);
spark1.render();
/* Total Visitors */

/* Total Views*/
var spark1 = {
    chart: {
        type: 'line',
        height: 40,
        width: 120,
        sparkline: {
            enabled: true
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 5,
            left: 0,
            blur: 3,
            color: 'var(--primary-color)',
            opacity: 0.5
        }
    },
    grid: {
        show: false,
        xaxis: {
            lines: {
                show: false
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        },
    },
    stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: undefined,
        width: 1.5,
        dashArray: 0,
    },
    fill: {
        gradient: {
            enabled: false
        }
    },
    series: [{
        name: 'Value',
        data: [54, 38, 56, 24, 65,55,45]
    }],
    yaxis: {
        min: 0,
        show: false
    },
    xaxis: {
        show: false,
        axisTicks: {
            show: false
        },
        axisBorder: {
            show: false
        }
    },
    yaxis: {
        axisBorder: {
            show: false
        },
    },
    colors: ['var(--primary-color)'],

}
var spark1 = new ApexCharts(document.querySelector("#total-views"), spark1);
spark1.render();
/* Total Views */

 /* visitors */
 var options = {
    series: [{
        name: 'Male',
        type: 'column',
        data: [200, 170, 250, 240, 220, 280, 170, 155, 130, 242],
    }, {
        name: 'Female',
        type: 'line',
        data: [13, 15, 25, 17, 19, 22, 11, 10, 9, 22],
        dataLabels: {
            enabled: false,
        },
    }],
    chart: {
        height: 350,
        type: 'line',
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 0,
            left: 0,
            blur: 4,
            color: ["rgba(255,255,255,0)", "rgba(255, 105, 55)"],
            opacity: 0.4,
        },
        toolbar: {
            show: false,
        }
    },
    dataLabels: {
        enabled: true,
        enabledOnSeries: [0],
        background: {
            enabled: false,
            foreColor: '#fff',
        },
        formatter: function (val) {
            return val + "%";
        },
        offsetY: -10,
        style: {
            fontSize: '12px',
            colors: ["#8c9097"]
        }
    },
    stroke: {
        curve: 'smooth',
        width: [0, 2],
    },
    plotOptions: {
        bar: {
            columnWidth: "30%",
            borderRadius: 3,
        }
    },

    colors: ["var(--primary-color)", "rgba(255, 105, 55)"],
    fill: {
        type: "gradient",
        gradient: {
            shade: "dark",
            type: "vertical",
            shadeIntensity: 0,
            inverseColors: false,
            gradientToColors: ["var(--primary-color)"],
            opacityFrom: [0.9, 1],
            opacityTo: [0.9, 1],
            stops: [0, 90, 100]
        }
    },
    labels: ['1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0'],
    yaxis: [{

    }, {
        opposite: true,
    }],
};
var chart = new ApexCharts(document.querySelector("#visitors"), options);
chart.render();
/* visitors */

/* Sales Overview */
var options = {
    chart: {
        height: 310,
        type: 'radialBar',
        responsive: 'true',
        offsetX: 0,
        offsetY: 10,
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            size: 120,
            imageWidth: 50,
            imageHeight: 50,
            track: {
                strokeWidth: "0",
            },
            dropShadow: {
                enabled: false,
                top: 0,
                left: 0,
                bottom: 0,
                blur: 3,
                opacity: 0.5
            },
            dataLabels: {
                name: {
                    fontSize: '16px',
                    color: undefined,
                    offsetY: 30,
                },
                hollow: {
                    size: "60%"
                },
                value: {
                    offsetY: -10,
                    fontSize: '22px',
                    color: undefined,
                    formatter: function (val) {
                        return val + "%";
                    }
                }
            }
        }
    },
    colors: ['var(--primary-color)'],
    fill: {
        type: "solid",
        gradient: {
            shade: "dark",
            type: "horizontal",
            shadeIntensity: .5,
            gradientToColors: ["#b94eed"],
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        }
    },
    stroke: {
        dashArray: 3
    },
    series: [92],
    labels: ["Profit"]
};
var chart1 = new ApexCharts(document.querySelector("#product-categories"), options);
chart1.render();
/* Sales Overview */

/* job application stats */
var options = {
    series: [
      {
        name: "Applications Received",
        data: [15, 30, 22, 49, 32, 45, 30, 45, 65, 45, 25, 45],
      }
    ],
    chart: {
      type: "area",
      height: 275,
      toolbar: {
        show: false
      }
    },
    colors: [
      "rgb(130, 116, 255)"
    ],
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.4,
        opacityTo: 0.5,
        stops: [0, 75]
      }
    },
    grid: {
      show: false,
      xaxis: {
        lines: {
          show: false
        }
      },
      yaxis: {
        lines: {
          show: false
        }
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: true,
      position: "top",
    },
    stroke: {
      curve: 'stepline',
      width: [1.7]
    },
    yaxis: {
      min: 0,
      show: false
    },
    xaxis: {
      type: "month",
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "sep",
        "oct",
        "nov",
        "dec",
      ],
      axisBorder: {
        show: false,
        color: "rgba(119, 119, 142, 0.05)",
        offsetX: 0,
        offsetY: 0,
      },
      axisTicks: {
        show: false,
        borderType: "solid",
        color: "rgba(119, 119, 142, 0.05)",
        width: 6,
        offsetX: 0,
        offsetY: 0,
      },
      labels: {
        rotate: -90,
      },
    },
  }; 
  var chart = new ApexCharts(document.querySelector("#application-stats"), options);
  chart.render();
  /* job application stats */

})();