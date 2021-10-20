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
}