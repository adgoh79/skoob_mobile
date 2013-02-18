<?php
abstract class CustomActiveRecord extends CActiveRecord
{

	public function beforeSave() {
		Yii::log('before save','info','CustomActiveRecord.beforeSave');
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
		if($this->isNewRecord)
		{
			// set the create date, last updated date and the user doing the creating
			$this->create_dt=new CDbExpression('NOW()');
			$this->update_dt=new CDbExpression('NOW()');
			Yii::log('the userid===='.Yii::app()->user->getId().' create time=='.$this->create_dt.' update time=='.$this->update_dt,'info','CustomActiveRecord.beforeValidate');
			$this->create_user_id=$this->update_user_id=Yii::app()->user->getId();
		}
		else
		{
			//not a new record, so just set the last updated time and last updated user id
			
			$this->update_dt=new CDbExpression('NOW()');
			$this->update_user_id=Yii::app()->user->id;
		}
		return parent::beforeValidate();
	}
	
	/**
	* perform one-way encryption on the password before we store it in
	the database
	*/
	protected function afterValidate()
	{
		Yii::log('inside after validate','info','CustomActiveRecord.beforeValidate');
		parent::afterValidate();
		if(isset($this->password) && trim($this->password)!="")
			$this->password = $this->encrypt($this->password);
	}
	public function encrypt($value)
	{
		return md5($value);
	}
}