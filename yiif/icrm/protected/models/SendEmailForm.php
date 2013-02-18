<?php

/**
 * SendEmailForm class.
 * SendEmailForm is the data structure for allowing users to send email
 */
class SendEmailForm extends CFormModel
{
	//public $name;
	//public $email;
	//public $subject;
	//public $verifyCode;
	public $wing_category;
	public $wing_subcategory;
	public $area_of_interest;
	//public $produce;
	public $email_content;
	public $filter_wing_category;
	public $filter_area_of_interest;
	public $member_types;
	public $subject;
	const EVERYBODY ='Everybody';
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			//array('wing_category,email_content', 'required'),
			// email has to be a valid email address
			//array('email', 'email'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			array('area_of_interest, wing_category, email_content,wing_subcategory,filter_area_of_interest,filter_wing_category,member_types,subject', 'safe'),
			array('email_content', 'verify'),
		);
	}
	/**
	* Authenticates the existence of the user in the system.
	* If valid, it will also make the association between the user,
	role and project
	* This is the 'verify' validator as declared in rules().
	*/
	public function verify($attribute,$params)
	{
		
		if(!$this->hasErrors())
		{
			$emails_to_send=array();
			/*
			if($this->wing_category==1)
			{
				$this->addError('wing_category','Please choose a Wing Category.');
			}*/
			
			if(!is_array($this->member_types) || sizeof($this->member_types)==0)
			{
				$this->addError('member_types','Please select a member type.');
			}
			if($this->filter_wing_category[0]==1)
			{
				if(sizeof($this->wing_category)==0 && sizeof($this->wing_subcategory)==0)
				{
					$this->addError('filter_wing_category','Please select a wing or wing subcategory.');
				}
			}
			if($this->filter_area_of_interest[0]==1)
			{
				
				if(!is_array($this->area_of_interest) || sizeof($this->area_of_interest)==0)
				{
					$this->addError('filter_area_of_interest','Please select an area of interest.');
				}
			}
			if($this->subject=='')
			{
				$this->addError('subject','Please enter the email subject.');
			}
			if($this->email_content=='')
			{
				$this->addError('email_content','Please enter the email content to send.');
			}
				
			//proceed to send only if have no errors	
			if(!$this->hasErrors())
			{
				//send to people under this group
				$wing_cat_email=array();
				$wing_subcat_email=array();
				$area_interest_email=array();
				$mem_types='';
				if(is_array($this->member_types) && isset($this->member_types) && sizeof($this->member_types)>0)
				{
					$mem_types=implode("','",$this->member_types);
					$mem_types="'".$mem_types."'";
				}
				Yii::log('memtypes'.$mem_types.' strpos='.strpos($mem_types,self::EVERYBODY),'info','SendEmailForm.verify');
				if( 
					!(strpos($mem_types,self::EVERYBODY)===false) 
					&&
					$this->filter_wing_category[0]==0
					&&
					!is_array($this->area_of_interest) || sizeof($this->area_of_interest)==0
				)
				{
					//send email to everyone
					$users=User::model()->findAll();
					foreach($users as $user)
						$emails_to_send[]=$user['email'];
							
				}
				else
				{
					$filtered_uid_str='';
					$filtered_uids=array();
					//get members id
					$sql = "select a.id,email from tbl_user a "
						." inner join tbl_member_type b "
						." on a.member_type=b.id "
						." and b.name in ({$mem_types})"
						;
					$command = Yii::app()->db->createCommand($sql);
					$dataReader=$command->query();
					// calling read() repeatedly until it returns false
					while(($row=$dataReader->read())!==false) { 
						$email_add=$row['email'];
						$user_id=$row['id'];
						$filtered_uids[]=$user_id;
						$emails_to_send[]=$email_add;
					}
					$filtered_uid_str=implode(',',$filtered_uids);
					Yii::log('imploded===='.$filtered_uid_str,'info','EmailFormToSend.verify');
					$interests='';
					if(is_array($this->area_of_interest) && isset($this->area_of_interest) && sizeof($this->area_of_interest)>0)
					{
						$interests=implode(',',$this->area_of_interest);
					}	
					Yii::log('the area of interest string=='.$interests,'info','SendEmailForm.verify');
					//wing category
					$wingcats='';
					if(is_array($this->wing_category) && isset($this->wing_category) && sizeof($this->wing_category)>0)
					{
						$wingcats=implode(',',$this->wing_category);
					}	
					
					//wing subcategory
					$wingcatsub='';
					if(is_array($this->wing_subcategory) && isset($this->wing_subcategory) && sizeof($this->wing_subcategory)>0)
					{
						$wingcatsub=implode(',',$this->wing_subcategory);
					}
					Yii::log('the wingsubcat=='.$wingcatsub,'info','SendEmailForm.verify');
					//get all people under all selected wing sub category
					if($wingcatsub!='' && $this->email_content!='')
					{
						if(is_array($this->member_types) && isset($this->member_types) && sizeof($this->member_types)>0)
						{
							$sql = "select distinct a.id,email from tbl_user a "
							." inner join tbl_wing_sub_user_assignment b "
							." on a.id=b.user_id "
							." inner join tbl_member_type c "
							." on a.member_type=c.id "
							." where c.name in ({$mem_types}) "
							." AND wing_subcategory_id in ({$wingcatsub})"
							;
							
						}
						else
						{
							$sql = "select distinct a.id,email from tbl_user a "
							." inner join tbl_wing_sub_user_assignment b "
							." on a.id=b.user_id "
							." WHERE wing_subcategory_id in ({$wingcatsub})"
							;
						}
						$command = Yii::app()->db->createCommand($sql);
						$dataReader=$command->query();
						// calling read() repeatedly until it returns false
						while(($row=$dataReader->read())!==false) { 
							$email_add=$row['email'];
							$user_id=$row['id'];
							if(null!==$email_add && $email_add!='')
								$wing_subcat_email[]=array('user_id'=>$user_id,'email'=>$email_add);
							Yii::log('the email address to use for sub cat====='.$email_add,'info','SendEmailForm.verify');
						}
						
						
					}
					$all_interests= false;
					
					
					//Yii::log('size of aoi=='.sizeof($this->area_of_interest),'info','SendEmailForm.send');
					$all_interests= ($interests!='' && in_array(0, $this->area_of_interest)) ?true:false;
				
					//get all people from the area of interest
					if( $interests!='' && $all_interests && $this->email_content!='')
					{
						if(is_array($this->member_types) && isset($this->member_types) && sizeof($this->member_types)>0)
						{
							$sql = "select distinct a.id,email from tbl_user a "
							." inner join tbl_user_area_of_interest b "
							." on a.id=b.user_id "
							." inner join tbl_member_type c "
							." on a.member_type=c.id "
							." where c.name in ({$mem_types}) "
							;
								
						}
						else
						{
							$sql = "select distinct a.id,email from tbl_user a "
							." inner join tbl_user_area_of_interest b "
							." on a.id=b.user_id ";
						
						}
					
						$command = Yii::app()->db->createCommand($sql);
						$dataReader=$command->query();
						// calling read() repeatedly until it returns false
						while(($row=$dataReader->read())!==false) { 
							$email_add=$row['email'];
							$user_id=$row['id'];
							if(null!==$email_add && $email_add!='')
								$area_interest_email[]=array('user_id'=>$user_id,'email'=>$email_add);
						}
					}
					else if( $interests!='' &&  !$all_interests  && $this->email_content!='')
					{
						if(is_array($this->member_types) && isset($this->member_types) && sizeof($this->member_types)>0)
						{
							$sql = "select  distinct a.id,email from tbl_user a "
							." inner join tbl_user_area_of_interest b "
							." on a.id=b.user_id "
							." inner join tbl_member_type c "
							." on a.member_type=c.id "
							." where c.name in ({$mem_types}) "
							." and area_of_interest_id in (".$interests.")";
							
						}
						else
						{
							$sql = "select  distinct a.id,email from tbl_user a "
							." inner join tbl_user_area_of_interest b "
							." on a.id=b.user_id "
							." where area_of_interest_id in (".$interests.")";
							
						}
					
						
						Yii::log('area of interest sql '.$sql,'info','EmailFormToSend.verify');
						$command = Yii::app()->db->createCommand($sql);
						$dataReader=$command->query();
						// calling read() repeatedly until it returns false
						while(($row=$dataReader->read())!==false) { 
							$email_add=$row['email'];
							$user_id=$row['id'];
							if(null!==$email_add && $email_add!='')
							{
								$area_interest_email[]=array('user_id'=>$user_id,'email'=>$email_add);
						//		Yii::log('the email address to use for AREA OF INTEREST ====='.$email_add,'info','SendEmailForm.verify');
							}	
						}
					}
					Yii::log('AREA OF INTEREST===== '.$this->area_of_interest.'no of area of interest email to send='.sizeof($area_interest_email),'info','verify');
					//get all people from the wing category
					$allWing=($wingcats!='' && in_array(0, $this->wing_category))?true:false;
					if( $wingcats!='' && $allWing  && $this->email_content!='')
					{
					
						if(is_array($this->member_types) && isset($this->member_types) && sizeof($this->member_types)>0)
						{
							$sql = "select distinct a.id,email from tbl_user a "
							." inner join tbl_wing_user_assignment b "
							." on a.id=b.user_id "
							." inner join tbl_member_type c "
							." on a.member_type=c.id "
							." where c.name in ({$mem_types}) "
							;
						
						}
						else
						{
							$sql = "select distinct a.id,email from tbl_user a "
							." inner join tbl_wing_user_assignment b "
							." on a.id=b.user_id ";
						
						}
					
							
						$command = Yii::app()->db->createCommand($sql);
						$dataReader=$command->query();
						// calling read() repeatedly until it returns false
						while(($row=$dataReader->read())!==false) { 
							$email_add=$row['email'];
							$user_id=$row['id'];
							if(null!==$email_add && $email_add!='')
								$wing_cat_email[]=array('user_id'=>$user_id,'email'=>$email_add);
						}
						
					}
					else if( $wingcats!='' && !$allWing  && $this->email_content!='')
					{
						if(is_array($this->member_types) && isset($this->member_types) && sizeof($this->member_types)>0)
						{

							$sql = "select  distinct a.id,email from tbl_user a "
							." inner join tbl_wing_user_assignment b "
							." on a.id=b.user_id "
							." inner join tbl_member_type c "
							." on a.member_type=c.id "
							." where c.name in ({$mem_types}) "
							." and wing_category_id in(".$wingcats.")";
							
							
						}
						else
						{
							$sql = "select  distinct a.id,email from tbl_user a "
							." inner join tbl_wing_user_assignment b "
							." on a.id=b.user_id "
							." where wing_category_id in(".$wingcats.")";
							
						}
					
					
						
						$command = Yii::app()->db->createCommand($sql);
						
						$dataReader=$command->query();
						// calling read() repeatedly until it returns false
						while(($row=$dataReader->read())!==false) { 
							$email_add=$row['email'];
							$user_id=$row['id'];
							if(null!==$email_add && $email_add!='')
								$wing_cat_email[]=array('user_id'=>$user_id,'email'=>$email_add);
						}

					}
					
					Yii::log('wing cat email no of email to send='.sizeof($wing_cat_email),'info','verify');
					
					
					//copy area of interest first
					if( sizeof($area_interest_email)>0)
					{
						foreach($area_interest_email as $aie)
						{
						
							if(!in_array($aie['email'],$emails_to_send))
								$emails_to_send[]=$aie['email'];
						}
					}
					
					
					
					if( sizeof($wing_cat_email)>0)
					{
						if($allWing)
						{
							foreach($wing_cat_email as $wce)
							{
								if(!in_array($wce['email'],$emails_to_send))
									$emails_to_send[]=$wce['email'];
							}
						
						}
						else
						{
							for($i=0;$i<sizeof($emails_to_send);$i++)
							{
								$found=false;
								foreach($wing_cat_email as $wce)
								{
									Yii::log('i=='.$i.' size of emails to send '.sizeof($emails_to_send),'info','wing_cat_email');
									if( $emails_to_send[$i]==$wce['email'] )
										$found=true;
									
								}
								if(!$found)
								{
								Yii::log('unset i===='.$i,'info','wing_cat_email');
									unset($emails_to_send[$i]);
									$emails_to_send=array_values($emails_to_send);
									$i--;
								}	
							}
						}//if(allWing)
					}
					
					if( sizeof($wing_subcat_email)>0)
					{
						if(sizeof($emails_to_send)==0)
						{
							foreach($wing_subcat_email as $wce)
							{
								if(!in_array($wce['email'],$emails_to_send) )
									$emails_to_send[]=$wce['email'];
							}
						}
					
						for($i=0;$i<sizeof($emails_to_send);$i++)
						{
							$found=false;
							foreach($wing_subcat_email as $wce)
							{
								if( $emails_to_send[$i]==$wce['email'] )
								{
								Yii::log('found email===='.$wce['email'],'info','SendEmailForm.send');
									$found=true;
					
								}
								if( 
								
									!in_array($wce['email'],$emails_to_send) && $allWing
									
									) //if not found in current email list, can add to it as all wing categories is selected or no wing selected
								{
									$emails_to_send[]=$wce['email'];
								}
							}
							
							
							if(!$found && !$allWing) //remove the email if not found. only applicable if 'All Wing Categories' is not selected
							{
								Yii::log('removing email===='.$emails_to_send[$i],'info','SendEmailForm.send');
								unset($emails_to_send[$i]);
								$emails_to_send=array_values($emails_to_send);
								$i--;
							}
							
						}//for loop wing subcat email
										
					}
					
				}//if not all members are selected	
				
				if( 
					
					($this->filter_wing_category[0]==1 && sizeof($wing_cat_email)==0 && sizeof($wing_subcat_email)==0 )
					||
					($this->filter_area_of_interest[0]==1 && sizeof($area_interest_email)==0)
				)	
				{
					$emails_to_send=array();
				}
				

						Yii::log('total emails to send......'.sizeof($emails_to_send),'info','SendEmailForm.send');
				foreach($emails_to_send as $email_add)
					Yii::log('assign final '.$email_add,'info','SendEmailForm.send');
				//code to send email - un comment for actual sending
				foreach($emails_to_send as $email_add)
					$this->sendEmail($this->subject,$email_add, $this->email_content);
			}//inner if(!$this->hasErrors())
		}//outer if(!$this->hasErrors())
	}
	
	/*
	* Function to enable sending of email using extension
	*/
	private function sendEmail($subject, $recipient, $message)
	{
		Yii::import('ext.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$message->setBody($this->email_content, 'text/html');
		$message->subject = $subject;
		$message->from = Yii::app()->params['adminEmail'];

		$message->addTo($recipient);
		
		$res=Yii::app()->mail->send($message);
	/*	
	// the email to validate
	$email = $recipient;
	// an optional sender
	$sender = Yii::app()->params['adminEmail'];
	// instantiate the class
	$SMTP_Valid = new SMTP_validateEmail();
	// turn debugging on to view the SMTP session
	$SMTP_Valid->debug = true;
	// do the validation
	$result = $SMTP_Valid->validate(array($recipient), $sender);
	// view results
	var_dump($result);
	Yii::log( $recipient.' is '.($result ? 'valid' : 'invalid'),'info','SendEmailForm.sendEmail');
*/
		
		
	}
	
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			//'verifyCode'=>'Verification Codesss',
			'wing_category'=>'Wing Category',
			'email_content'=>'Email Content',
		);
	}

	public function getAreaOfInterest()
	{
		$ret_arr=array();
		$ret_arr[0]='All Interests';
		$allInterest=AreaOfInterest::model()->findAll();
		
		for($i=0;$i<sizeof($allInterest);$i++)
		{
			$ret_arr[$allInterest[$i]['id']]=$allInterest[$i]['name'];
		}
		return $ret_arr;
	}
	
	/**
	 * Gets all wings as drop down list options
	 */
	
	public function getWingOptions()
	{
		$ret_arr=array();
		
		//set one for all wing
		$ret_arr[0]='All Wings';
		
		$array = Yii::app()->db->createCommand('SELECT id,name FROM tbl_wing_category')->queryAll();
		for($i=0;$i<sizeof($array);$i++)
		{
			$ret_arr[$array[$i]['id']]=$array[$i]['name'];
		}
		return $ret_arr;
	}

	public function getMemberCategoryOpt()
	{
		$ret_arr=array();
			
		$ret_arr['Everybody']=self::EVERYBODY;	
		$memTypes=MemberType::model()->findAll();
		foreach($memTypes as $member)
			$ret_arr[$member['name']]=$member['name'];
		return $ret_arr;
	}
}