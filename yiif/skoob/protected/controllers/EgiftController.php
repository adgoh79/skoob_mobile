<?php

class EgiftController extends Controller
{
	public $side_content;
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
				'actions'=>array('create','update','index','view','request_egift','preview','proceed','claim_gift','submit_egift_request'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(''),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(''),
				'users'=>array(''),
			),
			array('deny',  // deny all users
				'actions'=>array('admin'),
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

	public function actionPreview()
	{
		
		$egift_id= isset($_GET['egift_id'])?$_GET['egift_id']:'';
		$sess_egift_id = Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID];
		
		if($egift_id!='' && $sess_egift_id==$egift_id)
		{
			$model=$this->loadModel($egift_id);
			$model->getGiftCardImg();
				
			$this->render('preview',array(
				'model'=>$model,
			));
			
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::app()->globaldef->MSG_SESSION_TIMEOUT);
			Yii::log('EGift ID not passed via parameters. Re-direct to create new egift.','info',modelname().'.actionPreview');
			$url = Yii::app()->createUrl('egift/create');
			$this->redirect($url);
		}

	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Egift;
		//use this for update as well
		if(isset($_POST['id']))
		{
			Yii::log('found id','debug','asdasd');
			$model=Egift::model()->findByPk($_POST['id']);
			$model->getGiftCardImg();
		}
		else if( isset($_GET['id']))
		{
			Yii::log('found id','debug','asdasd');
			$model=Egift::model()->findByPk($_GET['id']);
			$model->getGiftCardImg();
		}
		else
		{
			Yii::log('nononono found id','debug','asdasd');
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Egift']))
		{
			
			$model->attributes=$_POST['Egift'];
			if(isset($_POST['Egift']['id']))
				$model->id=$_POST['Egift']['id'];
			//have to write customized function to avoid re-iterating 
			//business logic in update
			$proceed=false;
			if($model->updateRecord())
			{
				$proceed=true;
			}
			else
			{
				if($model->save())
					$proceed=true;
			}
			
			if($proceed)
			{
				Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID] = $model->id;
				
				if(isset($_POST['preview']))
				{
					//used only for mobile view
					$url = Yii::app()->createUrl('egift/preview',array('egift_id'=>$model->id));
				}
				else
				{
					//used only for normal view
					$url = Yii::app()->createUrl('checkout/create',array('egift_id'=>$model->id));
				}
				//$this->redirect(array('view','id'=>$model->id));
				//after saving redirect to checkout page
				$this->redirect($url);
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
		
		
	}

	public function actionProceed()
	{
		$egift_id= isset($_POST['id'])?$_POST['id']:'';
		$sess_egift_id = Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID];
		
		
		if($egift_id!='' && $sess_egift_id==$egift_id)
		{
			$url = Yii::app()->createUrl('checkout/create',array('egift_id'=>$egift_id));
			$this->redirect($url);	
		}
		else
		{
			Yii::log('EGift ID not passed via parameters. Re-direct to create new egift.','info',modelname().'.actionPreview');
			$url = Yii::app()->createUrl('egift/create');
			$this->redirect($url);
		}
		
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		//Yii::log('the egift id from session==='.Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID],'info',modelname().'.actionUpdate');
		
		
		if( isset($sess_egift_id) && $sess_egift_id == $id )
		{
			$model=$this->loadModel($id);
			
			
			$model->getGiftCardImg();
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Egift']))
			{
				$model->attributes=$_POST['Egift'];
				if($model->save())
				{
					$url = Yii::app()->createUrl('checkout/create',array('egift_id'=>$model->id));
					//$this->redirect(array('view','id'=>$model->id));
					//after saving redirect to checkout page
					$this->redirect($url);
			
				}	
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::app()->globaldef->MSG_SESSION_TIMEOUT);
			Yii::log('EGift ID not passed via parameters or session does not contain egift id. Re-direct to create new egift.','info',modelname().'.actionUpdate');
			$url = Yii::app()->createUrl('egift/create');
			$this->redirect($url);
		}
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
		
		$dataProvider=new CActiveDataProvider('Egift');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			
		));
	}

	/**
	* When user requests an e-gift from friend
	*/
	public function actionRequest_egift()
	{
		$model=new Egift;
		$this->render('request_egift',array('model'=>$model));
	}
	
	public function actionSubmit_egift_request()
	{
		if(isset($_POST['Egift']))
		{
			$model = new Egift;
			$model->attributes = $_POST['Egift'];
			//do checking for fields
			if($model->checkEgiftRequestFields()===false )
			{
				$this->render('request_egift',array(
					'model'=>$model,
				));
			}
			else
			{
				Yii::app()->user->setFlash('success', 'You have successfully requested for an egift.');
				//all checking is fine
				$url = Yii::app()->createUrl('emailSent/egiftRequested',array('sender_name'=>$model->sender_name,
				'sender_email'=>$model->sender_email,'recipient_name'=>$model->recipient_name,
				'recipient_email'=>$model->recipient_email, ));
				
				$this->redirect($url);
				
				
				//$this->render('index');	
			}
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Egift('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Egift']))
			$model->attributes=$_GET['Egift'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionClaim_gift()
	{
		
		$user_name='';
		$user_password='';
		$voucher_no='';
		if(isset($_GET['user_name']))
			$user_name=$_GET['user_name'];
		if(isset($_GET['user_password']))
			$user_password=$_GET['user_password'];
		if(isset($_GET['voucher_no']))
			$voucher_no=$_GET['voucher_no'];
		
		$ret_code=Egift::model()->claimEGift($user_name, $user_password, $voucher_no);
		
		//send email to user for successful claim
		if($ret_code['result_code'] == Yii::app()->globaldef->CLAIM_GIFT_SUCCESS)
		{
			$model = new Egift;
			$model->getClaimedVoucherDetails($voucher_no);
			//EmailSent::egiftVoucherClaimed($model->sender_name, $model->sender_email,$model->recipient_name, $model->recipient_email );
			
			$url = Yii::app()->createUrl('emailSent/egiftVoucherClaimed',array('sender_name'=>$model->sender_name,
			'sender_email'=>$model->sender_email,'recipient_name'=>$model->recipient_name,
			'recipient_email'=>$model->recipient_email,'code'=>$ret_code,'voucher_value'=>$model->voucher_value,'redeem_date'=>$model->voucher_redeem_date ));
			
			$this->redirect($url);
			
			Yii::log('Sending email code is =  '.$ret_code,'error',modelname().'.actionClaim_gfit');
			
		}
		else
		{
			Yii::log('Unable to send email. The return code is '.$ret_code,'error',modelname().'.actionClaim_gfit');
		}
		
		
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Egift::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='egift-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
