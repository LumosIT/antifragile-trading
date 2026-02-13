(function () {
    "use strict";

    /* Projects Activity */
    var options2 = {
        series: [
            {
                name: "Projects",
                data: [44, 42, 57, 86, 58, 55, 70, 43, 23, 54, 77, 34],
                type: "area",
            },
            {
                name: "Tasks",
                data: [74, 72, 87, 116, 88, 85, 100, 73, 53, 84, 107, 64],
                type: "line",
            }
        ],
        chart: {
            height: 330,
            type: 'line',
            toolbar: {
                show: false,
            },
            background: 'none',
            fill: "#fff",
            dropShadow: {
                enabled: true,
                enabledOnSeries: undefined,
                top: 7,
                left: 1,
                blur: 3,
                color: '#000',
                opacity: 0.1
            },
        },
        plotOptions: {
            bar: {
                borderRadius: 2,
                columnWidth: '30%',
            }
        },
        grid: {
                    borderColor: "#f5f4f4",
                    strokeDashArray: 5,
                    yaxis: {
                        lines: {
                            show: true,
                        },
                    },
                },
        colors: [
            "var(--primary-color)",
            "var(--primary03)",
        ],
        background: 'transparent',
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight',
            width: 2,
            dashArray: [0, 5],
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
                    ]
                ]
            }
        },
        yaxis: {
                    title: {
                        style: {
                            color: "#adb5be",
                            fontSize: "14px",
                            fontFamily: "Montserrat, sans-serif",
                            fontWeight: 600,
                            cssClass: "apexcharts-yaxis-label",
                        },
                    },
                    axisBorder: {
                        show: true,
                        color: "rgba(119, 119, 142, 0.05)",
                        offsetX: 0,
                        offsetY: 0,
                    },
                    axisTicks: {
                        show: true,
                        borderType: "solid",
                        color: "rgba(119, 119, 142, 0.05)",
                        width: 6,
                        offsetX: 0,
                        offsetY: 0,
                    },
                    labels: {
                        formatter: function (y) {
                            return y.toFixed(0) + "";
                        },
                    },
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
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };
    var chart4 = new ApexCharts(document.querySelector("#project-activity"), options2);
    chart4.render();
    /* Projects Activity */


    /*project statistics */
    var options = {
        series: [{
            data: [462, 451, 350, 530, 470, 500, 485],
            name: 'On Going',
        }, {
            data: [120, 150, 110, 170, 180, 140, 120],
            name: 'Un Finished',
        }],
        chart: {
            type: 'bar',
            stacked: "true",
            height: 375,
            toolbar: {
                show: false
            },
        },
        plotOptions: {
            bar: {
                barHeight: '30%',
                borderRadius: 2,
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: [
            "var(--primary-color)",
            "var(--primary03)",
        ],
        grid: {
            borderColor: '#ffffff',
        },
        xaxis: {
            categories: ['2017', '2018', '2019', '2020', '2021', '2022', '2023'],
            axisBorder: {
                show: true,
                color: '#c7cacd',
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: true,
                borderType: 'solid',
                color: '#c7cacd',
                width: 6,
                offsetX: 0,
                offsetY: 0
            },
            labels: {
                rotate: -90
            }
        },
    };
    var chart = new ApexCharts(document.querySelector("#yearly-revenue"), options);
    chart.render();
    /*project statistics */

})();