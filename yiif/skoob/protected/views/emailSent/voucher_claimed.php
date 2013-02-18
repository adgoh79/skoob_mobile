
<?php
/* @var $this EmailerController */
	
?>
<div style="width:90%;margin:0 auto;margin-top: 5px;
	margin-bottom: 5px;	background: white;border:2px solid #cccccc;border-radius:5px;" class="container" id="page"> 
	<?php include 'email_header.php'; ?>
	
	<table align="center" style="width: 90%; border:1px;line-height:100%;" class="table-info">
		<tr>	
			<td align="left" ><br/>Dear <?php echo $model->sender_name; ?>,</td>
		</tr>
		<tr>
			<td  style="padding-top:20px;" align="left" >Your egift voucher with the value of <?php echo $voucher_value ?> has been redeemed by <?php echo $model->recipient_name ?> at address <?php echo $model->recipient_email ?> on date <?php echo $redeem_date ?>.</td>
		</tr>
		
		<tr>
			<td style="padding-top:20px;" align="left" >Regards,<br/>skoob team</td>
		</tr>
		
	</table>
		   
	
	<br/>
	
	<?php include 'email_footer.php'; ?>
	</div>
</div>
