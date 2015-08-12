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
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script>
        $(document).ready(function (){
            var privilege = <?php echo $_SESSION['privilege'] ?>;
            
            if(privilege!=0){
                $(".delete-data").hide();
            }
            $(".data").hide();
            $("#confirmation").hide();
            
            $(".tutup").click(function (){
                $(".data").hide();
            });
            $("#confirmation-no").click(function(){
                $("#confirmation").hide();
            });
        });
    </script>
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
  $qjenis = " (PROGRESS IS NOT NULL OR PROGRESS IS NULL) ";
}
else if($_GET['jenis']=='drop')
{
  $qjenis = " PROGRESS = 'Drop' ";
}
else if($_GET['jenis']=='oa')
{
  $qjenis = " PROGRESS = 'L1 On Air' ";
}
else if($_GET['jenis']=='ogp')
{
  $qjenis = " PROGRESS NOT IN ('Drop','L1 On Air') ";
}

$sql = OCIParse($connect,
        "SELECT WITEL, SITE_ID, SITE_NAME, ALAMAT,LONGITUDE,LATITUDE, TARGET, TP, PLAN_DEPLOYMENT, "
        . "PROGRESS, REVENUE, EST_OA, KOMENTAR,PRIORITY,TGL_OA,LAST_UPDATER,TGL_LAST_UPDATE FROM SB_OGP_RO WHERE".$qwitel."AND".$qjenis
        ."ORDER BY TGL_LAST_UPDATE DESC");
ociexecute($sql);
?>
  <div class="container">
  <h3 align="center"><strong>DETIL ROLL OUT OGP - WITEL <?php echo $_GET['witel']; ?></strong></h3><br />
  <div class="panel panel-default">
  <div class="panel-body">

<div class="row">
<div class="col-md-12">
<p><a href="get.ogp.rollout.php?tipe=<?php echo $_GET['jenis']; ?>&witel=<?php echo $_GET['witel']; ?>" style="text-decoration:none"><font color="green"><strong><i class="fa fa-file-excel-o"></i> EXPORT TO EXCEL</strong></font></a></p>
  <table class="table table-bordered" id="table_id">
  <thead bgcolor="#E12E32" style="color:#FFFFFF">
  <tr>
    <?php if($_SESSION['privilege']!='guest') { ?>
    <td align="center" width="5%"><strong>ACT</strong></td>
    <?php } ?>
    <td><center><strong>WITEL</strong></center></td>
    <td><center><strong>PRIO</strong></center></td>
    <td><center><strong>SITE_ID</strong></center></td>
    <td><center><strong>SITE_NAME</strong></center></td>
    <!-- <td><center><br /><strong>ALAMAT</strong></center></td> -->
    <td><center><strong>TARGET</strong></center></td>
    <!-- <td><center><strong>TOWER<br />PROVIDER</strong></center></td> -->
    <td><center><strong>PLAN</strong></center></td>
    <td><center><strong>STATUS</strong></center></td>
    <td><center><strong>EST_CLS</strong></center></td>
    <td><center><strong>KOMENTAR</strong></center></td>
    <!-- <td><center><br /><strong>COMMENT</strong></center></td> -->
  </tr>
  </thead>
  <tbody>
  <?php while($row = oci_fetch_array($sql)) { ?>
  <tr>
    <?php if($_SESSION['privilege']!='guest') { ?>
    <td align="center">
        <a href="edit.ogp.rollout.php?siteid=<?php echo $row[1];?>&jenis=<?php echo $_GET['jenis']; ?>&witel=<?php echo $_GET['witel'] ?>&flag=1" style="text-decoration:none"><font color="#E12E32"><i class="fa fa-pencil"></i></font></a>
        <a href="#" style="text-decoration:none" id="but-<?php echo $row[1]; ?>"><font color="#E12E32"><i class="fa fa-eye"></i></font></a>
        <br><a href="#" style="text-decoration:none" id="del-<?php echo $row[1]; ?>" class="delete-data"><font color="#E12E32"><i class="fa fa-remove"></i></font></a>
    </td>
    <?php } ?>
    <script>
        $("#del-<?php echo $row[1]; ?>").click(function(){
            document.getElementById("confirmation-message").innerHTML="<b>Apakah Anda Yakin Untuk Mendelete Data dengan <br>ID = <?php echo $row[1]; ?><br>Secara PERMANEN ?</b>";
            document.getElementById("confirmation-yes").href="delete.detil.ogp.rollout.php?witel=<?php echo $_GET['witel']; ?>&jenis=<?php echo $_GET['jenis']; ?>&siteid=<?php echo $row[1]; ?>";
            $(".data").hide();
            $("#confirmation").show();
            $("#<?php echo $row[1]; ?>").show();
        });
    </script>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo $row[13]; ?></td>
    <td><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <!-- <td><?php echo $row[3]; ?></td> -->
    <td><?php echo $row[6]; ?></td>
    <!-- <td><?php echo $row[7]; ?></td> -->
    <td><?php echo $row[8]; ?></td>
    <td><?php echo $row[9]; ?></td>
    <td><?php echo $row[11]; ?></td>
    <td><?php echo $row[12]; ?></td>
    <!--<td align="right"><?php echo number_format($row[11],0,',',','); ?></td>-->
    <!-- <td><?php echo $row[12]; ?></td> -->
  </tr>
  <?php } ?>
  </table> 
  </div>
  </div> 
      <a onclick="window.location.href='ogp.rollout.php'" class="btn btn-primary btn-sm">Kembali</a>
  </div>
  </div>
