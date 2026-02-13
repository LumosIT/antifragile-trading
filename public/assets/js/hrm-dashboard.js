(function () {
  'use strict';
  /* total employees */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102,110,86,95]
    }],
    chart: {
      height: 40,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
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
    stroke: {
      curve: 'straight',
      width: [1.5],
    },
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'var(--primary01)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
        ]
      },
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
    colors: ["var(--primary-color)"],
  };
  var chart1 = new ApexCharts(document.querySelector("#total-employees"), options);
  chart1.render();
  /* total employees */

  /* employees on leave */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102,110,86,95]
    }],
    chart: {
      height: 40,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
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
        opacity: 0.075
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
    stroke: {
      curve: 'straight',
      width: [1.5],
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
    colors: ["var(--primary-color)"],
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'var(--primary01)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
        ]
      },
    },
  };
  var chart2 = new ApexCharts(document.querySelector("#employees-on-leave"), options);
  chart2.render();
  /* employees on leave */

  /* new employees */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102,110,86,95]
    }],
    chart: {
      height: 40,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
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
        opacity: 0.075
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
    stroke: {
      curve: 'straight',
      width: [1.5],
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
    colors: ["var(--primary-color)"],
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'var(--primary01)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
        ]
      },
    },
  };
  var chart3 = new ApexCharts(document.querySelector("#new-employees"), options);
  chart3.render();
  /* new employees */

  /* resigned employees */
  var options = {
    series: [{
      data: [98, 110, 80, 145, 105, 112, 87, 148, 102,110,86,95]
    }],
    chart: {
      height: 40,
      type: 'area',
      fontFamily: 'Montserrat, sans-serif',
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
        opacity: 0.075
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
    stroke: {
      curve: 'straight',
      width: [1.5],
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
    colors: ["var(--primary-color)"],
    fill: {
      type: 'gradient',
      gradient: {
        opacityFrom: 0.5,
        opacityTo: 0.2,
        stops: [0, 60],
        colorStops: [
          [
            {
              offset: 0,
              color: 'var(--primary01)',
              opacity: 1
            },
            {
              offset: 60,
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
        ]
      },
    },
  };
  var chart4 = new ApexCharts(document.querySelector("#resigned-employees"), options);
  chart4.render();
  /* resigned employees */

  /*  Attendance Statistics */
  var options2 = {  
    series: [{
      name: 'On Time',
      data: [44, 55, 70, 80, 90, 100, 120],
      type: 'bar',
    }, {
      name: 'Late',
      data: [50, 90, 78, 150, 125, 130, 175],
      type: 'area',
    }, {
      name: 'Obsent',
      data: [33, 50, 65, 75, 85, 95, 110],
      type: 'bar',
    },{
      name: 'Early',
      data: [30, 45, 55, 70, 75, 85, 100],
      type: 'bar',
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
        columnWidth: '50%',
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
    colors: ["var(--primary-color)", "var(--primary-color)", "var(--primary05)","var(--primary02)"],
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
              color: "var(--primary08)",
              opacity: 1
            },
            {
              offset: 75,
              color: "var(--primary08)",
              opacity: 1
            },
            {
              offset: 100,
              color: 'var(--primary08)',
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
              color: 'var(--primary01)',
              opacity: 1
            }
          ],
          [
            {
              offset: 0,
              color: 'var(--primary05)',
              opacity: 1
            },
            {
              offset: 75,
              color: 'var(--primary05)',
              opacity: 0.1
            },
            {
              offset: 100,
              color: 'var(--primary05)',
              opacity: 1
            }
          ],
          [
            {
              offset: 0,
              color: 'var(--primary02)',
              opacity: 1
            },
            {
              offset: 75,
              color: 'var(--primary02)',
              opacity: 0.1
            },
            {
              offset: 100,
              color: 'var(--primary02)',
              opacity: 1
            }
          ]
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
  var chart4 = new ApexCharts(document.querySelector("#subscriptions-overview"), options2);
  chart4.render();
  /*  Attendance Statistics */

  /* working format */
  var options = {
    series: [65.7,23.2, 10.5],
    labels: ["Office", "Home", "Remote"],
    chart: {
      height: 220,
      type: 'donut',
    },
    dataLabels: {
      enabled: false,
    },

    legend: {
      show: false,
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
                return val + '%'
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: 'High',
              fontSize: '22px',
              fontWeight: 600,
              color: '#495057',
            }

          }
        }
      }
    },
    colors: ["var(--primary-color)","var(--primary03)", "var(--primary05)"],
  };
  var chart = new ApexCharts(document.querySelector("#working-format"), options);
  chart.render();
  /* working format */

})();