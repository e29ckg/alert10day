<?php
include_once('connection.php');
$select_stmt = $db->prepare("SELECT * FROM 10day WHERE st = :st");
$select_stmt->bindParam(':st', $st);
$st = 0;
$select_stmt->execute();
$dayNum = $select_stmt->rowCount();
?>
<nav class="navbar navbar-static-top">
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
  <span class="sr-only">Toggle navigation</span>
</a>
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <!-- Messages: style can be found in dropdown.less-->
    
    <li class="dropdown notifications-menu">
      <a href="10day_index.php" class="dropdown-toggle">
        <i class="fa fa-bell"></i>
        <span class="label label-warning"><?=$dayNum;?></span>
      </a>
      
    </li>
    <!-- Tasks: style can be found in dropdown.less -->
    
    <li class="dropdown user user-menu">
      <a href="index.php" class="dropdown-toggle">
        <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
        <span class="hidden-xs">ระบบคำพิพากษา 10 วัน</span>
      </a>
      
    </li>
    <!-- Control Sidebar Toggle Button -->
    <li>
      <!-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> -->
    </li>
  </ul>
</div>

</nav>
