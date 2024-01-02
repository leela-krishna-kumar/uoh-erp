var barChartData = {
    labels: [
      "CSE",
      "ECE",
      "EEE",
      "IT",
    ],
    datasets: [
      {
        label: "Intake",
        backgroundColor: "lightblue",
        borderColor: "blue",
        borderWidth: 1,
        data: [4, 7, 10, 12, 10,12,10,9]       
      },
      {
        label: "Absent",
        backgroundColor: "pink",
        borderColor: "red",       
        borderWidth: 1,
        data: [3, 5, 6, 7,3, 5, 6, 7]       
      }
    ]
  };
  
  var chartOptions = {
    responsive: true,
    legend: {
      position: "top"
    },
    title: {
      display: true,
      text: "Student Attendence"
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
  
  window.onload = function() {
    var ctx = document.getElementById("stdAttcanvas").getContext("2d");
    window.myBar = new Chart(ctx, {
      type: "bar",
      data: barChartData,
      options: chartOptions
    });
  };
  




//pie chart


var student_fee = 93999;
var discounts = 0;
var fines = 0;
var fee_paid = 94019;

const ctx1 = document.getElementById('pieFacultyChart').getContext('2d');
const pieFacultyChart = new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['Total', 'Absent'],
        datasets: [{
            label: '# of Fees',
            data: [99, 55],
            backgroundColor: [               
                'lightblue',
                'pink',               
            ],
            borderColor: [
                'blue',
                'red',             
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        // title: {
        //     display: true,
        //     text: "Faculty Attendence"
        //   }
    }
});


//pie chart

"use strict";
var student_fee = 93999;
var discounts = 0;
var fines = 0;
var fee_paid = 94019;

const ctx6 = document.getElementById('pieStaffChart').getContext('2d');
const pieStaffChart = new Chart(ctx6, {
    type: 'pie',
    data: {
        labels: ['Total', 'Absent'],
        datasets: [{
            label: '# of Fees',
            data: [99, 75],
            backgroundColor: [               
                'lightblue',
                'pink',               
            ],
            borderColor: [
                'blue',
                'red',             
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        // title: {
        //     display: true,
        //     text: "Faculty Attendence"
        //   }
    }
});



//pie chart


var student_fee = 93999;
var discounts = 0;
var fines = 0;
var fee_paid = 94019;

const ctx5 = document.getElementById('piePlacementSummary').getContext('2d');
const piePlacementSummary = new Chart(ctx5, {
    type: 'pie',
    data: {
        labels: ['CSE', 'ECE', 'EEE', 'IT'],
        datasets: [{
            label: '# of Fees',
            data: [99, 55, 99, 55, 44],
            backgroundColor: [               
                'lightblue',
                'pink',
                'lightpurple',
                'lightgreen',
                'lightyellow'             
            ],
            borderColor: [
                'blue',
                'red',  
                'purple',
                'green',
                'yellow'            
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        title: {
            display: true,
            text: "Placement Summary"
          }
    }
});





var barOptions_stacked = {
    tooltips: {
        enabled: false
    },
    hover :{
        animationDuration:0
    },
    scales: {
        xAxes: [{
            ticks: {
                beginAtZero:true,
                fontFamily: "'Open Sans Bold', sans-serif",
                fontSize:11
            },
            scaleLabel:{
                display:false
            },
            gridLines: {
            }, 
            stacked: true
        }],
        yAxes: [{
            gridLines: {
                display:false,
                color: "#fff",
                zeroLineColor: "#fff",
                zeroLineWidth: 0
            },
            ticks: {
                fontFamily: "'Open Sans Bold', sans-serif",
                fontSize:11
            },
            stacked: true
        }]
    },
    legend:{
        display:true
    },
    
    animation: {
        onComplete: function () {
            var chartInstance = this.chart;
            var ctx = chartInstance.ctx;
            ctx.textAlign = "left";
            ctx.font = "9px Open Sans";
            ctx.fillStyle = "#fff";

            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                Chart.helpers.each(meta.data.forEach(function (bar, index) {
                    data = dataset.data[index];
                    if(i==0){
                        ctx.fillText(data, 50, bar._model.y+4);
                    } else {
                        ctx.fillText(data, bar._model.x-25, bar._model.y+4);
                    }
                }),this)
            }),this);
        }
    },
    pointLabelFontFamily : "Quadon Extra Bold",
    scaleFontFamily : "Quadon Extra Bold",
};

var ctx2 = document.getElementById("stackedResultsChart");
var myChart = new Chart(ctx2, {
    type: 'horizontalBar',
    data: {
        labels: ["CSE", "ECE", "EEE", "IT"],
        
        // label: "Intake",
        // backgroundColor: "lightblue",
        // borderColor: "blue",
        // borderWidth: 1,
        // data: [4, 7, 3, 6, 10,7,4,6] 
        
        datasets: [{
            label: 'Pass',
            data: [727, 589, 537, 543],
            backgroundColor: "#1de9b6",
          //  borderColor: "#1de9b6"
        },{
            label: 'Fail',
            data: [238, 553, 746, 884],
            backgroundColor: 'pink',
          //  borderColor: '#red'
        }]
    },

    options: barOptions_stacked,
});




var ctx4 = document.getElementById("complaintLineChart").getContext('2d');


var myChart = new Chart(ctx4, {
    type: 'line',
    data: {
        labels: ["2019",	"2020",	"2021",	"2022",	"2023"],
        datasets: [{
           label: 'Complaints', // Name the series
            data: [500,	50,	2424,	1404], //Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        }]},
    options: {
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});