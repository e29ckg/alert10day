<?php
include('config.php');
include('connection.php');
include('func.php');

$sToken = "shN6OBCI8wdSaIA8pNrONpgfuooZte8HLCCgLtzvsaa";

$db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "alert";
    $db_table = "10day";

    $db_access = [
      'username'  => "",
      'password'  => "",
  ];

try {
    $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_user, $db_password);
    $db->exec("set names utf8");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOEXCEPTION $e) {
    $e->getMessage();
}

function ckSpecial($date,$db){
  $sql = "SELECT * FROM sphd WHERE dayhd = :dayhd LIMIT 1";
  $query = $db->prepare($sql);
  $query->bindParam(':dayhd',$dayhd, PDO::PARAM_STR);
  $dayhd = date('Y-m-d',strtotime($date));
  $query->execute();
  // $result = $query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0){
    return true;
    // foreach($result as $res){
    //   echo $res->id.' | ';
    //   echo $res->dateSpecial . '<br>';
    // }
  }
  return false;
}

try {
    $dbh = new PDO("odbc:project", $db_access['username'], $db_access['password']);
    $dbh->exec("set names utf8");
    // set the PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    $stmt = $dbh->prepare("SELECT * FROM 10day ORDER BY justDate ASC");  
    // $dbh->bindParam(':justa', 'ผ', PDO::PARAM_STR);  
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);    
    $count = 0;
    $count =count($result);
    $dataD = array();
    if($count > 0){
        $data['count'] = $count;
        foreach ($result as $rs) {
            $dataD[] = [
                'mainKey' => iconv('TIS-620', 'UTF-8',$rs['mainKey']),
                'red' => iconv('TIS-620', 'UTF-8',$rs['red']),
                'justDate' => iconv('TIS-620', 'UTF-8',$rs['justDate']),    
                'just' => iconv('TIS-620', 'UTF-8',$rs['just']),         
            ];
            
        }
        // return $data;
    }else{
        echo 'ไม่มีคดีฟ้อง';
    }

    $data = [
        // 'justDate' => $dataD['justDate'],
        'count' => $count,
        'dataDD' => $dataD,
    ];
	$data = json_encode($data);
    // return $data;
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
// echo $count.'<br>';
// if(isset($data)){var_dump($data);}
if(isset($data)){$d = json_decode($data);}

function toFinish($date,$db){
$godate = 10 ;
// $date = date('Y-m-d',strtotime("2020-11-18"));
  for ($x = 1; $x <= $godate; $x++) {
    $date = date('Y-m-d',strtotime($date . "+1 days"));
    // echo "The number is: $x | ";
    // echo $date ." | ";
    // echo date("l",strtotime($date));
    // echo "<br>";

    if(SatSun($date) || ckSpecial($date,$db)){
      $x--;
    }
  }
  return $date;
}

function SatSun($date){
  $day = date("l",strtotime($date));
  if($day == 'Sunday' || $day == 'Saturday'){
    return true;
  }
  return false;
}

?>
<?php include "layout/header.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ข้อมูลจากฐาน Access ย้อนหลัง 15 วัน
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Access</li>
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
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>ลำดับ</th>
                    <th>เลขคดีดำ</th>
                    <th>เลขคดีแดง</th>
                    <th>วันที่ตัดสิน</th>                    
                    <th>ผู้พิพากษา</th>
                    <th>ต้องพิมพ์เสร็จ</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php 
                    if(count($d->dataDD) > 0 ){
                        $i = 1;
                        foreach ($d->dataDD as $rs) {
                    ?>  
                    <tr>
                        <td><a href="#"><?= $i++;?></a></td>
                        <td><?= $rs->mainKey;?></td>
                        <td><?= $rs->red;?></td>
                        <td><?=  DateThai_full_st($rs->justDate);?></td>
                        <td><?= $rs->just;?></td>
                        <?php $tofinish = toFinish($rs->justDate,$db) ?>
                        <td><?= DateThai_full_st($tofinish);?></td>
                        <td>
                        <?php
                          $sMessage = '';
                          $keymain = $rs->mainKey;
                          $select_stmt = $db->prepare("SELECT * FROM 10day WHERE keymain = :keymain LIMIT 1");
                          $select_stmt->bindParam(':keymain', $keymain);
                          $select_stmt->execute();
                          if($select_stmt->rowCount() > 0 ){
                            echo "<i class='fa fa-bell'></i>";
                          }else{
                            $insert_stmt = $db->prepare("INSERT INTO 10day(keymain, red, just, datejust, tofinish, finish) 
                            VALUES (:keymain, :red, :just, :datejust, :tofinish, :finish)");
                            $insert_stmt->bindParam(':keymain', $keymain);
                            $insert_stmt->bindParam(':red', $red);
                            $insert_stmt->bindParam(':just', $just);
                            $insert_stmt->bindParam(':datejust', $datejust);
                            $insert_stmt->bindParam(':tofinish', $tofinish);
                            $insert_stmt->bindParam(':finish', $finish);
        
                            $keymain = $rs->mainKey;
                            $red = $rs->red;
                            $just = $rs->just;
                            $datejust = $rs->justDate;
                            $tofinish = $tofinish;
                            $finish = null;
        
                            if ($insert_stmt->execute()) {
                              $sMessage .= $keymain.'->💾'."\n";
                              echo "<i class='fa fa-server'></i> <i class='fa fa-arrow-right'></i> <i class='fa fa-bell'></i>";
                            }
                            
                          }
                        ?>
                        </td>
                    </tr>
                    <?php
                          }
                      }

                      if($sMessage == ''){
                        $sMessage = 'No Update';
                      }
                      $sMessage = 'Alert10Day '.$sMessage;
                      sendLine($sToken,$sMessage);
                    ?>
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
  
