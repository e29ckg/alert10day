<?php
include('config.php');
require_once('connection.php');
require_once('func.php');
$title = "อยู่ระหว่างพิมพ์";
if (isset($_REQUEST['delete_id'])) {
    $id = $_REQUEST['delete_id'];

    $select_stmt = $db->prepare("SELECT * FROM $db_table WHERE id = :id");
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Delete an original record from db
    $delete_stmt = $db->prepare("DELETE FROM $db_table WHERE id = :id");
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    header('Location:index.php');
}

if (isset($_REQUEST['up_st_id'])) {
    $id = $_REQUEST['up_st_id'];
    $keymain = $_REQUEST['keymain'];
    $st = 1;
    $finish = date("Y-m-d");

    $update_stmt = $db->prepare("UPDATE $db_table SET st = :st, finish = :finish WHERE id = :id");
    $update_stmt->bindParam(':st', $st);
    $update_stmt->bindParam(':finish', $finish);
    $update_stmt->bindParam(':id', $id);
    $update_stmt->execute();

    if ($update_stmt->execute()) {
        $sMessage = "\n".$keymain.' พิมพ์เสร็จเรียบร้อยแล้ว';
        sendLine($sToken,$sMessage);
        header('Location:10day_index.php');
    }
}
?>
<?php include "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      อยู่ระหว่างพิมพ์คำพิพากษา
      <small>MySql</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">คำพิพากษา 10 วัน</li>
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
            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat pull-right">เพิ่มข้อมูล</a> -->
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table id="example" class="table no-margin">
                <thead>
                  <tr>
                    <th>เลขคดีดำ</th>
                    <th>เลขคดีแดง</th>
                    <th>ผู้พิพากษา</th>
                    <th>วันที่ตัดสิน</th>
                    <th>วันที่ต้องเสร็จ</th>
                    <th>เลขคดีดำ</th>
                    <!-- <th>finish</th> -->
                    <!-- <th>st</th> -->
                    <th>#</th>
                    <!-- <th>Delete</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $select_stmt = $db->prepare("SELECT * FROM $db_table WHERE st = :st");
                    $select_stmt->bindParam(':st', $st);
                    $st = 0;
                    $select_stmt->execute();
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <tr>
                    <td><?php echo $row["keymain"]; ?></td>
                    <td><?php echo $row["red"]; ?></td>
                    <td><?php echo $row["just"]; ?></td>
                    <td><?php echo DateThai_full_st($row["datejust"]); ?></td>
                    <td><?php echo DateThai_full_st($row["tofinish"]); ?></td>
                    <td><?php echo $row["keymain"]; ?></td>
                    <!-- <td><?php echo $row["finish"]; ?></td> -->
                    <!-- <td><?php echo $row["st"]; ?></td> -->
                    <td>
                    <a href="?up_st_id=<?php echo $row["id"]; ?>&keymain=<?php echo $row['keymain']; ?>"
                      class="btn btn-danger btn-flat" onclick="return confirm(' <?php echo $row['keymain']; ?> เสร็จแล้ว ? !!!')"> เสร็จแล้วกด</a>
                    <!-- <a href="edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning btn-flat">Edit</a></td> -->
                    <!-- <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-flat">Delete</a></td> -->
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