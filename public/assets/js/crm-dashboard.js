/* Total Customers Chart */
let options2 = {
    series: [{
        data: [54, 38, 56, 24, 65, 55, 45]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
        foreColor: '#5d6162',
        zoom: {
            enabled: false
        },
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
    tooltip: {
        enabled: true,
        theme: "dark",
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: undefined,
    },
    grid: {
        borderColor: 'transparent',
    },
    xaxis: {
        crosshairs: {
            show: false,
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: 'straight'
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.2,
            stops: [0, 60]
        }
    },
};
const chart2 = new ApexCharts(document.querySelector("#total-customers"), options2);
chart2.render();
/* Total Customers Chart */

/* Conversion Ratio Chart */
let options3 = {
    series: [{
        data: [45, 55, 65, 24, 56, 38, 54]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
        foreColor: '#5d6162',
        zoom: {
            enabled: false
        },
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
    tooltip: {
        enabled: true,
        theme: "dark",
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: undefined,
    },
    grid: {
        borderColor: 'transparent',
    },
    xaxis: {
        crosshairs: {
            show: false,
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: 'straight'
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.2,
            stops: [0, 60]
        }
    },
};
const chart3 = new ApexCharts(document.querySelector("#conversion-ratio"), options3);
chart3.render();
/* Conversion Ratio Chart */

/* Conversion Ratio Chart */
let options4 = {
    series: [{
        data: [54, 38, 56, 24, 65, 55, 45]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
        foreColor: '#5d6162',
        zoom: {
            enabled: false
        },
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
    tooltip: {
        enabled: true,
        theme: "dark",
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: undefined,
    },
    grid: {
        borderColor: 'transparent',
    },
    xaxis: {
        crosshairs: {
            show: false,
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: 'straight'
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.2,
            stops: [0, 60]
        }
    },
};
const chart4 = new ApexCharts(document.querySelector("#total-deals"), options4);
chart4.render();
/* Conversion Ratio Chart */

/* total revenue Chart */
let options7 = {
    series: [{
        data: [45, 55, 65, 24, 56, 38, 54]
    }],
    chart: {
        height: 40,
        width: 100,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
        foreColor: '#5d6162',
        zoom: {
            enabled: false
        },
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
    tooltip: {
        enabled: true,
        theme: "dark",
        x: {
            show: false
        },
        y: {
            title: {
                formatter: function (seriesName) {
                    return ''
                }
            }
        },
        marker: {
            show: false
        }
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: undefined,
    },
    grid: {
        borderColor: 'transparent',
    },
    xaxis: {
        crosshairs: {
            show: false,
        }
    },
    colors: ["rgb(130, 116, 255)"],
    stroke: {
        width: [1.7],
        curve: 'straight'
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.5,
            opacityTo: 0.2,
            stops: [0, 60]
        }
    },
};
const chart5 = new ApexCharts(document.querySelector("#total-revenue"), options7);
chart5.render();
/* total revenue Chart */

/* Revenue Analytics */
var options = {
    series: [
        {
            name: "Revenue",
            type: "column",
            data: [18, 23, 28, 36, 44, 52, 61, 71, 76, 88, 91, 100],
        },
        {
            name: "Revenue",
            type: "column",
            data: [15, 23, 22, 31, 39, 48, 57, 68, 70, 83, 89, 95],
        },
        {
            name: "Profit",
            type: "area",
            data: [ 34, 38, 46, 55, 59, 68, 73, 85, 92, 105, 125, 135],
        }
    ],
    chart: {
        toolbar: {
            show: false,
        },
        height: 345,
        stacked: false,
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 10,
            left: 0,
            blur: 0,
            color: 'var(--primary-color)',
            opacity: 0.05
          },
    },
    stroke: {
        width: [2, 2 ,2],
        curve: "smooth",
    },
    plotOptions: {
        bar: {
            columnWidth: "38%",
            borderRadius: 3,
        },
    },
    colors: [
        "var(--primary-color)",
        "var(--primary03)",
        "var(--primary-color)"
    ],
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
                [
                    {
                        offset: 0,
                        color: "var(--primary03)",
                        opacity: 1
                    },
                    {
                        offset: 75,
                        color: "var(--primary03)",
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: "var(--primary03)",
                        opacity: 1
                    }
                ],
                [
                    {
                        offset: 0,
                        color: "var(--primary01)",
                        opacity: 1
                    },
                    {
                        offset: 75,
                        color: "var(--primary01)",
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: "var(--primary01)",
                        opacity: 1
                    }
                ],
            ]
        }
    },
    labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ],
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
    markers: {
        size: 0,
    },
    xaxis: {
        type: "month",
    },
    yaxis: {
        min: 0,
    },
    tooltip: {
        shared: true,
        theme: "dark",
        intersect: false,
        y: {
            formatter: function (y) {
                if (typeof y !== "undefined") {
                    return y.toFixed(0) + " points";
                }
                return y;
            },
        },
    },
    legend: {
        show: true,
        position: "top",
        horizontalAlign: "center",
        fontFamily: "Montserrat",
    },
};
var chart = new ApexCharts(document.querySelector("#revenue-analytic"), options);
chart.render();

/* Revenue Analytics */ 

/* Contacts By Source */
var options = {
    series: [14, 23, 21, 17, 15, 10],
    chart: {
        type: 'polarArea',
        height: 375
    },
    stroke: {
        colors: ['#fff'],
    },
    fill: {
        opacity: 1
    },
    legend: {
        position: 'bottom',
        itemMargin: {
            horizontal: 5,
            vertical: 5
        },
        fontFamily: "Montserrat",
    },
    labels: ['Organic Search', 'Paid Search', 'Direct Traffic', 'Social Media', 'Referrals', "Others"],
    colors: ["var(--primary-color)", "var(--primary08)", "var(--primary07)", "var(--primary05)", "var(--primary03)", "var(--primary02)"],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 200
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
};
var chart = new ApexCharts(document.querySelector("#contacts-source"), options);
chart.render();
/* Contacts By Source */

//customers by contries//
var total = {
    chart: {
      height: 80,
      sparkline: {
        enabled: true
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 8,
        left: 0,
        blur: 0,
        color: 'var(--primary-color)',
        opacity: 0.075
      },
    },
    plotOptions: {
      bar: {
        columnWidth: '100%'
      }
    },
    stroke: {
      show: true,
      curve: 'straight',
      lineCap: 'butt',
      colors: undefined,
      width: [1.5],
    },
    grid: {
      borderColor: 'transparent',
      padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.1,
        type:"vertical",
        stops: [0, 90, 100],
        colorStops: [
          [
            {
              offset: 0,
              color: "var(--primary01)",
              opacity: 1
            },
            {
              offset: 75,
              color: "var(--primary005)",
              opacity: 1
            },
            {
              offset: 100,
              color: "var(--primary005)",
              opacity: 1
            }
          ]
        ]
      }
    },
    series: [{
      name: 'This Year',
      data: [
        [0, 48.11708650372481],
        [1, 44.83834104995953],
        [2, 45.727409628208974],
        [3, 44.69213146554142],
        [4, 44.92113232835135],
        [5, 44.200874587557415],
        [6, 41.750527715312444],
        [7, 44.84511185791557],
        [8, 46.04672992189592],
        [9, 45.9480092098883],
        [10, 46.9249480823427],
        [11, 43.600609487921346],
        [12, 40.29988975207692],
        [13, 42.03310106988357],
        [14, 39.457750445961125],
        [15, 40.540159797957294],
        [16, 37.277912393740806],
        [17, 41.43887402339309],
        [18, 39.47430428214318],
        [19, 36.91189415889479],
        [20, 36.42847097453014],
        [21, 36.96844325047937],
        [22, 35.54647151074562],
        [23, 32.998974290143025],
        [24, 30.43526314490385],
        [25, 31.14797888879888],
        [26, 27.20589032036549],
        [27, 25.777592542626508],
        [28, 30.052675048145275],
        [29, 30.92837408600937],
        [30, 34.190241658736014],
        [31, 37.57718922878679],
        [32, 41.18083316913268],
        [33, 41.27110666976231],
        [34, 36.33819281943194],
        [35, 37.39239238651191],
        [36, 37.046485292242615],
        [37, 34.594801853250495],
        [38, 31.488044618299227],
        [39, 34.69970813498227],
        [40, 39.66083111892072],
        [41, 40.203292838001616],
        [42, 36.089709320758985],
        [43, 40.31141091738469],
        [44, 44.170004784953846],
        [45, 48.84998014705778],
        [46, 43.93624560052546],
        [47, 40.62473022491363],
        [48, 39.154068738786684],
        [49, 42.803089612673666],
        [50, 40.6511024461858],
        [51, 38.34516630158569],
        [52, 39.546885205159555],
        [53, 42.50715860274628],
        [54, 38.1455129028495],
        [55, 33.87761157196474],
        [56, 37.30125615378047],
        [57, 38.799409423316405],
        [58, 39.185431079286275],
        [59, 43.32737024276462],
        [60, 41.52185070435002],
        [61, 41.613587244137946],
        [62, 44.23763577861365],
        [63, 44.91439321362589],
        [64, 42.18546432611939],
        [65, 41.0624926886062],
        [66, 44.24453261527582],
        [67, 47.34794952778721],
        [68, 48.10833243543891],
        [69, 43.640893412371504],
        [70, 40.614056030997666],
        [71, 42.9374730102888],
        [72, 46.1355421298619],
        [73, 48.995759760197956],
        [74, 52.19926195857424],
        [75, 49.2778849176981],
        [76, 52.46274689069702],
        [77, 56.74969793098863],
        [78, 60.92623317241021],
        [79, 57.70969775380601],
        [80, 57.35168105637668],
      ],
      type: 'area'
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
    colors: ["var(--primary-color)"],
    tooltip: {
      enabled: false,
    }
  }
  var total = new ApexCharts(document.querySelector("#countries"), total);
  total.render();
//customers by contries//

//Sales Activity//
var options = {
    series: [{
      name: 'Profit',
      data: [44, 42, 57, 86, 58, 55, 70],
    }, {
      name: 'Expenses',
      data: [34, 22, 47, 56, 21, 35, 60],
    }
    ],
    chart: {
      type: 'bar',
      stacked: true,
      height: 300,
    },
    grid: {
      show: true,
      borderColor: 'rgba(119, 119, 142, 0.1)',
      strokeDashArray: 4,
    },
    colors: ["var(--primary-color)", "var(--primary02)"],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        borderRadius: [5],
        borderRadiusWhenStacked: "all",
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
        width: [5, 5]
    },
    states: {
      hover: {
        filter: {
          type: 'none'
        }
      }
    }, 
    yaxis: {
      title: {
        style: {
          color: '	#adb5be',
          fontSize: '14px',
          fontFamily: 'poppins, sans-serif',
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
    xaxis: {
      categories: ['Mon', 'Tue', 'Web', 'Thu', 'Fri', 'Sat', 'Sun'],
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
    },
    fill: {
      opacity: 1
    },
    legend: {
      position: "top"
    },
  };
  var chart1 = new ApexCharts(document.querySelector("#sales-activity"), options);
  chart1.render();
//Sales Activity//