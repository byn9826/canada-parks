/**
 * Created by Lenoir on 4/7/2017.
 */

Highcharts.chart('role-and-quantity', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 35,
            beta: 0
        }
    },
    title: {
        text: 'Total quantity of users from 2017 until now for the website'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} user(s)</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 65,
            dataLabels: {
                enabled: true,
                format: '{point.rolename}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Actual Quantity',
        data: userAndQuantity
    }]
});




Highcharts.chart('monthly-reg', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 15,
            depth: 150
        }
    },
    title: {
        text: 'Users registered this year'
    },
    subtitle: {
        text: 'Notice the difference between a 0 value and a null point'
    },
    plotOptions: {
        column: {
            depth: 150
        }
    },
    xAxis: {
        categories: Highcharts.getOptions().lang.shortMonths
    },
    yAxis: {
        title: {
            text: 'Number of User'
        }
    },
    series: [{
        name: 'Number of User',
        data: month
    }]
});



Highcharts.chart('man-and-woman', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: 'User registered this year by gender'
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        plotBands: [{ // visualize the weekend
            from: 0,
            to: 0,
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    yAxis: {
        title: {
            text: 'Number of User'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' user(s)'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'Men',
        data: male
    }, {
        name: 'Women',
        data: female
    }, {
        name: 'Other',
        data: otherSex
    }]
});