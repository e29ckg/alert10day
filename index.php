<?php
// Start the session
session_start();
include('config.php');
require_once('connection.php');
?>
<?php include "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DashBoard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> DashBoard</a></li>
        <li class="active">หน้าแรก</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"> <i class="fa fa-bell"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">อยู่ระหว่างพิมพ์</span>
              <span class="info-box-number"> <?=$dayNum;?> <small>เรื่อง</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-gavel"></i></span>
            <?php
              $datejust = date("Y-m",strtotime("now")).'%';
              $select_stmt = $db->prepare("SELECT * FROM 10day WHERE datejust LIKE '{$datejust}'");              
              $select_stmt->execute();
              $datejustNum = $select_stmt->rowCount();
              ?>
            <div class="info-box-content">
              <span class="info-box-text">ทีตัดสินเดือนนี้</span>
              <span class="info-box-number"><?=$datejustNum?>  <small>เรื่อง</small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-edit"></i></span>
              <?php
                $datejust = date("Y-m",strtotime("now")).'%';
                $select_stmt = $db->prepare("SELECT * FROM 10day WHERE tofinish LIKE '{$datejust}'");              
                $select_stmt->execute();
                $tofinishNum = $select_stmt->rowCount();
                ?>
              <div class="info-box-content">
                <span class="info-box-text">ต้องพิมพ์ให้เสร็จเดือนนี้</span>
                <span class="info-box-number"><?=$tofinishNum?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
            <!-- /.col -->
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fa fa-check"></i></span>
              <?php
                $datejust = date("Y-m",strtotime("now")).'%';
                $select_stmt = $db->prepare("SELECT * FROM 10day WHERE finish LIKE '{$datejust}'");              
                $select_stmt->execute();
                $finishNum = $select_stmt->rowCount();
                ?>
              <div class="info-box-content">
                <span class="info-box-text">เดือนนี้พิมพ์เสร็จแล้ว</span>
                <span class="info-box-number"><?=$finishNum?></span>
              </div>
            <!-- /.info-box-content -->
            </div>
          <!-- /.info-box -->
          </div>
        <!-- /.col -->
        </div>
    <!-- Main content -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('layout/footer.php');?>