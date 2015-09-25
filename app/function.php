<?php

/**
 * @author DjJustin
 * @copyright 2015
 */

function computer_name(){
	   $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
	  		// if(substr_count($host, ".")==3){
	   	return strstr($host,'.',true);
	  		// } else {
	 		 // 		return $host;
			 //  }
	    

}

?>