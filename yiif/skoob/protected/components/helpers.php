<?php
// protected/components/helpers.php
 
function startsWith($needle, $haystack)
{

}

function curPageURL() {
	 $pageURL = 'http';
	 if ( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
}


function serverPrefix() {
	 $pageURL = 'http';
	 if ( isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"];
	 }
	 return $pageURL;
}

function modelname()
{
	$_name='';
	
	$_name=isset(Yii::app()->controller)?Yii::app()->controller->id:'';
    return $_name;
}

function actionname()
{
	$_name='';
	$_name=isset(Yii::app()->controller)?Yii::app()->controller->action->id:'';
	return $_name;
}