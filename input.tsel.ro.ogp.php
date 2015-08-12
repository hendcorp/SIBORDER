<?php 
session_start();
if(empty($_SESSION['privilege']))
{
  echo "<script language=javascript>
              parent.location.href='login.php';
        </script>";
}
else if($_SESSION['privilege']=='guest')
{
  echo "<script language=javascript>
              parent.location.href='unknown.php';
        </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="fav.ico" type="image/png">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Si Border - Input TSEL Roll Out OGP</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Datetime Picker -->
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
    <style>
    body{padding-top:80px}
    footer{
      margin:5em 0
      }
    footer li{
      float:left;
      margin-right:1.5em;
      margin-bottom:1.5em
      }
    footer p{
      clear:left;
      margin-bottom:0
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<form name="form1" method="POST">  
<?php 
include "mod/nav.php"; 
include "config/connect.php";

$alert = "";

if(isset($_POST['submit']))
{
  if($_POST['site_id']==""||$_POST['site_name']==""){
      $alert = "<div class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-success\" style=\"background-color: red;\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                <strong>FAILED!<br></strong> Data Gagal Disimpan karena tidak memeiliki Site ID atau Site Name!
                </div></div></div>";
  }
  else{
      $sql = "INSERT INTO SB_OGP_RO (PRIORITY,WITEL, SITE_ID, SITE_NAME, ALAMAT, TARGET, TP, REVENUE, PLAN_DEPLOYMENT,LONGITUDE,LATITUDE, PROGRESS, EST_OA, KOMENTAR,LAST_UPDATER,TGL_LAST_UPDATE) 
                                VALUES ('".$_POST['priority']."',
                                        '".$_POST['witel']."',
                                        '".$_POST['site_id']."',
                                        '".$_POST['site_name']."',
                                        '".$_POST['alamat']."',
                                        '".$_POST['tgt_bln']."',
                                        '".$_POST['tower']."',
                                        '".$_POST['revenue']."',
                                        '".$_POST['deploy']."',
                                        '".$_POST['longitude']."',
                                        '".$_POST['latitude']."',
                                        '".$_POST['status']."',
                                        TO_DATE('".$_POST['est_oa']."','DD/MM/YYYY'),
                                        '".$_POST['komentar']."',
                                        '".$_SESSION['username']."',
                                        '".  strtoupper(date("d-M-y"))."'
                                )";
        $result = oci_parse($connect, $sql);
        oci_execute($result);

        $alert = "<div class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-success\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
                <strong>Done!</strong> Data berhasil disimpan!
                </div></div></div>";
  }
}
?>
<div class="container">
<div class="row">
<div class="col-md-8">
<div class="panel panel-primary">
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-line-chart"></i> <strong>INPUT TSEL - ROLL OUT ON GOING PROJECT</strong></h3>
</div>
<div class="panel-body">
<br />
<div class="row">
    <?php echo $alert; ?>
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="priority"><i class="fa fa-magic"></i>PRIORITY</label>
    <select name="priority" class="form-control input-sm">
        <option value="P1">P1</option>
        <option value="P2">P2</option>
        <option value="P3">P3</option>
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="witel"><i class="fa fa-globe"></i> WITEL</label>
    <select name="witel" class="form-control input-sm">
      <option value="DENPASAR">DENPASAR</option>
      <option value="GRESIK">GRESIK</option>
      <option value="JEMBER">JEMBER</option>
      <option value="KEDIRI">KEDIRI</option>  
      <option value="KUPANG">KUPANG</option>
      <option value="MADIUN">MADIUN</option>
      <option value="MALANG">MALANG</option>
      <option value="MATARAM">MATARAM</option>
      <option value="PASURUAN">PASURUAN</option>
      <option value="SIDOARJO">SIDOARJO</option>
      <option value="SINGARAJA">SINGARAJA</option>
      <option value="SURABAYA">SURABAYA</option>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="site_id"><i class="fa fa-tag"></i> SITE ID</label>
    <input tipe="text" class="form-control input-sm" name="site_id" id="site_id" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="site_name"><i class="fa fa-book"></i> SITE NAME</label>
    <input tipe="text" class="form-control input-sm" name="site_name" id="site_name" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="alamat"><i class="fa fa-map-marker"></i> ALAMAT</label>
    <input tipe="text" class="form-control input-sm" name="alamat" id="alamat" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="tgt_bln"><i class="fa fa-calendar"></i> TARGET BULAN</label>
    <select name="tgt_bln" class="form-control input-sm">
      <option value="JANUARI">JANUARI</option>
      <option value="FEBRUARI">FEBRUARI</option>
      <option value="MARET">MARET</option>
      <option value="APRIL">APRIL</option>  
      <option value="MEI">MEI</option>
      <option value="JUNI">JUNI</option>
      <option value="JULI">JULI</option>
      <option value="AGUSTUS">AGUSTUS</option>
      <option value="SEPTEMBER">SEPTEMBER</option>
      <option value="OKTOBER">OKTOBER</option>
      <option value="NOVEMBER">NOVEMBER</option>
      <option value="DESEMBER">DESEMBER</option>
    </select>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="tower"><i class="fa fa-wifi"></i> TOWER PROVIDER</label>
    <input tipe="text" class="form-control input-sm" name="tower" id="tower" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-money"></i> REVENUE</label>
    <input tipe="text" class="form-control input-sm" name="revenue" id="revenue" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="deploy"><i class="fa fa-magic"></i> PLAN DEPLOYMENT</label>
    <select name="deploy" class="form-control input-sm">
        <option value="FIRO">FIRO</option>
        <option value="RIRO">RIRO</option>
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="longitude"><i class="fa fa-magic"></i>LONGITUDE</label>
    <input tipe="number" class="form-control input-sm" name="longitude" id="longitude" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="latitude"><i class="fa fa-magic"></i>LATITUDE</label>
    <input tipe="number" class="form-control input-sm" name="latitude" id="latitude" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="status"><i class="fa fa-plug"></i> STATUS</label>
    <select name="status" class="form-control input-sm">
      <option value="L1 Survey">L1 Survey</option>
      <option value="L1 Prepare">Prepare</option>
      <option value="L1 BTS Not Ready">L1 BTS Not Ready</option>
      <option value="L1 Comcase Akses BTS">L1 Comcase Akses BTS</option>
      <option value="L1 Comcase BTS">L1 Comcase BTS</option>
      <option value="L1 Drop">L1 Drop</option>
      <option value="L1 Penarikan & TC">L1 Penarikan & TC</option>
      <option value="L1 Alokasi port metro/GPON">L1 Alokasi port metro/GPON</option>
      <option value="L2 Request VLAN">L2 Request VLAN</option>
      <option value="L2 Detect MAC Address">L2 Detect MAC Address</option>
      <option value="L3 Ready">L3 Ready</option>
      <option value="On Air">On Air</option>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="est_oa"><i class="fa fa-calendar"></i> ESTIMATE ON AIR</label>
    <input tipe="text" class="form-control input-sm" name="est_oa" id="datetimepicker1" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="komentar"><i class="fa fa-comment"></i> COMMENT</label>
    <textarea name="komentar" class="form-control"></textarea>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">  
  <div class="form-group">
  <input type="submit" name="submit" class="btn btn-primary btn-sm" value="SUBMIT ORDER" id="submit">
  </div>
</div>
</div>
</div>
</div> 
</div>
</div>

<?php include "mod/footer.php"; ?>

</div>
</form>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
           
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({locale: 'id', format: 'DD/MM/YYYY'});
                });
        </script>    

        <script>
        $("#jenis").change(function() {
            $("#deploy").load(encodeURI("mod/getdeploy.php?jenis=" + $("#jenis").val()));
        });
        </script>

  </body>
</html>