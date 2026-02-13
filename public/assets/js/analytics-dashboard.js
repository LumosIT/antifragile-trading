/* realtimeusers Chart */
let options1 = {
  series: [{
      data: [20, 14, 20, 22, 9, 12, 19, 10, 25]
  }],
  chart: {
      height: 30,
      width: 120,
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
const chart1 = new ApexCharts(document.querySelector("#realtimeusers"), options1);
chart1.render();
/* realtimeusers Chart */

/* bouncerate Chart */
let options3 = {
  series: [{
      data: [25, 10, 19, 12, 9, 22, 20, 14, 20]
  }],
  chart: {
      height: 30,
      width: 120,
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
const chart3 = new ApexCharts(document.querySelector("#bouncerate"), options3);
chart3.render();
/* bouncerate Chart */

/* bouncerate Chart */
let options4 = {
  series: [{
      data: [12, 20, 10, 25, 19, 22, 20, 23, 9]
  }],
  chart: {
      height: 30,
      width: 120,
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
const chart4 = new ApexCharts(document.querySelector("#total-visitors"), options4);
chart4.render();
/* bouncerate Chart */

/* avg visit duration Chart */
let options2 = {
  series: [{
      data: [20, 14, 20, 22, 9, 12, 19, 10, 25]
  }],
  chart: {
      height: 30,
      width: 120,
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
const chart2 = new ApexCharts(document.querySelector("#avg-duration"), options2);
chart2.render();
/* avg visit duration Chart */

//sessions overview//
var options = {
  series: [{
      name: 'Clicks',
      type: "column",
      data: [100, 210, 180, 454, 400, 320, 256, 430, 350, 350, 210, 410],
      fill: {
          type: "gradient",
          gradient: {
              shadeIntensity: 1,
              opacityFrom: 0.7,
              opacityTo: 1,
              colorStops: [
                  {
                      offset: 0,
                      color: "#60a5fa",
                      opacity: 1,
                  },
                  {
                      offset: 100,
                      color: "#5a66f1",
                      opacity: 1,
                  },
              ],
          },
      },
  }, {
      name: "Actions",
      type: "area",
      data: [180, 620, 476, 220, 520, 780, 435, 515, 738, 454, 525, 230],
  }, {
      name: "Impressions",
      type: "line",
      data: [500, 330, 110, 530, 520, 420, 780, 435, 475, 738, 454, 480],
  }],
  chart: {
      redrawOnWindowResize: true,
      height: 330,
      type: 'bar',
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
  plotOptions: {
      bar: {
          horizontal: false,
          columnWidth: '25%',
          borderRadius : 2,
          colors: {
            ranges: [{
              from: 400,
              to: 500,
              color: 'var(--primary03)'
            }, {
              from: 0,
              to: 40,
              color: 'var(--primary-color)'
            }]
          },
      },
  },
  grid: {
      borderColor: '#f1f1f1',
      strokeDashArray: 3
  },
  dataLabels: {
      enabled: false
  },
  stroke: {
      width: [0, 2, 1.9],
      curve: "straight",
      dashArray: [0,0,6]
  },
  legend: {
      show: true,
      fontSize: "12px",
      position: 'top',
      horizontalAlign: 'center',
      fontWeight: 500,
      height: 40,
      offsetX: 0,
      offsetY: 20,
      labels: {
          colors: '#9ba5b7',
      },
      markers: {
          width: 7,
          height: 7,
          strokeWidth: 0,
          strokeColor: '#fff',
          fillColors: undefined,
          radius: 12,
          offsetX: 0,
          offsetY: 0
      },
  },
  colors: ["var(--primary-color)", "var(--primary08)", 'var(--primary03)'],
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
          },
          show: true,
          style: {
              colors: "#8c9097",
              fontSize: '11px',
              fontWeight: 600,
              cssClass: 'apexcharts-xaxis-label',
          },
      }
  },
  xaxis: {
      type: "month",
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Dec'],
      axisBorder: {
          show: true,
          color: 'rgba(119, 119, 142, 0.2)',
          offsetX: 0,
          offsetY: 0,
      },
      axisTicks: {
          show: true,
          borderType: 'solid',
          color: 'rgba(119, 119, 142, 0.2)',
          width: 6,
          offsetX: 0,
          offsetY: 0
      },
      labels: {
          rotate: -90,
          style: {
              colors: "#8c9097",
              fontSize: '11px',
              fontWeight: 600,
              cssClass: 'apexcharts-xaxis-label',
          },
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
            color: 'var(--primary01)',
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
  tooltip: {
      shared: true,
      intersect: false,
      y: {
          formatter: function (y) {
              if (typeof y !== "undefined") {
                  return y.toFixed(0);
              }
              return y;
          },
      },
  },
}
var chart = new ApexCharts(document.querySelector("#sessions-overview"), options);
chart.render();
//sessions overview//

//impressions//
var total = {
  chart: {
      type: 'area',
      height: 100,
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
              ]
          ]
      }
  },
  series: [{
      name: 'Value',
      data: [75,75,55,55,33,35,55,55,75,75,95,95,65,65,55,55,85,85]
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
document.getElementById('impressions').innerHTML = '';
var total = new ApexCharts(document.querySelector("#impressions"), total);
total.render();
//impressions//

//subscribers//
var total = {
  chart: {
      type: 'bar',
      height: 35,
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
      curve: 'smooth',
      lineCap: 'butt',
      colors: undefined,
      width: 1.7,
      dashArray: 0,
  },
  plotOptions: {
    bar: {
      borderRadius: 2,
      columnWidth: '65%',
    }
  },
  series: [{
      name: 'Value',
      data: [75,75,55,55,33,35,55,55,75,75,95,95,65,65,55,55,85,85]
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
  colors: ["var(--primary03)"],
  tooltip: {
      enabled: false,
  }
}
document.getElementById('subscribers').innerHTML = '';
var total = new ApexCharts(document.querySelector("#subscribers"), total);
total.render();
//subscribers//

//sessions by device//
var options = {
  series: [1754, 634, 878, 470],
  labels: ["Mobile", "Desktop", "Tablet", "Others"],
  chart: {
      height: 243,
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
          startAngle: -90,
          endAngle: 90,
          offsetY: 10,
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
                      offsetY: -30
                  },
                  value: {
                      show: true,
                      fontSize: '15px',
                      color: undefined,
                      offsetY: -25,
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
  grid: {
      padding: {
          bottom: -100
      }
  },
  colors: ["var(--primary-color)", "var(--primary08)", "var(--primary06)", "var(--primary03)"],
};
var chart = new ApexCharts(document.querySelector("#sessionsbydevice"), options);
chart.render();
//sessions by device//

//audience overview//
var options = { 
  series: [{
      name: 'Last Week',
      data: [650, 770, 840, 890, 1100, 1380]
  },{
    name: 'This Week',
    data: [500, 650, 720, 820, 1050, 1280]
}],
  chart: {
      height: 340,
      type: 'bar', 
      events: {
          click: function (chart, w, e) {
          }
      },
      toolbar: {
          show: false,
      }
  },
  colors: ['var(--primary-color)', 'var(--primary03)'],
  plotOptions: {
      bar: {
          barHeight: '50%',
          horizontal: true,
          borderRadius: 2,
      }
  },
  stroke: {
    width: 2,
  },
  dataLabels: {
      enabled: false
  },
  legend: {
      show: true,
      position: 'bottom',
      markers: {
        width: 8,
        height: 8,
      }
  },
  grid: {
      borderColor: '#f1f1f1',
      strokeDashArray: 3
  },
  xaxis: {
      categories: [
          ['Monday'],
          ['Tuesday'],
          ['Wedensday'],
          ['Thursday'],
          ['Friday'],
          ['Saturday'],
      ],
      labels: {
          show: false,
          style: {
              fontSize: '12px'
          },
      }
  },
  yaxis: {
      offsetX: 30,
      offsetY: 30,
      labels: {
          show: true,
          style: {
              colors: "#8c9097",
              fontSize: '11px',
              fontWeight: 500,
              cssClass: 'apexcharts-yaxis-label',
          },
          offsetY: 8,
      }
  },
  tooltip: {
      enabled: true,
      shared: false,
      intersect: true,
      x: {
          show: false
      },
      theme: "dark",
  },
};
var chart6 = new ApexCharts(document.querySelector("#audienceoverview"), options);
chart6.render();
//audience overview//


