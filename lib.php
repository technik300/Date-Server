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
function _err( $str=null ) { file_put_contents( __DIR__.'/'.__ERLOG, $str."\n", $str===null?0:FILE_APPEND ); }
?>
