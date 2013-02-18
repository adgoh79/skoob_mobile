<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/common/favicons.png" type="image/x-icon" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/skoob.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/elastislide/elastislide.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/elastislide/custom.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.17475.js"></script>
	

</head>

<body>
<!-- customized header for skoob -->
<div class="headHolder">
	
	<div class="topNav">
		<ul class="clogin in" id="topNav">
			<li><a class="cleft" href="/secure/login">Sign In</a></li>
			<li><a href="/secure/register">Register</a></li>
			<li><a class="cright" href="/page/help">Help</a></li>
			<li><a class="socialimg" target="_blank" href="http://www.facebook.com/pages/skoobsg/216557885053492">
				<img height="19" width="19" src="<?php echo Yii::app()->request->baseUrl; ?>/images/common/facebook-topbar.png">
				</a>
				<a class="socialimg" target="_blank" href="http://twitter.com/#!/skoobsg">
					<img height="20" width="19" src="<?php echo Yii::app()->request->baseUrl; ?>/images/common/twitter-topbar.png">
				</a>
			</li>
		</ul>
	</div>
	<div class="pageHead">
		<div class="logoBlock">
			<div class="logo">
				<a href="/">
					<img height="58" width="106" alt="skoob! ebook" src="<?php echo Yii::app()->request->baseUrl; ?>/images/common/logo_desktop.png">
				</a>
			</div>
		</div>
		<div class="FaveBookstore">Never Stop Reading</div>
	</div>	
</div>
<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php 
		
			$actionname= actionname();
			$modelname= modelname();
		$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				//array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>(Yii::app()->user->isGuest && $modelname=='egift' && $actionname=='index')),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Skoob.<br/>
		All Rights Reserved.<br/>
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
