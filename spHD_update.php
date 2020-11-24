<?php 
    require_once('connection.php');
    $title = "แก้ไขวันหยุดพิเศษ";
    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM sphd WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $dayhd_up = $_REQUEST['txt_dayhd'];
        $detail_up = $_REQUEST['txt_detail'];

        if (empty($dayhd_up)) {
            echo "<script>alert('กรุณาใส่วันที่')</script>";
        } else if (empty($detail_up)) {
            echo "<script>alert('รายละเอียด')</script>";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE sphd SET dayhd = :dayhd_up, detail = :detail_up WHERE id = :id");
                    $update_stmt->bindParam(':dayhd_up', $dayhd_up);
                    $update_stmt->bindParam(':detail_up', $detail_up);
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header('Location: spHD.php');
                        // header("refresh:1;spHD.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<?php include "layout/header.php"; ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขวันหยุดพิเศษ
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="spHD.php">วันหยุดพิเศษ</a></li>
            <li class="active">แก้ไข</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">      
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">แก้ไขวันหยุดพิเศษ</h3>
                    </div>
                    <!-- /.box-header -->
                <!-- form start -->
                    <form method="post" class="form-horizontal mt-5">            
                        <div class="form-group text-center">
                            <div class="row">
                                <label for="dayhd" class="col-sm-3 control-label">วันที่</label>
                                <div class="col-sm-4">
                                    <input type="date" name="txt_dayhd" class="form-control" value="<?php echo $dayhd; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="row">
                                <label for="detail" class="col-sm-3 control-label">รายละเอียด</label>
                                <div class="col-sm-4">
                                    <input type="text" name="txt_detail" class="form-control" value="<?php echo $detail; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-md-12 mt-3">
                                <input type="submit" name="btn_update" class="btn btn-success btn-flat" value="Update">
                                <a href="spHD.php" class="btn btn-danger btn-flat">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>   
<?php include('layout/footer.php');?>
  