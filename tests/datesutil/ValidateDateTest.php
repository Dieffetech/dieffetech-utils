<?php

use Kristianlentino\DieffetechUtils\DatesUtil;
use yii\helpers\Console;

class ValidateDateTest extends \PHPUnit\Framework\TestCase
{

	/**
	 * @dataProvider provider
	 */
	public function testIsValidDate($datesToCheck,bool $expectedValue)
	{

		$this->assertSame($expectedValue,DatesUtil::validateDate($datesToCheck['date'],$datesToCheck['format']));
	}

	public function provider()
	{
		return array(
			[
				[
					'format' => 'Y-m-d' ,
					'date' =>  date('Y-m-d')
				],
				true
			],
			[
				[
					'format' => 'd/M/Y',
					'date' => date('d/M/Y')
				],
				true
			],
			[
				[
					'format' => 'd/m/Y',
					'date' => date('d/m/Y')
				],
				true
			],
			[
				[
					'format' => 'D/M/Y',
					'date' => date('D/M/Y')
				],
				true
			],
			[
				[
					'format' => 'd/M/y',
					'date' => date('d/M/y')
				],
				true
			],
			[
				[
					'format' => 'd/m/y',
					'date' => date('d/m/y')
				],
				true
			],
			[
				[
					'format' => 'D/m/y',
					'date' => date('D/m/y')
				],
				true
			],
			[
				[
					'format' => 'D/M/y',
					'date' => date('D/M/y')
				],
				true
			],
			[
				[
					'format' => 'D/m/Y',
					'date' => date('D/m/Y')
				],
				true
			],
			[
				[
					'format' => 'D/m/Y',
					'date' => date('Y-m-d')
				],
				false
			],
			[
				[
					'format' => 'this-is-just85-atets',
					'date' => date('Y-m-d')
				],
				false
			],
		);
	}



}