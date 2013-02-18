<?php

class MessageController extends Controller
{

	public function actionGoodbye()
	{
		$theTime = date("D M j G:i:s T Y");
		$this->render('goodbye',array('time'=>$theTime,'test_var'=>'test test'));
	}
	public function actionHelloWorld()
	{
		$theTime = date("D M j G:i:s T Y");
		$this->render('helloWorld',array('time'=>$theTime,'test_var'=>'test test'));
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	// -----------------------------------------------------------
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}