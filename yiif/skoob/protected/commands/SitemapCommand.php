<?php
class SitemapCommand extends CConsoleCommand
{
    public function actionIndex($type, $limit=5) { 
		Yii::log('hello there.....','debug',modelname().'.'.actionname());
		echo '456';
	}
    public function actionInit() { 
		echo '122333';
	}
}

?>