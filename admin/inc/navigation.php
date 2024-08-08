</style>

<?php
$sql = $conn->query("SELECT `driver_list_check`,`impound_vehicle_check`,`reports_check`,`ticket_violation_check`,`impound_area_check`,`driver_archieve_check`,`enforcer_archieve_check`,`ticket_violation_archieve_check`
,`impound_vehicle_archieve_check` FROM `staff_privellages` WHERE `staff_unique_id`= '{$_settings->userdata('unique_id')}'");
if ($sql->num_rows > 0) {
  foreach ($sql->fetch_assoc() as $k => $v) {
    $$k = $v;
  }
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary text-white bg-black disabled elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link bg-black text-sm">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.7rem;height: 1.7rem;max-height: unset">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

              <li class="nav-item dropdown <?php echo $driver_list_check ? '' : 'd-none'; ?> ">
                <a href="<?php echo base_url ?>admin/?page=drivers" class="nav-link nav-drivers">
                  <i class="nav-icon fas fa-id-card"></i>
                  <p>
                    Drivers List
                  </p>
                </a>
              </li>

              <li class="nav-item  <?php echo ($ticket_violation_check || $impound_vehicle_check) ? '' : 'd-none'; ?>  nav-head">
                <a href="#" class="nav-link nav-title">
                  <i class=" nav-icon fas fa-archive"></i>
                  <p>
                    Offense Records
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item <?php echo $ticket_violation_check ? '' : 'd-none'; ?>">
                    <a href="<?php echo base_url ?>admin/?page=offenses" class="nav-link tree-item nav-offenses">
                      <i class="nav-icon fas fa-scroll"></i>
                      <p>Ticket Violation</p>
                    </a>
                  </li>
                  <li class="nav-item <?php echo $impound_vehicle_check ? '' : 'd-none'; ?>">
                    <a href="<?php echo base_url ?>admin/?page=impound_vehicle" class="nav-link tree-item nav-impound_vehicle">
                      <i class="nav-icon fas fa-car-side"></i>
                      <p>Impound Vehicle</p>
                    </a>
                  </li>

                </ul>
              </li>



              <li class="nav-item dropdown <?php echo $impound_area_check ? '' : 'd-none'; ?>">
                <a href="<?php echo base_url ?>admin/?page=impounding_area" class="nav-link nav-impounding_area">
                  <i class="nav-icon fas fa-map-marked-alt"></i>
                  <p>
                    Impounding Area
                  </p>
                </a>
              </li>
              <!-- <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>admin/?page=monitoring" class="nav-link nav-monitoring">
                  <i class="nav-icon far fa-eye"></i>
                  <p>
                    Monitoring
                  </p>
                </a>
              </li> -->

              <li class="nav-item dropdown <?php echo $reports_check ? '' : 'd-none'; ?> ">
                <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                    Reports
                  </p>
                </a>
              </li>

              <?php if ($_settings->userdata('type') == 1) : ?>
                <li class="nav-item dropdown ">
                  <a href="<?php echo base_url ?>admin/?page=enforcers" class="nav-link nav-enforcers">
                    <i class="nav-icon fas fa-user-nurse"></i>
                    <p>
                      Enforcer List
                    </p>
                  </a>
                </li>
              <?php endif ?>
              <?php if ($_settings->userdata('unique_id') == 843919718) : ?>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class=" nav-icon fas fa-comment-dots"></i>
                    <p>
                      Chat
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">

                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=data_visualization" class="nav-link nav-data_visualization">
                        </i><i class="nav-icon fas fa-chart-bar"></i>
                        <p>Data Visualization</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=responses" class="nav-link nav-responses">
                        <i class=" nav-icon fas fa-reply"></i>
                        <p>Response</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url ?>admin/?page=unanswered" class="nav-link nav-unanswered">
                        <i class="nav-icon far fa-question-circle"></i>
                        <p>Unaswred List</p>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php endif ?>
              <?php if ($_settings->userdata('type') != 3) : ?>
                <li class="nav-header">Maintenance</li>
              <?php endif ?>
              <li class="nav-item <?php echo ($driver_archieve_check || $enforcer_archieve_check || $ticket_violation_archieve_check) ? '' : 'd-none'; ?>">
                <a href="#" class="nav-link">
                  <i class=" nav-icon fas fa-archive"></i>
                  <p>
                    Archieve Data
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item <?php echo $driver_archieve_check ? '' : 'd-none'; ?>">
                    <a href="<?php echo base_url ?>admin/?page=drivers_archieve" class="nav-link tree-item nav-drivers_archieve">
                      <i class="nav-icon fas fa-id-card"></i>
                      <p>Drivers</p>
                    </a>
                  </li>
                  <li class="nav-item <?php echo $enforcer_archieve_check ? '' : 'd-none'; ?>">
                    <a href="<?php echo base_url ?>admin/?page=enforcers_archieve" class="nav-link tree-item nav-enforcers_archieve">
                      <i class="nav-icon fas fa-user-nurse"></i>
                      <p>Enforcers</p>
                    </a>
                  </li>
                  <li class="nav-item <?php echo $ticket_violation_archieve_check ? '' : 'd-none'; ?>">
                    <a href="<?php echo base_url ?>admin/?page=offense_records_archieve" class="nav-link tree-item nav-offense_records_archieve">
                      <i class="nav-icon fas fa-file-alt"></i>
                      <p>Offense Records</p>
                    </a>
                  </li>
                </ul>

              </li>

              <?php if ($_settings->userdata('type') == 1) : ?>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=maintenance/offenses" class="nav-link nav-maintenance_offenses">
                    <i class="nav-icon fas fa-traffic-light"></i>
                    <p>
                      Offenses List
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      User List
                    </p>
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                      Settings
                    </p>
                  </a>
                </li>
              <?php endif ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>

<script>
  $(document).ready(function() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    page = page.split('/');
    page = page.join('_');

    if ($('.nav-link.nav-' + page).length > 0) {
      $('.nav-link.nav-' + page).addClass('active')
      if ($('.nav-link.nav-' + page).hasClass('tree-item')) {
        $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
        $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
      }

    }


  })
</script>