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
    <title>Si Border - Sistem Informasi Boost The Order</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
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
  $QueDate = " OA_DATE BETWEEN TO_DATE('01/01/2015','DD/MM/YYYY') AND TO_DATE('".$today."','DD/MM/YYYY') ";
  $Month = date('m');
  $Kalimat = "<strong><i class='fa fa-calendar'></i> SELECTED DATE : 01/01/2015 - ".$today."</strong>";
  $start = "01/01/2015";
  $end = $today;
}
else
{
  $QueDate = " OA_DATE BETWEEN TO_DATE('".$_POST['startdate']."','DD/MM/YYYY') AND TO_DATE('".$_POST['enddate']."','DD/MM/YYYY') ";
  $Month = substr($_POST['enddate'],3,2);
  $Kalimat = "<strong><i class='fa fa-calendar'></i> SELECTED DATE : ".$_POST['startdate']." - ".$_POST['enddate']."</strong>";
  $start = $_POST['startdate'];
  $end = $_POST['enddate'];
}

$sql = OCIParse($connect,"SELECT C.*, 
NVL(D.MO,0) AS REALMO, 
NVL(D.RO,0) AS REALRO,
NVL(ROUND((D.MO/C.MO_YTD)*100,0),0) AS ACH_MO_YTD, 
NVL(ROUND((D.RO/C.RO_YTD)*100,0),0) AS ACH_RO_YTD,
NVL(ROUND((D.MO/C.MO)*100,0),0) AS ACH_MO, 
NVL(ROUND((D.RO/C.RO)*100,0),0) AS ACH_RO
FROM
(SELECT WITEL,
SUM(CASE WHEN JENIS = 'MO' AND PERIODE BETWEEN '201501' AND '2015".$Month."' THEN TARGET ELSE 0 END) AS MO_YTD,
SUM(CASE WHEN JENIS = 'RO' AND PERIODE BETWEEN '201501' AND '2015".$Month."' THEN TARGET ELSE 0 END) AS RO_YTD,
SUM(CASE WHEN JENIS = 'MO' AND PERIODE BETWEEN '201501' AND '201512' THEN TARGET ELSE 0 END) AS MO,
SUM(CASE WHEN JENIS = 'RO' AND PERIODE BETWEEN '201501' AND '201512' THEN TARGET ELSE 0 END) AS RO
FROM SB_TGT GROUP BY WITEL) C,
(SELECT A.WITEL, A.TOTAL AS MO, B.TOTAL AS RO FROM
(SELECT WITEL,
SUM(CASE WHEN PROJECT IN ('FIMO','RIMO') THEN 1 ELSE 0 END) AS TOTAL
FROM SB_NODE_B_MOD WHERE".$QueDate."AND STATUS_OA = 'OA' GROUP BY WITEL) A,
(SELECT WITEL,
SUM(CASE WHEN PROJECT IN ('FIRO','RIRO') THEN 1 ELSE 0 END) AS TOTAL
FROM SB_NODE_B_RO WHERE".$QueDate."AND STATUS_OA = 'OA' GROUP BY WITEL) B
WHERE A.WITEL = B.WITEL(+)) D
WHERE C.WITEL = D.WITEL(+)");
ociexecute($sql);
?>
  <div class="container">
  <div class="row">
  <div class='col-sm-6'>
  <h3><strong>TELKOMSEL - NODE B</strong></h3>
  </div>
  <div class='col-sm-6'>
  <p align="right"><img src="img/logo.png" width="200"></p>
  </div>
  </div>
  <br />
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
    <td width="5%" rowspan="2" align="center"><br /><strong>NO</strong></td>
    <td rowspan="2" align="center"><br /><strong>WITEL</strong></td>
    <td colspan="2" align="center" width="16%"><strong>TGT YTD</strong></td>
    <td colspan="2" align="center" width="16%"><strong>TGT 2015</strong></td>
    <td colspan="2" align="center" width="16%"><strong>REAL</strong></td>
    <td colspan="2" align="center" width="16%"><strong>ACH YTD %</strong></td>
    <td colspan="2" align="center" width="16%"><strong>ACH 2015 %</strong></td>
  </tr>
  <tr>
    <td width="8%" align="center"><strong>Modern</strong></td>
    <td width="8%" align="center"><strong>RollOut</strong></td>
    <td width="8%" align="center"><strong>Modern</strong></td>
    <td width="8%" align="center"><strong>RollOut</strong></td> 
    <td width="8%" align="center"><strong>Modern</strong></td>
    <td width="8%" align="center"><strong>RollOut</strong></td> 
    <td width="8%" align="center"><strong>Modern</strong></td>
    <td width="8%" align="center"><strong>RollOut</strong></td> 
    <td width="8%" align="center"><strong>Modern</strong></td>
    <td width="8%" align="center"><strong>RollOut</strong></td>     
  </tr>
  </thead> 
  <tbody>
  <?php $no=1; while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $row[0]; ?></td>
    <td align="right"><?php echo $row[1]; ?></td>
    <td align="right"><?php echo $row[2]; ?></td>
    <td align="right"><?php echo $row[3]; ?></td>
    <td align="right"><?php echo $row[4]; ?></td>
    <td align="right"><a href="detil.php?tipe=mo&witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[5]; ?></font></a></td>
    <td align="right"><a href="detil.php?tipe=ro&witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[6]; ?></font></a></td>
    <td align="right"><?php echo $row[7]; ?>%</td>
    <td align="right"><?php echo $row[8]; ?>%</td>
    <td align="right"><?php echo $row[9]; ?>%</td>
    <td align="right"><?php echo $row[10]; ?>%</td>
  </tr>
  <?php 
  $no++; 
  $mo_tgt_ytd  += $row[1];
  $ro_tgt_ytd  += $row[2];
  $mo_tgt      += $row[3];
  $ro_tgt      += $row[4];  
  $mo_real     += $row[5];
  $ro_real     += $row[6];
  } 
  $mo_ach  = round(($mo_real/$mo_tgt)*100,0);
  $ro_ach  = round(($ro_real/$ro_tgt)*100,0);
  $mo_ach_ytd  = round(($mo_real/$mo_tgt_ytd)*100,0);
  $ro_ach_ytd  = round(($ro_real/$ro_tgt_ytd)*100,0);
  ?>
  </tbody>    
  <tfoot>
  <tr>
    <td colspan="2"><strong>REGIONAL 5</strong></td>
    <td align="right"><strong><?php echo $mo_tgt_ytd; ?></strong></td>
    <td align="right"><strong><?php echo $ro_tgt_ytd; ?></strong></td> 
    <td align="right"><strong><?php echo $mo_tgt; ?></strong></td>
    <td align="right"><strong><?php echo $ro_tgt; ?></strong></td>   
    <td align="right"><a href="detil.php?tipe=mo&witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><strong><?php echo $mo_real; ?></strong></font></a></td>
    <td align="right"><a href="detil.php?tipe=ro&witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><strong><?php echo $ro_real; ?></strong></font></a></td>
    <td align="right"><strong><?php echo $mo_ach_ytd; ?>%</strong></td>
    <td align="right"><strong><?php echo $ro_ach_ytd; ?>%</strong></td>
    <td align="right"><strong><?php echo $mo_ach; ?>%</strong></td>
    <td align="right"><strong><?php echo $ro_ach; ?>%</strong></td>
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