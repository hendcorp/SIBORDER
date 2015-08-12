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
    <title>Si Border - Input Non Node B OGP</title>

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
  $getID = OCIParse($connect, "SELECT MAX(ID) AS LAST_ID FROM SB_NON_NODE_B");
  OCIExecute($getID);
  $get_last_id = oci_fetch_array($getID);
  $last_id = $get_last_id[0];
  $next_id = $last_id+1;

  OCIExecute(OCIParse($connect,"INSERT INTO SB_NON_NODE_B (ID, WITEL, DASAR_ORDER, JENIS, PRODUCT, KAPS, SAT, RUAS, REVENUE, NO_TICARES, STATUS, EST_CLS, KOMENTAR) VALUES (
                                '00".$next_id."',
                                '".$_POST['witel']."',
                                '".$_POST['dasar_order']."',
                                '".$_POST['jenis']."',
                                '".$_POST['layanan']."',
                                '".$_POST['kapasitas']."',
                                '".$_POST['satuan']."',
                                '".$_POST['ruas']."',
                                '".$_POST['revenue']."',
                                '".$_POST['ticares']."',
                                '".$_POST['progress']."',
                                TO_DATE('".$_POST['est_oa']."','DD/MM/YYYY'),
                                '".$_POST['komentar']."')"));
  sql_ora("commit");

  $alert = "<div class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-success\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
          <strong>Done!</strong> Data berhasil disimpan!
          </div></div></div>";
}
?>
<div class="container">
<div class="row">
<div class="col-md-8">
<div class="panel panel-primary">
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-line-chart"></i> <strong>INPUT NON NODE B - ON GOING PROJECT</strong></h3>
</div>
<div class="panel-body">
<br />
<div class="row">

<?php echo $alert; ?>

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
    <label class="control-label" for="dasar_order"><i class="fa fa-ticket"></i> DASAR ORDER</label>
    <input tipe="text" class="form-control input-sm" name="dasar_order" id="dasar_order" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="jenis"><i class="fa fa-tag"></i> JENIS ORDER</label>
    <select name="jenis" class="form-control input-sm">
      <option value="DUAL HOMING">DUAL HOMING</option>
      <option value="MO">MO</option>
      <option value="UPGRADE">UPGRADE</option>
      <option value="AKTIVASI">AKTIVASI</option>
    </select>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="layanan"><i class="fa fa-suitcase"></i> LAYANAN</label>
    <select name="layanan" class="form-control input-sm">
      <option value="DUAL HOMING DAN BACKHAUL">DUAL HOMING DAN BACKHAUL</option>
      <option value="SL LITE">SL LITE</option>
      <option value="CORE">CORE</option>
      <option value="METROLITE">METROLITE</option>
      <option value="BACKHAUL">BACKHAUL</option>
      <option value="METRO">METRO</option>
      <option value="RNC">RNC</option>
    </select>  
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="kapasitas"><i class="fa fa-map-marker"></i> KAPASITAS</label>
    <input tipe="text" class="form-control input-sm" name="kapasitas" id="kapasitas" />
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="satuan"><i class="fa fa-map-marker"></i> SATUAN</label>
    <select name="satuan" class="form-control input-sm">
      <option value="Mbps">Mbps</option>
      <option value="Gbps">Gbps</option>
      <option value="Core">Core</option>
    </select>  
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="ruas"><i class="fa fa-pencil-square"></i> RUAS</label>
    <textarea name="ruas" id="ruas" class="form-control"></textarea>
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
    <label class="control-label" for="ticares"><i class="fa fa-barcode"></i> NO TICARES</label>
    <input tipe="text" class="form-control input-sm" name="ticares" id="ticares" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="progress"><i class="fa fa-plug"></i> PROGRESS</label>
    <select name="progress" class="form-control input-sm">
      <option value="QUOTATION">QUOTATION</option>
      <option value="PENARIKAN AKSES">PENARIKAN AKSES</option>
      <option value="INSTALASI IKG">INSTALASI IKG</option>
      <option value="AKTIVASI LOGIC">AKTIVASI LOGIC</option>
      <option value="INTEGRATION">INTEGRATION</option>
      <option value="CLOSED">CLOSED</option>
    </select> 
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="est_oa"><i class="fa fa-calendar"></i> ESTIMATE CLOSED ORDER</label>
    <input tipe="text" class="form-control input-sm" name="est_oa" id="datetimepicker1" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="komentar"><i class="fa fa-comment"></i> COMMENT</label>
    <textarea name="komentar" id="komentar" class="form-control"></textarea>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">  
  <div class="form-group">
  <input type="submit" class="btn btn-primary btn-sm" value="SUBMIT ORDER" name="submit">
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