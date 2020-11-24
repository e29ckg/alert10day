<?php
require_once('config.php');
require_once('connection.php');
require_once('func.php');

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
    echo"<script> Swal.fire(
      'Good job!',
      'You clicked the button!',
      'success'
    );
    </script>";
   
    header('Location:10day_ok.php');
}

if (isset($_REQUEST['up_st_id'])) {
    $id = $_REQUEST['up_st_id'];
    $keymain = $_REQUEST['keymain'];
    $st = 0;
    $finish = null;

    $update_stmt = $db->prepare("UPDATE $db_table SET st = :st, finish = :finish WHERE id = :id");
    $update_stmt->bindParam(':st', $st);
    $update_stmt->bindParam(':finish', $finish);
    $update_stmt->bindParam(':id', $id);
    $update_stmt->execute();

    if ($update_stmt->execute()) {
        $sMessage = "\n".$keymain.' อยู่ระหว่างการพิมพ์คำพิพากษา';
        sendLine($sToken,$sMessage);
        
        header('Location:10day_ok.php');
    }
}
?>

<?php include "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        คำพิพากษาที่พิมพ์เรียบร้อยแล้ว
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">คำพิพากษาที่พิมพ์เรียบร้อยแล้ว</li>
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
              <h3 class="box-title">คำพิพากษาที่พิมพ์เรียบร้อยแล้ว</h3>
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
                <table id="example"  class="table no-margin">
                  <thead>
                  <thead>
                    <tr>
                        <th>เลขคดีดำ</th>
                        <th>เลขคดีแดง</th>
                        <th>ผู้พิพากษา</th>
                        <th>วันที่ตัดสิน</th>
                        <th>วันที่ต้องเสร็จ</th>
                        <th>วันที่พิมพ์เสร็จ</th>
                        <!-- <th>st</th> -->
                        <th>#</th>
                        <!-- <th>Delete</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $select_stmt = $db->prepare("SELECT * FROM $db_table WHERE st = :st ORDER BY finish DESC LIMIT 100");
                        $select_stmt->bindParam(':st', $st);
                        $st = 1;
                        $select_stmt->execute();
                        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $row["keymain"]; ?></td>
                        <td><?php echo $row["red"]; ?></td>
                        <td><?php echo $row["just"]; ?></td>
                        <td><?php echo DateThai_full_st($row["datejust"]); ?></td>
                        <td><?php echo DateThai_full_st($row["tofinish"]); ?></td>
                        <td><?php echo DateThai_full_st($row["finish"]); ?></td>
                        <!-- <td><?php echo $row["st"]; ?></td> -->
                        <td>
                        <a href="?up_st_id=<?php echo $row["id"]; ?>&keymain=<?php echo $row['keymain']; ?>" class="btn btn-danger btn-flat" 
                            onclick="return confirm(' <?php echo $row['keymain']; ?> ยังไม่ได้พิมพ์ใช่หรือไม่ ? !!!')">ยกเลิก</a>
                        <!-- <a href="edit.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning">Edit</a></td> -->
                        <!-- <td><a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">ลบ</a></td> -->
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
<script>
// Swal.fire({
//           position: 'top-end',
//           icon: 'success',
//           title: 'Your work has been saved',
//           showConfirmButton: false,
//           timer: 1500
//         })
        </script>
<?php include('layout/footer.php');?>