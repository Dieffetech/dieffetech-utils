<?php


namespace Kristianlentino\DieffetechUtils;

use yii\base\Exception;

class ConsoleUtil
{

	public static function runCron(string $action ,array $params = [])
	{

		$yii = \Yii::getAlias('@app')."/../yii";

		if(empty(\Yii::$app->params['CRONTAB_PHP'])){
			throw new Exception("Devi settare il comando CRONTAB_PHP nei params");
		}

		$phpCommand = \Yii::$app->params['CRONTAB_PHP']??'php';
		$command = "$phpCommand $yii $action ";

		foreach ($params as $value){
			$command .= "$value ";
		}

		exec($command." > /dev/null &");
	}
}