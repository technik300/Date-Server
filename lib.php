<?php

setlocale( LC_ALL, 'en_US.UTF-8' ); 
ini_set( 'display_errors', 1 ); 
ini_set( 'display_startup_errors', 1 ); 
ini_set( 'log_errors', 1 ); 
ini_set( 'error_log', __DIR__.'/php_errors.log' );
ini_set('max_execution_time', '300000000');
set_time_limit(0);
file_put_contents(__DIR__.'/TEST_.TXT','');
  function _test($raw, $name='', $flag=1){
	if($flag!==1){
		file_put_contents(__DIR__.'/TEST_.TXT','');
	}
	file_put_contents(__DIR__.'/TEST_.TXT',"$name ---".var_export($raw,1)."\n",FILE_APPEND);
} 
// GET -запрос к серверу
$curl_error = ''; 
// POST -запрос к серверу
function web_post( $url, $arg, $sleep=0, $timeout=600 ) { 
	global $curl_error,$curl_cookie; 
	echo " $url\n"; 
	if( $sleep>0 ) sleep( $sleep ); 
	$ch = curl_init();
	$copt = [ 
		CURLOPT_URL=>$url, 
		CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
		CURLOPT_COOKIE=>$curl_cookie,
		CURLOPT_POST=>1, 
		CURLOPT_POSTFIELDS=>$arg,
		CURLOPT_COOKIESESSION=>1, 
		CURLOPT_SSL_VERIFYHOST=>0, 
		CURLOPT_SSL_VERIFYPEER=>0, 
		CURLOPT_VERBOSE=>0,
		CURLOPT_FOLLOWLOCATION=>1, 
		CURLOPT_UNRESTRICTED_AUTH=>1,
		CURLOPT_FAILONERROR=>1, 
		CURLOPT_AUTOREFERER=>1, 
		CURLOPT_TIMEOUT=>$timeout, 
		CURLOPT_CONNECTTIMEOUT=>$timeout, 
		CURLOPT_RETURNTRANSFER=>1 
	];
	curl_setopt_array($ch,$copt); 
	if(false===($data=curl_exec($ch)))$curl_error=curl_error($ch);
	curl_close($ch);return $data; 
}
function web_url( $url, $sleep=0, $timeout=600,$ua ) { 
	global $curl_error,$curl_cookie;// echo " $ua\n";
	if( $sleep>0 ) sleep( $sleep ); 
	$ch = curl_init();
	$copt = [ 
		CURLOPT_URL=>$url, 
		CURLOPT_USERAGENT=>$ua,
		CURLOPT_COOKIE=>$curl_cookie,
		CURLOPT_COOKIESESSION=>1, 
		CURLOPT_SSL_VERIFYHOST=>0, 
		CURLOPT_SSL_VERIFYPEER=>0, 
		CURLOPT_VERBOSE=>0, 
		CURLOPT_FOLLOWLOCATION=>1, 
		CURLOPT_UNRESTRICTED_AUTH=>1,
		CURLOPT_FAILONERROR=>1, 
		CURLOPT_AUTOREFERER=>1, 
		CURLOPT_TIMEOUT=>$timeout, 
		CURLOPT_CONNECTTIMEOUT=>600, 
		CURLOPT_RETURNTRANSFER=>1,
		CURLOPT_COOKIEJAR=> dirname(__FILE__) . '/cookie.txt',
		CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt' 
	];
	curl_setopt_array($ch,$copt); 
	if(false===($data=curl_exec($ch))) $curl_error=curl_error($ch); 
	curl_close($ch);
	return $data; 
}
// дополнительные функции
function _err( $str=null ) { file_put_contents( __DIR__.'/'.__ERLOG, $str."\n", $str===null?0:FILE_APPEND ); }
function _flt( $str ) { $str = preg_replace( [ "/[\r\n\t]+/ui", '/ +/ui' ], [ ' ', ' ' ], $str ); return trim( html_entity_decode( strip_tags( $str ) ) ); }
function _xls( $str, $tab = "\t" ) { if( ( $str = trim($str) ) == '' ) return $tab; return $tab . '"' . preg_replace( '/"/ui', '""', $str ) . '"'; }
define( '_CCH_PATH', __DIR__.'/.cache/' ); 
$_cchopt = [ null, null ];
function _cch( $site, $ttl = 86400 ) { 
	global $_cchopt; 
	if( ( $site = trim($site).'' ) == '' ) return; 
	$_cchopt = [ _CCH_PATH.$site, $ttl ]; 
	if(!is_dir($_cchopt[0])) mkdir($_cchopt[0],0777,true); 
}
// get
function _get($url, $cache=null, $sleep=0 ) {
	$ua='Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36';
	//echo " $ua\n";
	global $_cchopt, $curl_error; 
	$cf = $_cchopt[0] . '/' . ( $ccid=(sha1($url).'_'.strlen($url)) );
	if( ($cache && $cache!==0) && !empty( $_cchopt[0] ) ) { 
		if( file_exists($cf) && filesize($cf)>0 ) {
			if( $_cchopt[1]>0 && time()<(filemtime($cf)+$_cchopt[1]) ) {
				return file_get_contents($cf);
			} 
		} 
	} 
	$data = web_url($url,$sleep,600,$ua);
	if( $data === false ) _err( $curl_error . ' -- ' . $url); 
	elseif( $cache ) file_put_contents( $cf, $data );
	return $data; 
}

