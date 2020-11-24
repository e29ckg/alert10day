<?php
include_once('config.php');
require_once('func.php');
require_once('connection.php');

$sMessage = "\n";
// $sToken = "shN6OBCI8wdSaIA8pNrONpgfuooZte8HLCCgLtzvsaa";
if (isset($_REQUEST['send_line_id'])) {
    $id = $_REQUEST['send_line_id'];        
    $select_stmt = $db->prepare("SELECT * FROM $db_table WHERE id = :id");
    $select_stmt->bindParam(':id', $id);
    $st = 0;
    $select_stmt->execute();
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        $sMessage .= 'เลขคดีดำ '.$row["keymain"] ."\n";
        $sMessage .= 'ตัดสินวันที่ '.DateThai_full_st($row["datejust"])."\n";
        $sMessage .= 'กำหนดเสร็จ '.DateThai_full_st($row['tofinish'])."\n";  
        $sMessage .= '('.$row['just'].')';      
    }
    sendLine($sToken,$sMessage);
    header('Location:line.php');
}

if (isset($_REQUEST['send_line_all'])) {
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
      $sMessage .= 'ตรวจสอบรายได้ที่ http://10.37.64.01/alert10day/index.php';  
    }else{
        $sMessage = 'ไม่มีคำพิพากษาอยู่ระหว่างพิมพ์';
    }  
    sendLine($sToken,$sMessage);
    header('Location:line.php');
}
?>
<?php include "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      คดีที่อยู่ระหว่างพิมพ์คำพิพากษา
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">sss</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-12">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">คำพิพากษา 10 วัน</h3>

            <div class="box-tools pull-right">
              <a href="?send_line_all" class="btn btn-sm btn-success btn-flat pull-right">ส่งทั้งหมด</a>
              <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> -->
              <!-- </button> -->
              <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                      <th>เลขคดีดำ</th>
                      <th>เลขคดีแดง</th>
                      <th>ผู้พิพากษา</th>
                      <th>วันที่ตัดสิน</th>
                      <th>วันที่ต้องเสร็จ</th>
                      <!-- <th>finish</th> -->
                      <!-- <th>st</th> -->
                      <th>#</th>
                      <!-- <th>Delete</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      $select_stmt = $db->prepare("SELECT * FROM $db_table WHERE st = :st ORDER BY tofinish ASC");
                      $select_stmt->bindParam(':st', $st);
                      $st = 0;
                      $select_stmt->execute();
                      while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <tr>
                      <td><?php echo $row["keymain"]; ?></td>
                      <td><?php echo $row["red"]; ?></td>
                      <td><?php echo $row["just"]; ?></td>
                      <td><?php echo $row["datejust"]; ?></td>
                      <td><?php echo $row["tofinish"]; ?></td>
                      <!-- <td><?php echo $row["finish"]; ?></td> -->
                      <!-- <td><?php echo $row["st"]; ?></td> -->
                      <td>
                      <a href="?send_line_id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-flat" 
                          onclick="return confirm(' <?php echo $row['keymain']; ?> ส่งผ่าน lineNotify ? !!!')">ส่ง</a>
                      <!-- <a href="edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td> -->
                      <!-- <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a></td> -->
                  </tr>
                  <?php } ?>
                </tbody>                  
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a> -->
          </div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('layout/footer.php');?>
