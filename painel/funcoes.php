<?php
	function datebdtobr($data){
		 return implode("/",array_reverse(explode("-",$data)));
	}
	
	function datebrtobd($data){
		 return implode("-",array_reverse(explode("/",$data)));
	}
	
	function delPasta($dir){
		$files = array_diff(scandir($dir), array('.','..')); 
	    foreach ($files as $file) { 
	      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	    } 
	    return rmdir($dir); 
	}

?>