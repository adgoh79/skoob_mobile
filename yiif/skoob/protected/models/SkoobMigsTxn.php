<?php

/**
 * This is the model class for table "skoob_migs_txn".
 *
 * The followings are the available columns in table 'skoob_migs_txn':
 * @property string $id
 * @property string $skoob_txn_id
 * @property string $user_id
 * @property string $email
 * @property string $mobile
 * @property string $campaign_id
 * @property integer $quantity
 * @property string $cardnumber
 * @property string $card_holder_name
 * @property string $card_type
 * @property string $currency
 * @property string $total_amount
 * @property integer $txn_status
 * @property string $txn_id
 * @property string $txn_resp_code
 * @property string $txn_resp_message
 * @property string $txn_amt_deducted
 * @property string $auth_id
 * @property string $created
 * @property integer $validate_success
 * @property string $validate_error_code
 * @property string $validate_error_message
 * @property string $validate_datetime
 * @property string $email_sent_datetime
 */
class SkoobMigsTxn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SkoobMigsTxn the static model class
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
		return 'skoob_migs_txn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, email, cardnumber, card_holder_name, card_type, currency, total_amount, created, checkout_id', 'required'),
			array('quantity, txn_status, validate_success', 'numerical', 'integerOnly'=>true),
			array('skoob_txn_id', 'length', 'max'=>50),
			array('user_id, email, card_holder_name', 'length', 'max'=>100),
			array('mobile, card_type', 'length', 'max'=>20),
			array('campaign_id, total_amount, txn_resp_code, txn_amt_deducted, validate_error_code', 'length', 'max'=>10),
			array('cardnumber', 'length', 'max'=>4),
			array('currency', 'length', 'max'=>3),
			array('txn_id', 'length', 'max'=>32),
			array('txn_resp_message', 'length', 'max'=>150),
			array('auth_id', 'length', 'max'=>12),
			array('validate_error_message', 'length', 'max'=>1024),
			array('validate_datetime, email_sent_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, skoob_txn_id, user_id, email, mobile, campaign_id, quantity, cardnumber, card_holder_name, card_type, currency, total_amount, txn_status, txn_id, txn_resp_code, txn_resp_message, txn_amt_deducted, auth_id, created, validate_success, validate_error_code, validate_error_message, validate_datetime, email_sent_datetime', 'safe', 'on'=>'search'),
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
			'skoob_txn_id' => 'Mo4u Txn',
			'user_id' => 'User',
			'email' => 'Email',
			'mobile' => 'Mobile',
			'campaign_id' => 'Campaign',
			'quantity' => 'Quantity',
			'cardnumber' => 'Cardnumber',
			'card_holder_name' => 'Card Holder Name',
			'card_type' => 'Card Type',
			'currency' => 'Currency',
			'total_amount' => 'Total Amount',
			'txn_status' => 'Txn Status',
			'txn_id' => 'Txn',
			'txn_resp_code' => 'Txn Resp Code',
			'txn_resp_message' => 'Txn Resp Message',
			'txn_amt_deducted' => 'Txn Amt Deducted',
			'auth_id' => 'Auth',
			'created' => 'Created',
			'validate_success' => 'Validate Success',
			'validate_error_code' => 'Validate Error Code',
			'validate_error_message' => 'Validate Error Message',
			'validate_datetime' => 'Validate Datetime',
			'email_sent_datetime' => 'Email Sent Datetime',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('campaign_id',$this->campaign_id,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cardnumber',$this->cardnumber,true);
		$criteria->compare('card_holder_name',$this->card_holder_name,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('total_amount',$this->total_amount,true);
		$criteria->compare('txn_status',$this->txn_status);
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('txn_resp_code',$this->txn_resp_code,true);
		$criteria->compare('txn_resp_message',$this->txn_resp_message,true);
		$criteria->compare('txn_amt_deducted',$this->txn_amt_deducted,true);
		$criteria->compare('auth_id',$this->auth_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('validate_success',$this->validate_success);
		$criteria->compare('validate_error_code',$this->validate_error_code,true);
		$criteria->compare('validate_error_message',$this->validate_error_message,true);
		$criteria->compare('validate_datetime',$this->validate_datetime,true);
		$criteria->compare('email_sent_datetime',$this->email_sent_datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}