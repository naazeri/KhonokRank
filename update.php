<?php
	function download_file($url) {
		file_put_contents("file.zip", fopen($url, 'r'));
	}

	function move_files() {
		// Get array of all source files
		$files = scandir("KhonokRank-master");
		// Identify directories
		$source = "KhonokRank-master/";
		$destination = "";
		// Cycle through all source files
		foreach ($files as $file) {
		  if (in_array($file, array(".",".."))) continue;
		  // If we copied this successfully, mark it for deletion
		  if (copy($source.$file, $destination.$file)) {
		    $delete[] = $source.$file;
		  }
		}
		
		// Delete all successfully-copied files
		foreach ($delete as $file) {
		  unlink($file);
		}
		rmdir("KhonokRank-master");
		unlink("file.zip");
	}

	
	download_file("https://github.com/rezanazeri/KhonokRank/archive/master.zip");
	$zip = new ZipArchive;
	$res = $zip->open('file.zip');
	if ($res === TRUE) {
	  $zip->extractTo('.');
	  $zip->close();
	  move_files();
	  echo 'done!';
	} else {
	  echo 'ERROR!';
	}	
?>
