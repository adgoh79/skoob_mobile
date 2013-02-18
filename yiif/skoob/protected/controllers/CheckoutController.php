<?php

class CheckoutController extends Controller
{
	//for displaying content at side
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
				'actions'=>array('create','update','index','view','back','skoob_home', 'thankyou', 'transaction_failed','preview','cancel','buy_gift'),
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

	public function actionPreview()
	{
		
		//session variable checking to see if session still valid to prevent hack
		$sess_egift_id = Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID];
		$egift_id= isset($_GET['egift_id'])?$_GET['egift_id']:'';
		
		if( isset($sess_egift_id) && $sess_egift_id==$egift_id )
		{
			$egift_id=$_GET['egift_id'];
			$egift=Egift::model()->findByPk($egift_id);
			$egift->getGiftCardImg();
			if(isset($egift))
			{
				//$model = new Checkout;
				$model = Checkout::model()->findByAttributes(array('egift_id'=>$egift_id));

				//only show preview if no voucher has been bought yet
				if(!$model->transactionExists())
				{
					$model->egift=$egift;
					//calculate amount - promo
					$model->calculateTotalAmt();
					$this->render('preview',array('model'=>$model));
				}
				else
				{
					Yii::log('Voucher already bought for checkout id = '.$model->id.'. Re-direct to egift/create.','info',modelname().'.actionpreview');
	
					$url = Yii::app()->createUrl('egift/create');
					//redirect to create egift if someone tries to access direct
					$this->redirect($url);
				}
			}
			else
			{
				Yii::log('unable to locate egift','info','debug');
			}
		}
		else
		{
			Yii::log('No egift id in parameter or session timeout. Re-direct to egift/create ','info',modelname().'.actionpreview');
			Yii::app()->user->setFlash('error', Yii::app()->globaldef->MSG_SESSION_TIMEOUT);
			$url = Yii::app()->createUrl('egift/create');
			//redirect to create egift if someone tries to access direct
			$this->redirect($url);
		}

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

	public function actionSkoob_home()
	{
		$this->redirect("http://www.skoob.com.sg/");
	}
	
	/** 
	* Displays transaction failed page
	*/
	public function actionTransaction_failed()
	{
		$model=new Checkout;
		$model->failed_msg=Yii::app()->globaldef->MSG_TRANSACTION_FAILED;
		$this->render('transaction_failed',array('model'=>$model));
	
	}
	
	/**
	 * Displays thank you page.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionThankyou()
	{
		//session variable checking to see if session still valid to prevent hack
		$sess_egift_id = Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID];
		$egift_id= isset($_GET['egift_id'])?$_GET['egift_id']:'';
		
		//if(true===true)
		if( isset($sess_egift_id) && $sess_egift_id==$egift_id )
		{
			$egift=Egift::model()->findByPk($egift_id);
			$egift->getGiftCardImg();
			if(isset($egift))
			{
				Yii::log('found egift','info','debug');
				$model = new Checkout;
				$model->egift=$egift;
				$model->calculateTotalAmt();
				$this->render('thankyou',array('model'=>$model));
			}
			else
			{
				Yii::log('unable to locate egift','info','debug');
			}
		}
		else
		{
			Yii::log('No egift id in parameter or session timeout. Re-direct to egift/create ','info',modelname().'.actionpreview');
			Yii::app()->user->setFlash('error', Yii::app()->globaldef->MSG_SESSION_TIMEOUT);
			$url = Yii::app()->createUrl('egift/create');
			//redirect to create egift if someone tries to access direct
			$this->redirect($url);
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Checkout;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		//session variable checking to see if session still valid to prevent hack
		$sess_egift_id = Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_EGIFT_ID];
		$egift_id= isset($_GET['egift_id'])?Yii::app()->getRequest()->getQuery('egift_id'):'';
		//ensure egift id is in the url parameter
		if( isset($sess_egift_id) && $egift_id==$sess_egift_id )
		{
			//$egift_id = Yii::app()->getRequest()->getQuery('egift_id');
			$model=Checkout::model()->findByAttributes(array('egift_id'=>$egift_id));
			if(!isset($model))
				$model=new Checkout;
				
			//check if the transaction for this checkout exists
			if(!$model->transactionExists())
			{
				$model->egift_id=$egift_id;
				//get egift object and assign to display info
				$egift=Egift::model()->findByPk($egift_id);
				//look for card image
				$egift->getGiftCardImg();
				$model->egift=$egift;
				//get total amount - promo discount if any
				$model->calculateTotalAmt();
				
				if(isset($_POST['Checkout']))
				{
					$model->attributes=$_POST['Checkout'];
					if($model->save())
					{
						//set session variable for later
						Yii::app()->session[Yii::app()->globaldef->SESSION_VAR_CHECKOUT_ID] = $model->id;
						//after save redirect to preview page
						$this->redirect(array('preview','egift_id'=>$model->egift_id));
						//$this->redirect(array('thankyou','egift_id'=>$model->egift_id));
					}
				}

				$this->render('create',array(
					'model'=>$model,
				));
			}
			else
			{
				Yii::log('Transaction for egift id '.$egift_id.' already exists. Re-direct to create new egift.','info',modelname().'.actionCreate');
				$url = Yii::app()->createUrl('egift/create');
				//redirect to create egift if someone tries to access direct
				$this->redirect($url);
			}
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::app()->globaldef->MSG_SESSION_TIMEOUT);
			Yii::log('EGift ID not passed via parameters or session does not contain egift id. Re-direct to create new egift.','info',modelname().'.actionCreate');
			$url = Yii::app()->createUrl('egift/create');
			//redirect to create egift if someone tries to access direct
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
			$model=$this->loadModel($id);
			
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);

			if(isset($_POST['Checkout']))
			{
				$model->attributes=$_POST['Checkout'];
				if($model->save())
				{
					//$this->redirect(array('view','id'=>$model->id));
					$this->redirect(array('preview','egift_id'=>$model->egift_id));
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
		$dataProvider=new CActiveDataProvider('Checkout');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	public function actionBuy_gift()
	{
		Yii::log('inside action','info',modelname().'.actionBuy_gift');
		if(isset($_GET['id']))
		{
			$checkout_id=$_GET['id'];
			$model=Checkout::model()->findByPk($checkout_id);
			Yii::log('before buying gift','info',modelname().'.actionBuy_gift');
			if($model->buy_gift())
			{
				//send email to user
				$model->runBackgroundTask();
				
				//immediately redirect if ok
				$this->redirect(array('thankyou','egift_id'=>$model->egift_id));
			}
			else
			{
				if(Yii::app()->user->hasFlash('error'))
					$this->redirect(array('preview','egift_id'=>$model->egift_id));
				else
					$this->redirect(array('transaction_failed','egift_id'=>$model->egift_id));
			}
		}
	}
	
	public function actionCancel()
	{
		if(isset($_GET['id']))
		{
			$checkout_id=$_GET['id'];
			$model=Checkout::model()->findByPk($checkout_id);
			//$this->render('update',array('id'=>$checkout_id));
			$this->redirect(array('create','egift_id'=>$model->egift_id));
			//$this->redirect(array('update','id'=>$checkout_id));
		}
		else
			$this->redirect('egift/create');
	}
	public function actionBack()
	{
		
		$url = Yii::app()->createUrl('egift/create');
		$this->redirect($url);
	}	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Checkout('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Checkout']))
			$model->attributes=$_GET['Checkout'];

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
		$model=Checkout::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='checkout-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
