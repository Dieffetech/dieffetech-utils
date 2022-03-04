<?php

namespace Kristianlentino\DieffetechUtils;

class ImageUtil
{
	public static function calculateAspectRatio(int $width, int $height,bool $returnAsString = false): string
	{
		// search for greatest common divisor
		$greatestCommonDivisor = static function($width, $height) use (&$greatestCommonDivisor) {
			return ($width % $height) ? $greatestCommonDivisor($height, $width % $height) : $height;
		};

		$divisor = $greatestCommonDivisor($width, $height);
		$left = $width / $divisor;
		$right = $height / $divisor;

		if(!$returnAsString){
			return $left / $right;
		}

		return $left.':'. $right;

	}
	public static function compressImage(int $quality,string $imagePath,string $destinationPath)
	{
		$img = new \Imagick($imagePath);
		$size = $img->getImageLength();
		$sizeInMb = round($size / pow(10,6),2);

		if($sizeInMb >= 0.5){

			/*$savedPath = ImageUtil::compress($imagePath,$baseFolder.'/'.$folder."/reduced_$index.jpeg",80);*/

			$orientation = $img->getImageOrientation();

			switch($orientation) {
				case \Imagick::ORIENTATION_BOTTOMRIGHT:
					$img->rotateimage("#000", 180); // rotate 180 degrees
					break;

				case \Imagick::ORIENTATION_RIGHTTOP:
					$img->rotateimage("#000", 90); // rotate 90 degrees CW
					break;

				case \Imagick::ORIENTATION_LEFTBOTTOM:
					$img->rotateimage("#000", -90); // rotate 90 degrees CCW
					break;
			}


			// Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
			$img->setImageCompression(\Imagick::COMPRESSION_JPEG);
			$img->setImageCompressionQuality($quality);
			$img->setImageBackgroundColor('#ffffff');
			$img->stripImage();
			$img->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
			$img = $img->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
			$img->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
			return [
				'success' => $img->writeImage($destinationPath)
			];
		}
	}
}