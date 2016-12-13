<?php include_once("../header.php"); ?> 
<?php include_once("../validar.php"); ?>

 <script>
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawBasic);

      function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Dia');
      data.addColumn('number', 'Consumo');

      data.addRows([
        <?php 
            echo consumoDia($con, 11, 2016, $login);
        ?>
      ]);

      var options = {
        hAxis: {
          title: 'Dia',
          baseline:31,
          
          gridlines: {
            count:16,
          }
        },
        vAxis: {
          title: 'm³/s'
        },
        width: 900,
        height: 300,
        title:'Consumo Diário de Água',
      };
      

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
    </script>

<div id="chart_div"></div>


<?php include_once("../footer.php") ?>