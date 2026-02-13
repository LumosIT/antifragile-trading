(function () {
  "use strict";

  var randomizeArray = function (arg) {
    var array = arg.slice();
    var currentIndex = array.length, temporaryValue, randomIndex;

    while (0 !== currentIndex) {

      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex -= 1;

      temporaryValue = array[currentIndex];
      array[currentIndex] = array[randomIndex];
      array[randomIndex] = temporaryValue;
    }

    return array;
  }

  // data for the main cards sparklines
  var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];


  /* Total Products */
  var options1 = {
    series: [{
      data: randomizeArray(sparklineData)
    }],
    labels: [...Array(24).keys()].map(n => `2018-09-0${n + 1}`),
    chart: {
      type: 'area',
      height: 50,
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
    stroke: {
      curve: 'straight',
      width: 2,
    },
    colors: ["var(--primary-color)"],
    fill: {
      type: ['gradient'],
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.1,
        stops: [0, 90, 100],
        colorStops: [
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
    tooltip: {
      fixed: {
        enabled: false
      },
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
    }
  };
  var chart1 = new ApexCharts(document.querySelector("#total-products"), options1);
  chart1.render();
  /* Total Products */

  /* Total Users */
  var options1 = {
    series: [{
      data: randomizeArray(sparklineData)
    }],
    labels: [...Array(24).keys()].map(n => `2018-09-0${n + 1}`),
    chart: {
      type: 'area',
      height: 50,
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
    stroke: {
      curve: 'straight',
      width: 2,
    },
    colors: ["var(--primary-color)"],
    fill: {
      type: ['gradient'],
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.1,
        stops: [0, 90, 100],
        colorStops: [
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
    tooltip: {
      fixed: {
        enabled: false
      },
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
    }
  };
  var chart1 = new ApexCharts(document.querySelector("#total-users"), options1);
  chart1.render();
  /* Total Users */

  /* Total Revenue */
  var options1 = {
    series: [{
      data: randomizeArray(sparklineData)
    }],
    labels: [...Array(24).keys()].map(n => `2018-09-0${n + 1}`),
    chart: {
      type: 'area',
      height: 50,
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
    stroke: {
      curve: 'straight',
      width: 2,
    },
    colors: ["var(--primary-color)"],
    fill: {
      type: ['gradient'],
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.1,
        stops: [0, 90, 100],
        colorStops: [
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
    tooltip: {
      fixed: {
        enabled: false
      },
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
    }
  };
  var chart1 = new ApexCharts(document.querySelector("#total-revenue"), options1);
  chart1.render();
  /* Total Revenue */

  /* Total Sales */
  var options1 = {
    series: [{
      data: randomizeArray(sparklineData)
    }],
    labels: [...Array(24).keys()].map(n => `2018-09-0${n + 1}`),
    chart: {
      type: 'area',
      height: 50,
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
    stroke: {
      curve: 'straight',
      width: 2,
    },
    colors: ["var(--primary-color)"],
    fill: {
      type: ['gradient'],
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0.1,
        stops: [0, 90, 100],
        colorStops: [
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
    tooltip: {
      fixed: {
        enabled: false
      },
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
    }
  };
  var chart1 = new ApexCharts(document.querySelector("#total-sales"), options1);
  chart1.render();
  /* Total Sales */

  /* Visitors By Source */
  var options = {
    series: [14, 23, 21, 17, 15, 10],
    chart: {
      type: 'polarArea',
      height: 300
    },
    stroke: {
      colors: ['rgba(255,255,255,0.5)'],
    },
    fill: {
      opacity: 1
    },
    legend: {
      show: true,
      position: 'bottom',
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
    labels: ['Organic Search', 'Direct', 'Referral', 'Social', 'Email', 'Paid'],
    colors: ["rgb(197, 190, 255)", "rgb(255, 194, 152)", "rgb(171, 225, 155)", "rgb(160, 202, 252)", "rgb(127, 235, 235)", "rgb(253, 166, 171)"],
    plotOptions: {
      pie: {
        startAngle: -90,
        endAngle: 90,
        offsetY: 10,
        expandOnClick: false,
        donut: {
          size: '70%',
          background: 'transparent',
        }
      }
    },
    grid: {
      padding: {
        bottom: -100
      }
    },
  };
  var chart = new ApexCharts(document.querySelector("#visitors-source"), options);
  chart.render();
  /* Visitors By Source */

  /* Sales Revenue */
  var options2 = {
    series: [{
      name: 'Profit',
      data: [32, 15, 63, 51, 36, 62, 99, 42, 78, 76, 32, 120],
      type: 'bar',
    }, {
      name: 'Sales',
      data: [156, 158, 68, 150, 164, 125, 135, 102, 115, 163, 151, 136],
      type: 'area',
    }, {
      name: 'Revenue',
      data: [148, 129, 150, 169, 120, 39, 152, 112, 148, 128, 117, 198],
      type: 'line',
    }],
    chart: {
      height: 320,
      type: 'line',
      toolbar: {
        show: false,
      },
      background: 'none',
      fill: "#fff",
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
    plotOptions: {
      bar: {
        borderRadius: 2,
        columnWidth: '30%',
      }
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
    colors: ["var(--primary-color)", "var(--primary-color)", "var(--primary03)"],
    background: 'transparent',
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'straight',
      width: 2,
      dashArray: [0, 0, 6]
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
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      show: false,
      axisBorder: {
        show: false,
        color: 'rgba(119, 119, 142, 0.05)',
        offsetX: 0,
        offsetY: 0,
      },
      axisTicks: {
        show: false,
        borderType: 'solid',
        color: 'rgba(119, 119, 142, 0.05)',
        width: 6,
        offsetX: 0,
        offsetY: 0
      },
      labels: {
        rotate: -90,
      }
    },
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
          [
            {
              offset: 0,
              color: 'var(--primary03)',
              opacity: 1
            },
            {
              offset: 75,
              color: 'var(--primary03)',
              opacity: 0.1
            },
            {
              offset: 100,
              color: 'var(--primary03)',
              opacity: 1
            }
          ],
        ]
      }
    },
    yaxis: {
      show: false,
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      }
    },
    tooltip: {
      x: {
        format: 'dd/MM/yy HH:mm'
      },
    },
  };
  var chart4 = new ApexCharts(document.querySelector("#salerevenue"), options2);
  chart4.render();
  /* Sales Revenue */

  /* Weekly Sales */
  var options = {
    series: [{
      name: 'This Week',
      data: [44, 42, 57, 86, 58, 55, 70],
    }, {
      name: 'Last Week',
      data: [-34, -22, -37, -56, -21, -35, -60],
    }],
    chart: {
      stacked: true,
      type: 'bar',
      height: 320,
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
    colors: ["var(--primary-color)", "var(--primary03)"],
    plotOptions: {
      bar: {
        borderRadius: 2,
        colors: {
          ranges: [{
            from: -100,
            to: -46,
            color: 'var(--primary03)'
          }, {
            from: -45,
            to: 0,
            color: 'var(--primary03)'
          }]
        },
        columnWidth: '25%',
        borderRadiusWhenStacked: "all",
      }
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
    yaxis: {
      title: {
        style: {
          color: '#adb5be',
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
      type: 'day',
      categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'sat'],
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
  var chart = new ApexCharts(document.querySelector("#weekly-sales"), options);
  chart.render();
  /* Weekly Sales */

  /* Visitors By Browser */
  var total = {
    chart: {
      height: 100,
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
  var total = new ApexCharts(document.querySelector("#visitors-browser"), total);
  total.render();
  /* Visitors By Browser */

})();