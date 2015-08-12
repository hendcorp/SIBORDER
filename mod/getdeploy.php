<?php
$jenis = $_GET['jenis'];

//DEFINE THE ARRAY DATA
$array = array('RIMO' => 'MODERNISATION',
'FIMO' => 'MODERNISATION',
'RIRO' => 'ROLL OUT',
'FIRO' => 'ROLL OUT');

//GENERATE SELECTED DATA
while ($datajenis = current($array)) {
    if ($datajenis == $jenis) {
        echo "<option value = '".key($array)."'>".key($array)."</option>";
    }
    next($array);
}
?>