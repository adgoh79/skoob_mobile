<?php

class ThemeSwitch
{
  public function BeginRequest(CEvent $event)
  {
	Yii::log('begin request funciton ','info','.BeginRequest');
	if (Yii::app()->detectMobileBrowser->getIsMobile()) {
		Yii::log('Viewing from mobile browser. Applying mobile layout','info','.BeginRequest');
		// do something, like using a different layout/theme
		//Yii::app()->theme = 'mobile-white-orange';
		Yii::app()->theme = 'mobile';
	}
	else
	{
		Yii::log('Viewing from a normal browser','info','.BeginRequest');
		Yii::app()->theme = Yii::app()->session['theme'];
		//Yii::app()->theme = 'mobile-white-orange';
		//Yii::app()->theme = 'mobile';
	}
    
  }
}