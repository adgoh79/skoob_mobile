<?php
Yii::import('ext.runactions.components.*');

/**
 * This is the model class for table "checkout".
 *
 * The followings are the available columns in table 'checkout':
 * @property string $id
 * @property string $sender_email_add
 * @property string $promotion_code
 * @prooperty double(10,5) $promotion_discount
 * @property string $card_type_id
 * @property string $card_holder_name
 * @property string $credit_card_no
 * @property string $security_code
 * @property string $expiry_date
 * @property string $egift_id
 * @property string $ins_dt
 */
class Checkout extends CustomActiveRecord
{
	public $check_agree;
	public $sender_email_add_repeat;
	public $egift;
	public $failed_msg;
	public $credit_card_name;
	public $total=0.00;
	public $voucher_no;
	//for transaction processing START
	CONST _TABLE_NAME = 'migs_txn';
	CONST _TXN_LEN = 10;
	private $default_txn_resp_message = 'cancelled';
	private $currency = 'SGD';
	
	private $make_payment_reply_assoc_name = array(
		"status",
		"txnRespCode",
		"txnRespCodeMessage",
		"merchRef",
		"txnId",
		"txnAmtDeducted",
		"authId",
	);

	private $validate_reply_assoc_name = array(
		"success",
		"errorCode",
		"errorMessage",
	);



