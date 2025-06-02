document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById("myPieChart");
  if (!ctx) return;

  const labels = typeof roleChartData !== 'undefined' ? roleChartData.labels : ["Direct", "Referral", "Social"];
  const data = typeof roleChartData !== 'undefined' ? roleChartData.data : [55, 30, 15];

  // new Chart(ctx, {
  //   type: 'doughnut',
  //   data: {
  //     labels: labels,
  //     datasets: [{
  //       data: data,
  //       backgroundColor: ['#1f77b4','#2ca02c','#17becf','#ff7f0e','#d62728','#9467bd','#e377c2','#7f7f7f'],
  //       hoverBackgroundColor: [ '#3a8dde','#4cc449','#38c4d6','#ffac40','#e34e4e','#b38ac9','#f199d2','#a0a0a0'],
  //       hoverBorderColor: "rgba(234, 236, 244, 1)",
  //     }],
  //   },
  const masterColors = ['#1f77b4','#2ca02c','#17becf','#ff7f0e','#d62728','#9467bd','#e377c2','#7f7f7f'];

const colors = masterColors.slice(0, data.length);
const hoverColors = ['#3a8dde','#4cc449','#38c4d6','#ffac40','#e34e4e','#b38ac9','#f199d2','#a0a0a0'].slice(0, data.length);

new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: colors,
      hoverBackgroundColor: hoverColors,
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
