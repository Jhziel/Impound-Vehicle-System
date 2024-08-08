<?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2) : ?>
  <?php
  $qry = $conn->query("SELECT `name` FROM enforcers_list")
  ?>
  <h2 class="text-center">Tracing the Frequented Locations of Impounded Vehicle </h2>
  <hr class="bg-light">

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <?php require_once('inc/infocard.php') ?>
      <div class="row">

        <?php require_once('inc/anaylticsnav.php') ?>

        <!-- /.col -->
        <div class="col-md-9">

          <!-- PIE CHART -->
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Location</h3>
              <button class="ml-2 border-none" id="showDataButton">Show Data Analytics</button>
              <!-- Add hide button -->
              <button class="ml-2 border-none" id="hideDataButton" style="display: none;">Hide Data Analytics</button>
              <!-- Output area for displaying the data -->
              <div id="output"></div>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>

              </div>
            </div>
            <div class="card-body">

              <canvas id="pieChart" style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <!--   <div id="piechart_3d" style="width: 600px; height: 500px;"></div>
  <div id="donutchart" style="width: 600px; height: 500px; position: absolute; top: 442px; left: 1200px; margin-right: -50px; transform: translate(-50%, -50%);"></div> -->

<?php endif ?>



<?php
$topCountsQuery = $conn->query("SELECT location_of_incident, COUNT(*) AS count FROM offense_list WHERE status != '4' GROUP BY location_of_incident ORDER BY count DESC LIMIT 3");

$topLocations = [];
$topCounts = [];

// Retrieve data and store in variables
while ($row = $topCountsQuery->fetch_assoc()) {
  $topLocations[] = $row['location_of_incident'];
  $topCounts[] = $row['count'];
}

// Store top locations and counts in separate variables
$top1 = isset($topLocations[0]) ? $topLocations[0] : null;
$top2 = isset($topLocations[1]) ? $topLocations[1] : null;
$top3 = isset($topLocations[2]) ? $topLocations[2] : null;

$count1 = isset($topCounts[0]) ? $topCounts[0] : null;
$count2 = isset($topCounts[1]) ? $topCounts[1] : null;
$count3 = isset($topCounts[2]) ? $topCounts[2] : null;

// Output or use the retrieved data as needed

$tally = $conn->query("SELECT * FROM `offense_location` ");
$list = array();

// Fetch counts for each officer name and store in $list array
while ($row = $tally->fetch_assoc()) {
  $location = $row['location'];

  $count = $conn->query("SELECT COUNT(*) AS count FROM offense_list WHERE `location_of_incident` = '{$location}' AND `status`!='4'")->fetch_assoc()['count'];

  if (!isset($list[$count])) {
    $list[$count] = array();
  }
  $list[$count][] = $location;
}



// Extract the top 6 highest counts and their corresponding last names
$label = array();
$data = array();

foreach ($list as $count => $location) {
  foreach ($location as $name) {

    $label[] = $name;
    $data[] = $count;
  }
}
?>

<script>
  $(document).ready(function() {
    $('#showDataButton').click(function() {
      // Replace these variables with your PHP variables or data
      var top1 = "<?php echo $top1; ?>";
      var count1 = "<?php echo $count1; ?>";
      var top2 = "<?php echo $top2; ?>";
      var count2 = "<?php echo $count2; ?>";
      var top3 = "<?php echo $top3; ?>";
      var count3 = "<?php echo $count3; ?>";

      // Display the values in the output area with fade animation
      $('#output').fadeOut(400, function() {
        $(this).html("Our data analysis unveiled a striking pattern: " + top1 + " in Cabuyao City has the highest number of reported violations, followed closely by " + top2 + ", and then " + top3 + ". Other areas fall into a moderate range of violation occurrences within their respective barangays. This highlights the urgent need for action to address the surge in violations across various barangays in Cabuyao City").fadeIn(400);
      });

      // Hide show button and display hide button with fade animation
      $('#showDataButton').fadeOut(400, function() {
        $('#hideDataButton').fadeIn(400);
      });
    });

    // Add click event for hide button
    $('#hideDataButton').click(function() {
      // Clear the output area with fade animation
      $('#output').fadeOut(400, function() {
        $(this).html("").fadeIn(400);
      });

      // Hide hide button and display show button with fade animation
      $('#hideDataButton').fadeOut(400, function() {
        $('#showDataButton').fadeIn(400);
      });
    });
  });
  $(function() {
    //-------------
    //- DONUT CHART -
    //-------------
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
      labels: ['<?php echo implode('\',\'', $label + $data) ?>'],
      datasets: [{
        data: [<?php echo implode(',', $data) ?>],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#5A2192',
          '#F414AD ', '#090106', '#3C76A1 ', '#E9D496 ', '#F5B3B3 ', '#34EA45 ', '#00FFE4 ', '#8EA254 ',
          '#E400FF ', '#193163 ', '#11540E '
        ],
      }]
    };
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: true,

      },

    }
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })
  });
</script>