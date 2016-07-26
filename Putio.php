<?php
require 'PutIO/Autoloader.php';
$putio = new PutIO\API(getenv('PUTIO_KEY'));
$root = "download";
$df = disk_free_space("/");
$df = $df - 1000000000;

// Retrieve a an array of files on your account.
$files = $putio->files->listall();

function downloadFile($id, $dest, $size){
	global $putio, $df;
	if(!file_exists($dest) && $size < $df) {
		echo "\n".$id." ".$dest."\n";
		$putio->files->download($id, $dest);
	}else if($size > $df){
		echo "\nSize:".$size." Disk:".$df."\n";
	}
}
function downloadDir($parentId=0, $parent=""){
	global $putio, $root;
	$files = $putio->files->listall($parentId);
	foreach($files as $file){
		$name = $file['name'];
		if($file['content_type'] == "application/x-directory"){
			$dir=$root.'/'.$parent.$name;
			if(!is_dir($dir)){
				echo "\nmkdir |".$dir."|\n";
				mkdir($dir);
			}
			downloadDir($file['id'], $parent.$name.'/');
		}else{
			downloadFile($file['id'], $root."/".$parent.$name, $file['size']);
		}
	}
}

downloadDir();

##Clean directory if nothing to DL
echo count($files)." fichiers \n";
if(count($files) == "0"){
	shell_exec('rm -rf '.$root.'/*');
}
?>