<?php

    require ("reader.php");
    
    $file = $_FILES["Excel"]["name"];
    
    $TargetDir = "Uploads/";
    $TargetFile = $TargetDir.basename($file);
    if(move_uploaded_file($_FILES["Excel"]["tmp_name"], $TargetFile))echo "Data has been Uploaded \n <br>";
    else echo "Failed to Upload data";
    
    $ObjExcel = new Spreadsheet_Excel_Reader();
    $ObjExcel->setOutputEncoding('CP1251');
    $ObjExcel->read($TargetFile);
    
    for ($i = 1; $i <= $ObjExcel->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= $ObjExcel->sheets[0]['numCols']; $j++){
		echo " ".$ObjExcel->sheets[0]['cells'][$i][$j]." ";
	}
	echo "\n";
}
?>