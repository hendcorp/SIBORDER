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
    <title>Si Border - Detil Roll Out On Going Report</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

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

if($_GET['witel']=='ALL')
{
  $qwitel = " WITEL IS NOT NULL ";
}
else
{
  $qwitel = " WITEL = '".$_GET['witel']."' ";
}


if($_GET['jenis']=='all')
{
  $qjenis = " (STATUS IS NOT NULL OR STATUS IS NULL) ";
}
else if($_GET['jenis']=='po')
{
  $qjenis = " STATUS = 'Pre Order' ";
}
else if($_GET['jenis']=='drop')
{
  $qjenis = " STATUS = 'DROP' ";
}
else if($_GET['jenis']=='oa')
{
  $qjenis = " STATUS = 'L0 OA' ";
}
else if($_GET['jenis']=='ogp')
{
  $qjenis = " STATUS NOT IN ('DROP','Pre Order','L0 OA') ";
}

$sql = OCIParse($connect,"SELECT WITEL, MITRA, SITE_ID, LOCATION, LONGITUDE, LATITUDE, REVENUE, "
        . "STATUS, PERANGKAT, EST_OA, KOMENTAR FROM SB_OGP_MO WHERE".$qwitel."AND".$qjenis."ORDER BY "
        . "SITE_ID");
ociexecute($sql);
?>
  <div class="container">
  <h3 align="center"><strong>DETIL MODERNISATION OGP - WITEL <?php echo $_GET['witel']; ?></strong></h3><br />
  <div class="panel panel-default">
  <div class="panel-body">

<div class="row">
<div class="col-md-12">
<p><a href="get.ogp.rollout.php?tipe=<?php echo $_GET['jenis']; ?>&witel=<?php echo $_GET['witel']; ?>" style="text-decoration:none"><font color="green"><strong><i class="fa fa-file-excel-o"></i> EXPORT TO EXCEL</strong></font></a></p>
  <table class="table table-bordered" id="table_id">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <?php if($_SESSION['privilege']!='guest') { ?>
    <td align="center" width="5%"><br /><strong>ACT</strong></td>
    <?php } ?>
    <td><center><br /><strong>WITEL</strong></center></td>
    <td><center><br /><strong>MITRA</strong></center></td>
    <td><center><br /><strong>SITE_ID</strong></center></td>
    <td><center><br /><strong>SITE_NAME</strong></center></td>
    <td><center><br /><strong>ALAMAT</strong></center></td>
    <td><br /><center><strong>LONGITUDE</strong></center></td>
    <td><center><br /><strong>LATITUDE</strong></center></td>
    <td><center><br /><strong>REVENUE</strong></center></td>
    <td><center><br /><strong>STATUS</strong></center></td>
    <td><center><strong>PERANGKAT<br />AKSES</strong></center></td>
    <td><center><br /><strong>EST_CLS_DATE</strong></center></td>
    <td><center><br /><strong>COMMENT</strong></center></td>
  </tr>
  </thead>
  <tbody>
  <?php while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <?php if($_SESSION['privilege']!='guest') { ?>
    <td align="center"><a href="edit.ogp.mod.php?siteid=<?php echo $row[2]; ?>" style="text-decoration:none"><font color="#E12E32"><i class="fa fa-pencil"></i></font></a></td>
    <?php } ?>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
    <td></td>
    <td><?php echo $row[4]; ?></td>
    <td><?php echo $row[5]; ?></td>
    <td align="right"><?php echo number_format($row[6],0,',',','); ?></td>
    <td><?php echo $row[7]; ?></td>
    <td><?php echo $row[8]; ?></td>
    <td><?php echo $row[9]; ?></td>
    <td><?php echo $row[10]; ?></td>
  </tr>
  <?php } ?>
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
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>

    <script>
    $(document).ready( function () {
    $('#table_id').DataTable({
      "scrollX": true,
      "autoWidth": false
      });  
    });
    </script>  

  </body>
</html>