<?php include "mod/footer.php"; ?>
<?php 
  ociexecute($sql);
while($row = oci_fetch_array($sql)) { ?>
  <div class="data" id="<?php echo $row[1]; ?>">
    <div class="panel panel-default" style="text-align: center;">
    <div class="panel-body">
        <h5><strong>DETAIL ON GOING PROJECT</strong></h5>
        <a href="#" class="btn btn-primary btn-sm tutup">TUTUP</a>
        <hr />
    <table class="table table-condensed">
        <script>
            $("#but-<?php echo $row[1]; ?>").click(function(){
                $(".data").hide();
                $("#<?php echo $row[1]; ?>").show();
            });
        </script>
    <tr>
      <td width="30%"><strong>WITEL</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[0]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>PRIORITY</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[13]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>SITE_ID</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[1]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>SITE_NAME</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[2]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>ALAMAT</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[3]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>TARGET</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[6]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>TOWER PROVIDER</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[7]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>DEPLOYMENT</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[8]; ?></td>
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
      <td width="30%"><strong>PROGRESS</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[9]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>REVENUE</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[10]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>ESTIMASI OA</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[11]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>TANGGAL ON AIR</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[14]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>UPDATE TERAKHIR</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[15]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>TGL UPDATE TERAKHIR</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[16]; ?></td>
    </tr>
    <tr>
      <td width="30%"><strong>KOMENTAR</strong></td>
      <td width="1%">:</td>
      <td><?php echo $row[12]; ?></td>
    </tr>
    </table>
    </div>
  </div>
</div>
<?php } ?>
  <style>
      .data{
          width: 40%;
          float: left;
          position: fixed;
          left: 29%;
          top: 10%;
          border: 3px groove #080808;
      }
      #confirmation{
          width: 40%;
          float: left;
          position: fixed;
          left: 29%;
          top: 10%;
          border-top: 3px groove #080808;
          border-left: 3px groove #080808;
          border-right: 3px groove #080808;
      }
  </style>
  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<div id="confirmation">
    <div class="panel panel-default" style="text-align: center;">
    <div class="panel-body">
        <h5 id="confirmation-message"><strong></strong></h5>
        <a href="#" class="btn btn-primary btn-sm tutup" style="margin-right: 3%; width: 10%; height: 5%;" id="confirmation-yes">YES</a>
        <a href="#" class="btn btn-primary btn-sm tutup" style="width: 10%; height: 5%;" id="confirmation-no">NO</a>
    </div>
  </div>
</div>
    <script>
    $(document).ready( function () {
    $('#table_id').DataTable({
      "scrollX": false,
      "autoWidth": false
      });  
    });
    </script>  

  </body>
</html>