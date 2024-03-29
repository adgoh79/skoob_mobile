<?php

/**
 * This is the model class for table "voucher_master".
 *
 * The followings are the available columns in table 'voucher_master':
 * @property string $id
 * @property string $campaign_gift_value_id
 * @property string $voucher
 * @property integer $claimed
 * @property string $created_on
 * @property string $created_by
 */
class VoucherMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VoucherMaster the static model class
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
		return 'voucher_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('campaign_gift_value_id, voucher, created_on, created_by', 'required'),
			array('claimed', 'numerical', 'integerOnly'=>true),
			array('campaign_gift_value_id', 'length', 'max'=>10),
			array('voucher, created_by', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, campaign_gift_value_id, voucher, claimed, created_on, created_by', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'campaign_gift_value_id' => 'Campaign Gift Value',
			'voucher' => 'Voucher',
			'claimed' => 'Claimed',
			'created_on' => 'Created On',
			'created_by' => 'Created By',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('campaign_gift_value_id',$this->campaign_gift_value_id,true);
		$criteria->compare('voucher',$this->voucher,true);
		$criteria->compare('claimed',$this->claimed);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}