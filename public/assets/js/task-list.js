(function () {
    "use strict"

    // for tasks stats
    let options2 = {
      series: [{
          data: [0, 32, 18, 58]
      }],
      chart: {
          height: 40,
          width: 80,
          type: 'area',
          fontFamily: 'Poppins, Arial, sans-serif',
          foreColor: '#5d6162',
          zoom: {
              enabled: false
          },
          sparkline: {
              enabled: true
          }
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
          curve: 'straight'
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
          width: [1.5],
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
  const chart2 = new ApexCharts(document.querySelector("#newtask"), options2);
  chart2.render();

  let options1 = {
    series: [{
        data: [58, 18, 32, 0]
    }],
    chart: {
        height: 40,
        width: 80,
        type: 'area',
        fontFamily: 'Poppins, Arial, sans-serif',
        foreColor: '#5d6162',
        zoom: {
            enabled: false
        },
        sparkline: {
            enabled: true
        }
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
        curve: 'straight'
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
        width: [1.5],
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
const chart3 = new ApexCharts(document.querySelector("#completedtask"), options1);
chart3.render();

let options4 = {
  series: [{
      data: [0, 32, 18, 58]
  }],
  chart: {
      height: 40,
      width: 80,
      type: 'area',
      fontFamily: 'Poppins, Arial, sans-serif',
      foreColor: '#5d6162',
      zoom: {
          enabled: false
      },
      sparkline: {
          enabled: true
      }
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
      curve: 'straight'
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
      width: [1.5],
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
const chart4 = new ApexCharts(document.querySelector("#pendingtask"), options4);
chart4.render();

let options5 = {
  series: [{
      data: [58, 18, 32, 0]
  }],
  chart: {
      height: 40,
      width: 80,
      type: 'area',
      fontFamily: 'Poppins, Arial, sans-serif',
      foreColor: '#5d6162',
      zoom: {
          enabled: false
      },
      sparkline: {
          enabled: true
      }
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
      curve: 'straight'
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
      width: [1.5],
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
const chart5 = new ApexCharts(document.querySelector("#inprogresstask"), options5);
chart5.render();
   // for tasks stats

    let checkAll = document.querySelector('.check-all');
    checkAll.addEventListener('click', checkAllFn)

    function checkAllFn() {
        if (checkAll.checked) {
            document.querySelectorAll('.task-checkbox input').forEach(function (e) {
                e.closest('.task-list').classList.add('selected');
                e.checked = true;
            });
        }
        else {
            document.querySelectorAll('.task-checkbox input').forEach(function (e) {
                e.closest('.task-list').classList.remove('selected');
                e.checked = false;
            });
        }
    }

    //delete Btn
    let taskbtn = document.querySelectorAll(".task-delete-btn");

    taskbtn.forEach((eleBtn) => {
        eleBtn.onclick = () => {
            let task = eleBtn.closest(".task-list")
            task.remove();
        }
    })

    /* multi select with remove button */
    const multipleCancelButton = new Choices(
        '#choices-multiple-remove-button1',
        {
            allowHTML: true,
            removeItemButton: true,
        }
    );

    /* AssignedDate Picker */
    flatpickr("#assignedDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    /* DueDate Picker */
    flatpickr("#dueDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    
})();
