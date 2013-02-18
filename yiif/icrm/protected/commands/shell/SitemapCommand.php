<?php
class SitemapCommand extends CConsoleCommand
{
    public function actionIndex($type, $limit=5) { 
		echo 'type=='.$type.' limit==='.$limit;
	}
    public function actionInit() { 
		echo 'actionInit';
	}
	
	public function run($args)
	{
		echo 'main';
		echo 'id==='.Yii::app()->user->getId();
	}
}
?>