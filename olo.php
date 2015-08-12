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
    <title>Si Border - OLO</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Datetime Picker -->
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">

    <style>
    body{padding-top:75px}
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
$today = date('d/m/Y');

if(empty($_POST['startdate'])) 
{
  $QueDate = " TANGGAL BETWEEN TO_DATE('01/01/2015','DD/MM/YYYY') AND TO_DATE('".$today."','DD/MM/YYYY') ";
  $Month = date('m');
  $Kalimat = "<strong><i class='fa fa-calendar'></i> SELECTED DATE : 01/01/2015 - ".$today."</strong>";
  $start = "01/01/2015";
  $end = $today;  
}
else
{
  $QueDate = " TANGGAL BETWEEN TO_DATE('".$_POST['startdate']."','DD/MM/YYYY') AND TO_DATE('".$_POST['enddate']."','DD/MM/YYYY') ";
  $Month = substr($_POST['enddate'],3,2);
  $Kalimat = "<strong><i class='fa fa-calendar'></i> SELECTED DATE : ".$_POST['startdate']." - ".$_POST['enddate']."</strong>";
  $start = $_POST['startdate'];
  $end = $_POST['enddate'];  
}

$sql = OCIParse($connect,"SELECT WITEL, JML, CLOSED, OGP, STATDROP, ROUND(((decode(CLOSED,0,1,CLOSED)/decode(JML,0,1,JML))*100),2) AS ACH
FROM
(SELECT WITEL,
SUM(CASE WHEN STAT_SERVICE IS NOT NULL THEN 1 ELSE 0 END) AS JML,
SUM(CASE WHEN STAT_SERVICE = 'CLOSED' THEN 1 ELSE 0 END) AS CLOSED,
SUM(CASE WHEN STAT_SERVICE NOT IN ('DROP','CLOSED') THEN 1 ELSE 0 END) AS OGP,
SUM(CASE WHEN STAT_SERVICE = 'DROP' THEN 1 ELSE 0 END) AS STATDROP
FROM SB_OLO GROUP BY WITEL)");
ociexecute($sql);
?>
  <div class="container">
  <h3 align="center"><strong>DASHBOARD OLO</strong></h3><br />
  <div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
        <div class='col-sm-6'>
          <p><br /><?php echo $Kalimat; ?></p>
        </div>
        <div class='col-sm-2'>
            <div class="form-group">START DATE
                <input type='text' class="form-control input-sm" name="startdate" id='datetimepicker1' />
            </div>
        </div>
        <div class='col-sm-1' align="center"><br />
        <strong>S.D</strong>
        </div>
        <div class='col-sm-2'>
            <div class="form-group">END DATE
                <input type='text' class="form-control input-sm" name="enddate" id='datetimepicker2' />
            </div>
        </div>
        <div class='col-sm-1'><br />
        <input type="submit" value="FILTER" name="submit" class="btn btn-primary btn-sm btn-block">
        </div>
    </div>

<div class="row">
<div class="col-md-12">

  <table class="table table-bordered">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <td width="5%" align="center"><strong>NO</strong></td>
    <td><strong>WITEL</strong></td>
    <td align="center"><strong>ORDER</strong></td>
    <td align="center"><strong>CLOSED</strong></td>
    <td align="center"><strong>OGP</strong></td>
    <td align="center"><strong>DROP</strong></td>
    <td align="center"><strong>ACH</strong></td>
  </tr>
  </thead> 
  <tbody>
  <?php $no=1; while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $row[0]; ?></td>
    <td align="right" width="15%"><a href="detil.olo.php?tipe=order&witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[1]; ?></font></a></td>
    <td align="right" width="15%"><a href="detil.olo.php?tipe=closed&witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[2]; ?></font></a></td>
    <td align="right" width="15%"><a href="detil.olo.php?tipe=ogp&witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[3]; ?></font></a></td>
    <td align="right" width="15%"><a href="detil.olo.php?tipe=drop&witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[4]; ?></font></a></td>
    <td align="right" width="15%"><?php echo $row[5]; ?>%</td>
  </tr>
  <?php 
  $no++; 
  $order  += $row[1];
  $closed += $row[2];
  $ogp    += $row[3];
  $drop   += $row[4];
  } 
  $ach = round(($closed/$order)*100,2);
  ?>
  </tbody>    
  <tfoot>
  <tr>
    <td colspan="2"><strong>REGIONAL 5</strong></td>
    <td align="right"><strong><a href="detil.olo.php?tipe=order&witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $order; ?></font></a></strong></td>
    <td align="right"><strong><a href="detil.olo.php?tipe=closed&witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $closed; ?></font></a></strong></td>
    <td align="right"><strong><a href="detil.olo.php?tipe=ogp&witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $ogp; ?></font></a></strong></td>
    <td align="right"><strong><a href="detil.olo.php?tipe=drop&witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $drop; ?></font></a></strong></td>
    <td align="right"><strong><?php echo $ach; ?>%</strong></td>    
  </tr>
  </tfoot>
  </table> 
  </div>
  </div> 
  </div>
  </div>
</form>
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