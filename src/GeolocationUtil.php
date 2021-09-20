<?php

namespace Kristianlentino\DieffetechUtils;

use yii\base\Exception;

class GeolocationUtil
{

	public static function prepareAddress(&$address)
	{
		$address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern
	}

	public static function getCoordinates($address){

		if(empty($address))
			return null;

		self::prepareAddress($address);

		if(empty(\Yii::$app->params['GOOGLE_KEY'])){
			throw new Exception("Devi settare la chiave GOOGLE_KEY");
		}

		$url = self::getBaseUrl()."json?sensor=false&address=$address&key=".\Yii::$app->params['GOOGLE_KEY'];

		$response = file_get_contents($url);


		$json = json_decode($response,TRUE); //generate array object from the response from the web
		$coordinate=array();
		if(!empty($json['results'])) {

			$coordinate[] = $json['results'][0]['geometry']['location']['lat'];
			$coordinate[] = $json['results'][0]['geometry']['location']['lng'];
		}


		return ($coordinate);

	}
}