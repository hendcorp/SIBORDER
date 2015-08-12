<?php
        session_start();
        include "config/connect.php";
        $tgl_oa = $_POST['tgl_oa'];
        if($_POST['status']!="On Air"){
            $tgl_oa="";
        }
        $sql = "UPDATE SB_OGP_RO SET 
                                PRIORITY = '".$_POST['priority']."',
                                TGL_OA = '".$tgl_oa."',    
                                PLAN_DEPLOYMENT = '".$_POST['deployment']."', 
                                PROGRESS = '".$_POST['status']."', 
                                REVENUE = '".$_POST['revenue']."',
                                EST_OA = TO_DATE('".$_POST['est_oa']."','DD/MM/YYYY'),
                                KOMENTAR = '".$_POST['comment']."',
                                LAST_UPDATER = '".$_SESSION['username']."'
                                WHERE SITE_ID = '".$_GET['siteid']."'";
        $result = oci_parse($connect, $sql);
        oci_execute($result);
        
        header("Location: detil.ogp.rollout.php?witel=".$_GET['witel']."&jenis=".$_GET['jenis']);
?>