<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/common/favicons.png" type="image/x-icon" />

	<!-- blueprint CSS framework -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/skeleton/base.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/skeleton/layout.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/skeleton/skeleton.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/general.css" />
	<!--
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/lungo/lungo.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/lungo/lungo.icon.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/css/lungo/lungo.theme.default.css" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/js/quo.js" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/mobile/js/lungo.js" />
	-->
	
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/elastislide/elastislide.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/elastislide/custom.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.17475.js"></script>
	<style type="text/css">

</style>

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
	<div class="headHolder">
		<div class="pageHead">
		
			<div class="logoBlock">
				
				
				<div class="logo">
					
						<img class="scale-with-grid" height="58" width="106"  alt="skoob! ebook" src="<?php echo Yii::app()->request->baseUrl; ?>/images/common/logo_desktop.png">
					
				</div>
			</div>
	
	<div  class="sixteen columns fav_bookstore">
        Never Stop Reading
    </div>			
			
			
		</div>	
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
<p>
	<?php echo $content; ?>
</p>
	<div class="clear"></div>

	<footer  id="sub-footer">
		Copyright &copy; <?php echo date('Y'); ?> by Skoob.<br/>
		All Rights Reserved.<br/>
		
	</footer ><!-- footer -->

</div><!-- page -->

</body>
</html>
