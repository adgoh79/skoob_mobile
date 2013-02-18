<?php

class SiteController extends Controller
{
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
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
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
	 * Displays the send email page
	 */
	public function actionSend_email()
	{
		if(!Yii::app()->user->checkAccess('admin'))
		{
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}
		else
		{
			$model=new SendEmailForm;
			
			if(isset($_POST['SendEmailForm']))
			{
				$model->attributes=$_POST['SendEmailForm'];
				
				// validate user input and set a sucessfull flash message if valid
				if($model->validate())
				{
					//Yii::app()->user->setFlash('success',$form->username ." has been added to the project." );
					//$form=new SendEmailForm;
					Yii::app()->user->setFlash('send_email','Email sent to users.');
					$this->refresh();
				}
			}
			
			$this->render('send_email',array('model'=>$model));
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
				/*
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";
				*/
				$body="<br>From: {$model->name} <{$model->email}><br>".
					"Reply-To: {$model->email}<br><br>".
					"Subject: {$model->subject}"
					;
				Yii::import('ext.yii-mail.YiiMailMessage');
				$message = new YiiMailMessage;
				$message->setBody($body, 'text/html');
				$message->subject = "[iCRM Contact Form Email] {$model->subject}";
				$message->from = 'no.reply@chinmaya.com';

				$message->addTo(Yii::app()->params['adminEmail']);
				Yii::app()->mail->send($message);
					
					
				//mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
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

	public function actionMainSite()
	{
		$this->redirect("http://www.chinmaya.org.sg");
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