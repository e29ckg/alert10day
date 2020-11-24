<?php 
require_once('connection.php');
require_once('func.php');
$title = "วันหยุดพิเศษ";
    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM sphd WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        // Delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM sphd WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:spHD.php');
    }
?>

<?php include "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      วันหยุดพิเศษ
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">วันหยุดพิเศษ</li>
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
            <h3 class="box-title">วันหยุดพิเศษ</h3>
            <div class="box-tools pull-right">
              <a href="spHD_add.php" class="btn btn-sm btn-success btn-flat pull-right">
                <i class="fa fa-plus"></i>
                เพิ่มข้อมูล
              </a>
              <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th>วันที่</th>
                    <th>รายละเอียด</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $select_stmt = $db->prepare("SELECT * FROM sphd ORDER BY dayhd DESC");
                    $select_stmt->execute();
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <tr>
                      <td><?php echo DateThai_full($row["dayhd"]); ?></td>
                      <td><?php echo $row["detail"]; ?></td>
                      <td><a href="spHD_update.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-warning btn-flat">Edit</a> 
                      <a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-flat"onclick="return confirm('ต้องการลบหรือไม่ ?')">Delete</a></td>
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
<?php include('layout/footer.php');?>
  