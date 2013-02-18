<?php 
	$baseURL = Yii::app()->params['base_url'];
?>

<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;width:95%;" class="seperator"/>
		<div style="margin-left: auto;margin-right: auto;width:90%;color: grey; " class="centered-text subtextHighlight">
		<?php echo Yii::app()->globaldef->SKOOB_INTRO; ?>
		
<table style="padding-top:40px;margin-left: auto;margin-right: auto;width:80%;" class="footer-table">
	
	<tr>
		<td style="text-align:right;width:20%">
			<img width="45%" height="auto" src="<?php echo $baseURL; ?>/images/common/skoob.png"/>
		</td>
	
		<td style="width:80%;">
		<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;" />
			<span style="font-weight:bold;font-size:2em;" class="email-footer-large">Start browsing on <?php echo Yii::app()->globaldef->SKOOB_URL; ?> today.</span>
		<hr style="border:dotted #cccccc;  border-width:2px 0 0; height:0;" />
		</td>
		
	</tr>
	<tr>	
		<td align="center" colspan="2">
			<?php echo Yii::app()->globaldef->SKOOB_EMAIL_SUB_TEXT; ?>
		</td>
	</tr>
</table>
