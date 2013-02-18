<?php

/**
 * This is the model class for table "tbl_membership_fee".
 *
 * The followings are the available columns in table 'tbl_membership_fee':
 * @property string $user_id
 * @property string $last_paid_dt
 * @property string $next_paid_dt
  * @property string $create_dt
 * @property string $create_user_id
 * @property string $update_dt
 * @property string $update_user_id
 */
//class MembershipFee extends CActiveRecord
class MembershipFee extends CustomActiveRecord
{
	const OPT_NO=1;
	const OPT_YES=2;
	
	const OPT_THIS_YEAR=1;
	const OPT_NEXT_YEAR=2;
	
	public $membership_availability;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MembershipFee the static model class
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
		return 'tbl_membership_fee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('create_dt, create_user_id', 'required'),
			//array('numerical', 'integerOnly'=>true),
			array('create_user_id, update_user_id', 'length', 'max'=>10),
			array('membership_availability,last_paid_dt, next_paid_dt, update_dt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, last_paid_dt, next_paid_dt, create_dt, create_user_id, update_dt, update_user_id',  'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'username' => 'User Name',
			'member_type_id' => 'Member Type',
			'last_paid_dt' => 'Last Paid Date',
			'next_paid_dt' => 'Next Date to Pay',
			'create_dt' => 'Create Dt',
			'create_user_id' => 'Create User',
			'update_dt' => 'Update Dt',
			'update_user_id' => 'Update User',
			'membership_availability'=>'Membership Expiry Year'
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('last_paid_dt',$this->last_paid_dt,true);
		$criteria->compare('next_paid_dt',$this->next_paid_dt,true);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('update_dt',$this->update_dt,true);
		$criteria->compare('update_user_id',$this->update_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	
	public function getMemberTypeOpt()
	{
		$memberTypes=array();
		$sql = "SELECT id,name FROM tbl_member_type ";
		$command = Yii::app()->db->createCommand($sql);
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			$memberTypes[$row['id']]=$row['name'];
		}
	
		return $memberTypes;
	}
	
	public function getMemberTypeText()
	{
		
		$getMemberTypeOpt=$this->memberTypeOpt;
		
		return ( isset($getMemberTypeOpt[$this->member_type_id]) ) ? $getMemberTypeOpt[$this->member_type_id] : "unknown type ({$this->member_type_id})";
	}
	
	public function getAvailabilityOpt()
	{
		//get membership expiry in years
		$yr_arr=array();
		$yr_start=date('Y')-4;
		for($i=0;$i<9;$i++)
		{
			$yr_arr[$i]=$yr_start+$i;
		}
		return $yr_arr;
		/*
		return array(
		self::OPT_THIS_YEAR=>'This Year',
		self::OPT_NEXT_YEAR=>'Next Year',
		
		);*/
	}
	
	public function getAvailabilityText()
	{
		$retStr='';
		$availabilityOpt=$this->availabilityOpt;
		$next_paid_dt=Yii::app()->dateFormatter->format("yyyy",$this->next_paid_dt);
		Yii::log('$next_paid_dt===='.$next_paid_dt,'info','MembershipFee.getAvailabilityText');
		foreach($availabilityOpt as $eo=>$val)
		{
			Yii::log('$next_paid_dt===='.$next_paid_dt,'info','MembershipFee.getAvailabilityText');
			if("" != $next_paid_dt && null != $next_paid_dt  )
			{
				if($next_paid_dt==$val)
				{
					$retStr=$val;
				}
			}
		}
		
		//return "unknown type ({$this->has_paid})";
		return $retStr;
	}
	
	public function getUserName($uid)
	{
		$user=User::model()->findByAttributes(array('id'=>$uid));
		return $user->username;

	}
}