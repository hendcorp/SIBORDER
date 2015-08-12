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
    <title>Si Border - Report On Going Project OLO</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

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
<form name="form1" method="post">
<?php 
include "mod/nav.php"; 
include "config/connect.php";

if((empty($_POST['witel']))||($_POST['witel']=='ALL'))
{
  $qwit = " WITEL IS NOT NULL";
}
else
{
  $qwit = " WITEL = '".$_POST['witel']."'";
}

$sql = OCIParse($connect,"SELECT WITEL, OLO, PRODUCT, CONCAT(KAPS, SAT) AS BW, RUAS, NO_TICARES, STAT_SERVICE, EST_CLOSE, REVENUE, KOMENTAR FROM SB_OLO WHERE STAT_SERVICE NOT IN ('CLOSED','DROP') AND".$qwit);
ociexecute($sql);

$wit = OCIParse($connect, "SELECT DISTINCT WITEL FROM SB_OLO ORDER BY WITEL");
ociexecute($wit);
?>
<div class="container">
<h3 align="center"><strong>REPORT ON GOING PROJECT OLO</strong></h3><br />
<div class="panel panel-default">
<div class="panel-body">

<div class="row">
<div class="col-md-4">
<i class="fa fa-globe"></i> <strong>WITEL</strong>
<select name="witel" id="witel" class="form-control input-sm">
<?php if(!empty($_POST['witel'])) { ?>
<option value="<?php echo $_POST['witel']; ?>" selected><?php echo $_POST['witel']; ?></option>
<?php } ?>
<option value="ALL">ALL</option>
<?php while($thewitel = oci_fetch_array($wit)) { ?>
<option value="<?php echo $thewitel[0]; ?>"><?php echo $thewitel[0]; ?></option>
<?php } ?>
</select>
</div>

<div class="col-md-2"><br />
<input type="submit" class="btn btn-primary btn-sm" value="RELOAD" name="submit">
</div>

<div class="col-md-6"><br />
<p align="right"><a href="get.ogp.olo.php" style="text-decoration:none"><font color="green"><strong><i class="fa fa-file-excel-o"></i> EXPORT TO EXCEL</strong></font></a></p>
</div>
</div>
<hr />

<div class="row">
<div class="col-md-12">
  <table class="table table-bordered" id="table_id">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <?php if($_SESSION['privilege']!='guest') { ?>
    <td align="center" width="3%"><strong>ACT</strong></td>
    <?php } ?>
    <td><strong>WITEL</strong></td>
    <td><strong>CUSTOMER</strong></td>
    <td><strong>SERVICE</strong></td>
    <td><strong>BW</strong></td>
    <td><strong>LOCATION</strong></td>
    <td><strong>NO_TICARES</strong></td>
    <td><strong>PROGRESS</strong></td>
    <td><strong>EST_CLS_DATE</strong></td>
    <td><strong>REVENUE</strong></td>
    <td><strong>COMMENT</strong></td>
  </tr>
  </thead>
  <tbody>
  <?php while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <?php if($_SESSION['privilege']!='guest') { ?>
    <td align="center"><a href="edit.ogp.olo.php?id=<?php echo $row[5]; ?>" style="text-decoration:none"><font color="#E12E32"><i class="fa fa-pencil"></i></font></a></td>
    <?php } ?>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
    <td><?php echo $row[4]; ?></td>
    <td><?php echo $row[5]; ?></td>
    <td><?php echo $row[6]; ?></td>
    <td><?php echo $row[7]; ?></td>
    <td align="right"><?php echo number_format($row[8],0,',','.'); ?></td>
    <td><?php echo $row[9]; ?></td>
  </tr>
  <?php } ?>
  </tbody>
  </table> 
  </div>
  </div> 
  </div>
  </div>

<?php include "mod/footer.php"; ?>
  </form>
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