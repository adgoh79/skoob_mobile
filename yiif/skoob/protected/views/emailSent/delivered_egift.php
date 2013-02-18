<?php
/* @var $this EmailerController */
?>	

	
	<div style="width:90%;margin:0 auto;margin-top: 5px;margin-bottom: 5px;	background: white;border:2px solid #cccccc;border-radius:5px;" class="container" id="page">
	<?php include 'email_header.php'; ?>
	<table align="center" style="width: 90%; border:1px;line-height:100%;" class="table-info">
		<tr>	
			<td align="left" ><br/>Dear <?php echo $model->egift['sender_name']; ?>,</td>
		</tr>
		<tr>
			<td  style="padding-top:20px;" align="left" >Your e-Gift Voucher with the value of <?php echo $globaldef->CURRENCY_SYM.$model->egift['amount']; ?> has been successfully sent to <?php $model->egift['recipient_name'] ?> at the email address <?php echo $model->egift['recipient_email']; ?></td>
		</tr>
		
		<tr>
			<td style="padding-top:20px;" align="left" >Regards,<br/>skoob team</td>
		</tr>
		
	</table>
	<?php include 'email_footer.php'; ?>
	</div>
	
	
