<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="fav.ico" type="image/png">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Si Border - Detil Roll Out</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Datetime Picker -->
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">

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

$sql = OCIParse($connect,"SELECT SITE_ID, SITE_NAME, PROJECT, FLAG_ORDER, OA_DATE, REVENUE FROM SB_NODE_B_RO WHERE STATUS_OA = 'OA' AND".$qwitel."AND OA_DATE BETWEEN TO_DATE('".$_GET['start']."','DD/MM/YYYY') AND TO_DATE('".$_GET['end']."','DD/MM/YYYY') ORDER BY SITE_ID");
ociexecute($sql);
?>
  <div class="container">
  <h3 align="center"><strong>DETIL ROLL OUT ON AIR WITEL <?php echo $_GET['witel']; ?></strong></h3><br />
  <div class="panel panel-default">
  <div class="panel-body">
<div class="row">
<div class="col-md-12">
<p><a href="get.oa.ro.php?witel=<?php echo $_GET['witel']; ?>" style="text-decoration:none"><font color="green"><strong><i class="fa fa-file-excel-o"></i> EXPORT TO EXCEL</strong></font></a></p>
  <table class="table table-bordered" id="table_id">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <td align="center" width="5%"><strong>NO</strong></td>
    <td><strong>SITE_ID</strong></td>
    <td width="35%"><strong>LOCATION</strong></td>
    <td><strong>DEPLOYMENT</strong></td>
    <td><strong>FLAG_ORDER</strong></td>
    <td><strong>OA_DATE</strong></td>
    <td><strong>REVENUE</strong></td>
  </tr>
  </thead>
  <tbody>
  <?php $no=1; while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo strtoupper($row[1]); ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
    <td><?php echo $row[4]; ?></td>
    <td align="right"><?php echo number_format($row[5],0,',','.'); ?></td>
  </tr>
  <?php $no++; } ?>
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

    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
    <script>
    $(document).ready( function () {
    $('#table_id').DataTable({
      "scrollX": true
      });  
    });
    </script>
           
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({locale: 'id', format: 'DD/MM/YYYY'});
                $('#datetimepicker2').datetimepicker({locale: 'id', format: 'DD/MM/YYYY'});
                $('#datetimepicker1').on("dp.change", function (e) {
                $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
                });
                $('#datetimepicker2').on("dp.change", function (e) {
                $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
                });
            });
        </script>    

  </body>
</html>