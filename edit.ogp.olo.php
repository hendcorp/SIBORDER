<?php 
session_start();
if(empty($_SESSION['privilege']))
{
  echo "<script language=javascript>
              parent.location.href='login.php';
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
    <title>Si Border - Update OGP OLO</title>

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

$sql = OCIParse($connect,"SELECT NO_TICARES, OLO, PRODUCT, CONCAT(KAPS, SAT) AS BW, RUAS, WITEL, REVENUE, KOMENTAR FROM SB_OLO WHERE NO_TICARES = '".$_GET['id']."'");
ociexecute($sql);
$row = oci_fetch_array($sql);

if(isset($_POST['submit']))
{
  if(!empty($_POST['est_close']))
  {
    $qtgl = " EST_CLOSE = TO_DATE('".$_POST['est_close']."','DD/MM/YYYY'), ";
  }
  else
  {
    $qtgl = "";
  }

  OCIExecute(OCIParse($connect,"UPDATE SB_OLO SET
                                STAT_SERVICE = '".$_POST['progress']."',
                                ".$qtgl."REVENUE = '".$_POST['revenue']."',
                                KOMENTAR = '".$_POST['comment']."',
                                LAST_UPDATER = '".$_SESSION['username']."'
                                WHERE NO_TICARES = '".$_GET['id']."'"));
  sql_ora("commit");

  $alert = "<div class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-success\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
          <strong>Done!</strong> Data berhasil diupdate!
          </div></div></div>";
}
?>
<div class="container">
<div class="row">
<div class="col-md-6">
<div class="panel panel-danger">
<div class="panel-heading">
    <h3 class="panel-title"><strong>FORM UPDATE OGP OLO</strong></h3>
</div>
<div class="panel-body">

<div class="row">

<?php echo $alert; ?>

<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="progress"><i class="fa fa-line-chart"></i> PROGRESS</label>
    <select name="progress" class="form-control input-sm">
    <option value="QUOTATION">QUOTATION</option>
    <option value="PENARIKAN AKSES">PENARIKAN AKSES</option>
    <option value="INSTALASI IKG">INSTALASI IKG</option>  
    <option value="AKTIVASI LOGIC">AKTIVASI LOGIC</option>  
    <option value="INTEGRATION">INTEGRATION</option>
    <option value="CLOSED">CLOSED</option>   
    <option value="DROP">DROP</option>   
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="est_close"><i class="fa fa-calendar"></i> EST CLOSE DATE</label>
    <input type="text" class="form-control input-sm" name="est_close" id='datetimepicker1' />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-money"></i> REVENUE</label>
    <input type="text" class="form-control input-sm" name="revenue" id="revenue" value="<?php echo $row[6]; ?>" />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="comment"><i class="fa fa-comment"></i> COMMENT</label>
    <textarea name="comment" class="form-control"><?php echo $row[7]; ?></textarea>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">  
  <div class="form-group">
  <input type="submit" class="btn btn-danger btn-sm" name="submit" value="UPDATE DATA">&nbsp;
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
    <h3 class="panel-title"><strong>DETIL ON GOING PROJECT - OLO</strong></h3>
</div>
<div class="panel-body"><br />
<table class="table">
<tr>
  <td width="20%"><strong>NO TICARES</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[0]; ?></td>
</tr>
<tr>
  <td><strong>CUSTOMER</strong></td>
  <td>:</td>
  <td><?php echo $row[1]; ?></td>
</tr>
<tr>
  <td><strong>SERVICE</strong></td>
  <td>:</td>
  <td><?php echo $row[2]; ?></td>
</tr>
<tr>
  <td><strong>BANDWIDTH</strong></td>
  <td>:</td>
  <td><?php echo $row[3]; ?></td>
</tr>
<tr>
  <td><strong>LOCATION</strong></td>
  <td>:</td>
  <td><?php echo $row[4]; ?></td>
</tr>
<tr>
  <td><strong>WITEL</strong></td>
  <td>:</td>
  <td><?php echo $row[5]; ?></td>
</tr>
</table>
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