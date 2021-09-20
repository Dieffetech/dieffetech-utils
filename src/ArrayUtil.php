<?php
namespace Kristianlentino\DieffetechUtils;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class ArrayUtil
{
	/**
	 *
	 * funzione per comporre una query che ritorni dati per le select2
	 * type_return: 0: select2 normale,1: depDrop,2: Select2 ajax
	 * $whereCondition: array con 2 chiavi: ['condition'=>condizione, 'params'=>'valori su qui eseguire la where']
	 * $joinCondition: array con 4 chiavi: ['type'=> 'inner,left o right' ,'table'=>nome tabella su cui andare in join, 'join_clause'=>'Condizione della join','params'=>'parametri della join'] esempio : ['table'=>'courses','join_clause'=>'courses.id=lessons.courseidfk']
	 * model: da passare con get_class()
	 * keyName: nome della primary key
	 * textName: nome del campo di testo, esempio titolo
	 * selected: un array dove passare gli id degli elementi da selezionare nella select
	 * disabled: un array dove passare gli id degli elementi da settare a disabled
	 * printRawSql: stampa a schermo la query
	 *
	 * @return array;
	 */
	public static function getArrayForSelect(
		$model,
		$fieldsToSelect=[],
		$whereCondition=[],
		$joinCondition=[],
		$keyName=null,
		$textName='',
		$type_return= 0,
		$orderBy=null,
		$distinct=false,
		$selected=array(),
		$disabled=array(),
		$printRawSql=false
	){


		if(!empty($model)){
			$models= $model::find();
		} else {

			return [];
		}
		/* @var $models  ActiveRecord */
		if(!empty($fieldsToSelect)){
			$models->select($fieldsToSelect);
		}

		if(!empty($whereCondition)){
			foreach ($whereCondition as $where){
				$models->andWhere($where['condition'],$where['params']??null);
			}
		}
		if(!empty($joinCondition)){
			foreach ($joinCondition as $join){
				switch ($join['type']) {
					case 'inner':
						$models->innerJoin($join['table'],$join['join_clause'],$join['params']??null);
						break;
					case 'left':
						$models->leftJoin($join['table'],$join['join_clause'],$join['params']??null);
						break;
					case 'right':
						$models->rightJoin($join['table'],$join['join_clause'],$join['params']??null);
						break;
					default:
						$models->innerJoin($join['table'],$join['join_clause'],$join['params']??null);
						break;
				}
			}
		}
		if(!empty($orderBy)){
			if(is_array($orderBy)){
				$models->orderBy(implode(',', $orderBy));
			} else {
				$models->orderBy($orderBy);
			}
		}
		if($distinct){
			$models->distinct(true);
		}

		if($printRawSql){

			echo '<pre>';
			print_r($models->createCommand()->getRawSql());
			exit();

		}

		$models=$models->all();

		$models= ArrayHelper::toArray($models);
		$return=array();

		if($type_return == 0){
			foreach ($models as $model){

				$return[$model[$keyName??'id']]= $model[$textName??'name'];
			}
		}else if($type_return == 1){
			foreach ($models as $model){
				$selectedCondition=false;
				if(!empty($selected)){
					if(in_array($model[$keyName??'id'], $selected)){
						$selectedCondition=true;
					}
				}
				$disableCondition=false;
				if(!empty($disabled)){
					if(in_array($model[$keyName??'id'], $disabled)){
						$disableCondition=true;
					}
				}
				$return[] = [
					"id" => $model[$keyName??'id'],
					"name" => $model[$textName??'name'],
					'selected'=>$selectedCondition,
					'disabled'=>$disableCondition
				];
			}
		}else{
			$return[] = [
				"id" => '',
				"text" => '',
			];
			foreach ($models as $model){

				$selectedCondition=false;
				if(!empty($selected)){
					if(in_array($model[$keyName??'id'], $selected)){
						$selectedCondition=true;
					}
				}

				$disableCondition=false;
				if(!empty($disabled)){
					if(in_array($model[$keyName??'id'], $disabled)){
						$disableCondition=true;
					}
				}

				$return[] = [
					"id" => $model[$keyName??'id'],
					"text" => $model[$textName??'name']?? $model['name'],
					'selected'=>$selectedCondition,
					'disabled'=>$disableCondition
				];
			}
		}

		return $return;

	}
	/**
	 * Trasforma un array di model che estendo la classe Model
	 *	@param $models array array di model da trasformare nel formato della select
	 * @param int $type_return    0: select2 normale,1: depDrop,2: Select2 ajax
	 * @param string $keyName nome della chiave primaria
	 * @param string $textName nome della chiave del model testuale da visualizzare nella select
	 * @param array $disabled array di id da mettere come disabilitati
	 * @param array $selected array di id da mettere ad abilitati
	 *
	 * @return array;
	 */
	public static function transformArrayModelsToSelect(array $models, $type_return = 0,$keyName='id',$textName='name',$selected = array(),$disabled = array()){

		$return = [];
		if($type_return == 0){


			foreach ($models as $model){


				$return[$model[$keyName??'id']]= $model[$textName??'name'];
			}
		}else if($type_return == 1){
			foreach ($models as $model){
				$selectedCondition=false;
				if(!empty($selected)){
					if(in_array($model[$keyName??'id'], $selected)){
						$selectedCondition=true;
					}
				}
				$disableCondition=false;
				if(!empty($disabled)){
					if(in_array($model[$keyName??'id'], $disabled)){
						$disableCondition=true;
					}
				}
				$return[] = [
					"id" => $model[$keyName??'id'],
					"name" => $model[$textName??'name'],
					'selected'=>$selectedCondition,
					'disabled'=>$disableCondition
				];
			}
		}else{
			/*$return[] = [
				"id" => '',
				"text" => '',
			];*/
			foreach ($models as $model){

				$selectedCondition=false;
				if(!empty($selected)){
					if(in_array($model[$keyName??'id'], $selected)){
						$selectedCondition=true;
					}
				}

				$disableCondition=false;
				if(!empty($disabled)){
					if(in_array($model[$keyName??'id'], $disabled)){
						$disableCondition=true;
					}
				}

				$text = $model[$textName];

				if(empty($text)){
					$text = $model['name']??null;
				}
				$return[] = [
					"id" => $model[$keyName??'id'],
					"text" => $text,
					'selected'=>$selectedCondition,
					'disabled'=>$disableCondition
				];

			}
		}

		return $return;
	}

