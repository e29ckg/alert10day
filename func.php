<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
    // $sToken = "shN6OBCI8wdSaIA8pNrONpgfuooZte8HLCCgLtzvsaa";
	// $sMessage = "มีรายการสั่งซื้อเข้าจ้า....".date("Y-m-d h:i:s");
    // sendLine($sToken,$sMessage);

    function sendLine($sToken,$sMessage){
        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec( $chOne ); 
    
        //Result error 
        if(curl_error($chOne)) 
        { 
            echo 'error:' . curl_error($chOne); 
            $res = ['error' => curl_error($chOne) ];
        } 
        else { 
            $result_ = json_decode($result, true); 
            echo "status : ".$result_['status']; echo "message : ". $result_['message'];
            $res = ['ok' => $result_ ];
        } 
        curl_close( $chOne );   
        return $res;
    }

//Full Date
    function DateThai_full($strDate){
        if($strDate == ''){
            return "-";
        }
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear"; //format date
    }

    function DateThai_full_st($strDate){
        if($strDate == ''){
            return "-";
        }
        $strYear = date("y",strtotime($strDate))+43;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
        $strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai$strYear"; //format date
    }

    //Short Date
    function DateThai_short($strDate){
      if($strDate == ''){
          return "-";
      }
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("j",strtotime($strDate));
      $strHour= date("H",strtotime($strDate));
      $strMinute= date("i",strtotime($strDate));
      $strSeconds= date("s",strtotime($strDate));
      $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strYear-$strMonthThai-$strDay"; //format date
    }

    //Date
    function Date_short($strDate){
        if($strDate == ''){
            return "-";
        }
        $strYear = date("Y",strtotime($strDate))-543;
        $strMonth= date("m",strtotime($strDate));
        $strDay= date("d",strtotime($strDate));
        /*$strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
        $strMonthThai=$strMonthCut[$strMonth];*/
        return "$strYear-$strMonth-$strDay"; //format date
      }
?>