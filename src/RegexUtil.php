<?php

namespace Kristianlentino\DieffetechUtils;

class RegexUtil
{

	const REGEX_VALID_DATETIME = '/^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/';
	const REGEX_SECURE_PASSWORD = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!;@$%^&*-]).{8,}$/';
	const REGEX_VALID_DATE = '/^(\d{2})\/(\d{2})\/(\d{4})$/';
	const REGEX_VALID_URL = '/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i';
	const REGEX_VALID_PHONE = '^(\+\d{12}|\d{11}|\+\d{2}-\d{3}-\d{7})$';
}