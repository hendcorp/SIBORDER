<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="fav.ico" type="image/png">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Si Border - Detil Non Node B</title>

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

if($_GET['tipe']=='order')
{
  $QueStat = " (STATUS IS NULL OR STATUS IS NOT NULL) ";
}
else if($_GET['tipe']=='closed')
{
  $QueStat = " STATUS = 'CLOSED' ";
}
else if($_GET['tipe']=='drop')
{
  $QueStat = " STATUS = 'DROP' ";
}
else if($_GET['tipe']=='ogp')
{
  $QueStat = " STATUS NOT IN ('CLOSED','DROP') ";
}

if($_GET['witel']=='ALL')
{
  $qwitel = " WITEL IS NOT NULL ";
}
else
{
  $qwitel = " WITEL = '".$_GET['witel']."' ";
}

$sql = OCIParse($connect,"SELECT WITEL, DASAR_ORDER, JENIS, PRODUCT, KAPS, SAT, RUAS, ID FROM SB_NON_NODE_B WHERE".$QueStat."AND".$qwitel);
ociexecute($sql);
?>
<div class="container">
<h3 align="center"><strong>DETIL NON NODE B WITEL <?php echo $_GET['witel']; ?></strong></h3><br />
<div class="panel panel-default">
<div class="panel-body">
<div class="row">
<div class="col-md-12">
<p><a href="get.non.nodeb.php?witel=<?php echo $_GET['witel']; ?>&tipe=<?php echo $_GET['tipe']; ?>" style="text-decoration:none"><font color="green"><strong><i class="fa fa-file-excel-o"></i> EXPORT TO EXCEL</strong></font></a></p>
  <table class="table table-bordered" id="table_id">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <td><strong>WITEL</strong></td>
    <td><strong>DASAR ORDER</strong></td>
    <td><strong>JENIS</strong></td>
    <td><strong>LAYANAN</strong></td>
    <td><strong>KAPASITAS</strong></td>
    <td><strong>SATUAN</strong></td>
    <td><strong>RUAS</strong></td>
    <td><strong>NO_TICARES</strong></td>
    <td><strong>PROGRESS</strong></td>
    <td><strong>EST_CLS_DATE</strong></td>
    <td><strong>COMMENT</strong></td>
  </tr>
  </thead>
  <tbody>
  <?php while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
    <td><?php echo $row[4]; ?></td>
    <td><?php echo $row[5]; ?></td>    
    <td><?php echo $row[6]; ?></td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
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
      "scrollX": true
      });  
    });
    </script>

  </body>
</html>