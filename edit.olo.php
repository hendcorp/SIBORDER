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
    <title>Si Border - Update OLO</title>

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
<?php 
include "mod/nav.php"; 
include "config/connect.php";

$sql = OCIParse($connect,"SELECT NO_TICARES, OLO, PRODUCT, CONCAT(KAPS, SAT) AS BW, RUAS, WITEL FROM SB_OLO WHERE NO_TICARES = '".$_GET['id']."'");
ociexecute($sql);
$row = oci_fetch_array($sql);
?>
<div class="container">
<div class="row">
<div class="col-md-6">
<div class="panel panel-danger">
<div class="panel-heading">
    <h3 class="panel-title"><strong>FORM UPDATE OLO</strong></h3>
</div>
<div class="panel-body">

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="fullname"><i class="fa fa-line-chart"></i> PROGRESS</label>
    <select name="progress_telkom" class="form-control input-sm">
    <option value="- PILIH -">- PILIH -</option>
    <option value="PROSES PENARIKAN FO">PROSES PENARIKAN FO</option>
    <option value="PERANGKAT PELANGGAN BELUM SIAP">PERANGKAT PELANGGAN BELUM SIAP</option>
    <option value="CLOSED ORDER">CLOSED ORDER</option>  
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="fullname"><i class="fa fa-calendar"></i> EST CLOSE DATE</label>
    <input type='text' class="form-control input-sm" name="startdate" id='datetimepicker1' />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-money"></i> REVENUE</label>
    <input type='text' class="form-control input-sm" name="revenue" id='revenue' />
  </div>
</div>
</div>


<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-comment"></i> COMMENT</label>
    <textarea name="comment" class="form-control"></textarea>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">  
  <div class="form-group">
  <input type="submit" class="btn btn-danger btn-sm" value="UPDATE DATA">&nbsp;
  <a href="ogp.olo.php" class="btn btn-primary btn-sm">KEMBALI</a>
  </div>
</div>
</div>
</div>
</div> 
</div>

<div class="col-md-6">
<div class="panel panel-danger">
<div class="panel-heading">
    <h3 class="panel-title"><strong>DETIL DATA OLO</strong></h3>
</div>
<div class="panel-body"><br />
<table class="table table-bordered">
<tr>
  <td width="20%">NO TICARES</td>
  <td>: <?php echo $row[0]; ?></td>
</tr>
<tr>
  <td>CUSTOMER</td>
  <td>: <?php echo $row[1]; ?></td>
</tr>
<tr>
  <td>SERVICE</td>
  <td>: <?php echo $row[2]; ?></td>
</tr>
<tr>
  <td>BW</td>
  <td>: <?php echo $row[3]; ?></td>
</tr>
<tr>
  <td>LOCATION</td>
  <td>: <?php echo $row[4]; ?></td>
</tr>
<tr>
  <td>WITEL</td>
  <td>: <?php echo $row[5]; ?></td>
</tr>
</table>
</div>
</div>
</div>
</div>

<?php include "mod/footer.php"; ?>

  </div>
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