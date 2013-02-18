<?php

/**
 * This is the model class for table "egift".
 *
 * The followings are the available columns in table 'egift':
 * @property string $id
 * @property double $amount
 * @property string $recipient_email
 * @property string $recipient_name
 * @property string $sender_name
 * @property string $message
 * @property string $delivery_date
 * @property string $ins_dt
 */
class Egift extends CustomActiveRecord
{
	const TYPE_AMT_NONE=0;
	const TYPE_AMT_10=1;
	const TYPE_AMT_100=2;
	const TYPE_AMT_1000=3;
	
	public $recipient_email_repeat;
	public $gift_cards;
	
	public $amount_opts;
	public $gift_card_img;
	public $selected_amount_id;
	public $current_date;
	public $sender_email;
	
	public $sender_email_repeat;
	public $voucher_value;
	public $voucher_redeem_date;
	
	public function getGiftCardImg()
	{
		if($this->gift_card_id!='')
		{
			$gift_card=GiftCard::model()->findByPk($this->gift_card_id);
			
			if( isset($gift_card->img_url) )
				$this->gift_card_img=str_replace(' ', '%20',$gift_card->img_url);
		}
	}
	
	public function getAmtOptions()
	{
		/*
		return array(
		self::TYPE_AMT_NONE=>'-Please select-',
		self::TYPE_AMT_10=>'10.00',
		self::TYPE_AMT_100=>'100.00',
		self::TYPE_AMT_1000=>'1000.00',
		);*/
		$ret_arr=array();
		$ret_arr[0]='-Please select-';
		$c_values=CampaignGiftValues::model()->findAll();
		foreach($c_values as $c_val)
		{
			$ret_arr[$c_val->id]=number_format(($c_val->value /  100 ), 2, '.',',');
		}
		return $ret_arr;
		
	}
	
	/**
	* Override constructor
	*/
	public function __construct($scenario = 'insert')
	{
		$gift_cards=GiftCard::model()->findAll();
		$this->gift_cards=$gift_cards;
		$this->current_date=date('Y-m-d');
		parent::__construct($scenario);
	}
	
