<?php
/*
Yii::log('before ----- url===','info','asd');
Yii::log('url==='.Yii::app()->createAbsoluteUrl('egift/send',array(),'http'),'info','asd');
*/
	$baseURL = Yii::app()->params['base_url'];
?>

<div style="background-color: #3f3f3f; background: -webkit-gradient(linear, left top, left bottom, from(#282828), to(#3f3f3f)); background: -moz-linear-gradient(top, #282828, #3f3f3f);"	>
	
	<div style="margin: 0 auto; width: 100%; position: relative; background: #456575; padding: 0.213em 0 0.1em; text-align: center;">
		<ul style="list-style-type: none; width: 100%; display: inline-block; text-align: right; margin: 0px auto;padding:0;height:21px" id="topNav">
			<li style="display: inline;line-height: 1em;margin: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;">
			<a class="cleft" style="text-decoration: none; display: inline; padding: 0px 10px;color: #FFF; font-size: 13px; font-family: Arial, Helvetica, sans-serif; border-left: 0;line-height: 1em; " href="/secure/login">Sign In</a></li>
			<li style="display: inline;line-height: 1em;margin: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;">
				<a style="text-decoration: none; display: inline; padding: 0px 10px;color: #FFF; font-size: 13px; font-family: Arial, Helvetica, sans-serif; padding: 0 10px;border-left: 0;" href="/secure/register">Register</a></li>
			<li style="display: inline;line-height: 1em;margin: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;">
				<a style="text-decoration: none; color: white;font-size: 13px; font-family: Arial, Helvetica, sans-serif; padding: 0 10px;" class="cright" href="/page/help">Help</a>
			</li>
			<li style="display: inline;line-height: 1em;margin: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;">
				<a  class="socialimg" target="_blank" href="http://www.facebook.com/pages/skoobsg/216557885053492">
					<img style="vertical-align: middle;padding-bottom: 1px; " height="19" width="19" src="<?php echo $baseURL; ?>/images/common/facebook-topbar.png">
				</a>
				<a style="padding:0 5px 0 0;" class="socialimg" target="_blank" href="http://twitter.com/#!/skoobsg">
					<img style="vertical-align: middle;padding-bottom: 2px; " height="20" width="19" src="<?php echo $baseURL; ?>/images/common/twitter-topbar.png">
				</a>
			</li>
		</ul>
	</div>	
	<div style="margin: 0 auto;width: auto;position: relative;height: 6.5em;" class="pageHead email-head-width">
		<div style="float: left; width: auto; height: 104px; text-align: center; padding-right: 20px;padding-left: 20px" class="logoBlock">
			<div style="padding: 15px 0 0;" class="logo">
				<a href="/">
					<img style="line-height: normal;font-size: 0.75em;color: #CCC;text-align: center;vertical-align: middle;" height="58" width="106" 
					alt="skoob! ebook" src="<?php echo $baseURL.'/images/common/logo_desktop.png' ?>" >
				</a>
			</div>
		</div>
		<div style="color: white;font-style: italic;font-weight: bold;line-height: 100%;padding-right: 10px;font-size: 110%;padding-top: 35px;text-align:right;" class="FaveBookstore extraPad">Never Stop Reading</div>
	</div>	
</div>
