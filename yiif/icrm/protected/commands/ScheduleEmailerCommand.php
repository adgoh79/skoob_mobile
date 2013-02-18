<?php
	//yiic run from <installation directory>\icrm\protected\
	//so require_once in this way
	require_once dirname(__FILE__)."/../components/EmailManager.php";
	require_once dirname(__FILE__)."/../config/EmailReminderConfig.php";
	
	class ScheduleEmailerCommand extends CConsoleCommand
	{
		public function run($args)
		{
			//echo Yii::app()->db->connectionString;
			//Yii::app()->authManager;
			
			$con = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
			
			if($con)
			{
				mysqli_select_db($con, DB_NAME);
				
				
				//send reminder for those membership about to be up
				$this->sendOneMonthEmailReminder($con);
				//send reminder for those membership that they haven't pay 
				//for a period of 4 months, every 2 weeks
				$this->sendRepeatEmailReminder($con);
					
				//finish job close conn
				mysqli_close($con);
			}
		}
		
		
		private function sendOneMonthEmailReminder($con)
		{
			$sql="SELECT b.email,b.first_name,b.last_name,c.name as member_type_name,a.next_paid_dt FROM tbl_membership_fee a "
				."inner join tbl_user b "
				."on a.user_id=b.id "
				."inner join tbl_member_type c "
				."on b.member_type=c.id "
				."where c.name NOT IN ('Non Member','Life Member') "
				."AND  DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 MONTH),'%Y-%m-%d')";
			$res = mysqli_query($con,$sql);
			while ($row = $res->fetch_assoc())
			{
				$msg='Dear '.$row['first_name'].' '.$row['last_name'].','."<br/><br/>"
					.'This is a gentle reminder. '
					.'Your membership fee for \''.$row['member_type_name'].'\' will be due in one month\'s time.'
					."<br/<br/>".'Thank You for reading this email.'."<br/><br/>"
					.'Best Regards,'."<br/>".'From Chimaya Seva Centre'
				;
				echo $msg;
				$this->sendEmail($row['email'],$msg);
			}
		}
	
		private function sendRepeatEmailReminder($con)
		{
			$sql="SELECT b.email,b.first_name,b.last_name,c.name as member_type_name,a.next_paid_dt FROM tbl_membership_fee a "
				." inner join tbl_user b "
				." on a.user_id=b.id "
				." inner join tbl_member_type c "
				." on b.member_type=c.id "
				." where c.name NOT IN ('Non Member','Life Member') "
				." AND "
				." (DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 2 WEEK),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 1 MONTH),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 6 WEEK),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 2 MONTH),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 10 WEEK),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 3 MONTH),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 14 WEEK),'%Y-%m-%d') "
				." OR "
				." DATE_FORMAT(next_paid_dt,'%Y-%m-%d') = DATE_FORMAT(DATE_SUB(NOW(),INTERVAL 4 MONTH),'%Y-%m-%d') )"
				;
			$res = mysqli_query($con,$sql);
			while ($row = $res->fetch_assoc())
			{
				$msg='Dear '.$row['first_name'].' '.$row['last_name'].','."<br/><br/>"
					.'We would like to remind you that '
					.'your membership fee for \''.$row['member_type_name'].'\' is overdue.'
					.'<br/<br/>'
					.'We shall be glad if you will send us a cheque to balance the amount immediately.'
					.' If by any chance your cheque is already in the mail, please ignore this reminder and accept our thanks.'
					.'<br/><br/>'
					.'Best Regards,'."<br/>".'From Chimaya Seva Centre'
				;
				echo $msg;
				$this->sendEmail($row['email'],$msg);
			}
		}
			
		private function sendEmail($recipient, $msg)
		{
			$subject = 'Membership Fee payment reminder';
			$emgr =new EmailManager();
			$emgr->sendMail($subject,$recipient,$msg,'');	
		}
	}
?>