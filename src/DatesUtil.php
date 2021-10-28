<?php


namespace Kristianlentino\DieffetechUtils;

use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\validators\DateValidator;

class DatesUtil
{

	/**
	 * @param $date
	 * @param string $format
	 * @return bool
	 * check if a given date in a given format is valid
	 */
	public static function validateDate($date, $format = 'Y-m-d'): bool
	{
		$d = \DateTime::createFromFormat($format,$date);
		return !empty($d) && $d->format($format) === $date;
	}
	/**
	 * @param string $dateFromString
	 * @param string|null $dateToString
	 * @param string|null $dayName
	 * @param bool|bool $startNextWeek
	 * @param string|string $format
	 * @return array
	 * @throws \Exception
	 */
	public static function getDatesInRange(?string $dateFromString = null, ?string $dateToString=null,string $format='Y-m-d')
	{


		if(empty($dateFromString)){
			$dateFromString = date('Y-m-d');
		}

		if(!self::validateDate($dateFromString)){
			throw new InvalidArgumentException("dateFromString not valid: $dateFromString");
		}
		if(!self::validateDate($dateToString)){
			throw new InvalidArgumentException("dateToString not valid: $dateToString");
		}

		$dateFromString= self::convertDateToSql($dateFromString);
		if(!empty($dateToString)){
			$dateToString= self::convertDateToSql($dateToString);
			$dateTo = new \DateTime($dateToString);
		}
		$dateFrom = new \DateTime($dateFromString);

		$dates = [];

		//aggiungo un giorno così che recupera anche quello
		if(!empty($dateToString)){
			$to = $dateTo->modify( '+1 day' );
			$interval = new \DateInterval('P1D');
			$period= new \DatePeriod($dateFrom,$interval,$to);

			foreach($period as $date){
				$dates[]= $date->format($format);
			}
		} else {
			$dates[]= $dateFrom->format($format);
		}


		return $dates;
	}


	/**
	 * converte una data in formato americano in formato italiano
	 * @param $date
	 * @return false|string
	 */
	public static function convertDate($date){

		if(empty($date)){
			return "";
		}

		if(!self::validateDate($date,'Y-m-d')){

			if(
				!(RegexUtil::matchItaliandate($date) || RegexUtil::matchAmericandate($date))
			){

				$date = false;
			} else {

				if(RegexUtil::matchItalianDate($date)){
					return $date;
				};
				$date = self::convertToFormat($date,'Y-m-d');
			}

			if($date === false){
				return false;
			}
		}

		return date("d/m/Y",strtotime($date));
	}

	/**
	 * converte una data in formato americano in formato americano
	 * @param $data
	 * @return false|string
	 */
	public static function convertDateToSql($data){

		if(empty($data)){
			return "";
		}

		if (preg_match("^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$^",$data)){
			//se è già nel formato americano torno la data
			return $data;
		}

		$date = str_replace("/", "-", $data);
		return date("Y-m-d",strtotime($date));
	}

	/**
	 * @param $date
	 * @return false|string
	 */
	public static function convertDateTime($date){
		if(empty($date)){
			return "";
		}

		return date("d/m/Y H:i",strtotime($date));
	}

	/**
	 * @param $data
	 * @return false|string
	 */
	public static function convertDateTimeToSql($data){

		if(empty($data)){
			return "";
		}

		$date = str_replace("/", "-", $data);
		return date("Y-m-d H:i:s",strtotime($date));
	}

	/**
	 * @param $day
	 * @param false $timestamp
	 * @param string|string $format
	 * @return false|int|string
	 */
	public static function getDayOfThisWeek($day, $timestamp = false, string $format = 'Y-m-d')
	{
		return $timestamp ? strtotime("{$day} this week") : date($format,strtotime("{$day} this week"));

	}

	/**
	 * permette di rimuovere o aggiungere giorni,mesi e anni ad una data
	 * @param string|null $date
	 * @param string|string $format
	 * @param array $params
	 * @return false|string
	 */
	public static function addRemoveToDate(array $params,string $date = null , string $format= 'Y-m-d')
	{
		if(empty($date)){

			$date = date($format);
		}

		$addRemoveString = '';
		foreach ($params as $k =>  $param) {

			if(!isset($param['operation'])){
				$param['operation'] = '+';
			}
			$addRemoveString = $param['operation'].$param['value'].' '.$k;

		}


		return date($format,strtotime($addRemoveString,strtotime($date)));


	}
	/**
	 * torna l'ultimo giorno del mese dell'anno passato (se vuoto di quello corrente)
	 * @param string $month
	 * @param null $year
	 * @return \DateTime
	 */
	public static function getLastDayOfMonth(string $month, $year = null)
	{
		if(empty($year)){

			$year = date('Y');

		}

		$endDate = new \DateTime("last day of {$year}-{$month}");


		return $endDate;
	}
	/**
	 * torna un oggetto DateInterval,entrambe devono essere in formato Y-m-d
	 * @param string $dateEnd data maggiore tra le due
	 * @param string $dateStart data minore tra le due
	 * @return \DateInterval
	 * @link https://php.net/manual/en/function.date-diff.php
	 *
	 * @return \DateInterval
	 */
	public static function dateDiff(string $dateStart,string $dateEnd)
	{
		$dateTimeStart = new \DateTime($dateStart);
		$dateTimeEnd = new \DateTime($dateEnd);

		return date_diff($dateTimeEnd,$dateTimeStart);
	}

	/* ritorna il mese prossimo  */
	public static function getNextMonth()
	{
		return date('m',strtotime('first day of +1 month'));
	}

	/**
	 * @param $date
	 * @param string $format
	 * @return string
	 * @throws InvalidArgumentException
	 * Cast a date in a specific date format
	 */
	private static function convertToFormat($date, string $format): string
	{

		try {
			$date = new \DateTime($date);
		} catch (\Exception $e) {
			return false;
		}

		return $date->format($format);
	}
}