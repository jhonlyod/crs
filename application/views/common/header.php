<?php //if(empty($_SESSION['client_id'])){ echo "<script>alert('Your session has expired. Please relogin.')</script>"; echo "<script>window.location.href='".base_url()."'</script>"; exit; } ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>COMPANY REGISTRATION SYSTEM</title>
  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="<?php echo base_url(); ?>assets/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/crs.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/selectize/dist/css/selectize.bootstrap3.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Custom styles for -->
  <link href="<?php echo base_url(); ?>assets/datatables/plugins/FixedColumns/css/fixedColumns.bootstrap4.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/datatables/plugins/Select-1.2.6/css/select.bootstrap4.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/datatables/plugins/CheckTable/css/dataTables.checkboxes.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->
  <link href="<?php echo base_url(); ?>assets/css/font-googleapis.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/dropzone/dropzone.css" rel="stylesheet">
  <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

    <link href="<?php echo base_url(); ?>assets/sweetalert2/css/sweetalert2.min.css" rel="stylesheet">

</head>

<body class="bg-white">
  <!--<div class="alert alert-danger" role="alert" >
      ATTENTION: CRS and SMR, will undergo System Maintenance on April 20, 2021 at 10:00PM onwards. Please close and finish all transactions before the said schedule to avoid data loss. Sorry for the inconvenience.
  </div>-->
