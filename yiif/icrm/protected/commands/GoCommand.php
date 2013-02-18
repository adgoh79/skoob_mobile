<?php

class GoCommand extends CConsoleCommand
{
    public function run($args)
    {
		echo 'Hello, world u r ';
	  
		//User::model()->findAll();
		
		$sql = "SELECT * FROM tbl_user_area_of_interest ";
		$command = Yii::app()->db->createCommand($sql);
		
		$dataReader=$command->query();
		// calling read() repeatedly until it returns false
		while(($row=$dataReader->read())!==false) { 
			//$model->area_of_interest[]=$row['area_of_interest_id'];
		}
		
    }
}

?>