	//for transaction processing END
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Checkout the static model class
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
		return 'checkout';
	}
	/**
	 * @return array of credit cards
	 */
	public function getCreditCards()
	{
		$arr=array();
		$arr[0]='-Please select-';
		
		$creditCards=CreditCardMaster::model()->findAll();
		foreach($creditCards as $creditCard)
		{
			if($creditCard->card_name=='MASTERCARD' || $creditCard->card_name=='VISA')
				$arr[$creditCard->id]=$creditCard->card_name;
		}
		return $arr;
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender_email_add, card_type_id, card_holder_name, credit_card_no, security_code, expiry_date,  ins_dt', 'required'),
			array('sender_email_add, promotion_code, card_holder_name', 'length', 'max'=>100),
			array('credit_card_no', 'length','max'=>16, 'min'=>16),
			array('expiry_date', 'date', 'format'=>'MMyyyy'),
			array('sender_email_add,sender_email_add_repeat', 'email'),
			array('security_code', 'numerical', 'integerOnly'=>true),
			array('sender_email_add', 'compare'),
			array('check_agree, sender_email_add_repeat, credit_card_name','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sender_email_add, promotion_code, card_type_id, card_holder_name, credit_card_no, expiry_date, egift_id, ins_dt', 'safe', 'on'=>'search'),
			array('check_agree', 'verify'),
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
	* Authenticates the whether has ticked agreement.
	* This is the 'verify' validator as declared in rules().
	*/
	public function verify($attribute,$params)
	{
		
		if(!$this->hasErrors()) // we only want to authenticate when no other input errors are present
		{
			if($this->check_agree=='0')
				$this->addError('check_agree','Please agree to the Terms.');
	
		}
	}
	
	public function buy_gift()
	{
		//processTxn
		$res=true;
		$txn=SkoobMigsTxn::model()->findByAttributes(array('checkout_id'=>$this->id));
		Yii::log('the checkout id =='.$this->id.' and id='.$txn->id,'debug',modelname().'.buy_gift');
		if(isset($txn))
		{
			//insert into purchase voucher table
			$vc=new SkoobPurchasedVouchers;
			
			$vc->skoob_txn_id=$txn->skoob_txn_id;
			
			$vc->skoob_migs_txn_id=$txn->id;
			
			$vc->user_id=$txn->user_id;
			
			//$vc->voucher_id='000000'.$txn->id;
			$avail_voucher=VoucherMaster::model()->findByAttributes(array('claimed'=>'0'));
			
			if( isset($avail_voucher) )
			{
				Yii::log('Using voucher number'.$avail_voucher->voucher,'info',modelname().'.buy_gift');
				
				$vc->voucher_id=$avail_voucher->voucher;
				$vc->created=date('Y-m-d H:i:s');
				$vc->status=1;
				if($vc->save())
				{
					Yii::log('The voucher with id '.$vc->voucher_id.' has been created with transaction id='.$txn->id,'info',modelname().'.buy_gift');
					//indicate this voucher has been claimed
					$avail_voucher->claimed=1;
					
					if($avail_voucher->save())
					{
						Yii::log('Set voucher status as 1. id='.$avail_voucher->id,'info',modelname().'.buy_egift');
					}
					else
					{
						Yii::log('Unable to set voucher claimed status as 1. id='.$avail_voucher->id,'error',modelname().'.buy_egift');
					}
				}
				else
				{
					Yii::log('Unable to create transaction with the voucher with id '.$vc->voucher_id,'info',modelname().'.buy_gift');
				}
			}
			else
			{
				Yii::log('No more vouchers to issue.','erorr',modelname().'.buy_gift');
			
				$err_msg=sprintf(Yii::app()->globaldef->MSG_NO_VOUCHERS,Yii::app()->globaldef->SKOOB_ADMIN_EMAIL,Yii::app()->globaldef->SKOOB_ADMIN_EMAIL);
				
				Yii::app()->user->setFlash('error', $err_msg);
				$res=false;
				
			}
		}
		else
			Yii::log('the voucher with id '.'000000'.$txn->id.' has been created with transaction id='.$txn->id.' could not be created.','error',modelname().'.buy_gift');
		return $res;
	}
	
	public function calculateTotalAmt()
	{
		if(isset($this->egift))
			$this->total=floatval($this->egift->amount) - floatval($this->promotion_discount);
		$this->total=number_format($this->total,2,'.',',');
	}
	
	protected function afterFind()
	{	
		//assign total amount
		if(isset($this->egift))
			$this->total=floatval($this->egift->amount) - floatval($this->promotion_discount);
		$this->total=number_format($this->total,2,'.',',');	
		
		//assign * to front of credit card number
		$cc_len = Yii::app()->globaldef->CREDIT_CARD_MIN_LENGTH;
		$i=0;
		$cc_no = '';
		while( $i < ($cc_len - strlen($this->credit_card_no)) )
		{
			$cc_no .= '*';
			$i++;
		}
		$this->credit_card_no=$cc_no.$this->credit_card_no;
		
		//as this is a retrieval of data, change date to be MMYYYY
		$date=strtotime($this->expiry_date);
		$this->expiry_date = date('mY',$date);
		$this->sender_email_add_repeat = $this->sender_email_add;
		return parent::afterFind();
	}
	
	
	public function afterSave()
    {
		//after checkout successfully, create another model
		if(!isset($this->egift))
		{
			Yii::log('No egift found. Unable to create egift.','error',modelname().'.afterSave');
		}
		else
		{
			if(!SkoobMigsTxn::model()->findByAttributes(array('checkout_id'=>$this->id)))
			{
				//insert transaction string
				$txn=new SkoobMigsTxn;
				$egift=$this->egift;
				$txn->user_id=$egift->sender_name;
				$txn->email=$this->sender_email_add;
				$txn->quantity=1; //currently set as 1
				$txn->cardnumber=$this->credit_card_no;
				$txn->card_holder_name=$this->card_holder_name;
				$txn->card_type=$this->credit_card_name;
				$txn->currency=Yii::app()->globaldef->CURRENCY;
				$txn->total_amount=$egift->amount;
				$txn->txn_resp_message=Yii::app()->globaldef->MIGS_DEFAULT_TXN_MSG;
				$txn->created=date('Y-m-d H:i:s');
				$txn->checkout_id = $this->id;
				
				
				
				if($txn->save())
				{
					Yii::log('Saved transaction using checkout id '.$this->id.' successfully.','info',modelname().'.afterSave');
					
					//use increment id to form transaction id
					$strid=strval($txn->id);		
					$iden='';
					for($i=0; $i<(10-strlen($strid)); $i++)
					{
						$iden.='0';
					}
					$iden.=$strid;
					$skoob_txn_id = 'SKB-EG-'.date('Y').$iden.date('md');	
					$txn->skoob_txn_id = $skoob_txn_id;
					$txn->update();
					
				}
				else
					Yii::log('Unable to save using checkout id '.$this->id.' transaction.','error',modelname().'.afterSave');
			}
			else
				Yii::log('Transaction with checkout id '.$this->id.' alreay exists.No need to create.','error',modelname().'.afterSave');
		}
		return parent::afterSave();
	}	
	
	public function beforeSave()
    {
		$mth = substr($this->expiry_date, 0, 2);
		$yr = substr($this->expiry_date, -4);
		$dt = $yr.'-'.$mth.'-01';
		$this->expiry_date=$dt;
		
		if(!Checkout::model()->findByAttributes(array('egift_id'=>$this->egift_id)))
		{
			$this->credit_card_no=substr($this->credit_card_no,-4);	 
			return parent::beforeSave();	
		}
		else
		{
			Yii::log('The checkout record with egift id '.$this->egift_id.' already exists. Updating checkout record with id='.$this->id,'info',modelname().'.beforeSave');
			return true;
		}
		
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sender_email_add' => 'Your Email Address',
			'sender_email_add_repeat' => 'Confirm Email Address',
			'promotion_code' => 'Redeem any promotion codes',
			'card_type_id' => 'Card Type',
			'card_holder_name' => 'Name on Card',
			'credit_card_no' => 'Credit Card No',
			'security_code' => 'Security Code',
			'expiry_date' => 'Expiry Date',
			'egift_id' => 'Egift',
			'ins_dt' => 'Ins Dt',
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
		$criteria->compare('sender_email_add',$this->sender_email_add,true);
		$criteria->compare('promotion_code',$this->promotion_code,true);
		$criteria->compare('card_type_id',$this->card_type_id,true);
		$criteria->compare('card_holder_name',$this->card_holder_name,true);
		$criteria->compare('credit_card_no',$this->credit_card_no,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('egift_id',$this->egift_id,true);
		$criteria->compare('ins_dt',$this->ins_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/*
	protected function afterSave()
	{
		$txn = array();
		$txn['id']=1;
		$egift=Egift::model()->findByPk($this->egift_id);
		$txn['amount']=$egift->amount;
		$txn['credit_card_no']=$this->credit_card_no;
		$txn['expiry_date']=$this->expiry_date;
		$txn['card_type']=$this->credit_card_name;
		$txn['card_holder_name']=$this->card_holder_name;
		$txn['security_code']=$this->security_code;
		$txn['currency']=Yii::app()->globaldef->CURRENCY;
		
		$this->processTxn($txn);
		parent::afterSave();
	}*/
	public function processTxn($txn = NULL)
	{
		//assign data for posting to payment gateway
		$post_data = array(
		"trackingid" => $txn['id'],
		"totalamount" => $txn['amount'],
		"cardnumber" => $txn['credit_card_no'],
		"cardexpirydate" => $txn['expiry_date'],
		"cardtype" => $txn['card_type'],
		"cardholdername" => $txn['card_holder_name'],
		"cvv" => $txn['security_code'],
		"currency" => $txn['currency'],
		"partnerid" => Yii::app()->globaldef->MIGS_PARTNER_ID,
		"projectid" => Yii::app()->globaldef->MIGS_PROJECT_ID,
		);
	
		$url = Yii::app()->globaldef->MIGS_SERVER.'makepaymentwithreceipt';
		$this->curl->create($url);
		$this->curl->post($post_data);
		$reply = $this->curl->execute();
		if ( $reply )
		{
			$reply_arr = explode("|", $reply);
		}
	}
	
	public function transactionExists()
	{
		$res=false;
		
		//only check for transaction if checkout id exists
		if(isset($this->id))
		{
			Yii::log('Checkout id "'.$this->id.'" found. ','info',modelname().'transactionExists');
			$txn = SkoobMigsTxn::model()->findByAttributes(array('checkout_id'=>$this->id));
			
			Yii::log('txn id "'.$txn->id.'" found. ','info',modelname().'transactionExists');
			$vc = SkoobPurchasedVouchers::model()->findByAttributes(array('skoob_migs_txn_id'=>$txn->id));
			if( isset($vc))
			{
				$res=true;
			}
		}
		else
		{
			Yii::log('No checkout id. Unable to check if voucher purchased. ','info',modelname().'transactionExists');
		}
		
		return $res;
	}
	public function runBackgroundTask()
	{
		Yii::log('before running background task','info',modelname().'runBackgroundTask');
		//$this->redirect(array('emailSent/orderReceipt','checkout_id'=>$checkout_id));
		ERunActions::runAction('emailSent/orderReceipt',array('checkout_id'=>$this->id),false,false,false,true);
		Yii::log('after running task','info',modelname().'runBackgroundTask');
	}
}