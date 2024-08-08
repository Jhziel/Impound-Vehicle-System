<?php if ($_settings->userdata('type') != 3) : ?>
    <h2 class="text-center">Tracing the Frequented Locations of Vehicle Impoundments</h2>
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
$topCountsQuery = $conn->query("SELECT location, COUNT(*) AS count FROM location_tally GROUP BY location ORDER BY count DESC LIMIT 3");

$topLocations = [];
$topCounts = [];

// Retrieve data and store in variables
while ($row = $topCountsQuery->fetch_assoc()) {
    $topLocations[] = $row['location'];
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
echo "Top 1: $top1, Count: $count1<br>";
echo "Top 2: $top2, Count: $count2<br>";
echo "Top 3: $top3, Count: $count3<br>";

$tally = $conn->query("SELECT * FROM `offense_location` ");
$list = array();

// Fetch counts for each officer name and store in $list array
while ($row = $tally->fetch_assoc()) {
    $location = $row['location'];

    $count = $conn->query("SELECT COUNT(*) AS count FROM location_tally WHERE `location` = '{$row['location']}'")->fetch_assoc()['count'];

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
    $(function() {
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = {
            labels: ['<?php echo implode('\',\'', $label+$data) ?>'],
            datasets: [{
                data: [<?php echo implode(',', $data) ?>],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#5A2192',
                    '#F414AD ', '#090106', '#3C76A1 ', '#E9D496 ', '#F5B3B3 ', '#34EA45 ', '#00FFE4 ', '#8EA254 ',
                    '#E400FF ', '#193163 ', '#11540E '
                ],
            }]
        };
        var pieChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
        }

        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieChartOptions
        });
    });
</script>
<!--  -->