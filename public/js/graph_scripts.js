// Load the Visualization API and the corechart package.
google.charts.load('current', { 'packages': ['corechart'] });

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawPieChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawPieChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Fee Type');
    data.addColumn('number', 'Fees %');
    data.addRows([
        ['Hostel', 3],
        ['Admission', 4],
        ['Examination', 1],
        ['Bus', 1],
        ['Other', 2]
    ]);

    // Set chart options
    var options = {
        // 'title': 'Fee Dues',
        'width': 400,
        'height': 300,
        colors: ['#f4c22b', '#04a9f5', '#32de84', '#ff6384', '#FFD580'],
        is3D: true
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('fee_dues_pie_chart'));
    chart.draw(data, options);
}




// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(hAPieChart);

function hAPieChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Attendence');
    data.addColumn('number', '%');
    data.addRows([
        ['Present', 999],
        ['Absent', 28],
    ]);

    // Set chart options
    var options = {
        // 'title': 'Fee Dues',
        'width': 400,
        'height': 300,
        colors:['#04a9f5', '#ff6384']
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('hostel_attendence_pie_chart'));
    chart.draw(data, options);
}


// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(pSPieChart);

function pSPieChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Placement');
    data.addColumn('number', '%');
    data.addRows([
        ['Placed', 600],
        ['Yet to be Placed', 50],
    ]);

    // Set chart options
    var options = {
        // 'title': 'Fee Dues',
        'width': 400,
        'height': 300,
        colors:['#32de84', '#fd5c63'],
    };

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('Placement_pie_chart'));
    chart.draw(data, options);
}






//Bar chart

google.charts.setOnLoadCallback(drawBarChart);

function drawBarChart() {
    var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" }],        
        ["Transport", 75.49, "#04a9f5"],
        ["Hostel", 120.94, "#f4c22b"],
        ["Stationary", 150.30, "#C04000"],
        ["Equipment", 170.30, "#ff6384"],
        ["Salaries", 210.45, "color: #32de84"]
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2]);

    var options = {
       
        width: 600,
        height: 400,
        bar: { groupWidth: "95%" },
        legend: { position: "none" },
    };
    var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
    chart.draw(view, options);
}


//column chart
google.charts.setOnLoadCallback(drawColumnChart);
function drawColumnChart() {
    var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" }],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2]);

    var options = {
        // title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: { groupWidth: "95%" },
        legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
}


//2line chart

google.charts.setOnLoadCallback(draw2LineChart);

function draw2LineChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Complaints'],
        ['2004', 1000],
        ['2005', 1170],
        ['2006', 660],
        ['2007', 1030]
    ]);

    var options = {
        // title: 'Company Performance',
        curveType: 'function',
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve2_chart'));

    chart.draw(data, options);
}


//line chart

google.charts.setOnLoadCallback(drawLineChart);

function drawLineChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales'],
        ['2004', 1000],
        ['2005', 1170],
        ['2006', 660],
        ['2007', 1030]
    ]);

    var options = {
        title: 'Company Performance',
        curveType: 'function',
        legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
}


//stacked bar chart

google.charts.setOnLoadCallback(drawSBChart);
function drawSBChart() {
    var data = google.visualization.arrayToDataTable([
        ['Program', 'Pass', 'Fail', { role: 'annotation' }],
        ['CSE', 190, 10, ''],
        ['CSE (AI/ML)', 55, 5, ''],
        ['ECE', 199, 16, ''],
        ['EEE', 144, 22, ''],
        ['IT', 176, 14, ''],
        ['Mechanical', 66, 14, '']
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2]);

    var options = {
        width: 600,
        height: 300,
        colors:['#1de9b6', '#fd5c63'],
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true
    };
    var chart = new google.visualization.BarChart(document.getElementById("examresult_sbarchart_values"));
    chart.draw(view, options);
}


google.charts.load('current', { 'packages': ['bar'] });


google.charts.setOnLoadCallback(att1DrawChart);

const currentDate = new Date();

  const year = currentDate.getFullYear();
const month = currentDate.getMonth() + 1; // Note: Month is zero-based, so January is 0
const day = currentDate.getDate();

function att1DrawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Program', 'Admitted', 'Attendance'],
        ['CSE', 200, 185],
        ['CSE (AI/ML)', 60, 55],
        ['ECE', 215, 196],
        ['EEE', 166, 142],
        ['IT', 190, 184],
        ['Mechanical', 80, 74]
    ]);

    var options = {
        chart: {
            // title: 'Student Attendence',
            subtitle: 'Daily - ('+ day + '/'+month+'/'+year+')',
        },
      //  colors: ['#ffb1c1', '#9ad0f5'],
      colors:['#36a2eb', '#ff6384'],
      backgroundColor : { fill:'transparent' },
        bars: 'vertical' // Required for Material Bar Charts.
        
    };

    var chart = new google.charts.Bar(document.getElementById('attendence1_barchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}


google.charts.setOnLoadCallback(att2DrawChart);

function att2DrawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Program', 'Total', 'Attendance'],
        ['Administration', 36, 35],
        ['CSE', 48, 45],
        ['H&M', 10, 9],
        ['ECE', 45, 36],
        ['EEE', 36, 32],
        ['IT', 40, 34],
        ['Mechanical', 30, 24]
        
    ]);

    var options = {
        chart: {
            // title: 'Student Attendence',
            subtitle: 'Daily - ('+ day + '/'+month+'/'+year+')',
        },
        colors:['#36a2eb', '#ff6384'],
        backgroundColor : { fill:'transparent' },
        backgroundColor : 'none',
        bars: 'vertical' // Required for Material Bar Charts.
    };

    var chart = new google.charts.Bar(document.getElementById('attendence2_barchart_material'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
}