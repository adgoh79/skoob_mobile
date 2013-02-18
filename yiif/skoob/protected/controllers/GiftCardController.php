<?php

class GiftCardController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index','view'),
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
		$model=new GiftCard;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GiftCard']))
		{
			
			$model->attributes=$_POST['GiftCard'];
			$model->new_image=CUploadedFile::getInstance($model,'new_image');
		
			if($model->save())
			{
				//upload file to directory
				//go up on level to get to images as now in protected
				$model->new_image->saveAs(Yii::app()->getBasePath().'/..'.Yii::app()->globaldef->GIFT_CARD_DIR.$model->new_image);
		
				$this->redirect(array('admin','id'=>$model->id));
			}
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GiftCard']))
		{
			$model->attributes=$_POST['GiftCard'];
			$model->new_image=CUploadedFile::getInstance($model,'new_image');
		
			if($model->save())
			{
				//upload file to directory
				//go up on level to get to images as now in protected
				$model->new_image->saveAs(Yii::app()->getBasePath().'/..'.Yii::app()->globaldef->GIFT_CARD_DIR.$model->new_image);
				$this->redirect(array('admin','id'=>$model->id));
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
		$model = $this->loadModel($id);
		$res = $model->delete();
		
		if(Yii::app()->request->isPostRequest)
        {
			//$this->deleteMyAssociatedImage($model->img_url);
			if($res===true)
			{
				Yii::log('delete the file '.Yii::app()->basepath.$model->img_url,'info',modelname().'.actionDelete');
				if(file_exists(Yii::app()->basepath.'/..'.$model->img_url))
				{
					Yii::log('Deleting file '.Yii::app()->basepath.'/..'.$model->img_url,'info',modelname().'.actionDelete');
					// delete directly directly 
					unlink(Yii::app()->basepath.'/..'.$model->img_url);
				}
				else
				{
					Yii::log('Unable to find file  '.Yii::app()->basepath.'/..'.$model->img_url.' to delete.','info',modelname().'.actionDelete');
				}
				
			}
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('GiftCard');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new GiftCard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GiftCard']))
			$model->attributes=$_GET['GiftCard'];

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
		$model=GiftCard::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gift-card-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
