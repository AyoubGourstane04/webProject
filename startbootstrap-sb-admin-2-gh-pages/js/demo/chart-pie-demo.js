document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById("myPieChart");
  if (!ctx) return;

  const labels = typeof roleChartData !== 'undefined' ? roleChartData.labels : ["Direct", "Referral", "Social"];
  const data = typeof roleChartData !== 'undefined' ? roleChartData.data : [55, 30, 15];

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80,
    },
  });
});
