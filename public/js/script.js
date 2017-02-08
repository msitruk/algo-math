var dataAlgo = new Array();
$('.value-algo').each(function() {
	dataAlgo.push($(this).text());
});
var labelAlgo = new Array();
$('.label-algo').each(function() {
	labelAlgo.push($(this).text());
});

var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labelAlgo,
        datasets: [{
            label: '# of seconds',
            data: dataAlgo,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(187, 187, 187, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(34, 34, 34, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

/// M.S : bouton check tout les algos
$("#allAlgo").click(function() {
    $(".checkbox-inline").each(function(){
        if($(this).children().prop("checked") == false){
            $(this).children().prop("checked", true); 
        }
        else{
            $(this).children().prop("checked", false);
        }
    });
});
