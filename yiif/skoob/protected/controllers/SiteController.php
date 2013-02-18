<?php

class SiteController extends Controller
{
	private $_authManager;
	private function loadRoles()
	{
		if(($this->_authManager=Yii::app()->authManager)!=null)
		{
		$this->_authManager->clearAll();
		//create the lowest level operations for users
		$this->_authManager->createOperation("createUser","create a new user");
		$this->_authManager->createOperation("readUser","read user profile information");
		$this->_authManager->createOperation("updateUser","update a users information");
		$this->_authManager->createOperation("deleteUser","remove a user from a project");
		//create the reader role and add the appropriate permissions as	children to this role
		$role=$this->_authManager->createRole("admin");
		$role=$this->_authManager->createRole("reader");
		$role->addChild("readUser");
		//create the member role, and add the appropriate permissions, as well as the reader role itself, as children
		$role=$this->_authManager->createRole("member");
		$role->addChild("reader");
		//create the owner role, and add the appropriate permissions, as well as both the reader and member roles as children
		$role=$this->_authManager->createRole("owner");
		$role->addChild("reader");
		$role->addChild("member");
		$role->addChild("createUser");
		$role->addChild("updateUser");
		$role->addChild("deleteUser");
		
		//provide a message indicating success
		
		}
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//$this->loadRoles();
		//$this->_authManager=Yii::app()->authManager;
		//$this->_authManager->assign('admin',Yii::app()->user->getId());
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		if(Yii::app()->user->isGuest)
			$url = Yii::app()->createUrl('egift/index');
		else if(Yii::app()->user->isAdmin())
			$url = Yii::app()->createUrl('giftCard/admin');
		$this->redirect($url);
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}