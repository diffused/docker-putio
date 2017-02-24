<?php
require 'PutIO/Autoloader.php';
$putio = new PutIO\API(getenv('PUTIO_KEY'));
$root = "download";
$df = disk_free_space("/");
$df = $df - 1000000000;
$putio_root_directory = getenv('PUTIO_ROOT_DIR');
if (!$putio_root_directory) {
	$putio_root_directory = "";
}
$clean=true;

// Retrieve a an array of files on your account.
$files = $putio->files->listall();

function startsWith($haystack, $needle){
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}
	return (substr($haystack, 0, $length) === $needle);
}

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
	global $putio, $root, $putio_root_directory;
	$files = $putio->files->listall($parentId);
	foreach($files as $file){
		$name = $file['name'];
		if($file['content_type'] == "application/x-directory" && startsWith($name, $putio_root_directory)){
			$dir=$root.'/'.$parent.$name;
			if(!is_dir($dir)){
				echo "\nmkdir |".$dir."|\n";
				mkdir($dir);
			}
			downloadDir($file['id'], $parent.$name.'/');
		}else if ($file['content_type'] != "application/x-directory"){
			downloadFile($file['id'], $root."/".$parent.$name, $file['size']);
			$clean=false;
		}
	}
}

downloadDir();

##Clean directory if nothing to DL
if($clean){
	shell_exec('rm -rf '.$root.'/'.$putio_root_directory.'/*');
}
?>