// добавление характеристики в массив характеристик
$_char = $_keys = [];
function add_char( $h, $v ) { 
	global $_char, $_keys; 
	$id = null;
	$h = preg_replace( '/ +/u', ' ', $h );
	$k = preg_replace( '/[^0-9a-zа-яё]/u', '', mb_strtolower( $h ) );
	foreach( $_keys as $i => $d ) { 
		if( $d[0] == $k ) { 
			$id = $i; break; 
		} 
	}
	if( $id === null ) { 
		$id = count($_keys); 
		$_keys[] = [ $k, $h ]; 
	}
	$_char[ $id ] = str_replace( ' Узнать о типах ламп', '', _flt( $v ) ); }

/*$_char = $_keys = [];*/  ///////!!!
function add_cmp( $h, $v ) { 
	global $_char, $_keys; $id = null;
	$h = preg_replace( '/ +/u',' ', $h );                                  //меняем много пробелов на два
	$k = preg_replace( '/[^0-9a-zа-яё]/u', '', mb_strtolower( $h ) );     //убираем из названия все кроме букв и цифр
	foreach( $_keys as $i => $d ) {                                      // пребор массива ключей   i - номер d - значение(название характеристики)
		if( $d[0] == $k ) {                                           // если первый элемент равен текущему названию
			 $id = $i; break;                                     // то id запоминает номер ключа   и конец цикла
		}                                                             
	}
	if( $id === null ) {                                                   // если id не уствновлен
		 $id = count($_keys); $_keys[] = [ $k, $h ];                    // то id - количество ключей, в массив ключей добавляем новое значение
	}
	$_char[ $id ] = str_replace( ' Узнать о типах ламп', '', _flt( $v ) );  //  добавляем в массив характеристик по ключу значение
 } 

// запись массива спарсенных характеристик в файл
function put_char( $file, $f = true ) { 
	global $_char, $_keys; 
	$sz = count( $_keys ); 
	$str = "";
	for( $i=0; $i<$sz; ++$i ) $str .= _xls( $f?($_char[$i]??''):($_keys[$i][1]??''), ($i?"\t":'') );
   file_put_contents( $file, $str . "\n", FILE_APPEND );
	foreach( $_char as $i=>$v ) unset( $_char[$i] ); $_char = []; 
}

function _fname( $fname, $type = 'noext' ) {
	$p = pathinfo( str_replace( '"', '', $fname ) );
	$f = rtrim( $p['filename'], " \t\n\r\0\x0B." );
	$c = strtolower( substr( $f, -4 ) );
	$e = trim( $p['extension'] );
	switch( $e = strtolower( $e ?: $type ) ) {
		case 'rar': case '7z': case 'tgz': case 'txz': case 'tbz': case 'tbz2': case 'zip': $t = 1; break;
		case 'xls': case 'xlsx': $t = 2; break;
		case 'doc': case 'docx': $t = 3; break;
		case 'pdf': $t = 4; break;
		case 'gz': case 'xz': case 'bz': case 'bz2':
			if( $c == '.tar' ) { $e = 'tar.'.$e; $f = rtrim( substr( $f, 0 -4 ), " \t\n\r\0\x0B." ); }
			$t = 1; break;
		default: $t = 0;
	}
	return [($f?:'noname').'.'.$e, $e ];
}

function _f1( $str ){ 
	return mb_convert_encoding( $str.'', 'UTF-8', 'CP1251' ); 
}

function _flta($ar,$str){
               $str=str_replace($ar,'',$str);
               for($xn=-1;$xn++<20;){
               $str=str_replace('#@@'.$xn,'',str_replace('#@@'.$xn.' ','',str_replace(' #@@'.$xn,'',$str)));
               }
               return $str;
}           
function scan_Dir($dir) {
	$result = [];
	foreach(scandir($dir) as $filename) {
   //_test("\t\t".$filename);
   if ($filename[0] === '.') continue;
   $filePath = $dir . '/' . $filename;
   if (is_dir($filePath)) {
      		   foreach (scan_Dir($filePath) as $childFilename) {
      		      if(mb_strpos($childFilename,'.php')!==false){
        				    $result[] = $filename . '/' . $childFilename;
					   }
      		   }
    		   } else {
				   if(mb_strpos($filename,'.php')!==false){
      			   $result[] = $filename;
				   }
			   }
		  }  //_test($result,'scan_Dir');   //!!! 
	     return $result;
   }

?>