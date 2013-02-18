<?php

/**
 * This is the model class for table "tbl_wing_category".
 *
 * The followings are the available columns in table 'tbl_wing_category':
 * @property string $id
 * @property string $name
 * @property string $create_dt
 * @property string $create_user_id
 * @property string $update_dt
 * @property string $update_user_id
 */
//class WingCategory extends CActiveRecord
class WingCategory extends CustomActiveRecord
{
	public $subcategory_name;
	public $subcategories=array();
	public $initial_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WingCategory the static model class
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
		return 'tbl_wing_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>100),
			array('create_user_id, update_user_id', 'length', 'max'=>10),
			
			array('update_dt,subcategory_name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, create_dt, create_user_id, update_dt, update_user_id', 'safe', 'on'=>'search'),
			//check if this name already exists
			array('name', 'verify'),
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
	* Authenticates the existence of the wing category in the system.
	* This is the 'verify' validator as declared in rules().
	*/
	public function verify($attribute,$params)
	{
		if(!$this->hasErrors()) // we only want to authenticate when no other input errors are present
		{
			if($this->isNewRecord)
			{
				
				if($this->wingExists())
					$this->addError('username','This wing category has already been added.');
				
			}
			else
			{
				if($this->name!=$this->initial_name && !$this->isNewRecord && $this->wingExists())
						$this->addError('username','This wing category has already been added.');
				else
				{
					$emptyName=false;
					Yii::log('Trying to check subcategory name','info','WingCategory.verify');
					//insert sub-category if any
					if(isset($this->subcategory_name))
					{
						Yii::log('before foreach...','info','WingCategory.verify');
						foreach($this->subcategory_name as $sname)
						{
						
							$sname=trim($sname);
							if(null===$sname || $sname==="")
							{
								Yii::log('is null?','info','WingCategory.verify');
								$emptyName=true;
								
							}
							else
							{
								Yii::log('not null?','info','WingCategory.verify');
								
							}	
						}
						
						if($emptyName)
							$this->addError('subcategory_name','Please enter the Subcategory Name');
		
					}
				}
			}
		}
		
	}
	
	private function associateWingWithSubCategory()
	{
		
		//save data to subcategory table
		if(isset($this->subcategory_name))
		{
			WingSubCategory::model()->deleteAllByAttributes(array('wing_category_id'=>$this->id));
			for($i=0;$i<sizeof($this->subcategory_name);$i++)
			{
				$sname=$this->subcategory_name[$i];
				$wingSub=new WingSubCategory;
				$wingSub->attributes=array('name'=>$sname,'wing_category_id'=>$this->id);
				$wingSub->save();
			}
		}	
	}
	
	protected function afterSave()
	{
		$this->associateWingWithSubCategory();
		parent::afterSave();
	}
	
	public function afterFind()
    {
		$this->initial_name=$this->name;
		
		//assign sub category
		$subs=WingSubCategory::model()->findAllByAttributes(array('wing_category_id'=>$this->id));
		foreach($subs as $sub)
			$this->subcategories[]=array('subcategory_name'=>$sub['name']);
	    parent::afterFind();
    }
	
	
	public function afterValidate()
	{
		if($this->hasErrors())
		{
			$this->subcategories=array();
			if( isset($this->subcategory_name) )
			{
				$i=0;
				foreach($this->subcategory_name as $sname)
				{
					
					$this->subcategories[$i]=array('subcategory_name'=>$this->subcategory_name[$i]);
					$i++;
				}
			}
		
		}
		return parent::afterValidate();
	}
	
	/**
	* @return boolean whether or not the current wing category exists
	*/
	public function wingExists()
	{
		$sql = "SELECT 1 FROM tbl_wing_category WHERE name=:name";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":name", $this->name, PDO::PARAM_STR);
		$res=$command->execute();
		return $res==1 ? true : false;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'create_dt' => 'Create Date',
			'create_user_id' => 'Create User',
			'update_dt' => 'Update Date',
			'update_user_id' => 'Update User',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_dt',$this->create_dt,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('update_dt',$this->update_dt,true);
		$criteria->compare('update_user_id',$this->update_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUserName($id)
	{
		$user=User::model()->findByAttributes(array('id'=>$id));
		return $user->username;
	}
}