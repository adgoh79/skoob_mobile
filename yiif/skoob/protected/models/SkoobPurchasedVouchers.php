<?php

/**
 * This is the model class for table "skoob_purchased_vouchers".
 *
 * The followings are the available columns in table 'skoob_purchased_vouchers':
 * @property string $id
 * @property string $skoob_txn_id
 * @property string $skoob_migs_txn_id
 * @property string $user_id
 * @property string $voucher_id
 * @property string $created
 * @property integer $status
 * @property string $modified_date
 */
class SkoobPurchasedVouchers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkoobPurchasedVouchers the static model class
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
		return 'skoob_purchased_vouchers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('skoob_txn_id, skoob_migs_txn_id, user_id, voucher_id, created', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('skoob_txn_id', 'length', 'max'=>50),
			array('skoob_migs_txn_id', 'length', 'max'=>10),
			array('user_id', 'length', 'max'=>100),
			array('voucher_id', 'length', 'max'=>13),
			array('modified_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, skoob_txn_id, skoob_migs_txn_id, user_id, voucher_id, created, status, modified_date', 'safe', 'on'=>'search'),
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
			'skoob_txn_id' => 'Skoob Txn',
			'skoob_migs_txn_id' => 'Skoob Migs Txn',
			'user_id' => 'User',
			'voucher_id' => 'Voucher',
			'created' => 'Created',
			'status' => 'Status',
			'modified_date' => 'Modified Date',
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
		$criteria->compare('skoob_txn_id',$this->skoob_txn_id,true);
		$criteria->compare('skoob_migs_txn_id',$this->skoob_migs_txn_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('voucher_id',$this->voucher_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('modified_date',$this->modified_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}