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
<?php
    function CekPlan($data,$data2){
        if($data==$data2){
            echo "selected";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="fav.ico" type="image/png">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Si Border - Form Update Roll Out OGP</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap Datetime Picker -->
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script>
        $(document).ready(function(){
            $("#error").hide();
            if(document.getElementById("status").value=="On Air"){
                $("#tgl_oa").show();
                $("#est_oa").hide();
            }
            else{
                $("#est_oa").show();
                $("#tgl_oa").hide();
            }
            $(".target").change(function(){
                if(document.getElementById("status").value=="On Air"){
                    $("#est_oa").hide();
                    $("#tgl_oa").show();
                }
                else{
                    $("#est_oa").show();
                    $("#tgl_oa").hide();
                }
            });
            $("#update-data").click(function(){
                if($("#est_oa").css("display")!="hidden" && document.getElementById("datetimepicker1").value==""){
                    $("#error").show();
                }
                else{
                    var update = "edit.ogp.rollout.process.php?siteid=<?php echo $_GET['siteid']; ?>&witel=<?php echo $_GET['witel']; ?>&jenis=<?php echo $_GET['jenis']; ?>";
                    document.getElementById("form-update").action = update;
                }
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
      <form name="form1" method="POST" action="" id="form-update">  
<?php 
include "mod/nav.php"; 
include "config/connect.php";

$alert = "";

$sql = OCIParse($connect,"SELECT SITE_ID, SITE_NAME, ALAMAT, TARGET, TP, PLAN_DEPLOYMENT, PROGRESS, WITEL, REVENUE,EST_OA,KOMENTAR,PRIORITY,TGL_OA FROM SB_OGP_RO WHERE SITE_ID = '".$_GET['siteid']."'");
ociexecute($sql);
$row = oci_fetch_array($sql);

/*if(isset($_POST['submit']))
{
  $sql = "UPDATE SB_OGP_RO SET 
                                PRIORITY = '".$_POST['priority']."',
                                PLAN_DEPLOYMENT = '".$_POST['deployment']."', 
                                PROGRESS = '".$_POST['status']."', 
                                REVENUE = '".$_POST['revenue']."',
                                EST_OA = TO_DATE('".$_POST['est_oa']."','DD/MM/YYYY'),
                                KOMENTAR = '".$_POST['comment']."',
                                LAST_UPDATER = '".$_SESSION['username']."'
                                WHERE SITE_ID = '".$_GET['siteid']."'";
  $result = oci_parse($connect, $sql);
  oci_execute($result);

  $alert = "<div class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-success\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
          <strong>Done!</strong> Data berhasil diupdate!
          </div></div></div>";
}*/
?>
<div class="container">
<div class="row">
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-body">
<h5><strong>FORM UPDATE DATA ROLL OUT</strong></h5><hr />

<div class="row">
<?php 
$alert = "<div id =\"error\" class=\"col-md-12\"><div class=\"form-group\"><div class=\"alert alert-dismissable alert-success\" style=\"background-color: red;\">
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
          <strong>FAILED!</strong> Data Gagal diupdate karena Estimasi OA tidak diisi!
          </div></div></div>";
echo $alert; ?>
    
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="priority"><i class="fa fa-line-chart"></i>PRIORITY</label>
    <select name="priority" class="form-control input-sm">
        <option value="P1" <?php CekPlan("P1", $row[11]); ?>>P1</option>
        <option value="P2" <?php CekPlan("P2", $row[11]); ?>>P2</option>
        <option value="P3" <?php CekPlan("P3", $row[11]); ?>>P3</option>
    </select>
  </div>
</div>  
</div>

<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="deployment"><i class="fa fa-line-chart"></i> PLAN DEPLOYMENT</label>
    <select name="deployment" class="form-control input-sm">
        <option value="FIRO" <?php CekPlan("FIRO", $row[5]); ?>>FIRO</option>
        <option value="RIRO" <?php CekPlan("RIRO", $row[5]); ?>>RIRO</option>
    </select>
  </div>
</div>  

<div class="col-md-6">
  <div class="form-group">
    <label class="control-label" for="status"><i class="fa fa-random"></i> STATUS</label>
    <select name="status" class="form-control input-sm target" id="status">
      <option value="L1 Survey" <?php CekPlan("L1 Survey", $row[6]); ?>>L1 Survey</option>
      <option value="L1 Prepare" <?php CekPlan("L1 Prepare", $row[6]); ?>>L1 Prepare</option>
      <option value="L1 BTS Not Ready" <?php CekPlan("L1 BTS Not Ready", $row[6]); ?>>L1 BTS Not Ready</option>
      <option value="L1 Comcase Akses BTS" <?php CekPlan("L1 Comcase Akses BTS", $row[6]); ?>>L1 Comcase Akses BTS</option>
      <option value="L1 Comcase BTS" <?php CekPlan("L1 Comcase BTS", $row[6]); ?>>L1 Comcase BTS</option>
      <option value="L1 Drop" <?php CekPlan("L1 Drop", $row[6]); ?>>L1 Drop</option>
      <option value="L1 Penarikan & TC" <?php CekPlan("L1 Integrasi", $row[6]); ?>>L1 Integrasi</option>
      <option value="L1 Alokasi port metro /GPON" <?php CekPlan("L1 Alokasi port metro /GPON", $row[6]); ?>>L1 Alokasi port metro /GPON</option>
      <option value="L2 Request VLAN" <?php CekPlan("L2 Request VLAN", $row[6]); ?>>L2 Request VLAN</option>
      <option value="L2 Detect MAC Address" <?php CekPlan("L2 Detect MAC Address", $row[6]); ?>>L2 Detect MAC Address</option>
      <option value="L3 Ready" <?php CekPlan("L3 Ready", $row[6]); ?>>L3 Ready</option>
      <option value="On Air" <?php CekPlan("On Air", $row[6]); ?>>On Air</option>
    </select>
  </div>
</div>
</div>

<div class="row">
<div class="col-md-6">
 <div class="form-group">
    <label class="control-label" for="revenue"><i class="fa fa-money"></i> REVENUE</label>
    <input type='text' class="form-control input-sm" name="revenue" id='revenue' value="<?php echo $row[8]; ?>"/>
  </div>
</div>

<div class="col-md-6" id="est_oa">
  <div class="form-group">
    <label class="control-label" for="est_oa"><i class="fa fa-calendar"></i> ESTIMATION OA</label>
    <input type='text' class="form-control input-sm" name="est_oa" id='datetimepicker1' value="<?php echo $row[9]; ?>"/>
  </div>
</div>
    
<div class="col-md-6" id="tgl_oa">
  <div class="form-group">
    <label class="control-label" for="tgl_oa"><i class="fa fa-calendar"></i>Tanggal On Air</label>
    <input type='text' class="form-control input-sm" name="tgl_oa" id='datetimepicker2' value="<?php echo $row[12]; ?>"/>
  </div>
</div>
</div>
<div class="row">
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label" for="comment"><i class="fa fa-comment"></i> COMMENT</label>
    <textarea name="comment" class="form-control" id="comment-data"><?php echo $row[10]; ?></textarea>
  </div>
</div>
</div>
<div class="row">
<div class="col-md-12">  
  <div class="form-group">
        <input type="submit" class="btn btn-danger btn-sm" name="submit" value="UPDATE DATA" id="update-data">
        <a onclick="window.location.href='detil.ogp.rollout.php?witel=<?php echo $_GET['witel']; ?>&jenis=<?php echo $_GET['jenis']; ?>'" class="btn btn-primary btn-sm">Kembali</a>
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
  <td width="30%"><strong>SITE_ID</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[0]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>SITE_NAME</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[1]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>ALAMAT</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[2]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>TARGET</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[3]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>TP</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[4]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>DEPLOYMENT</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[5]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>STATUS</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[6]; ?></td>
</tr>
<tr>
  <td width="30%"><strong>WITEL</strong></td>
  <td width="1%">:</td>
  <td><?php echo $row[7]; ?></td>
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
                $(function () {
                $('#datetimepicker2').datetimepicker({locale: 'id', format: 'DD/MM/YYYY'});
                });
        </script>    

<script>
function goBack() {
    window.history.back();
}
</script>

  </body>
</html>