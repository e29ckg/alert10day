<?php
// ฟังก์ชั่นอย่างง่ายใช้ทดสอบ หน้าปัจจุบัน
function active_menu($link_chk){
    if(basename($_SERVER['SCRIPT_NAME']) == $link_chk){
        return "active";
    }
    // else{
    //     return basename($_SERVER['SCRIPT_NAME']);
    // }
}
// include_once('config.php');

?>

<section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?=active_menu("index.php")?>">
          <a href="index.php">
            <i class="fa fa-th"></i> <span>DashBoard</span>
            
          </a>
        </li>
        <li class="<?=active_menu("10day_index.php")?>">
          <a href="10day_index.php">
            <i class="fa fa-bell"></i> <span>คำพิพากษา 10 วัน </span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green"><?=$dayNum?></small>
            </span>
          </a>
        </li>
        <li class="<?=active_menu("10day_ok.php")?>">
          <a href="10day_ok.php">
            <i class="fa fa-briefcase"></i> <span>คำพิพากษาที่พิมพ์เสร็จแล้ว</span>            
          </a>
        </li>
        
        <li class="header">ตั้งค่า</li>
        <li class= "<?= active_menu('spHD.php').active_menu('spHD_update.php').active_menu('spHD_add.php')?>">
          <a href="spHD.php">
            <i class="fa fa-tree"></i> <span>วันหยุดพิเศษ</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
        <li class="<?= active_menu('line.php')?>">
          <a href="line.php">
            <i class="fa fa-send"></i> <span>LINE Notify (แจ้งเตือน)</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
        <li class="<?=active_menu("10day_acc_to_mysql.php")?>">
          <a href="10day_acc_to_mysql.php">
            <i class="fa fa-server"></i> <span>ข้อมูลจาก access</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
      </ul>
    </section>