	/**
	 * @param array $array array da ridurre
	 * @param bool $preserve_keys mantenere le stesse chiavi o meno, serve nei casi di array con chiavi literal
	 *
	 * ritorna un array ridotto di una dimensione
	 *
	 * @return array;
	 */
	public static function array_flatten(array &$array, $preserve_keys = true)
	{
		$flattened = array();

		array_walk_recursive($array, function($value, $key) use (&$flattened, $preserve_keys) {

			if ($preserve_keys && !is_int($key)) {
				$flattened[$key] = $value;
			} else {
				$flattened[] = $value;
			}
		});


		return $flattened;
	}
	/**
	 * Aggiunge gli apici a tutti gli elementi di un array semplice monodimensionale
	 * @param array $array
	 */
	public static function addQuotesToArrayElements(array &$array)
	{
		array_walk($array,function (&$item,$key){
			$item= '\''.$item.'\'';
		});

	}

	/**
	 * @param $arr array con referenza,l'array verrà modificato direttamente
	 * @param $col nome colonna di riferimento per ordinare
	 * @param int $dir SORT_ASC o SORT_DESC
	 * */
	public static function usortByColValue(&$arr, $col,$dir = SORT_ASC) {


		usort($arr, function($a,$b) use($col,$dir){

			if($dir == SORT_DESC){
				return $a[$col] > $b[$col] ? -1 : 1;
			} else {
				return $a[$col] > $b[$col] ? 1 : -1;
			}

		});


		return $arr;

	}

	/***
	 *
	 * permette di rimuovere da un array le chiavi scelte per un array monodimensionale,
	 *
	 *
	 *
	 * @param array $array array sulla quale rimuovere le chiavi
	 * @param array $keysToUnset array di chiavi da rimuovere
	 *
	 */
	public static function remove_element_recursive(array &$array, array $keysToUnset)
	{

		if(!empty($array)){

			if( isset($array[0]) && is_array($array[0])){

				foreach ($array as $index => $item) {

					//se non è settato item in posizione 0 vuol dire che è questo l'array da scomporre
					if(!isset($item[0])){
						foreach ($item as $key => $value) {

							if(in_array($key,$keysToUnset)){

								unset($array[$index][$key]);

							}

						}
					} else {

						foreach ($item as $subkey => $subItem) {


							foreach ($subItem as $k =>  $item) {

								if(in_array($k,$keysToUnset)){

									unset($array[$index][$subkey][$k]);

								}
							}

						}

					}

				}

			} else {

				foreach ($keysToUnset as $item) {

					unset($array[$item]);

				}

			}

		}

	}

	/**
	 * ritorna la prima chiave dell'array
	 * @param array $array
	 * @return int|string|null
	 */
	public static function array_first_key(array $array)
	{
		reset($array);

		return key($array);
	}
}
