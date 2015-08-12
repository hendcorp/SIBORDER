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
    <title>Si Border - Form Update Modernisation OGP</title>

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

$sql = OCIParse($connect,"SELECT WITEL, MITRA, SITE_ID, LOCATION, LONGITUDE, LATITUDE, STATUS FROM SB_OGP_MO WHERE SITE_ID = '".$_GET['siteid']."'");
ociexecute($sql);
$row = oci_fetch_array($sql);

if(isset($_POST['submit']))
{
  OCIExecute(OCIParse($connect,"UPDATE SB_OGP_MO SET 
                                PLAN_DEPLOYMENT = '".$_POST['deployment']."', 
                                STATUS = '".$_POST['status']."', 
                                REVENUE = '".$_POST['revenue']."',
                                EST_OA = TO_DATE('".$_POST['est_oa']."','DD/MM/YYYY'),
                                KOMENTAR = '".$_POST['comment']."',
                                PERANGKAT = '".$_POST['perangkat']."',
                                LAST_UPDATER = '".$_SESSION['username']."'
                                WHERE SITE_ID = '".$_GET['siteid']."'"));
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
<div class="panel panel-default">
<div class="panel-body">
<h5><strong>FORM UPDATE DATA MODERNISATION</strong></h5><hr />
<div class="row">

<?php echo $alert; ?>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="deployment"><i class="fa fa-line-chart"></i> PLAN DEPLOYMENT</label>
    <select name="deployment" class="form-control input-sm">
    <option value="FIMO">FIMO</option>
    <option value="RIMO">RIMO</option>
    </select>
  </div>
</div>  

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="status"><i class="fa fa-random"></i> STATUS</label>
    <select name="status" class="form-control input-sm">
      <option value="Pre Order">Pre Order</option>
      <option value="DROP">DROP</option>
      <option value="L0 Order">L0 Order</option>
      <option value="L0 Feasibility FO">L0 Feasibility FO</option>
      <option value="L0 Pelimpahan Witel ">L0 Pelimpahan Witel </option>
      <option value="L0 Penunjukan Mitra">L0 Penunjukan Mitra</option>
      <option value="L0 Survey">L0 Survey</option>
      <option value="L0 Tarik FO">L0 Tarik FO</option>
      <option value="L0 Integrasi">L0 Integrasi</option>
      <option value="L0 NY RFI">L0 NY RFI</option>
      <option value="L0 RFI">L0 RFI</option>
      <option value="L0 RFI NY MOS">L0 RFI NY MOS</option>
      <option value="L0 MOS NY Connected">L0 MOS NY Connected</option>
      <option value="L0 Integrasi ">L0 Integrasi </option>
      <option value="L0 Commcase ">L0 Commcase </option>
      <option value="L0 OA">L0 OA</option>
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
 <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-money"></i> REVENUE</label>
    <input type='text' class="form-control input-sm" name="revenue" id='revenue' />
  </div>
</div>

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="est_oa"><i class="fa fa-calendar"></i> ESTIMATION OA</label>
    <input type='text' class="form-control input-sm" name="est_oa" id='datetimepicker1' />
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="perangkat"><i class="fa fa-gear"></i> PERANGKAT AKSES</label>
    <select name="perangkat" class="form-control input-sm">
    <option value="ONT ALU DC">ONT ALU DC</option>
    <option value="ONT ZTE F821 DC">ONT ZTE F821 DC</option>
    <option value="ONT ZTE F829 DC - DH">ONT ZTE F829 DC - DH</option>
    <option value="ONT HUAWEI DC">ONT HUAWEI DC</option>
    <option value="DIRECT PORT">DIRECT PORT</option>
    </select>
  </div>
</div>  
</div>

<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="comment"><i class="fa fa-comment"></i> COMMENT</label>
    <textarea name="comment" class="form-control"></textarea>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-12">  
  <div class="form-group">
  <input type="submit" class="btn btn-danger btn-sm" name="submit" value="UPDATE DATA">
  <button onclick="goBack()" class="btn btn-primary btn-sm">BATAL</button>
  </div>
</div>
</div>

</div>
</div> 
</div>

<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-body">
<h5><strong>DETIL ON GOING PROJECT</strong></h5><hr />
<table class="table table-condensed">
<tr>
  <td width="30%"><strong>WITEL</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[0]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>MITRA</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[1]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>SITE ID</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[2]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>LOCATION</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[3]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>LONGITUDE</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[4]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>LATITUDE</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[5]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>STATUS</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[6]; ?></td>
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

<script>
function goBack() {
    window.history.back();
}
</script>

  </body>
</html>