	public function getSelectedAmtId()
	{
		$ret_id=0;
		if(isset($this->sender_name))
		{
			$arr=$this->getAmtOptions();
		
			foreach($arr as $key=>$val)
			{
				if($val==$this->amount)
				{
					$ret_id=$key;
				}
			
			}
			
		}
		return $ret_id;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Egift the static model class
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
		return 'egift';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, recipient_email, recipient_name, sender_name, message, delivery_date, ins_dt', 'required'),
			array('amount', 'numerical'),
			array('recipient_email, sender_name', 'length', 'max'=>45),
			array('recipient_email,recipient_email_repeat', 'email'),
			array('delivery_date', 'date', 'format'=>'yyyy-m-d'),
			array('delivery_date', 'compare',
				  'compareAttribute'=>'current_date',
				  'operator'=>'>', 
				  'allowEmpty'=>false , 
				  'message'=>'{attribute} must be greater than "{compareValue}"'),
			array('recipient_email', 'compare'),
			array('recipient_email_repeat, amount_opts, sender_email, sender_email_repeat', 'safe'),
			array('recipient_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, amount, recipient_email, recipient_name, sender_name, message, delivery_date, ins_dt', 'safe', 'on'=>'search'),
			array('gift_card_id', 'verify'),
		);
	}

	
	/**
	* Authenticates the whether has ticked agreement.
	* This is the 'verify' validator as declared in rules().
	*/
	public function verify($attribute,$params)
	{
		if(!$this->hasErrors()) // we only want to authenticate when no other input errors are present
		{
			Yii::log('gift_card_id.==='.$this->gift_card_id,'info','debug.Egift');
			if($this->gift_card_id=='')
				$this->addError('gift_card_id','Please select a gift card to send.');
			if($this->amount=='' || $this->amount=='0.00')
				$this->addError('amount','Please select a value for the card.');
	
		}
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

	public function updateRecord()
    {
		$res=false;
		if( isset($this->id) && Egift::model()->findByPk($this->id) )
		{
			//have to set this, if not cannot update 
			//even though record is found
			$this->setIsNewRecord(false);
			$this->ins_dt=new CDbExpression('NOW()');
			$this->update();
			$res=true;
		}
		
		Yii::log('Before returning, the result='.$res,'debug',modelname().'.updateRecord');
		return $res;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'recipient_email' => 'Recipient\' Email Address',
			'recipient_email_repeat' => 'Confirm Recipient\' Email Address',
			'recipient_name' => 'Recipient\'s Name',
			'sender_name' => 'Your Name',
			'message' => 'Message',
			'delivery_date' => 'Delivery Date',
			'ins_dt' => 'Ins Dt',
			'sender_email' => 'Your Email Address',
			'sender_email_repeat' => 'Confirm Your Email Address',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('recipient_email',$this->recipient_email,true);
		$criteria->compare('recipient_name',$this->recipient_name,true);
		$criteria->compare('sender_name',$this->sender_name,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('ins_dt',$this->ins_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function afterFind()
	{
		$this->recipient_email_repeat = $this->recipient_email;
		return parent::afterFind();
	}
	
	public function getClaimedVoucherDetails($voucher_no)
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'created DESC';
		$vc = SkoobPurchasedVouchers::model()->findByAttributes(array('voucher_id'=>$voucher_no), $criteria);
		
		if(isset($vc))
		{
			Yii::log('Found purchased voucher id = '.$vc->id,'info',modelname().'.claimedVoucherDetails');
			
			//get attributes
			$txn = SkoobMigsTxn::model()->findByAttributes(array('skoob_txn_id'=>$vc->skoob_txn_id));
			
			if( isset($txn) )
			{
				Yii::log('Found transaction using skoob_txn_id = '.$vc->skoob_txn_id,'info',modelname().'.claimedVoucherDetails');
				
				//find checkout
				
				$checkout = Checkout::model()->findByPk($txn->checkout_id);
				
				if( isset($checkout) )
				{
					Yii::log('Found checkout using checkout id = '.$txn->checkout_id,'info',modelname().'.claimedVoucherDetails');
					
					
					
					$egift = Egift::model()->findByPk($checkout->egift_id);
					
					if( isset($egift) )
					{
						Yii::log('Found egift using egift id = '.$checkout->egift_id,'info',modelname().'.claimedVoucherDetails');
						
						$this->sender_email = $checkout->sender_email_add;
						$this->sender_name = $egift->sender_name;						
						$this->recipient_name = $egift->recipient_name;
						$this->recipient_email = $egift->recipient_email;
						$this->voucher_value = $egift->amount;
						$vm = VoucherMaster::model()->findByAttributes(array('voucher'=>$voucher_no));
						$timemills = strtotime ($vm->redeem_date);
						$dt = date('d M Y',$timemills);
						$this->voucher_redeem_date = $dt;
					}
					else
					{
						Yii::log('Unable to find egift using egift id = '.$checkout->egift_id,'info',modelname().'.claimedVoucherDetails');
					}
				}
				else
				{
					Yii::log('Unable to find checkout using checkout id = '.$txn->checkout_id,'info',modelname().'.claimedVoucherDetails');
				}
			}
			else
			{
				Yii::log('Unable to find transaction using skoob_txn_id = '.$vc->skoob_txn_id,'info',modelname().'.claimedVoucherDetails');
			}
		}
		else
		{
			Yii::log('No purchased voucher found','info',modelname().'.claimedVoucherDetails');
		}
		
	}
	
	public function claimEGift($user_name, $user_password, $voucher_no)
	{
		$ret_arr=array();
		$ret_code=-1;
		Yii::log('starting....','info',modelname().'claimEGift');
		
		$user=AuthUser::model()->findByAttributes(array('username'=>$user_name));
		
		if( isset($user))
		{
			Yii::log('The username '.$user_name.' is found','error',modelname().'.claimEGift');
			//unset to reuse var
			unset($user);
			
			//check to see if password is correct
			$user=AuthUser::model()->findByAttributes(array('password'=>md5($user_password)));
			if( isset($user))
			{
				Yii::log('The password for  '.$user_name.' is correct','error',modelname().'.claimEGift');	
				
				//find if voucher attempted to redeem exists
				$vc = VoucherMaster::model()->findByAttributes(array('voucher'=>$voucher_no,'redeemed'=>0));
				
				if( isset($vc) )
				{
					Yii::log('The voucher '.$voucher_no.' is found.','error',modelname().'.claimEGift');	
						
					//update voucher to indicate already claimed
					$rows_updated=VoucherMaster::model()->updateByPk($vc->id, array( 'redeemed'=>1 ,'redeem_date'=>new CDbExpression('NOW()')) );
					//AuthUser::model()->updateByPk($this->_identity->id, array('last_login_time'=>new CDbExpression('NOW()')));
					if($rows_updated>0)
					{
						Yii::log('Rows updated = '.$rows_updated,'error',modelname().'.claimEGift');	
						$ret_code=Yii::app()->globaldef->CLAIM_GIFT_SUCCESS;
						
					}
					else
					{
						Yii::log('No rows updated. ','error',modelname().'.claimEGift');	
					}
				}
				else
				{
					Yii::log('The voucher '.$voucher_no.' is not found.','error',modelname().'.claimEGift');	
					$ret_code=Yii::app()->globaldef->CLAIM_GIFT_ERROR_VOUCHER_NOT_FOUND;	
				}
			}
			else
			{
				Yii::log('The password for  '.$user_name.' is incorrect','error',modelname().'.claimEGift');	
				$ret_code=Yii::app()->globaldef->CLAIM_GIFT_ERROR_PASSWORD_WRONG;	
			}
			
		}
		else
		{
			$ret_code=Yii::app()->globaldef->CLAIM_GIFT_ERROR_USER_NAME_WRONG;
			Yii::log('The username '.$user_name.' is not found','error',modelname().'claimEGift');
		}
		
		
		return $ret_code;
	}
	
	public function checkEgiftRequestFields()
	{
		$res=true;
		
		
		if( !isset($this->sender_name) || $this->sender_name=='')
		{
			$this->addError('sender_name','Please enter your name.');
			$res=false;
		}
		if( !isset($this->sender_email) || $this->sender_email=='')
		{
			$this->addError('sender_email','Please enter your email address.');
			$res=false;
		}
		if( !isset($this->recipient_name) || $this->recipient_name=='')
		{
			$this->addError('recipient_name','Please enter recipient\'s name.');
			$res=false;
		}
		if( !isset($this->recipient_email) || $this->recipient_email=='')
		{
			$this->addError('recipient_email','Please enter recipient\'s email address.');
			$res=false;
		}
		//continue special check after mandatory check
		if($res)
		{
			if($this->sender_email == $this->recipient_email)
			{
				$this->addError('recipient_email','You cannot request the egift to yourself.');
				$res=false;
			}
			else
			{
				if($this->sender_email != $this->sender_email_repeat )
				{
					$this->addError('sender_email','You must repeat your email address exactly.');
					$res=false;
				}
				
				if($this->recipient_email != $this->recipient_email_repeat )
				{
					$this->addError('recipient_email','You must repeat the recipient\'s email address exactly.');
					$res=false;
				}
			}
		}
		return $res;
	}
}