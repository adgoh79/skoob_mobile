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
		
		
		$sql = "SELECT * FROM tbl_user_area_of_interest ";
		$command = Yii::app()->db->createCommand($sql);
		
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			echo 'area of interest==='.$row['area_of_interest_id'];
		}
	}
}
?>