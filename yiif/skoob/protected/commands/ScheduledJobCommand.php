<?php

	
	
class ScheduledJobCommand extends CConsoleCommand
{
	const MODEL_NAME='ScheduledJobCommand';
	
	public function actionSendEmail()
	{
		$logPrefix = self::MODEL_NAME.'.actionSendEmail';
		Yii::log('Start of action to send email','info',$logPrefix);
		//echo 'start';
		$model=new Egift;
		//find gifts to be delivered on this date
		$gifts=Egift::model()->findAllByAttributes(array('delivery_date'=>date('Y-m-d')));
		$checkouts=array();
		if(isset($gifts))
		{
			Yii::log('Found egifts to be delivered today ('.date('Y-m-d').'). Total='.sizeof($gifts),'info',$logPrefix);
			
			$egift_ids='';
			foreach($gifts as $gift)
			{
				//echo '\n id=='.$gift->id;
				
				//concat ids
				$egift_ids.=($egift_ids=='')?$gift->id:','.$gift->id;
				//Yii::log('the gift id'.$gift->id,'info','asdasd');
				$checkout=Checkout::model()->findByAttributes(array('egift_id'=>$gift->id));
				if(isset($checkout))
				{
					Yii::log('Found checkout for egift id '.$gift->id.'. Proceed to find transaction','info',$logPrefix);
					$gift->getGiftCardImg();
					$checkout->egift=$gift;
					$checkouts[]=$checkout;
					
					$txn = SkoobMigsTxn::model()->findByAttributes(array('checkout_id'=>$checkout['id']));
					
					if(isset($txn))
					{
						Yii::log('The transaction for checkout id '.$checkout['id'].'. found. Proceed to find voucher.','info',$logPrefix);
						
						$vc = SkoobPurchasedVouchers::model()->findByAttributes(array('skoob_migs_txn_id'=>$txn['id']));
						
						if(isset($vc))
						{
							$checkout->voucher_no=$vc->voucher_id;
							Yii::log('The purchased voucher for transaction id '.$txn['id'].' is found. Proceed to send email','info',$logPrefix);
							$this->sendDeliveredGift($checkout);
							
							$this->sendClaimGift($checkout);
						}
						else
						{
							Yii::log('Unable to find purchased voucher for transaction id '.$txn['id'].' is found. Not sending email.','info',$logPrefix);
							
						}
					}
					else
					{
						Yii::log('The transaction for checkout id '.$checkout['id'].'. not found.','info',$logPrefix);
					}
				}
			}
			
			if(isset($checkouts) && sizeof($checkouts)>0)
			{
				Yii::log('Checkouts found. Proceed to check if purchased.','info',$logPrefix);
				
				//check if voucher has been found before sending email
				
			}
			else
			{
				Yii::log('No checkouts found.','info',$logPrefix);
			}
		}
		else
		{
			Yii::log('No egifts to be delivered today','info',$logPrefix);
		}
		
		Yii::log('End of action','info',$logPrefix);
	}
    public function actionIndex($type, $limit=5) { 
		Yii::log('hello there.....','debug','ScheduledJobCommand.actionIndex');
		echo '456';
	}
    public function actionInit() { 
		echo '122333';
	}
	
	private function sendDeliveredGift($checkout)			
	{
		$logPrefix = self::MODEL_NAME.'.sendDeliveredGift';
		$model=new EmailSent;
		$model->checkout_id=$checkout['id'];
		//get egift and checkout details
		$model->egift=$checkout->egift;
		$model->egift_id=$checkout->egift_id;
		$url = Yii::getPathOfAlias('application.views.emailSent').'/delivered_egift.php';
		Yii::log('URL==='.$url,'info',$logPrefix);
		$email_content=$this->renderFile($url,array('model'=>$model,'globaldef'=>Yii::app()->globaldef),true);
		//Yii::log('file content==='.$email_content,'info',$logPrefix);
		//for testing
		//$email_content=$this->renderPartial('delivered_egift',array('model'=>$model),false,true);
		$subject=sprintf(Yii::app()->globaldef->EMAIL_DELIVERED_GIFT_SUBJECT,$model->checkout_id);
		Yii::log('checkout id==='.$model->checkout_id.' egift id=='.$model->egift_id,'info',$logPrefix);
		$model->email_type=Yii::app()->globaldef->EMAIL_SENT_TYPE_DELIVERED;
		//check if email has been sent before sending again
		if($model->emailExists())
		{
			Yii::log('Email has already been sent out. Not going to send again.','info',$logPrefix);
		}
		else
		{
			Yii::log('Email has not been sent out. Sending email.','info',$logPrefix);
			$model->sendEmail($subject, $checkout->sender_email_add, $email_content);
			
			if($model->save())
			{
				Yii::log('Saved email sent out.','info',$logPrefix);
			}
			else
			{
				Yii::log('Unable to save email sent out.','info',$logPrefix);
			}
		}
	}
	
	private function sendClaimGift($checkout)			
	{
		$logPrefix = self::MODEL_NAME.'.sendClaimGift';
		$model=new EmailSent;
		$model->checkout_id=$checkout['id'];
		//get egift and checkout details
		$model->egift=$checkout->egift;
		$model->egift_id=$checkout->egift_id;
		$model->checkout=$checkout;
		$url = Yii::getPathOfAlias('application.views.emailSent').'/egift_claim.php';
		
		$email_content=$this->renderFile($url,array('model'=>$model,'globaldef'=>Yii::app()->globaldef),true);
		//Yii::log('file content==='.$email_content,'info',$logPrefix);
		//$email_content='';
		//for testing
		//$email_content=$this->renderPartial('delivered_egift',array('model'=>$model),false,true);
		$subject=sprintf(Yii::app()->globaldef->EMAIL_GIFT_CLAIM_SUBJECT,$model->egift->sender_name);
		//$subject='abc';
		$model->email_type=Yii::app()->globaldef->EMAIL_SENT_TYPE_CLAIM;
		if($model->emailExists())
		{
			Yii::log('Email has already been sent out. Not going to send again.','info',$logPrefix);
		}
		else
		{
			$model->sendEmail($subject, $model->egift->recipient_email, $email_content);
			
			$model->save();
		}
	}
}

?>