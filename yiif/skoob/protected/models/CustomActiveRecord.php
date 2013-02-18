<?php
abstract class CustomActiveRecord extends CActiveRecord
{

	public function beforeSave() {
        foreach ($this->attributes as $key => $value)
                if (!$value)
                        $this->$key = NULL;
                
        return parent::beforeSave();
	}
	/**
	* Prepares create_time, create_user_id, update_time and update_user_
	id attributes before performing validation.
	*/
	protected function beforeValidate()
	{
		Yii::log('inside before validate','info','CustomActiveRecord.beforeValidate');
		//if($this->isNewRecord)
	//	{
			// set the insert datetime
			$this->ins_dt=new CDbExpression('NOW()');
			
		//}
		
		return parent::beforeValidate();
	}
	
	public function encrypt($value)
	{
		return md5($value);
	}
}