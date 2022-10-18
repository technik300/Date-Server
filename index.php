<?php
   define('__ERLOG','err.log');
   date_default_timezone_set('UTC');
   $today = date("d-m-Y");
   include('lib.php');
   if(!is_file('timеstamp.txt')){
       file_put_contents('timеstamp.txt',$today);
   }

   function validation($date){
      $date_arr = explode('-',$date);
      if(count($date_arr) !== 3) return false;
      if(mb_strlen($date_arr[0])!== 2 || !is_numeric($date_arr[0]) || $date_arr[0] > 31 || $date_arr[0] < 1) return false;
      if(mb_strlen($date_arr[1])!== 2 || !is_numeric($date_arr[1]) || $date_arr[1] > 12 || $date_arr[1] < 1) return false;
      if(mb_strlen($date_arr[2])!== 4 || !is_numeric($date_arr[2]) || $date_arr[2] < date("Y")) return false;
   }

	if(isset($_SERVER) && isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'get')){
      if(isset($_GET['date'])){
         $_date = trim($_GET['date']);        
         if($_date == ''){
            echo file_get_contents('timеstamp.txt');
         }else{           
            if(validation($_date) !== false){
               file_put_contents('timеstamp.txt',$_date);
            }else{              
               echo 'request error';
            }            
         }
      }else{
         include('body.php');
      }
	}else{
      die();
   }
?>