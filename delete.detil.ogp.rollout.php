<?php
    include './config/connect.php';
    $sql = "DELETE FROM SB_OGP_RO WHERE SITE_ID='".$_GET['siteid']."'";
    $result = oci_parse($connect, $sql);
    oci_execute($result);
    
    header("Location: detil.ogp.rollout.php?witel=".$_GET['witel']."&jenis=".$_GET['jenis']);
?>