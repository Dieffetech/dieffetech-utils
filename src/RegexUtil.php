<?php

namespace Kristianlentino\DieffetechUtils;

class RegexUtil
{

	const REGEX_VALID_DATETIME = '/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/';
	const REGEX_SECURE_PASSWORD = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!;@$%^&*-]).{8,}$/';
	const REGEX_VALID_DATE_ITALIAN = '/^(\d{2})\/(\d{2})\/(\d{4})$/';
	const REGEX_VALID_DATE_AMERICAN = '/^(\d{4})\/(\d{2})\/(\d{2})$/';
	const REGEX_VALID_URL = '/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i';
	const REGEX_ONLY_LETTERS = '/^[a-zA-Z]+$/';
	const REGEX_ONLY_NUMBERS = '/^[0-9]+$/';

	public static function matchItalianDate(string $date)
	{
		return preg_match(self::REGEX_VALID_DATE_ITALIAN,$date);
	}
	public static function matchAmericanDate(string $date)
	{
		return preg_match(self::REGEX_VALID_DATE_AMERICAN,$date);
	}
}