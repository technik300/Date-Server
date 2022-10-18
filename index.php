<?php
   define('__ERLOG','err.log'); // контстанта __ERLOG определяет название файла для записи своих `несистемных`ошибок, используется в  lib.php
   date_default_timezone_set('UTC'); // установка зоны по Гринвичу
   $today = date("d-m-Y"); // в переменной $today текущая дата в формате 00-00-0000
   include('lib.php'); // в этом месте подключается библиотека функций lib.php
   if(!is_file('timеstamp.txt')){  // если в текущей папке нет такого файла 'timеstamp.txt'
       file_put_contents('timеstamp.txt',$today); // то создать его и записать значение $today (текущая дата)
   }

   function validation($date){   // функция валидации даты по формату 00-00-0000
      $date_arr = explode('-',$date); // разбиваем строку даты в массив тпо разделителю `-`
      if(count($date_arr) !== 3) return false; // если в полученном массиве не 3 элемента - не валидно
      if(mb_strlen($date_arr[0])!== 2 || !is_numeric($date_arr[0]) || $date_arr[0] > 31 || $date_arr[0] < 1) return false; // если дата не двузначна или есть не только цифры или болььше 31 или меньше 1 - не валидно 
      if(mb_strlen($date_arr[1])!== 2 || !is_numeric($date_arr[1]) || $date_arr[1] > 12 || $date_arr[1] < 1) return false; // если месяц не двузначный или есть не только цифры или болььше 12 или меньше 1 - не валидно
      //if(mb_strlen($date_arr[2])!== 4 || !is_numeric($date_arr[2]) || $date_arr[2] < date("Y")) return false; - пока отменили валидацию года
   }

	if(isset($_SERVER) && isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'get')){
       /*если существует переменная $_SERVER и установлен тип запроса и тип запроса GET или get то,  */
      if(isset($_GET['date'])){ //если в массиве $_GET есть элемент date
         $_date = trim($_GET['date']);  // в переменной очищеный от пробельных символов элемент $_GET['date']      
         if($_date == ''){ // если пришла пустая строка (?date=)
            echo file_get_contents('timеstamp.txt'); // возврвщаем содержимое файла 'timеstamp.txt' - запрос времени 'get'
         }else{           // иначе
            if(validation($_date) !== false){ // если валидна дата в $_date = $_GET['date']
               file_put_contents('timеstamp.txt',$_date); // то перезапишем значение в файл 'timеstamp.txt'
            }else{              // если не валидна 
               echo 'request error';  // вернем текст ошибки
            }            
         }
      }else{  //если в массиве $_GET НЕТ элемента date (считаем, что страницу открыли браузером)
         include('body.php');  // подключаем веб-морду
      }
	}else{ // если запрос не GET 
      die(); // - умираем
   }
?>
