<?php

namespace Kristianlentino\DieffetechUtils;

use yii\validators\Validator;

class TelephoneValidator extends Validator
{

	public function validateTelephone($telephone): bool
	{
		$formats = [
			'###-###-####', '####-###-###',
			'(###) ###-###', '####-####-####',
			'##-###-####-####', '####-####', '###-###-###',
			'#####-###-###', '##########', '#########',
			'# ### #####', '#-### #####'
		];

		return in_array(
			trim(preg_replace('/[0-9]/', '#', $telephone)),
			$formats
		);
	}
	public function validateAttribute($model, $attribute): ?array
	{
		$result = $this->validateTelephone($model->$attribute);

		if(!$result){
			$this->addError($model,"$attribute", \Yii::t('app','Numero non valido'));

			return [
				\Yii::t('app','Numero non valido'),[]
			];
		}

		return null;
	}

	protected function validateValue($value)
	{
		return $this->validateTelephone($value);
	}

}