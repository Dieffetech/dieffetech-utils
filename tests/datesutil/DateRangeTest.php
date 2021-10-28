<?php

use Kristianlentino\DieffetechUtils\DatesUtil;
use yii\helpers\Console;

class DateRangeTest extends \PHPUnit\Framework\TestCase
{

	public function testFirstParameterSet()
	{
		$dateStart = '2021-09-10';
		$dateEnd = '2021-09-18';
		$datesInRange = DatesUtil::getDatesInRange($dateStart,$dateEnd);
		$this->assertIsArray($datesInRange);
	}

	public function testFirstParameterEmpty()
	{
		$dateEnd = '2021-09-10';
		$datesInRange = DatesUtil::getDatesInRange(null,$dateEnd);
		$this->assertIsArray($datesInRange);
	}
	public function testSecondParameterEmpty()
	{
		$dateStart = '2021-09-10';
		$this->expectException(\yii\base\InvalidArgumentException::class);
		$datesInRange = DatesUtil::getDatesInRange($dateStart);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testDateStartAsInvalidDate()
	{
		$dateStart = '2021-09-42';
		$this->expectException(\yii\base\InvalidArgumentException::class);
		$datesInRange = DatesUtil::getDatesInRange($dateStart);
	}
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testDateEndAsInvalidDate()
	{

		$dateEnd = '2021-09-42';
		$this->expectException(\yii\base\InvalidArgumentException::class);
		$datesInRange = DatesUtil::getDatesInRange(null,$dateEnd);
	}

}