// Police SB Admin 2
Chart.defaults.global.defaultFontFamily ='Nunito,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var ctx = document.getElementById("myPieChart");
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: categories,
        datasets: [{
            data: counts,
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796',
                '#5a5c69',
                '#fd7e14',
                '#20c997',
                '#6f42c1'
            ],
            hoverBackgroundColor: [
                '#2e59d9',
                '#17a673',
                '#2c9faf',
                '#dda20a',
                '#be2617',
                '#60616f',
                '#484a54',
                '#d96a00',
                '#17a589',
                '#59359c'
            ],
            hoverBorderColor: "rgba(234,236,244,1)"
        }]
    },
    options: {
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        legend: {
            display: true,
            position: 'bottom'
        },
        tooltips: {
            backgroundColor: "#fff",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            displayColors: true,
            xPadding: 15,
            yPadding: 15
        }
    }
});