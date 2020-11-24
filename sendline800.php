<?php
require_once('config.php');
require_once('func.php');
require_once('connection.php');
$sMessage = "";
// $sToken = "shN6OBCI8wdSaIA8pNrONpgfuooZte8HLCCgLtzvsaa";
$sMessage = "กำหนดที่ต้องพิมพ์เสร็จ"."\n";
$select_stmt = $db->prepare("SELECT * FROM $db_table WHERE st = :st ORDER BY tofinish ASC");
$select_stmt->bindParam(':st', $st);
$st = 0;
$select_stmt->execute();
if($select_stmt->rowCount() > 0){
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        $sMessage .= $row["keymain"] ;
        // $sMessage .= 'ตัดสินวันที่ '.DateThai_full_st($row["datejust"])."\n";
        $sMessage .= ' -> '.DateThai_full_st($row['tofinish'])."\n";  
    }
    $sMessage .= 'ตรวจสอบได้ที่ http://10.37.64.01/alert10day/index.php';  
}else{
    $sMessage = 'ไม่มีคำพิพากษาอยู่ระหว่างพิมพ์';
}      
sendLine($sToken,$sMessage);
?>