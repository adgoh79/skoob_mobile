<?php

/**
 * This is the model class for table "tbl_wing_user_assignment".
 *
 * The followings are the available columns in table 'tbl_wing_user_assignment':
 * @property integer $wing_category_id
 * @property integer $user_id
 * @property string $create_dt
 * @property integer $create_user_id
 * @property string $update_dt
 * @property integer $update_user_id
 */
class WingUserAssignment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WingUserAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_wing_user_assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wing_category_id, user_id', 'required'),
			array('wing_category_id, user_id, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('create_dt, update_dt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wing_category_id, user_id, create_dt, create_user_id, update_dt, update_user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wing_category_id' => 'Wing Category',
			'user_id' => 'User',
			'create_dt' => 'Create Dt',
			'create_user_id' => 'Create User',
			'update_dt' => 'Update Dt',
			'update_user_id' => 'Update User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('wing_category_id',$this->wing_category_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_dt',$this->update_dt,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}