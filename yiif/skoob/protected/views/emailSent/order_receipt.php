
<?php
/* @var $this EmailerController */
	$terms_url=Yii::app()->globaldef->SKOOB_EVOUCHER_TAC;
?>
<div style="width:90%;margin:0 auto;margin-top: 5px;
	margin-bottom: 5px;	background: white;border:2px solid #cccccc;border-radius:5px;" class="container" id="page"> 
	<?php include 'email_header.php'; ?>
	
	<table align="center" style="width: 90%; border:1px;line-height:100%;" class="table-info">
		<tr>	
			<td align="left" ><br/>Dear <?php echo $model->egift->sender_name; ?>,</td>
		</tr>
		<tr>
			<td  style="padding-top:20px;" align="left" >Thank you for purchasing skoob e-Gift Voucher.</td>
		</tr>
		<tr>
			<td style="padding-top:20px;" align="left" >Please find your purchase confirmation details below.</td>
		</tr>
		<tr>
			<td style="padding-top:20px;" align="left" >We look forward to your next visit!</td>
		</tr>
		<tr>
			<td style="padding-top:20px;" align="left" >Regards,<br/>skoob team</td>
		</tr>
		
	</table>
	<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;width:95%;" />
	<table align="center" style="width: 90%;" class="table-info">
		<tr>
			<th align="left" colspan="3">Order Summary</th>
		</tr>
		<tr>
			
			<th>ITEM</th>
			<th>DATE</th> 
			<th style="text-align:right;">PRICE</th>
		</tr>
		<tr>
			<td>1.eGift Card</td>
			<td><?php echo $model->egift->delivery_date; ?></td>
			<td style="text-align:right;"><?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount; ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;"><b>GRAND TOTAL: <?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount; ?></b></td>
		</tr>
		<tr>
			<td align="left" colspan="3"><?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount; ?> has been charged to your credit card.</td>
		</tr>
	</table>

	   
	
	<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;width:95%;" />
	<table align="center" style="width: 90%;" class="table-info">
		<tr>
			<td align="left">For more information on the terms of your purchase, visit: <a href="<?php echo $terms_url; ?>"><?php echo $terms_url; ?></a></td>
		</tr>
	</table>
	<br/><br/>
	
	<?php include 'email_footer.php'; ?>
	</div>
</div>
