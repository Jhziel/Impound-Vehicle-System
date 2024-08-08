<?php require_once('config.php'); ?>
<!DOCTYPE html>

<html lang="en">
<?php require_once('inc/header.php') ?>

<body>
  <?php require_once('inc/Navbar.php') ?>
  <?php $page = isset($_GET['p']) ? $_GET['p'] : 'home';  ?>


  <?php
  if (!file_exists($page . ".php") && !is_dir($page)) {
    include '404.html';
  } else {
    if (is_dir($page))
      include $page . '/index.php';
    else
      include $page . '.php';
  }
  ?>

  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog   rounded-0 modal-md modal-dialog-centered" role="document">
      <div class="modal-content  rounded-0">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog  rounded-0 modal-full-height  modal-md" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="fa fa-arrow-right"></span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
        <img src="" alt="">
      </div>
    </div>
  </div>
  <script>
    sr = ScrollReveal();

    sr.reveal('.navbar', {
      distance: '20%',
      duration: 2000,
      origin: 'bottom'
    });

    sr.reveal('#homeTop', {
      duration: 2000,
      distance: '100px',
      origin: 'top'
    });

    sr.reveal('.homeRight', {
      duration: 2000,
      distance: '100px',
      origin: 'right'
    });

    sr.reveal('#homeBtn', {
      duration: 2000,
      delay: 1000,
      origin: 'bottom',
      distance: '50px'
    });

    sr.reveal('.serLeft', {
      duration: 2000,
      origin: 'left',
      distance: '50px'
    });

    sr.reveal('.serRight', {
      duration: 2000,
      origin: 'right',
      distance: '50px'
    });

    sr.reveal('.serTop', {
      duration: 2000,
      origin: 'top',
      distance: '50px'
    });
  </script>

</body>

</html>