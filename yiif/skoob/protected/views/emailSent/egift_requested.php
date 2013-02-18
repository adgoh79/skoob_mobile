
<?php
/* @var $this EmailerController */
	$terms_url=Yii::app()->globaldef->SKOOB_EVOUCHER_TAC;
?>
<div style="width:90%;margin:0 auto;margin-top: 5px;
	margin-bottom: 5px;	background: white;border:2px solid #cccccc;border-radius:5px;" class="container" id="page"> 
	<?php include 'email_header.php'; ?>
	
	<table align="center" style="width: 90%; border:1px;line-height:100%;" class="table-info">
		<tr>	
			<td align="left" ><br/>Dear <?php echo $model->recipient_name; ?>,</td>
		</tr>
		<tr>
			<td  style="padding-top:20px;" align="left" >Your friend, <?php echo $model->sender_name; ?> at <?php echo $model->sender_email; ?>, has requested for a skoob e-Gift Voucher. <br/><br/>Please go to <?php echo CHtml::Link('skoob create egift',array('egift/create') ) ?>.</td>
		</tr>
		
		<tr>
			<td style="padding-top:20px;" align="left" >Regards,<br/>skoob team</td>
		</tr>
		
	</table>
		   
	
	<br/>
	
	<?php include 'email_footer.php'; ?>
	</div>
</div>
