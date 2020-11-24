<?php 
require_once('connection.php');
$title = "เพิ่มวันหยุดพิเศษ";

if (isset($_REQUEST['btn_insert'])) {
  $dayhd = $_REQUEST['txt_dayhd'];
  $detail = $_REQUEST['txt_detail'];

  if (empty($dayhd)) {
      echo "<script>alert('กรุณาใส่วันที่')</script>";
  } else if (empty($detail)) {
      echo "<script>alert('กรุณาใส่รายละเอียด')</script>";
  } else {
      try {
          if (!isset($errorMsg)) {
              $insert_stmt = $db->prepare("INSERT INTO sphd(dayhd, detail) VALUES (:dayhd, :detail)");
              $insert_stmt->bindParam(':dayhd', $dayhd);
              $insert_stmt->bindParam(':detail', $detail);

              if ($insert_stmt->execute()) {
                header('Location: spHD.php');
                  // header("refresh:1;spHD.php");
              }
          }
      } catch (PDOException $e) {
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
        เพิ่มวันหยุดพิเศษ
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="spHD.php">วันหยุดพิเศษ</a></li>
        <li class="active">เพิ่ม</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">      
      <!-- Main row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">เพิ่มวันหยุดพิเศษ</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" onsubmit="return validateForm()" class="form-horizontal mt-5">            
              <div class="form-group text-center">
                  <div class="row">
                      <label for="dayhd" class="col-sm-3 control-label">วันที่</label>
                      <div class="col-sm-4">
                          <input type="date" id = "txt_dayhd" name="txt_dayhd" class="form-control" placeholder="Enter วันที่..." require>
                      </div>
                  </div>
              </div>
              <div class="form-group text-center">
                  <div class="row">
                      <label for="detail" class="col-sm-3 control-label">รายละเอียด</label>
                      <div class="col-sm-4">
                          <input type="text" id="txt_detail" name="txt_detail" class="form-control" placeholder="Enter รายละเอียด..." require>
                      </div>
                  </div>
              </div>
              <div class="form-group text-center">
                  <div class="col-md-12 mt-3">
                      <input type="submit" name="btn_insert" class="btn btn-success btn-flat" value="Insert">
                      <a href="index.php" class="btn btn-danger btn-flat">Cancel</a>
                  </div>
              </div>
            </form>
          </div>
      </div>
      <!-- /.row -->
      <div class="box-footer clearfix">
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a> -->
      </div>
            <!-- /.box-footer -->
    </div>
  </section>
  <!-- /.content -->
</div>
    
<script type="text/javascript">
document.getElementById("txt_detail").addEventListener("input", function() {
  if( this.value == '' ) {
    console.log( "NAME is invalid (Empty)" )
  } else {
    console.log( `NAME value is: ${this.value}` );
  }
});
</script>
<script type="text/javascript">
  function validateForm() {
    var a = document.getElementById("txt_dayhd").value;
    var b = document.getElementById("txt_detail").value;
    console.log( b );
    if (a == null || a == "", b == null || b == "") {
      alert("Please Fill All Required Field");
      return false;
    }
  }
</script>
<?php include('layout/footer.php');?>
  