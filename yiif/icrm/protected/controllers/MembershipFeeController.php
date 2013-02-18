<?php

class MembershipFeeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_authManager;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			/*
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','view','cancel'),
				//'users'=>array('@'),
				'roles'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				//'users'=>array('admin'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		Yii::log('action viewing now ','info','MembershipFeeController.actionView');
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MembershipFee;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MembershipFee']))
		{
			$model->attributes=$_POST['MembershipFee'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCancel()
	{
		$this->redirect(array('admin'));
	}
		
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		$auth=Yii::app()->authManager;
		
		$model=$this->loadModel($id);
		
		
		$res=0;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$tenure_duration=0;
		//get user membership type
		$sql = "SELECT tenure_duration,member_type FROM tbl_user a "
		." INNER JOIN tbl_member_type b "
		." ON a.member_type=b.id "
		." where a.id=:userId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $model->user_id, PDO::PARAM_INT);	
		$dataReader=$command->query();
		if(($row=$dataReader->read())!==false) { 
			$model->member_type_id=$row['member_type'];
			$tenure_duration=$row['tenure_duration'];
		}
		
		if(isset($_POST['MembershipFee']))
		{
			$update_user_id=Yii::app()->user->getId();
			
			$model->attributes=$_POST['MembershipFee'];
			//stop default update 
			//as need to change last paid date and next to pay date
			$year_opt=0;
			$yearsOpts=$model->getAvailabilityOpt();
			foreach($yearsOpts as $eo=>$val)
			{
				if($model->membership_availability == $eo )
				{
					$year_opt=$val;
				}
			}
			
			$lastPaidDt='';
				
			//get tenure to calculate next paying date
			//tenure_duration
			
			$res=0;
			
			
				Yii::log('ma======='.$model->membership_availability,'info','MembershipFeeController');
				$nextPaidDt=date('Y-m-j',mktime(0, 0, 0, 1, 1, $year_opt));
				
				$begints=strtotime('-'.$tenure_duration.' year', strtotime($nextPaidDt));
				
				$lastPaidDt = date ( 'Y-m-j' , $begints );
				
				$sql = "UPDATE tbl_membership_fee SET last_paid_dt=:lastPaidDt,next_paid_dt=:nextPaidDt, "
				." update_dt=NOW(),update_user_id=:upUserId "
				." where user_id=:userId ";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindValue(":lastPaidDt", $lastPaidDt, PDO::PARAM_STR);
				$command->bindValue(":nextPaidDt", $nextPaidDt, PDO::PARAM_STR);
				$command->bindValue(":upUserId", $update_user_id, PDO::PARAM_INT);
				$command->bindValue(":userId", $model->user_id, PDO::PARAM_INT);
				$res=$command->execute();
				/*
			}
			else
			{
				$sql = "UPDATE tbl_membership_fee SET  membership_availability=:ma, "
				." update_dt=NOW(),update_user_id=:upUserId, has_paid=:hasPaid "
				." where user_id=:userId ";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindValue(":ma", $model->membership_availability, PDO::PARAM_INT);
				$command->bindValue(":hasPaid", $model->has_paid, PDO::PARAM_INT);
				$command->bindValue(":upUserId", $update_user_id, PDO::PARAM_INT);
				$command->bindValue(":userId", $model->user_id, PDO::PARAM_INT);
				$res=$command->execute();

			}*/
			if($res==1)
				$this->redirect(array('view','id'=>$model->user_id));
		}

		
		//set availability to year format to auto select dropdown list
		$expiryOpt=$model->getAvailabilityOpt();
		$next_paid_dt=($model->membership_availability=='' || !isset($model->membership_availability))?Yii::app()->dateFormatter->format("yyyy",Yii::app()->locale->getDateFormat('short')):Yii::app()->dateFormatter->format("yyyy",$model->next_paid_dt);
		foreach($expiryOpt as $eo=>$val)
		{
			if("" != $next_paid_dt && null != $next_paid_dt  )
			{
				if($next_paid_dt==$val)
				{
					$model->membership_availability=$eo;
				}
			}
		}
		
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Yii::log('action indexing now ','info','MembershipFeeController.actionView');
		$this->populateMembershipFeeTable();
		$dataProvider=new CActiveDataProvider('MembershipFee');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	private function populateMembershipFeeTable()
	{
		$uids=array();
		$sql = "SELECT id,username,member_type FROM tbl_user ";
		$command = Yii::app()->db->createCommand($sql);
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			$uids[]=array('id'=>$row['id'],'username'=>$row['username'],'member_type'=>$row['member_type']);
		}
	
		//get current user id
		$create_user_id=$update_user_id=Yii::app()->user->getId();
	
		foreach($uids as $uid)
		{
			//prepopulate the table as this will not be added manually
			$assign=MembershipFee::model()->findByAttributes(array('user_id'=>$uid['id']));
		
			if(!isset($assign))
			{
				$sql = "INSERT INTO tbl_membership_fee (user_id,username,member_type_id, create_dt,create_user_id,update_dt,update_user_id) "
					." VALUES (:userId,:userName,:memberTypeID, :hasPaid,NOW(), :createUserID, NOW(), :updateUserID)";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindValue(":userId", $uid['id'], PDO::PARAM_INT);
				$command->bindValue(":userName", $uid['username'], PDO::PARAM_STR);
				$command->bindValue(":memberTypeID", $uid['member_type'], PDO::PARAM_STR);
				
				$command->bindValue(":createUserID", $create_user_id, PDO::PARAM_INT);
				$command->bindValue(":updateUserID", $update_user_id, PDO::PARAM_INT);
				$command->execute();
			}
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->populateMembershipFeeTable();
		$model=new MembershipFee('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MembershipFee']))
			$model->attributes=$_GET['MembershipFee'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MembershipFee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='membership-fee-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
