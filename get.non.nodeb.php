<?php
header("Pragma: public"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=TSEL_NON_NODE_B_".$_GET['witel'].".xls");

include "config/connect.php";

if($_GET['tipe']=='order')
{
  $QueStat = " (STATUS IS NULL OR STATUS IS NOT NULL) ";
}
else if($_GET['tipe']=='closed')
{
  $QueStat = " STATUS = 'Closed' ";
}
else if($_GET['tipe']=='ogp')
{
  $QueStat = " STATUS <> 'Closed' ";
}

if($_GET['witel']=='ALL')
{
  $qwitel = " WITEL IS NOT NULL ";
}
else
{
  $qwitel = " WITEL = '".$_GET['witel']."' ";
}


$sql = OCIParse($connect, "SELECT * FROM SB_NON_NODE_B WHERE".$QueStat."AND".$qwitel);
ociexecute($sql);

echo "<table border='1'>\n";
$ncols = oci_num_fields($sql);
echo "<tr>\n";
for ($i = 1; $i <= $ncols; ++$i) {
    $colname = oci_field_name($sql, $i);
    echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
}
echo "</tr>\n";

while (($row = oci_fetch_array($sql, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
     echo "<tr>\n";
     foreach ($row as $therow) {
          echo "  <td>".($therow !== null ? htmlentities($therow, ENT_QUOTES):" ")."</td>\n";
     }
    echo "</tr>\n";
}
echo "</table>\n";
?>