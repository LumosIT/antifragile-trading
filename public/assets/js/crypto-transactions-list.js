(function () {
    "use strict";
  
    // for transactions stats
    var options = {
      series: [{
          name: 'Total Invoices',
          data: [4, 42, 57, 86, 58, 55, 70],
      }, {
          name: 'Paid Invoices',
          data: [74, 72, 87, 116, 88, 85, 100],
      }, {
          name: 'Pending Invoices',
          data: [84, 82, 97, 126, 98, 95, 110],
      }, {
          name: 'Overdue Invoices',
          data: [134, 82, 57, 56, 91, 35, 60],
      }],
    chart: {
      type: "bar",
      height: 220,
      stacked: true,
      toolbar: {
          show: false,
      }
    },
    plotOptions: {
        bar: {
            columnWidth: '25%',
            borderRadius: 1,
        }
    },
    grid: {
        show: false,
        borderColor: '#f2f6f7',
    },
    dataLabels: {
      enabled: false,
    },
    colors: ["var(--primary-color)", "var(--primary08)", "var(--primary05)", "var(--primary03)"],
    stroke: {
      width: 0,
    },
    legend: {
      show: true,
      position: 'top',
      horizontalAlign: 'center', 
    },
    xaxis: {
      categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      labels: {
        show: true,
        style: {
          colors: "#8c9097",
          fontSize: "11px",
          fontWeight: 500,
          cssClass: "apexcharts-xaxis-label",
        },
      },
    },
    yaxis: {
      title: {
        style: {
          color: "#8c9097",
        },
      },
      labels: {
        show: true,
        style: {
          colors: "#8c9097",
          fontSize: "11px",
          fontWeight: 500,
          cssClass: "apexcharts-xaxis-label",
        },
      },
    }, 
  };
  var chart = new ApexCharts(
    document.querySelector("#transactions"),
    options
  );
  chart.render();
  
  })();