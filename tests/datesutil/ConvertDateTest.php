<?php

use Kristianlentino\DieffetechUtils\DatesUtil;
use yii\helpers\Console;

class ConvertDateTest extends \PHPUnit\Framework\TestCase
{
	const ITALIAN_FORMAT = 'd/m/Y';

	/**
	* @dataProvider getTestCases	
	 */
	public function testConvertDate($testCase,$shouldBeValid)
	{

		$dateInItalianFormat = DatesUtil::convertDate($testCase['date']);
		$this->assertSame(
			$shouldBeValid,
			DatesUtil::validateDate($dateInItalianFormat,self::ITALIAN_FORMAT)
		);

		return Console::output($dateInItalianFormat);
	}

	public function getTestCases(): array
	{
		return [
			[
				[
					'date' => date('Y-m-d'),
				],
				true
			],
			[
				[
					'date' => date('d/m/Y'),
				],
				true
			],
		];
	}


	/**
	 * @dataProvider getTestCasesExceptions
	 * @expectedException \yii\base\InvalidArgumentException
	 */
	public function testInvalidFormatsOfDates($testCase)
	{

		$dateInItalianFormat = DatesUtil::convertDate($testCase['date']);
		$this->assertSame(false,$dateInItalianFormat);
	}

	public function getTestCasesExceptions(): array
	{
		return [
			[
				[
					'date' => 'this-isnot-adate',
				],
			],
			[
				[
					'date' => '201111-323-44',
				],
			],
			[
				[
					'date' => '2021-2-20',
				],
			],
			[
				[
					'date' => '2021-12-2',
				],
			],
			[
				[
					'date' => '21-02-20',
				],
			],
			[
				[
					'date' => '2021-02-40',
				],
			],
			[
				[
					'date' => '2021-09-31',
				],
			],
		];
	}


}