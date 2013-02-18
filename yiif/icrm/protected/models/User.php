<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property date $dob
 * @property string $nationality
 * @property string $email
 */
//class User extends CActiveRecord
class User extends CustomActiveRecord extends CustomActiveRecord
{
	const SEX_NA='N';
	const SEX_MALE='M';
	const SEX_FEMALE='F';

	const ROLE_MEMBER='member';
	const ROLE_ADMIN='admin';
	
	const OPT_NO=1;
	const OPT_YES=2;
	
	
	const OPT_SINGLE='Single';
	const OPT_MARRIED='Married';
	const OPT_DIVORCED='Divorced';
	public $password_repeat;
	public $wing_category;
	public $member_type;
	public $user_role;
	public $area_of_interest;
	//will hold the encrypted password for update actions.
    public $initialPassword;
	public $initialUsername;
	public $children=array(); //temp assign as empty arr
	//public $selected_wing;
	public $child_first_name;
	public $child_last_name;
	public $child_dob;
	public $wing_categories;
	public $wing_subcategory;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, username, address, residential_number, sex, marital_status', 'required'),
			array('username, password, email', 'length', 'max'=>128),
			array('email', 'email'),
			array('residential_number,mobile_phone,work_phone,fax_number', 'numerical', 'integerOnly'=>true), //comment out as no need to enter from form
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dob', 'date', 'format'=>'d-M-yyyy'),
			array('id, username, password, email, nationality', 'safe', 'on'=>'search'),
			array('password, password_repeat', 'required', 'on'=>'insert'),
			array('password', 'compare', 'compareAttribute'=>'password_repeat'),
			array('spouse_gender,spouse_name,password_repeat,wing_category,member_type,user_role,area_of_interest,nationality,child_first_name,child_last_name,child_dob,wing_subcategory'
			, 'safe'),
			array('username', 'verify'), //run validation for checking existing user only upon create
			
		);
	}
	/*
	* @ afterValidate function called before returned to ui after things are done
	*/
	public function afterValidate()
	{
			
		Yii::log('User after validate','info','User.afterValidate()');
		if($this->hasErrors())
		{
			Yii::log('setting password empty','info','User.afterValidate()');
			$this->password="";
			$this->password_repeat="";
			
			$i=0;
			//set children array for display, in case of errors
			if( isset($this->child_first_name) )
			{
				foreach($this->child_first_name as $fname)
				{
					
					$this->children[$i]=array('child_first_name'=>$this->child_first_name[$i]
					,'child_last_name'=>$this->child_last_name[$i]
					,'child_dob'=>$this->child_dob[$i]
					);
					$i++;
				}
			}
		}
		return parent::afterValidate();
	}
	public function beforeDelete()
	{
		$current_user_id=$update_user_id=Yii::app()->user->getId();
		if($current_user_id==$this->id)
		{
			Yii::app()->user->setFlash('deleteError','You are unable to delete your own account.');
			return false;
		}	
		else
			return parent::beforeDelete();
	}
	public function beforeSave()
    {
        // in this case, we will use the old hashed password.
        if(empty($this->password) && empty($this->password_repeat) && !empty($this->initialPassword))
		{
			if(!$this->hasErrors())
				$this->password=$this->password_repeat=$this->initialPassword;
		}
		//format dob to be mysql format
		$this->dob=Yii::app()->dateFormatter->format("yyyy-MM-dd",$this->dob);
			 
        return parent::beforeSave();
    }
		
	protected function afterDelete()
    {
		parent::afterDelete();
		//delete related 
		UserAreaOfInterest::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		MembershipFee::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		UserChild::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		WingUserAssignment::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		WingSubUserAssignment::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		UserAreaOfInterest::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		MembershipFee::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		//revoke all assignment for this deleted user
		$assigned_roles = Yii::app()->authManager->getRoles($this->id); //obtains all assigned roles for this user id
		if(!empty($assigned_roles)) //checks that there are assigned roles
		{
			$auth=Yii::app()->authManager; //initializes the authManager
			foreach($assigned_roles as $n=>$role)
			{
				if($auth->revoke($n,$this->id)) //remove each assigned role for this user
					Yii::app()->authManager->save(); //again always save the result
			}
		}
		Yii::log('already deleted all ','info','User.afterDelete');
	}	
		
    public function afterFind()
    {
		Yii::log('the uid retrieved===','info','User.afterFind');

        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->password;
		$this->initialUsername = $this->username;
        //$this->password = null;
		$this->dob=Yii::app()->dateFormatter->format("dd-MM-yyyy",$this->dob);
		$this->getChildren();
	    parent::afterFind();
    }
	
	public function getChildren()
	{
			//get children for this user, if any
		$childrenAsso=UserChild::model()->findAllByAttributes(array('user_id'=>$this->id));
		
		//Yii::log('the size of the association is =='.sizeof($childrenAsso).' user id='.$id);
		
		//$childrenRetArr=array();
		foreach($childrenAsso as $child)
		{
			Yii::log('------found association==='.$child['child_id'].' user_id=='.$child['user_id'],'info','User.afterFind');	
			$childrenRetArr=Child::model()->findByAttributes(array("id"=>$child['child_id']));
		//	Yii::log('--------------trying to find child using id==='.$child['child_id'].' and size==='.sizeof($childrenAsso)	,'info','User.afterFInd');
	//		
			
			if($childrenRetArr['first_name']!='' && $childrenRetArr['last_name']!='' && $childrenRetArr['dob']!='')
				$this->children[]=array('child_first_name'=>$childrenRetArr['first_name'],'child_last_name'=>$childrenRetArr['last_name'],
				'child_dob'=>Yii::app()->dateFormatter->format("dd-MM-yyyy",$childrenRetArr['dob']));
		}
    
	}
	
	public function saveModel($data=array())
    {
            //because the hashes needs to match
            if(!empty($data['password']) && !empty($data['password_repeat']))
            {
                $data['password'] = Yii::app()->user->hashPassword($data['password']);
                $data['password_repeat'] = Yii::app()->user->hashPassword($data['password_repeat']);
            }
			
            $this->attributes=$data;
 
            if(!$this->save())
                return CHtml::errorSummary($this);
			
         return true;
    }
	
	/**
	* Authenticates the existence of the user in the system.
	* This is the 'verify' validator as declared in rules().
	*/
	public function verify($attribute,$params)
	{
		
		if(!$this->hasErrors()) // we only want to authenticate when no other input errors are present
		{
			if($this->userExists())
			{
				
				$this->addError('username','This user with the username \''.$this->username.'\' has already been added.');
				$this->password = "";
				$this->password_repeat = "";
				$this->username = $this->initialUsername;
			}
			else
			{
				Yii::log('going to check dob','info','User.verify');
		
				//ensure that all child first name is filled up
				if(isset($this->child_first_name) || isset($this->child_last_name))
				{
					foreach($this->child_first_name as $fname)
					{
						$fname=trim($fname);
						if(null===$fname || $fname==="")
						{
							$this->addError('child_first_name','Please enter the Child First Name');
						}
					}
				}
		
			//ensure that all child last name is filled up
				if(isset($this->child_last_name))
				{
					foreach($this->child_last_name as $lname)
					{
						$lname=trim($lname);
						if(null===$lname || $lname==="")
						{
							$this->addError('child_lirst_name','Please enter the Child Last Name');
						}
					}
				}
		
		
				//do other validation
				//check if children dob is valid
				if(isset($this->child_dob))
				{
					Yii::log('before for loop','info','User.verify');
					foreach($this->child_dob as $dob)
					{
						
						if(!CDateTimeParser::parse($dob,'dd-MM-yyyy'))
							$this->addError('child_dob','Please enter a valid date for Child Date Of Birth');
					}
				}//if isset child_dob
			}//if user does not exist
		}//if don't have errors
		
		if($this->hasErrors())
		{
			//re-init children array according to ui
			$this->children=array();
			if( isset($this->child_first_name) )
			{
				$i=0;
				foreach($this->child_first_name as $fname)
				{
					Yii::log('adding the name of '.$fname,'info','User.verify');
					$this->children[$i]=array('child_first_name'=>$this->child_first_name[$i]
					,'child_last_name'=>$this->child_last_name[$i]
					,'child_dob'=>$this->child_dob[$i]
					);
					$i++;
				}
			}
		
		}
	}

	/**
	* @return boolean whether or not the current user exists
	*/
	public function userExists()
	{
		if(
			$this->initialUsername!='' && $this->initialUsername!=$this->username
			||
			$this->initialUsername==''
		)
		{
		$sql = "SELECT 1 FROM tbl_user WHERE username=:userName";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userName", $this->username, PDO::PARAM_STR);
		$res=$command->execute();
		return $res==1 ? true : false;
		}
		else
			return false;
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
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'sex' => 'Sex',
			'dob' => 'Date of Birth',
			'nationality' => 'Nationality',
			'address' => 'Address',
			'marital_status' => 'Marital Status',
			'spouse_name' => 'Spouse Name',
			'spouse_gender' => 'Spouse Gender',
			'residential_number' => 'Residential Number',
			'mobile_phone' => 'Mobile Phone',
			'work_phone' => 'Work Phone',
			'fax_number' => 'Fax Number',
			'wing_category' => 'Wing Category',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getMemberTypeOptions()
	{
		$ret_arr=array();
		$array = Yii::app()->db->createCommand('SELECT id,name FROM tbl_member_type')->queryAll();
		for($i=0;$i<sizeof($array);$i++)
		{
			$ret_arr[$array[$i]['id']]=$array[$i]['name'];
		}
		return $ret_arr;
	}
	public function getUserWingSubCat()
	{
		$ret_arr=array();
		$recs=WingSubUserAssignment::model()->findAllByAttributes(array('user_id'=>$this->id));
		foreach($recs as $rec)
		{
			$ret_arr[]=$rec->wing_subcategory_id;
		}
		return $ret_arr;
	}
	public function getUserWingCat()
	{
		$ret_arr=array();
		$sql = "SELECT b.wing_category_id "
		." FROM tbl_user a "
		." INNER JOIN tbl_wing_user_assignment b "
		." ON a.id=b.user_id "
		." where user_id=:userId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $this->id, PDO::PARAM_INT);
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			$ret_arr[]=$row['wing_category_id'];
		}
		
		return $ret_arr;
	}
	
	public function getWingOptions()
	{
		
		$ret_arr=array();
		$array = Yii::app()->db->createCommand('SELECT id,name FROM tbl_wing_category')->queryAll();
		for($i=0;$i<sizeof($array);$i++)
		{
			$ret_arr[$array[$i]['id']]=$array[$i]['name'];
		}
		//get selected checkbox if any
		//$this->selected_wing= array('1','2');
		
		$sql = "SELECT wing_category_id FROM tbl_wing_user_assignment where user_id=:userId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $this->id, PDO::PARAM_INT);
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			$this->wing_category[]=$row['wing_category_id'];
		}
		
		//$ret_arr = array('item1'=>'Item One','item2'=>'Item Two','item3'=>'Item Three');
		return $ret_arr;
	}
	
	public function getUserRoleOptions()
	{
		return array(
			self::ROLE_MEMBER=>'Member',
			self::ROLE_ADMIN=>'Admin'
		);
	}
		
	
	/**
	* @return array sex type names indexed by type IDs
	*/
	public function getSexTypeOptions()
	{
		return array(
		self::SEX_MALE=>'Male',
		self::SEX_FEMALE=>'Female',
		
		);
	}

	/**
	* @return array sex type names indexed by type IDs
	*/
	public function getOptSexTypeOptions()
	{
		return array(
		self::SEX_NA=>'N.A.',
		self::SEX_MALE=>'Male',
		self::SEX_FEMALE=>'Female',
		
		);
	}
	
	/**
	* @return array yes no values for combo box
	*/
	public function getYesNoOpt()
	{
		return array(
		self::OPT_NO=>'No',
		self::OPT_YES=>'Yes',
		
		);
	}
	
	/**
	* @return array marital status values for combobox
	*/
	public function getMaritalStatusOpt()
	{
		return array(
		self::OPT_SINGLE=>'Single',
		self::OPT_MARRIED=>'Married',
		self::OPT_DIVORCED=>'Divorced',
		);
	}
	
	/**
	* @return string the type text display for the current sex
	*/
	public function getSexText()
	{
		$getSexTypeOptions=$this->sexTypeOptions;
		return isset($getSexTypeOptions[$this->sex]) ? $getSexTypeOptions[$this->sex] : "unknown type ({$this->sex})";
	}
	
	/**
	* @return string the type text display for the current sex
	*/
	public function getYesNoText()
	{
		$getYesNoOpt=$this->yesNoOpt;
		return isset($getYesNoOpt[$this->is_member]) ? $getYesNoOpt[$this->is_member] : "unknown type ({$this->sex})";
	}
	
	private function associateUserToAreaOfInterest()
	{
		$rec=$this->findByAttributes(array('username'=>$this->username));
		
		if(isset($rec))
		{
			$uid=$rec->id;
			$create_user_id=$update_user_id=Yii::app()->user->getId();
			Yii::log('retrieved user id==='.$rec->id,'info','associateUserToAreaOfInterest');
			if($uid!=-1)
			{
				//delete all records for this user first
				$sql = "DELETE FROM tbl_user_area_of_interest WHERE user_id=:userId ";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindValue(":userId", $uid, PDO::PARAM_INT);
				$command->execute();
				
				if(is_array($this->area_of_interest) && isset($this->area_of_interest) && sizeof($this->area_of_interest)>0)
				{
					
					for($i=0; $i<sizeof($this->area_of_interest); $i++)
					{	
						$aoi=$this->area_of_interest[$i];
						
						$sql = "INSERT INTO tbl_user_area_of_interest (area_of_interest_id, user_id,create_dt,create_user_id,update_dt,update_user_id) "
						." VALUES (:aoId, :userId, NOW(), :createUserID, NOW(), :updateUserID)";
						$command = Yii::app()->db->createCommand($sql);
						$command->bindValue(":aoId", $aoi, PDO::PARAM_INT);
						$command->bindValue(":userId", $uid, PDO::PARAM_INT);
						$command->bindValue(":createUserID", $create_user_id, PDO::PARAM_INT);
						$command->bindValue(":updateUserID", $update_user_id, PDO::PARAM_INT);
						$command->execute();
				
					}//inner for
				}//inner if
			}//if($uid!=-1)
			
		}//if set
	}
	
	/**
	* Makes an association between a user and a wing
	*/
	public function associateUserToWingCategory($user_id)
	{
		$uid=-1;
		$rec=$this->findByAttributes(array('username'=>$this->username));
		if(isset($rec))
			$uid=$rec->id;
		//insert wing id and user id into association table
		//foreach($this->wing_category as $wc)
		//	Yii::log('wcid============ '.$wc,'info','associateUserToWingCategory');

		
		Yii::log('the uid retrieved==='.$uid,'info','User.associateUserToWingCategory');
		if($uid!=-1)
		{
			//get current user id
			$create_user_id=$update_user_id=Yii::app()->user->getId();
			
			//delete all records for this user first for wing subcategory
			WingSubUserAssignment::model()->deleteAllByAttributes(array('user_id'=>$this->id));
			if(is_array($this->wing_subcategory) && isset($this->wing_subcategory) && sizeof($this->wing_subcategory)>0)
			{
				for($i=0; $i<sizeof($this->wing_subcategory); $i++)
				{	
					
					$ws_id=$this->wing_subcategory[$i];
					Yii::log('===inserting ws_id=='.$ws_id,'info','WinSubUserAssignment');
					$ws = new WingSubUserAssignment;
					$ws->attributes=array('wing_subcategory_id'=>$ws_id,'user_id'=>$this->id);
					$ws->save();
				}
			}				
			
			//delete all records for this user first for wing category
			$sql = "DELETE FROM tbl_wing_user_assignment WHERE user_id=:userId ";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindValue(":userId", $user_id, PDO::PARAM_INT);
			$command->execute();
			
			if(is_array($this->wing_category) && isset($this->wing_category) && sizeof($this->wing_category)>0)
			{
				for($i=0; $i<sizeof($this->wing_category); $i++)
				{	
					$wcid=$this->wing_category[$i];
						
					Yii::log('trying to insert into wing user assign uid='.$user_id.' wing = '.$wcid,'info','User.associateUserToWingCategory');
					$sql = "INSERT INTO tbl_wing_user_assignment (wing_category_id, user_id,create_dt,create_user_id,update_dt,update_user_id) "
					." VALUES (:wingCatId, :userId, NOW(), :createUserID, NOW(), :updateUserID)";
					$command = Yii::app()->db->createCommand($sql);
					$command->bindValue(":wingCatId", $wcid, PDO::PARAM_INT);
					$command->bindValue(":userId", $user_id, PDO::PARAM_INT);
					$command->bindValue(":createUserID", $create_user_id, PDO::PARAM_INT);
					$command->bindValue(":updateUserID", $update_user_id, PDO::PARAM_INT);
					$command->execute();
			
				}	
			}
		}
		
	}
	
	public function getUserRoleText()
	{
		$retStr='';
		$auth = Yii::app()->authManager;
		$authArr = $auth->getAuthAssignments($this->id);
		foreach($authArr as $auth)
		{
			Yii::log('the authentication assign == key = '.$auth->getItemName(),'info','User.getUserRoleText');
			
			$retStr.=$auth->getItemName();
			if(sizeof($authArr)>1)
				$retStr.=',';
		}
		
		return $retStr;	
	}
	
	private function associateUserToMembershipFee()
	{
		$rec=MembershipFee::model()->findByAttributes(array('user_id'=>$this->id));
		
		if(!isset($rec))
		{
			$create_user_id=$update_user_id=Yii::app()->user->getId();
	
			$sql = "INSERT INTO tbl_membership_fee (user_id,username,member_type_id, create_dt,create_user_id,update_dt,update_user_id) "
				." VALUES (:userId,:userName,:memberTypeID, NOW(), :createUserID, NOW(), :updateUserID)";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$command->bindValue(":userName", $this->username, PDO::PARAM_STR);
			$command->bindValue(":memberTypeID", $this->member_type, PDO::PARAM_STR);
			$command->bindValue(":createUserID", $create_user_id, PDO::PARAM_INT);
			$command->bindValue(":updateUserID", $update_user_id, PDO::PARAM_INT);
			$command->execute();
		
		}
	}
	
	private function associateUserToRole()
	{
		$auth = Yii::app()->authManager;

			
		//remove assignment before adding
		//one user can only have one role
		if( isset($this->id) && $this->id > 0)
		{
			$assignments=$auth->getAuthAssignments($this->id);
			foreach($assignments as $assignment)
			{
				$auth->revoke($assignment->itemname,$this->id);
			}
			/*
			$sql = "DELETE FROM authassignment WHERE userid=:userId ";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindValue(":userId", $this->id, PDO::PARAM_INT);
			$command->execute();*/
		}
		
		//check if the user has been assigned
		$is_assigned=$auth->isAssigned($this->user_role,$this->id);
		if(!$is_assigned)
		{
			$auth->assign($this->user_role,$this->id);
		}	
	}
	
	private function associateUserToChild()
	{
		//delete association first
		UserChild::model()->deleteAllByAttributes(array("user_id"=>$this->id));
		
		//save data to child table
		if(isset($this->child_first_name))
		{
			for($i=0;$i<sizeof($this->child_first_name);$i++)
			{
				//echo 'child name==='.$cname;
				$child=new Child;
				$this->child_dob[$i]=Yii::app()->dateFormatter->format("yyyy-MM-dd",$this->child_dob[$i]);
				
				//find to see if child particulars exist
				$rec=User::model()->findByAttributes(array('first_name'=>$this->child_first_name[$i],'last_name'=>$this->child_last_name[$i],'dob'=>$this->child_dob[$i]));
				$child->attributes=array('first_name'=>$this->child_first_name[$i],'last_name'=>$this->child_last_name[$i],'dob'=>$this->child_dob[$i]);
				$saveRes=false;
				if(!$rec)
					$saveRes=$child->save();
				else
					$saveRes=true;
				if($saveRes===true)
				{
					//save association
					$asso=new UserChild;
					$asso->attributes=array('user_id'=>$this->id,'child_id'=>$child->id,'create_dt'=>new CDbExpression('NOW()'),'create_user_id'=>Yii::app()->user->getId());
					$asso->save();
				}
				else
				{
					Yii::log('==================>saved child model failed='.CHtml::errorSummary($child),'info','User.afterSave');
				}
			}
			
			
		}
		
	}
	
	protected function afterSave()
	{
		Yii::log('==================>aftersave','info','User.associateUserToWingCategory');
		
		
		//add child to child table
		$this->associateUserToChild();
		
		//add wing category and user assignment
		
		$this->associateUserToAreaOfInterest();
		
		$this->associateUserToWingCategory($this->id);
		if(isset($this->user_role) && null!=$this->user_role && ''!=$this->user_role)
			$this->associateUserToRole();
		//create membership fee record
		$this->associateUserToMembershipFee();	
		/*
		$bal = User::model()->findByPk(Yii::app()->user->id);
		$bal->balance = ($bal->balance - $this->amount);
		$bal->save(false);
		*/
		parent::afterSave();
	}	

}

