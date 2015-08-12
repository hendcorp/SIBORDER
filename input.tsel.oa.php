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
    <title>Si Border - Input TSEL On Air</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
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
  if(empty($_POST['jenis']))
  {
    $alert = "<div class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-danger\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
          <strong>Ops!</strong> Mohon pilih JENIS!
          </div></div></div>";
  }
  else
  {
    if($_POST['jenis']=='ROLL OUT')             $TableName = "SB_NODE_B_RO";
    else if($_POST['jenis']=='MODERNISATION')   $TableName = "SB_NODE_B_MOD";
    
    $sql = "INSERT INTO ".$TableName." (WITEL, SITE_ID, SITE_NAME, AO, PROJECT, FLAG_ORDER, OA_DATE, REVENUE, STATUS_OA) 
                                  VALUES (
                                    '".$_POST['witel']."',
                                    '".$_POST['site_id']."',
                                    '".$_POST['location']."',
                                    '".$_POST['sid_ticares']."',
                                    '".$_POST['deploy']."',
                                    '".$_POST['flag']."',
                                    TO_DATE('".$_POST['oa_date']."','DD/MM/YYYY'),
                                    '".$_POST['revenue']."', 
                                    'OA'
                                  )";
    $result = oci_parse($connect,$sql);
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
    <h3 class="panel-title"><i class="fa fa-wifi"></i> <strong>INPUT TSEL - ON AIR</strong></h3>
</div>
<div class="panel-body">
<br />
<div class="row">

<?php echo $alert; ?>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="jenis"><i class="fa fa-database"></i> JENIS</label>
    <select name="jenis" id="jenis" class="form-control input-sm">
      <option value="">- PILIH -</option>
      <option value="ROLL OUT">ROLL OUT</option>
      <option value="MODERNISATION">MODERNISATION</option>
    </select>
  </div>
</div>
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
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="site_id"><i class="fa fa-tag"></i> SITE ID</label>
    <input tipe="text" class="form-control input-sm" name="site_id" id="site_id" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="location"><i class="fa fa-map-marker"></i> LOCATION</label>
    <input tipe="text" class="form-control input-sm" name="location" id="location" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="sid_ticares"><i class="fa fa-key"></i> SID TICARES</label>
    <input tipe="text" class="form-control input-sm" name="sid_ticares" id="sid_ticares" />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="deploy"><i class="fa fa-magic"></i> DEPLOYMENT</label>
    <select name="deploy" id="deploy" class="form-control input-sm">

    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="flag"><i class="fa fa-flag"></i> FLAG ORDER</label>
    <select name="flag" id="flag" class="form-control input-sm">
      <option value="REGULER">REGULER</option>
      <option value="ADDITIONAL">ADDITIONAL</option>
    </select>
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="oa_date"><i class="fa fa-calendar"></i> ON AIR DATE</label>
    <input tipe="text" class="form-control input-sm" name="oa_date" id="datetimepicker1" />
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

</div>
</form>  

<!-- Editted By Wahyu -->
<form name="form1" method="POST" action="Prototype/Excel_Reader.php" enctype="multipart/form-data">   
<div class="container">
<div class="row">
<div class="col-md-8">
<div class="panel panel-primary">
<div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-wifi"></i> <strong>IMPORT DATA TSEL - ON AIR</strong></h3>
</div>
<div class="panel-body">
<div class="row">
<div class="col-md-12">  
  <div class="form-group">
  <input type="file" name="Excel" class="btn btn-primary btn-sm">
  <br>
  <input type="submit" name="submit" class="btn btn-primary btn-sm" value="SUBMIT">
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
      <!-- Editted By Wahyu -->
      
      
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