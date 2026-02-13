(function () {
    "use strict";

    var options = {
        series: [{
            name: 'Hours',
            data: [20, 35, 66, 40, 30, 55, 45]
        }],
        chart: {
            height: 245,
            fontFamily: 'Poppins, Arial, sans-serif',
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        grid: {
            show: false,
            borderColor: '#f2f6f7',
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: 'top',
            fontSize: '13px',
        },
        colors: ["var(--primary03)"],
        stroke: {
            width: [1],
            curve: 'straight',
        },
        plotOptions: {
            bar: {
                columnWidth: "30%",
                borderRadius: 3,
				colors: {
					ranges: [{
						from: 41,
						to: 100,
						color: 'var(--primary-color)'
					}, {
						from: 0,
						to: 40,
						color: 'var(--primary03)'
					}]
				},
            }
        },
        tooltip: {
          enabled: true,
          theme: "dark",
        },
        labels: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    };
    var chart3 = new ApexCharts(document.querySelector("#podcast-activity"), options);
    chart3.render();

})()
