<?php

namespace Kristianlentino\DieffetechUtils;

use yii\base\Exception;

class SecurityUtil
{

	public static function encryptByKey(string $stringToEncrypt)
	{
		if(empty(\Yii::$app->params['SECURE_TOKEN'])){
			throw new Exception("E' necessario impostare il params SECURE_TOKEN");
		}
		$crypt = openssl_encrypt($stringToEncrypt,"AES-128-ECB",\Yii::$app->params['SECURE_TOKEN']);
		return base64_encode($crypt);
	}

	public static function decryptString($stringToDecrypt)
	{
		if(empty(\Yii::$app->params['SECURE_TOKEN'])){
			throw new Exception("E' necessario impostare il params SECURE_TOKEN");
		}
		$decrypt = openssl_decrypt(base64_decode($stringToDecrypt),"AES-128-ECB",\Yii::$app->params['SECURE_TOKEN']);
		return $decrypt;
	}

}