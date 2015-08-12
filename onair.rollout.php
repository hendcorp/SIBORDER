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
    <title>Si Border - Roll Out On Air Report</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Datetime Picker -->
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">    

    <!-- Morris Chart CSS -->
    <link href="css/morris.css" rel="stylesheet">    

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

$sql = OCIParse($connect,"SELECT A.*, B.FIRO, B.RIRO, B.TOTAL, A.TARGET - B.TOTAL AS DEV, ROUND((B.TOTAL/A.TARGET)*100,0) AS ACH FROM
(SELECT WITEL, 
SUM(CASE WHEN JENIS = 'RO' AND PERIODE BETWEEN '201501' AND '2015".$Month."' THEN TARGET ELSE 0 END) AS TARGET 
FROM SB_TGT WHERE JENIS = 'RO' GROUP BY WITEL) A,
(SELECT WITEL, 
SUM(CASE WHEN PROJECT = 'FIRO' THEN 1 ELSE 0 END) AS FIRO,
SUM(CASE WHEN PROJECT = 'RIRO' THEN 1 ELSE 0 END) AS RIRO,
SUM(CASE WHEN PROJECT IN ('FIRO','RIRO') THEN 1 ELSE 0 END) AS TOTAL
FROM SB_NODE_B_RO WHERE".$QueDate."AND STATUS_OA = 'OA' GROUP BY WITEL) B
WHERE A.WITEL = B.WITEL ORDER BY ACH DESC");
ociexecute($sql);
?>
  <div class="container">
  <h3 align="center"><strong>ROLL OUT - ON AIR REPORT</strong></h3><br />
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
  <table class="table table-bordered table-striped">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <td width="5%" rowspan="2" align="center"><br /><strong>NO</strong></td>
    <td rowspan="2" align="center"><br /><strong>WITEL</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>TGT YTD</strong></td>
    <td colspan="3" align="center" width="30%"><strong>REAL</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>DEV</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>ACH %</strong></td>
  </tr>
  <tr>
    <td align="center" width="10%"><strong>FIRO</strong></td>
    <td align="center" width="10%"><strong>RIRO</strong></td> 
    <td align="center" width="10%"><strong>TOTAL</strong></td>
  </tr>
  </thead>
  <tbody>
  <?php $no=1; while($row=oci_fetch_array($sql)) { ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $row[0]; ?></td>
    <td align="right"><?php echo $row[1]; ?></td>
    <td align="right"><?php echo $row[2]; ?></td>
    <td align="right"><?php echo $row[3]; ?></td>
    <td align="right"><a href="detil.ro.php?witel=<?php echo $row[0]; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $row[4]; ?></font></a></td>
    <td align="right"><?php echo $row[5]; ?></td>
    <td align="right"><?php echo $row[6]; ?>%</td>
  </tr>
  <?php 
  $no++; 
  $tgt   += $row[1]; 
  $firo  += $row[2];
  $riro  += $row[3];
  $total += $row[4];
  $dev   += $row[5];
  } 
  $ach = round(($total/$tgt)*100,0);
  ?>  
  </tbody>
  <tfoot>
  <tr>
  <td colspan="2"><strong>TOTAL REGIONAL 5</strong></td>
  <td align="right"><strong><?php echo $tgt; ?></strong></td>
  <td align="right"><strong><?php echo $firo; ?></strong></td>
  <td align="right"><strong><?php echo $riro; ?></strong></td>
  <td align="right"><strong><a href="detil.ro.php?witel=ALL&start=<?php echo $start; ?>&end=<?php echo $end; ?>" style="text-decoration:none"><font color="#E12E32"><?php echo $total; ?></font></a></strong></td>
  <td align="right"><strong><?php echo $dev; ?></strong></td>
  <td align="right"><strong><?php echo $ach; ?>%</strong></td>
  </tr>
  </tfoot>    
  </table> 
  </div>
  </div>

  <!--
  <hr />
  <div class="row">
  <div class="col-md-8">
  <strong>GRAFIK ROLL OUT ON AIR REGIONAL 5</strong>
  <div id="bar-example"></div>
  </div>  
  </div>
  -->
  
  </div>
  </div>
</form>
<?php include "mod/footer.php"; ?>

  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment-with-locales.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    <script src="js/raphael-min.js"></script>
    <script src="js/morris-0.4.1.min.js"></script>
           
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

        <script type="text/javascript">
          Morris.Bar({
          element: 'bar-example',
          data: [
                  { y: '201501', a: 100, b: 90 },
                  { y: '201502', a: 75,  b: 65 },
                  { y: '201503', a: 50,  b: 40 },
                  { y: '201504', a: 75,  b: 65 },
                  { y: '201505', a: 50,  b: 40 },
                  { y: '201506', a: 75,  b: 65 }
                ],
          xkey: 'y',
          ykeys: ['a', 'b'],
          labels: ['Target', 'Real'],
          hideHover: 'auto',
          barColors: ['#E12E32', '#959695']
          });
        </script>
  </body>
</html>