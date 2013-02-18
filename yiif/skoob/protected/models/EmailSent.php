<?php

/**
 * This is the model class for table "email_sent".
 *
 * The followings are the available columns in table 'email_sent':
 * @property string $id
 * @property string $egift_id
 * @property string $checkout_id
 * @property string $email_type
 * @property string $ins_dt
 */
class EmailSent extends CustomActiveRecord
{
	public $egift;
	public $checkout;
	public $checkout_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailSent the static model class
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
		return 'email_sent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('egift_id, checkout_id, ins_dt', 'required'),
			array('egift_id, checkout_id', 'length', 'max'=>10),
			array('sender_name, sender_email, recipient_name, recipient_email','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, egift_id, checkout_id, ins_dt, sender_name', 'safe', 'on'=>'search'),
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
			'egift_id' => 'Egift',
			'checkout_id' => 'Checkout',
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
		$criteria->compare('egift_id',$this->egift_id,true);
		$criteria->compare('checkout_id',$this->checkout_id,true);
		$criteria->compare('ins_dt',$this->ins_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getGiftDetails()
	{
		if(isset($this->checkout_id))
		{
			//get checkout details
			$this->checkout=Checkout::model()->findByPk($this->checkout_id);
			if(isset($this->checkout))
			{
				Yii::log('Finding the gift details using checkout id '.$this->checkout_id,'debug',modelname().'');
				$this->egift=Egift::model()->findByPk($this->checkout->egift_id);
				$this->egift->getGiftCardImg();
				//for saving record to db
				$this->egift_id=$this->egift->id;
			}
			else
				Yii::log('Unable to find the gift details using checkout id '.$this->checkout_id,'debug',modelname().'');
		}
	}
	
		/*
	* Function to enable sending of email using extension
	*/
	public function sendEmail($subject, $recipient, $body)
	{
	
		Yii::import('ext.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$message->setBody($body, 'text/html');
		$message->subject = $subject;
		$message->from = Yii::app()->params['adminEmail'];

		$message->addTo($recipient);
		
		$res=Yii::app()->mail->send($message);
		
		
	}
	
	public function sendEmailUseView($subject, $recipient, $view, $model)
	{
		Yii::import('ext.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$message->view=$view;
		$message->setBody(array('model'=>$model), 'text/html');
		$message->subject = $subject;
		$message->from = Yii::app()->params['adminEmail'];

		$message->addTo($recipient);
		
		$res=Yii::app()->mail->send($message);
		
		
	}

	public function beforeSave()
	{
		if( isset($this->egift_id) && isset($this->checkout_id) && isset($this->email_type) )
		{
			//only save record if it do not exist
			if( isset($this->sender_name) && $this->sender_name != '')
				$rec=EmailSent::model()->findByAttributes(array('sender_name'=>$this->sender_name, 'sender_email'=>$this->sender_email, 'recipient_name'=>$this->recipient_name, 'recipient_email'=>$this->recipient_email));
			else
				$rec=EmailSent::model()->findByAttributes(array('egift_id'=>$this->egift_id, 'checkout_id'=>$this->checkout_id, 'email_type'=>$this->email_type));
			if( isset($rec) )
			{
				Yii::log('Record exists with egift_id='.$this->egift_id.' and checkout id='.$this->checkout_id.'. Not saving','error',modelname().'.beforeSave');
				return false;
			}
			else
			{
				Yii::log('Record does not exist with egift_id='.$this->egift_id.' and checkout id='.$this->checkout_id.' . Saving','error',modelname().'.beforeSave');
				return parent::beforeSave();	
				
			}
		}
		else
		{
			Yii::log('No egift id and/or checkout id and/or email type set. Unable to save email sent record','error',modelname().'.beforeSave');
			return false;
		}
		
	}
	
	public function emailExists()
	{
		$res=false;
		if( isset($this->egift_id) && isset($this->checkout_id) && isset($this->email_type) )
		{
			//only save record if it do not exist
			$rec=EmailSent::model()->findByAttributes(array('egift_id'=>$this->egift_id, 'checkout_id'=>$this->checkout_id, 'email_type'=>$this->email_type));
			
			if( isset($rec))
				$res=true;
		}	
		return $res;
	}
	
	
}