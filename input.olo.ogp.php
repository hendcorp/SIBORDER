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
    <title>Si Border - Input OLO On Going Project</title>

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

$sqlolo = OCIParse($connect, "SELECT DISTINCT OLO FROM SB_OLO WHERE OLO IS NOT NULL ORDER BY OLO");
ociexecute($sqlolo);

$sqlprod = OCIParse($connect, "SELECT DISTINCT PRODUCT FROM SB_OLO WHERE PRODUCT IS NOT NULL ORDER BY PRODUCT");
ociexecute($sqlprod);


$alert = "";

if(isset($_POST['submit']))
{
  OCIExecute(OCIParse($connect,"INSERT INTO SB_OLO (WITEL, OLO, PRODUCT, KAPS, RUAS, REVENUE, NO_TICARES, EST_CLOSE, STAT_SERVICE, KOMENTAR) 
                                VALUES ('".$_POST['witel']."',
                                        '".$_POST['customer']."',
                                        '".$_POST['service']."',
                                        '".$_POST['bandwidth']."',
                                        '".$_POST['location']."',
                                        '".$_POST['revenue']."',
                                        '".$_POST['ticares']."',
                                        TO_DATE('".$_POST['est_oa']."','DD/MM/YYYY'),
                                        '".$_POST['progress']."',
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
    <h3 class="panel-title"><i class="fa fa-wifi"></i> <strong>INPUT OLO - ON GOING PROJECT</strong></h3>
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
    <label class="control-label" for="customer"><i class="fa fa-building"></i> CUSTOMER</label>
    <select name="customer" id="customer" class="form-control input-sm">
      <?php while ($olo = oci_fetch_array($sqlolo)) { ?>
      <option value="<?php echo strtoupper($olo[0]); ?>"><?php echo strtoupper($olo[0]); ?></option>
      <?php } ?>
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
 <div class="form-group">
    <label class="control-label" for="service"><i class="fa fa-building"></i> SERVICE</label>
    <select name="service" id="service" class="form-control input-sm">
      <option value="">- PILIH -</option>
      <?php while ($prod = oci_fetch_array($sqlprod)) { ?>
      <option value="<?php echo $prod[0]; ?>"><?php echo strtoupper($prod[0]); ?></option>
      <?php } ?>
    </select>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="bandwidth"><i class="fa fa-cloud-download"></i> BANDWIDTH</label>
    <input type="text" class="form-control input-sm" name="bandwidth" id="bandwidth" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="location"><i class="fa fa-map-marker"></i> LOCATION</label>
    <input type="text" class="form-control input-sm" name="location" id="location" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-money"></i> REVENUE</label>
    <input type="text" class="form-control input-sm" name="revenue" id="revenue" />
  </div>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
   <label class="control-label" for="ticares"><i class="fa fa-barcode"></i> NO TICARES</label>
    <input type="text" class="form-control input-sm" name="ticares" id="ticares" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="est_oa"><i class="fa fa-calendar"></i> ESTIMATE CLOSED DATE</label>
    <input type="text" class="form-control input-sm" name="est_oa" id="datetimepicker1" />
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
      <option value="INSTALAGI IKG">INSTALAGI IKG</option>
      <option value="AKTIVASI LOGIC">AKTIVASI LOGIC</option>
      <option value="INTEGRATION">INTEGRATION</option>
      <option value="CLOSED">CLOSED</option>
    </select> 
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
  <input type="submit" name="submit" class="btn btn-primary btn-sm" value="SUBMIT ORDER">
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

  </body>
</html>