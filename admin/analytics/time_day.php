<?php if ($_settings->userdata('type') == 1 || $_settings->userdata('type') == 2) : ?>
    <h1 class="text-center">Most Common Time and day of Offenses</h1>
    <hr class="bg-light">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Include other required files -->
            <?php require_once('inc/infocard.php') ?>


            <!-- Chart Section -->
            <div class="row">
                <?php require_once('inc/anaylticsnav.php') ?>
                <div class="col-md-9">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Time and day</h3>
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
                            <form method="POST">
                                <div class="row justify-content-center">
                                    <div class="col-5">
                                        <div class="form-group text-center">
                                            <label for="day_of_the_week" class="control-label">Day of the Week</label>
                                            <select name="day_of_the_week" id="day_of_the_week" class="custom-select select2">
                                                <option <?php echo (!isset($_POST['day_of_the_week']) || $_POST['day_of_the_week'] == 'Monday') ? 'selected' : '' ?>>Monday</option>
                                                <option <?php echo (isset($_POST['day_of_the_week']) && $_POST['day_of_the_week'] == 'Tuesday') ? 'selected' : '' ?>>Tuesday</option>
                                                <option <?php echo (isset($_POST['day_of_the_week']) && $_POST['day_of_the_week'] == 'Wednesday') ? 'selected' : '' ?>>Wednesday</option>
                                                <option <?php echo (isset($_POST['day_of_the_week']) && $_POST['day_of_the_week'] == 'Thursday') ? 'selected' : '' ?>>Thursday</option>
                                                <option <?php echo (isset($_POST['day_of_the_week']) && $_POST['day_of_the_week'] == 'Friday') ? 'selected' : '' ?>>Friday</option>
                                                <option <?php echo (isset($_POST['day_of_the_week']) && $_POST['day_of_the_week'] == 'Saturday') ? 'selected' : '' ?>>Saturday</option>
                                                <option <?php echo (isset($_POST['day_of_the_week']) && $_POST['day_of_the_week'] == 'Sunday') ? 'selected' : '' ?>>Sunday</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2 align-self-center mt-3 ">
                                        <button type="submit" name="submit" value="submit" class="btn btn-success ">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <div class="chart">
                                <canvas id="barChart" style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;"></canvas>
                            </div>
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
if (!isset($_POST['submit'])) {
    $days = 'Monday';
} else {
    $days = $_POST['day_of_the_week'];
}

$dayMap = [
    'Monday' => 2,
    'Tuesday' => 3,
    'Wednesday' => 4,
    'Thursday' => 5,
    'Friday' => 6,
    'Saturday' => 7,
    'Sunday' => 1
];
$day_of_the_week = $dayMap[$days];

$topCountsQuery = $conn->query("SELECT 
    DAYOFWEEK(COALESCE(date_updated, date_created)) AS day_of_week,
    HOUR(COALESCE(date_updated, date_created)) AS hour_of_day,
    COUNT(*) AS count
FROM 
    offense_list 
WHERE 
    DAYOFWEEK(COALESCE(date_updated, date_created)) = $day_of_the_week
    AND status != '4' 
GROUP BY 
    day_of_week, hour_of_day 
ORDER BY 
    count DESC 
LIMIT 3");

$topTime = [];
$topCounts = [];

// Retrieve data and store in variables
while ($row = $topCountsQuery->fetch_assoc()) {
    $topTime[] = $row['hour_of_day'];
    $topCounts[] = $row['count'];
}

// Store top locations and counts in separate variables
$top1 = isset($topTime[0]) ? ($topTime[0] % 12 === 0 ? ($topTime[0] == 24 ? '12 AM' : '12 PM') : (($topTime[0] % 12) . ($topTime[0] < 12 ? ' AM' : ' PM'))) : null;
$top2 = isset($topTime[1]) ? ($topTime[1] % 12 === 0 ? ($topTime[1] == 24 ? '12 AM' : '12 PM') : (($topTime[1] % 12) . ($topTime[1] < 12 ? ' AM' : ' PM'))) : null;
$top3 = isset($topTime[2]) ? ($topTime[2] % 12 === 0 ? ($topTime[2] == 24 ? '12 AM' : '12 PM') : (($topTime[2] % 12) . ($topTime[2] < 12 ? ' AM' : ' PM'))) : null;


$count1 = isset($topCounts[0]) ? $topCounts[0] : null;
$count2 = isset($topCounts[1]) ? $topCounts[1] : null;
$count3 = isset($topCounts[2]) ? $topCounts[2] : null;



$tally = $conn->query("SELECT * FROM `temp_day` WHERE day='{$days}'");
$list = array_fill(1, 24, 0); // Initialize the list to hold counts for 24 hours

// Fetch counts for each officer name and store in $list array
while ($row = $tally->fetch_assoc()) {

    $day = $dayMap[$row['day']];
    for ($i = 1; $i <= 24; $i++) {

        $count = $conn->query("SELECT COUNT(*) AS count 
                               FROM offense_list 
                               WHERE DAYOFWEEK(COALESCE(date_updated, date_created)) = $day
                                 AND HOUR(COALESCE(date_updated, date_created)) = $i 
                                 AND status != '4'")->fetch_assoc()['count'];
        $list[$i] += $count; // Accumulate the count for the specific hour

    }
}



// Extract the counts for the chart data
$label = range(1, 24); // Hours of the day
$data = array_values($list); // Counts for each hour
?>
<script src="/../traffic_offense/assets/js/timeAndDayAction.js"></script>
<script></script>
<script>
    var top1 = "<?php echo $top1; ?>";
    var count1 = "<?php echo $count1; ?>";
    var top2 = "<?php echo $top2; ?>";
    var count2 = "<?php echo $count2; ?>";
    var top3 = "<?php echo $top3; ?>";
    var count3 = "<?php echo $count3; ?>";
    var days = "<?php echo $days; ?>";
    $(function() {
        var areaChartData = {
            labels: <?php echo json_encode($label); ?>.map(function(hour) {
                return hour % 12 === 0 ? (hour === 24 ? '12 AM' : '12 PM') : (hour % 12) + (hour < 12 ? ' AM' : ' PM');
            }),
            datasets: [{
                label: 'Time of Incident',
                backgroundColor: '#B90B0B',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: <?php echo json_encode($data); ?>
            }]
        }
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: 'Time of Incident',
                        fontSize: 16, // Adjust the font size
                        fontStyle: 'bold'
                    },
                }, ],

                yAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: 'Number of Incident',
                        fontSize: 16, // Adjust the font size
                        fontStyle: 'bold'
                    },
                    ticks: {
                        beginAtZero: true // Ensure that the y-axis starts from zero
                    }
                }]
            }

        }
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })

    })
</script>