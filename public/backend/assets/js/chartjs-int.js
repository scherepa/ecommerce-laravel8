//[chartjs Javascript]



$(function () {

  'use strict';
	
// bar chart
//console.log(brands);
var xValues = brands.split(',');//["Italy", "France", "Spain", "USA", "Argentina"];
var yValues = JSON.parse(qty);//[55, 49, 44, 24, 15];
var barColors = ["red", "green","blue","yellow","violet"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Products In Stock"
    }
  }
});//End of Bar Chart

//pie chart
new Chart("myChartpie", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Brands"
    }
  }
});//End of Pie Chart
}); // End of use strict
