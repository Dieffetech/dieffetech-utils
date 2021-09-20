<?php

namespace Kristianlentino\DieffetechUtils;

class FileUtil
{

	public static function deleteDirectory($dir) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? deleteDirectory("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	}
}