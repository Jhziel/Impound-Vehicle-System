<?php
require_once('sess_auth.php');

?>


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_settings->info('title') != false ? $_settings->info('title') . ' | ' : '' ?><?php echo $_settings->info('name') ?></title>
  <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
  <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <style type="text/css">
    /* Chart.js */
    @keyframes chartjs-render-animation {
      from {
        opacity: .99
      }

      to {
        opacity: 1
      }
    }

    .uls {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #222;
    }

    .lis {
      margin: 0;
      padding: 0;
      float: left;
    }

    .lis a {
      display: block;
      color: white;
      text-align: center;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-right: 40px;
      padding-left: 40px;
      border-right: 1px solid #555652;
      text-decoration: none;
    }

    .lis a img {
      width: 30px;
      height: 30px;
    }

    .lis a:hover {
      background-color: #555652;
    }

    .actives {
      background-color: #DD4F43;
    }

    .form-area {
      float: right;
      display: table-column;
      margin-bottom: 10px;
      color: white;
    }

    .btn-submit {
      outline: 0;
      background: #F4BA0F;
      width: 120px;
      border: 0;
      padding: 8px;
      color: white;
      font-size: 12px;
      cursor: pointer;
    }

    .btn-submit:hover,
    .form button:active {
      background: #555652;
    }

    #userTable {
      background: #222;
    }

    .outer-scontainer {
      color: #E8E9EB;
      background: #333;
      border: #555652 1px solid;
      padding: 10px;
    }

    .outer-scontainer table {

      width: 100%;
    }

    .outer-scontainer th {
      border: 1px solid #555652;
      padding: 5px;
      text-align: center;
    }

    .outer-scontainer td {
      border: 1px solid #555652;
      padding: 5px;
      text-align: center;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    #analytics_head {
      background-color: #7c3aed
    }

    #openChatBtn {
      width: 100px;
      position: fixed;
      right: 20px;
      bottom: 10px;
    }

    #newConvo {
      display: none;
      position: fixed;
      right: 20px;
      bottom: 2px;

    }

    .form-check-input {
      width: 1.5em;
      /* Adjust as needed */
      height: 1.5em;
    }

    .form-check-label {
      font-size: 1.4em;
    }
  </style>

  <!-- jQuery -->
  <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
  <script>
    var _base_url_ = '<?php echo base_url ?>';
  </script>
  <script src="<?php echo base_url ?>dist/js/script.js"></script>

</head>