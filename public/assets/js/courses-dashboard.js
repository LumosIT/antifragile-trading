(function () {
  "use strict";

  /* learning activity */
  var options = {
    series: [ {
      name: 'Last Week',
      type: 'line',
      data:[44, 42, 57, 86, 112, 55, 70, 43, 23, 54, 77, 34]
    }, {
      name: 'Average',
      type: 'area',
      data: [20, 88, 58, 120, 80, 95, 35, 88, 60, 85, 75, 85]
    }],
    chart: {
      height: 315,
      type: 'line',
      stacked: false,
      toolbar: {
        show: false
      },
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
    colors: ["var(--primary05)", "var(--primary-color)"],
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
              color: 'var(--primary005)',
              opacity: 1
            }
          ],
          [
            {
              offset: 0,
              color: 'var(--primary005)',
              opacity: 0.1
            },
            {
              offset: 75,
              color: 'var(--primary01)',
              opacity: 1
            },
            {
              offset: 100,
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
        ]
      }
    },
    grid: {
      show: true,
      borderColor: 'rgba(119, 119, 142, 0.1)',
      strokeDashArray: 4,
    },
    stroke: {
      width: [2, 2],
      curve: 'straight',
      dashArray: [6,0]
    },
    plotOptions: {
      bar: {
        columnWidth: '25%',
        borderRadius: 5,
      }
    },
    labels:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'sep', 'oct', 'nov', 'dec'],
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
        text: 'Growth',
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
  var chart = new ApexCharts(document.querySelector("#learning-activity"), options);
  chart.render();
  /* learning activity */

  /* payouts */
  var options1 = {
    chart: {
        height: 230,
        type: 'radar',
        toolbar: {
            show: false,
        },
        offsetY: 20
    },
    series: [{
        name: 'Total Visitors',
        data: [25, 98, 56, 22, 75, 19, 86],
    }],
    labels: ['IT', ' Sales', 'Markting', 'Coding', 'QA', 'Develops', 'Designing'],
    plotOptions: {
        radar: {
            size: 75,
            polygons: {
                fill: {
                    colors: ['var(--primary005)', 'var(--primary005)']
                },
            }
        }
    },
    colors: ["#8274ff"],
    stroke: {
        width: 2,
        curve: 'straight',
    },
    markers: {
        size: 4,
        strokeColor: "#8274ff",
        colors: ['#fff'],
        strokeWidth: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return val
            }
        },
        theme: 'dark',
    },
    yaxis: {
        tickAmount: 7,
        labels: {
            formatter: function (val, i) {
                if (i % 5 === 0) {
                    return val
                }
            }
        }
    }
}
var chart = new ApexCharts(document.querySelector("#payouts"), options1);
chart.render();
  /* payouts */

  /* course statistics */
  var options = {
    series: [{
      name: 'Completed',
      data: [24, 62, 57, 86, 58, 65, 40],
    }, {
      name: 'Ongoing',
      data: [-24, -42, -37, -56, -31, -45, -30],
    }],
    chart: {
      stacked: true,
      type: 'bar',
      height: 370,
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
        borderRadius: 5,
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
        columnWidth: '40%',
        borderRadiusWhenStacked: "all",
      }
    },
    dataLabels: {
      enabled: false,
    },
     stroke: {
        width: [5, 5]
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
  var chart = new ApexCharts(document.querySelector("#course-statistics"), options);
  chart.render();
  /* course statistics */

})();