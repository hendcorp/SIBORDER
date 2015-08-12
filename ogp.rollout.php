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
    <title>Si Border - Roll Out On Going Project</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

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
<?php 
include "mod/nav.php"; 
include "config/connect.php";

//Initialization By Wahyu
  $no=0; 
  $jml=0;
  $drop=0;
  $oa=0;
  $ogp=0;
  $firo=0;
  $riro=0;
//End of Initialization

$sql = OCIParse($connect,"SELECT WITEL, 
COUNT(*) AS TOTAL,
SUM(CASE WHEN PROGRESS = 'Drop' THEN 1 ELSE 0 END) AS STATDROP,
SUM(CASE WHEN PROGRESS = 'L1 On Air' THEN 1 ELSE 0 END) AS OA,
SUM(CASE WHEN PROGRESS NOT IN ('Drop','L1 On Air') THEN 1 ELSE 0 END) AS OGP,
SUM(CASE WHEN PLAN_DEPLOYMENT = 'FIRO' THEN 1 ELSE 0 END) AS FIRO,
SUM(CASE WHEN PLAN_DEPLOYMENT = 'RIRO' THEN 1 ELSE 0 END) AS RIRO
FROM SB_OGP_RO GROUP BY WITEL ORDER BY WITEL");
ociexecute($sql);
?>
  <div class="container">
  <h3 align="center"><strong>NODE B - ROLL OUT ON GOING PROJECT REPORT</strong></h3><br />
  <div class="panel panel-default">
  <div class="panel-body">

<div class="row">
<div class="col-md-12"><br />
  <table class="table table-bordered">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <td width="5%" rowspan="2" align="center"><br /><strong>NO</strong></td>
    <td rowspan="2" align="center"><br /><strong>WITEL</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>TOTAL</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>DROP</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>OA</strong></td>
    <td rowspan="2" align="center" width="10%"><br /><strong>OGP</strong></td>
    <td colspan="2" align="center" width="20%"><strong>PLAN DEPLOYMENT</strong></td>
  </tr>
  <tr>
    <td width="10%" align="center"><strong>FIRO</strong></td>
    <td width="10%" align="center"><strong>RIRO</strong></td> 
  </tr>
  </thead>
  <tbody>
  <?php $no=1; while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $row[0]; ?></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=<?php echo $row[0]; ?>&jenis=all" style="text-decoration:none"><font color="#E12E32"><?php echo $row[1]; ?></font></a></td></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=<?php echo $row[0]; ?>&jenis=drop" style="text-decoration:none"><font color="#E12E32"><?php echo $row[2]; ?></font></a></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=<?php echo $row[0]; ?>&jenis=oa" style="text-decoration:none"><font color="#E12E32"><?php echo $row[3]; ?></font></a></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=<?php echo $row[0]; ?>&jenis=ogp" style="text-decoration:none"><font color="#E12E32"><?php echo $row[4]; ?></font></a></td>
    <td align="right"><?php echo $row[5]; ?></td>
    <td align="right"><?php echo $row[6]; ?></td>
  </tr>
  <?php 
  $no++; 
  $jml  += $row[1];
  $drop += $row[2];
  $oa   += $row[3];
  $ogp  += $row[4];
  $firo += $row[5];
  $riro += $row[6];
  } 
  ?>
  </tbody>    
  <tfoot>
  <tr>
    <td colspan="2"><strong>REGIONAL 5</strong></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=ALL&jenis=all" style="text-decoration:none"><font color="#E12E32"><strong><?php echo $jml; ?></strong></font></a></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=ALL&jenis=drop" style="text-decoration:none"><font color="#E12E32"><strong><?php echo $drop; ?></strong></font></a></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=ALL&jenis=oa" style="text-decoration:none"><font color="#E12E32"><strong><?php echo $oa; ?></strong></font></a></td>
    <td align="right"><a href="detil.ogp.rollout.php?witel=ALL&jenis=ogp" style="text-decoration:none"><font color="#E12E32"><strong><?php echo $ogp; ?></strong></font></a></td>
    <td align="right"><strong><?php echo $firo; ?></strong></td>
    <td align="right"><strong><?php echo $riro; ?></strong></td>
  </tr>
  </tfoot>
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
  </body>
</html>