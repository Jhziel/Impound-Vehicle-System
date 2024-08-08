</style>
<!-- Main Sidebar Container -->
<div class="col-md-3">
    <div class="card ">
        <div class="card-header" id='analytics_head'>
            <h3 class="card-title text-light">Analytics</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0" style="height: 80%;">
            <ul class="nav nav-pills flex-column">

                <li class="nav-item">
                    <a href="./" class="nav-link">
                        <i class="fas fa-map-marker-alt"></i> Location
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=analytics/time_day" class="nav-link">
                        <i class="fas fa-stopwatch"></i> Day and Time
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=analytics/common_offenses" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i> Common Offenses

                    </a>
                </li>

            </ul>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<script>
    $(document).ready(function() {
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        page = page.split('/');
        page = page.join('_');

        if ($('.nav-link.nav-' + page).length > 0) {
            $('.nav-link.nav-' + page).addClass('active');
            if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
                $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
                $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
            }
            if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
                $('.nav-link.nav-' + page).parent().addClass('menu-open');
            }
        } else {
            // If the current page link doesn't exist in the sidebar, specifically add 'active' class to Dashboard link
            $('.nav-link.nav-home').addClass('active');
        }
    });
</script>