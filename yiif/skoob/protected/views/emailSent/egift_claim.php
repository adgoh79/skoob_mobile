<?php
/* @var $this EmailerController */
	$bURL = Yii::app()->params['base_url'];
?>
<div style="width:90%;margin:0 auto;margin-top: 5px;margin-bottom: 5px;	background: white;border:2px solid #cccccc;border-radius:5px;" class="container" id="page"> 
	<?php include 'email_header.php'; ?>
	


		<table align="center" style="width: 90%; border:1px;line-height:100%;" class="table-info">
			<tr>	
				<td align="left" ><br/>Dear <?php echo $model->egift->recipient_name; ?>,</td>
			</tr>
			<tr>
				<td  style="padding-top:20px;" align="left" >"<?php echo $model->egift->message; ?>"</td>
			</tr>
			<tr>
				<td style="padding-top:20px;" align="left" ><?php echo $model->egift->sender_name; ?> has sent you a <?php echo Yii::app()->globaldef->CURRENCY_SYM.$model->egift->amount; ?> skoob eGift card.</td>
			</tr>
			
			
		</table>		
				
			<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;width:95%;" class="seperator" />
			
			<div style="margin-left: auto;margin-right: auto;width:90%;text-align:center; " align="center" > 
				<img  src="<?php echo $bURL.$model->egift->gift_card_img; ?>" alt="egift card"  height="auto" />
			</div>
			<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;width:95%;" class="seperator" />
			<br/>
			<div style="margin-left: auto;margin-right: auto;width:90%;text-align:center; " class="centered-text h-center">
				<span style="color:#990000;font-size:200%;" class="font-attn">A Gift for YOU!</span>
				<br/>
				<span style="background-color:#dedbdb;font-size:150%;padding:5px;" class="font-wrap">
				<span style="color:#00aeef;" class="font-label">VOUCHER CODE:</span> <span style="color:#666666;"><?php echo $model->checkout->voucher_no; ?></span></span>
			</div>
			
			<br/>
			<hr style="border:dotted #cccccc; border-width:2px 0 0; height:0;width:95%;" class="seperator"/>
			<br/>
			<div  style="margin-left: auto;margin-right: auto;width:90%; " class="centered-text">
				How to Redeem Your eGift Card? 
				<ol>
					<li>Create a <span style="color:red;font-style:italic;" class="redHighlight">free skoob account</span> or <span style="color:red;font-style:italic;" class="redHighlight">sign in</span> if you already have one.</li>
					<li>Go to <span style="color:red;font-style:italic;" class="redHighlight">My Account > Voucher/Credit Management</span> and enter the voucher code displayed above.</li>
					<li>Your account will be credited with the gift value and be used to purchase all titles on skoob.</li>
				</ol>
			</div>
		
		<br/>
		
	<?php include 'email_footer.php'; ?>
	</div>
