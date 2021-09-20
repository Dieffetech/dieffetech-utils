<?php

namespace Kristianlentino\DieffetechUtils;

class GoogleRecaptchaUtil
{

	/**
	 * controlla se il captcha di google è valido
	 * @param string $secret_key
	 * @return false
	 */
	public static function validateCaptcha(string $secret_key): bool
	{
		if(!empty($_POST['g-recaptcha-response'])){
			$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
			$responseDecoded = json_decode($response);

			return $responseDecoded->success;
		}

		return false;
	}
}