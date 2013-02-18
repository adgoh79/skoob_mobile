<?php

class EmailSentController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionEgiftVoucherClaimed()
	{
		$sender_name='';
		$sender_email='';
		$recipient_name='';
		$recipient_email='';
		$ret_code='';	
		$redeem_date='';
		if(isset($_GET['sender_name']))
			$sender_name=$_GET['sender_name'];
		if(isset($_GET['sender_email']))
			$sender_email=$_GET['sender_email'];
		if(isset($_GET['recipient_name']))
			$recipient_name=$_GET['recipient_name'];
		if(isset($_GET['recipient_email']))
			$recipient_email=$_GET['recipient_email'];			
		if(isset($_GET['code']))
			$ret_code=$_GET['code'];		
		if(isset($_GET['voucher_value']))			
			$voucher_value=$_GET['voucher_value'];
		if(isset($_GET['redeem_date']))			
			$redeem_date=$_GET['redeem_date'];
		
		
		if( $sender_name=='' || $sender_email=='' || $recipient_name=='' || $recipient_email=='' )
		{
			Yii::log('Sender Name / Sender Email / Recipient Name / Recipient Email is missing. Unable to proceed.','info',modelname().'.actionEgiftRequested');
			Yii::app()->user->setFlash('error', "Unable to send egift request. Please contact skoob administrator.");
			
		}
		else
		{
			$model = new EmailSent;
			$model->sender_name=$sender_name;
			$model->sender_email=$sender_email;
			$model->recipient_name=$recipient_name;
			$model->recipient_email=$recipient_email;
			
		
			$rec = $model->findByAttributes(array('recipient_email'=>$recipient_email,'email_type'=>Yii::app()->globaldef->EMAIL_SENT_TYPE_EGIFT_VOUCHER_CLAIMED));
			
			if( isset($rec) )
			{
				Yii::log('Egift voucher claimed email sent. Not sending again. ','info',modelname().'.actionEgiftRequested');	
			}
			else
			{
				//save to db
				$model->egift_id=0;
				$model->checkout_id=0;
				$model->ins_dt = new CDbExpression('NOW()');
				$model->email_type = Yii::app()->globaldef->EMAIL_SENT_TYPE_EGIFT_VOUCHER_CLAIMED;
				$model->save();
				Yii::log('Before sending the email ','info',modelname().'.actionEgiftVoucherClaimed');
				$email_content=$this->renderPartial('voucher_claimed',array('model'=>$model,'voucher_value'=>$voucher_value,'redeem_date'=>$redeem_date),true,true);
				$model->sendEmail('Your friend has claimed egift voucher no ', $recipient_email, $email_content);
				Yii::log('Sent the email already ','info',modelname().'.actionEgiftVoucherClaimed');
			}
		
		}
		$ret_arr['result_code']=$ret_code;
		echo CJSON::encode($ret_arr);
	}
	
	public function actionEgiftRequested()
	{
		$sender_name='';
		$sender_email='';
		$recipient_name='';
		$recipient_email='';
			
		if(isset($_GET['sender_name']))
			$sender_name=$_GET['sender_name'];
		if(isset($_GET['sender_email']))
			$sender_email=$_GET['sender_email'];
		if(isset($_GET['recipient_name']))
			$recipient_name=$_GET['recipient_name'];
		if(isset($_GET['recipient_email']))
			$recipient_email=$_GET['recipient_email'];			
		if( $sender_name=='' || $sender_email=='' || $recipient_name=='' || $recipient_email=='' )
		{
			Yii::log('Sender Name / Sender Email / Recipient Name / Recipient Email is missing. Unable to proceed.','info',modelname().'.actionEgiftRequested');
			$this->redirect(array('egift/create'));
		}
		else
		{
			$model = new EmailSent;
			$model->sender_name=$sender_name;
			$model->sender_email=$sender_email;
			$model->recipient_name=$recipient_name;
			$model->recipient_email=$recipient_email;
			
			$rec = $model->findByAttributes(array('recipient_email'=>$recipient_email,'email_type'=>Yii::app()->globaldef->EMAIL_SENT_TYPE_EGIFT_REQUESTED));
			
			if( isset($rec) )
			{
				Yii::app()->user->setFlash('error', 'You have already send an egift request to '.$recipient_name.'.');
				$this->redirect(array('egift/request_egift'));
			}
			else
			{
				//save to db
				$model->egift_id=0;
				$model->checkout_id=0;
				$model->ins_dt = new CDbExpression('NOW()');
				$model->email_type = Yii::app()->globaldef->EMAIL_SENT_TYPE_EGIFT_REQUESTED;
				$model->save();
				
				//$email_content=$this->renderPartial('egift_requested',array('model'=>$model),false,true);
				$email_content=$this->renderPartial('egift_requested',array('model'=>$model),true,true);
				$model->sendEmail('Your friend has requested for a skoob egift', $recipient_email, $email_content);
				$this->redirect(array('egift/index'));	
			}
			
		}
	}
	
	public function actionOrderReceipt()
	{
		Yii::log('start of actionOrderReciept','info','aaiosdj');
		if(isset($_GET['checkout_id']))
		{
			$model=new EmailSent;
			$model->checkout_id=$_GET['checkout_id'];
			//get egift and checkout details
			$model->getGiftDetails();
		}
		if(isset($model) && isset($model->egift))
		{
			//for testing
			//$email_content=$this->renderPartial('order_receipt',array('model'=>$model),false,true);
			$email_content=$this->renderPartial('order_receipt',array('model'=>$model),true,true);
			
			//use migs_txn_id as order receipt
			$txn = SkoobMigsTxn::model()->findByAttributes(array('checkout_id'=>$model->checkout_id));
			$subject=sprintf(Yii::app()->globaldef->EMAIL_ORDER_RECEIPT_SUBJECT,$txn->skoob_txn_id);
			
			$checkout = Checkout::model()->findByPk($model->checkout_id);
			//send to send email
			if( isset($checkout) )
			{
				$model->email_type=Yii::app()->globaldef->EMAIL_SENT_TYPE_RECEIPT;			
				
				if($model->emailExists())
				{
					Yii::log('Email has already been sent out. Not going to send again.','info',$logPrefix);
				}
				else
				{
					$model->sendEmail($subject, $checkout->sender_email_add, $email_content);
		
					//save instance
					$model->save();
				}
			}
		
			
		}
		else
		{
			Yii::log('Unable to find gift details. No checkout id.','info',modelname());
			$this->redirect(array('egift/create'));
		
		}
	}

	public function actionDeliveredEgift()
	{
		
		if(isset($_GET['checkout_id']))
		{
			$model=new EmailSent;
			$model->checkout_id=$_GET['checkout_id'];
			//get egift and checkout details
			$model->getGiftDetails();
		}
		if(isset($model) && isset($model->egift))
		{
			$email_content=$this->renderPartial('delivered_egift',array('model'=>$model),true,true);
			//for testing
			//$email_content=$this->renderPartial('delivered_egift',array('model'=>$model),false,true);
			$subject=sprintf(Yii::app()->globaldef->EMAIL_DELIVERED_GIFT_SUBJECT,$model->checkout_id);
			$model->sendEmail($subject, $model->egift->recipient_email, $email_content);
			$model->save();
		
		
		}
		else
		{
			Yii::log('Unable to find gift details. No checkout id.','info',modelname());
			$this->redirect(array('egift/create'));
		
		}
	}
	
	public function actionEgiftClaim()
	{
		$model=new EmailSent;
		if(isset($_GET['checkout_id']))
		{
			$model->checkout_id=$_GET['checkout_id'];
			//get egift and checkout details
			$model->getGiftDetails();
		}
		//find tansaction related to this checkout
		$txn=SkoobMigsTxn::model()->findByAttributes(array('checkout_id'=>$model->checkout_id));
		if(isset($txn))
		{
			$vc=SkoobPurchasedVouchers::model()->findByAttributes(array('skoob_txn_id'=>$txn->skoob_txn_id));
			if(isset($vc))
			{
				$checkout = Checkout::model()->findByAttributes(array('egift_id'=>$model->egift_id));
				$model->checkout->voucher_no = $vc->voucher_id;
				Yii::log('Generating email for voucher id = '.$vc->voucher_id,'info',modelname());
				//$email_content=$this->renderPartial('egift_claim',array('model'=>$model,'voucher_no'=>$vc->voucher_id),true,true);
				//for testing
				$email_content=$this->renderPartial('egift_claim',array('model'=>$model,'voucher_no'=>$vc->voucher_id),false,true);
				//$subject=sprintf(Yii::app()->globaldef->EMAIL_GIFT_CLAIM_SUBJECT,$model->egift->sender_name);
				//$model->sendEmail($subject, $model->egift->recipient_email, $email_content);
				//$model->save();
				//$this->render('egift_claim',array('model'=>$model));
			}
			else
			{
				Yii::log('Unable to find voucher for checkout id = '.$model->checkout_id,'info',modelname());
				$this->redirect(array('egift/create'));
			}	
		}
		else
		{
			Yii::log('Unable to find transaction for checkout id = '.$model->checkout_id,'info',modelname());
			$this->redirect(array('egift/create'));
		}
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}