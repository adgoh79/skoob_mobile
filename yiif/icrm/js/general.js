$(document).ready(function() {
		if($('div.errorSummary').length > 0)
		{
			//display checkbox filter if exist
			//console.log('error, showing checkbox '+$('#SendEmailForm_filter_wing_category' ).is(":checked"));
			console.log('?????? '+$('#SendEmailForm_filter_area_of_interest' ).is(":checked"));
			//$(':checkbox.filter_wing').checked?$('.crow').show():$('.crow').hide();
			if($('#SendEmailForm_filter_wing_category' ).is(":checked"))
				$('.crow').show();
			else
				$('.crow').hide();
			
			if($('#SendEmailForm_filter_area_of_interest' ).is(":checked"))
			{
				$('.crow_1').show();
			}	
			else
			{
				$('.crow_1').hide();			
				console.log('hide');
			}	
		}
		else
		{
			console.log('oasmdoij ');
		}

 });

$(function () {
		
	
 $(':checkbox').change(function () {
        //console.log('the checkall has been checked on calss name='+$(this).attr('class'));
		var className=$(this).attr('class');
		var checked=this.checked;
		console.log('class===='+className+' index=='+className.indexOf('filter_wing'));
		
		
		
		if(className=='filter_wing')
		{
			if(checked)
			{
				
				$('.crow').slideDown("slow");
			}	
			else
			{
			
				 $(".crow").slideUp("slow");
			}	 
		}
		else if(className=='filter_interest')
		{
			if(checked)
			{
				$('.crow_1').slideDown("slow");
			}	
			else
			{
			
				 $(".crow_1").slideUp("slow");
			}
		}
		else if(className.indexOf('member_types')>-1)
		{
			if($(this).val()=="Everybody")
			{
				console.log('here here');
				$(this).parent().children().each(function () {
					$('input:checkbox.member_types').attr('checked',checked);
					
				});
			}
			else
			{
				
				$(this).parent().children(":first").attr('checked',false);
			}
		}
		if(className.indexOf('_subcat')>0)
		{
			var parent_class=className.substring(0,className.indexOf('_subcat'));
			//console.log('parent class==='+parent_class);
			if(!checked)
			{
				$('input:checkbox.'+parent_class).attr('checked',false);
				//for items everything except All
				$(this).parent().children().each(function () {
					if($(this).val()==0)
						$(this).attr('checked',checked);
				});
			}
			else	
			{
				var all_checked=true;
				$('input:checkbox.'+className).each(function () {
					all_checked=(this.checked && all_checked)?true:false;
				});
				//console.log('allchecked?'+all_checked);
				if(all_checked)
					$('input:checkbox.'+parent_class).attr('checked',true);
			}
		}
		else
		{
			
			if($(this).val()==0) //all has been selected
			{
			
				$(this).parent().children().each(function () {
					$(this).attr('checked',checked);
				});
				/*
				$(this).siblings('div.').each(function () {
					$('input:checkbox').attr('checked',checked);
				});*/
					
			}
			else
			{
				//for items everything except All
				$(this).parent().children().each(function () {
					if($(this).val()==0 && !checked)
						$(this).attr('checked',checked);
				});
				
				var children_class=$(this).attr('class')+'_subcat';
				
				$('input:checkbox.'+children_class).each(function () {
					   $(this).attr('checked',checked);
				  });
			}
		 }
    });
});