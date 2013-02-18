<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index'  actions
				'actions'=>array('index','cancel'),
				'roles'=>array('admin'),
			),
			array('allow',  // allow all users to perform  'view' actions
				'actions'=>array('view'),
				'roles'=>array('admin','member'),
			),
			array('allow', // allow admin to perform 'update' actions
				'actions'=>array('update'),
				//'users'=>array('@'),
				'roles'=>array('admin','member'),
			),
			array('allow', // allow member to perform 'create' actions
				'actions'=>array('create'),
				//'users'=>array('@'),
				'roles'=>array('admin'),
			),
		
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$issueDataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
			'pageSize'=>3,
			),
		));
		$this->render('view',array(
			//'model'=>$this->loadModel($id),
			'model'=>$this->loadModel($id),
			'issueDataProvider'=>$issueDataProvider
		));
	}

	public function actionCancel()
	{
		$this->redirect(array('index'));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->password=null;
		$userRole=Yii::app()->authManager->getAuthItems(2, $id);
		$arrayKeys = array_keys($userRole);
		$role='';
		if(isset($arrayKeys) && sizeof($arrayKeys)>0)
			$role = strtolower ($arrayKeys[0]);
		
		Yii::log('the user id==='.$id.' role=='.$role,'info','UserController.actionUpdate');
		$model->user_role=$role;
		$sql = "SELECT area_of_interest_id FROM tbl_user_area_of_interest where user_id=:userId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $id, PDO::PARAM_INT);
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			$model->area_of_interest[]=$row['area_of_interest_id'];
		}
	
		
		//find which wing category this user belongs to
		$sql = "SELECT wing_category_id FROM tbl_wing_user_assignment where user_id=:userId ";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $id, PDO::PARAM_INT);
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			$model->wing_category[]=$row['wing_category_id'];
			Yii::log('the ret id=='.$row['wing_category_id'].' an userid='.$this->id,'info','User.getWingOptions');
		}
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

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
		$model=User::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
