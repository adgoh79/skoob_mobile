<?php

/**
 * This is the model class for table "gift_card".
 *
 * The followings are the available columns in table 'gift_card':
 * @property string $id
 * @property string $title
 * @property string $img_url
 * @property string $ins_dt
 */
class GiftCard extends CustomActiveRecord
{
	//for replacing current image
	public $new_image;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GiftCard the static model class
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
		return 'gift_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('new_image', 'safe'),
			array('new_image', 'file', 'types'=>'jpg, gif, png'),
			array('title', 'length', 'max'=>45),
			array('img_url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, img_url, ins_dt, new_image', 'safe', 'on'=>'search'),
			array('new_image', 'verify'),
		);
	}
	
	public function verify($attribute,$params)
	{
		if(!$this->hasErrors()) 
		{
			$max_ht = Yii::app()->globaldef->GIFT_CARD_MAX_HEIGHT;
			$max_wt = Yii::app()->globaldef->GIFT_CARD_MAX_WIDTH;
				
			$this->new_image=CUploadedFile::getInstance($this,'new_image');
			
			//if this is file creation
			//user must upload image
			if($this->isNewRecord)
			{
				if(!isset($this->new_image))
					$this->addError("new_image","Please upload an image file of dimensions $max_ht (width) x $max_ht (height).");
			}
			
			//only check for dimension if new file is indicated
			if(isset($this->new_image))
			{
				$img_info=getimagesize($this->new_image->getTempName());
				if(isset($img_info))
				{
					$wt=$img_info[0];
					$ht=$img_info[1];
					
					if($wt!=$max_wt && $ht!=$max_ht)
						$this->addError("new_image","Please upload image file of dimensions $max_ht (width) x $max_ht (height) only.");
					else
					{
						
					
						//the width and height pass
						//assign img_url to update
						$this->img_url=Yii::app()->globaldef->GIFT_CARD_DIR.$this->new_image;
						
						if( file_exists(Yii::app()->basepath.'/..'.$this->img_url) )
						{
							$this->addError("new_image","The image with a file name '".$this->new_image."' already exists. Please choose another file with a file name.");
						}
						
					}
				
				} 
			}
			
			
			
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'img_url' => 'Image',
			'new_image' => 'New Image',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('ins_dt',$this->ins_dt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}