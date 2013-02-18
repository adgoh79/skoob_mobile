<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_authManager;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		
		Yii::log('the username=='.$this->username,'info','UserIdentity');
		$user=User::model()->findByAttributes(array('username'=>$this->username));
		if($user===null)
		{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else
		{
			if($user->password!==$user->encrypt($this->password))
			{
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			else
			{
				$this->_id = $user->id;
				if(null===$user->last_login_time)
				{
					$lastLogin = time();
				}
				else
				{
					$lastLogin = strtotime($user->last_login_time);
				}
				$this->setState('lastLoginTime', $lastLogin); 
				Yii::log('the last login time === '.$lastLogin,'info','UserIdentity');
				$this->errorCode=self::ERROR_NONE;
			}
		}
		
		//$this->runRBAC();
		/*
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			//add to find out user id
			$this->_id=$user->id;
			$this->errorCode=self::ERROR_NONE;
		}*/
		return !$this->errorCode;
	}
	
	 function runRBAC()
	{
			$this->_authManager=Yii::app()->authManager;
			if($this->_authManager===null)
			{
				Yii::log('Authorization hierarchy unable to be generated.','info','UserIdentity.runRABC');
			}
			else
			{
		//first we need to remove all operations, roles, child relationship	and assignments
			$this->_authManager->clearAll();
			//create the lowest level operations for users
			$this->_authManager->createOperation("createUser","create a new user");
			$this->_authManager->createOperation("readUser","read user profile information");
			$this->_authManager->createOperation("updateUser","update a users information");
			$this->_authManager->createOperation("deleteUser","remove a user from a project");
			//create the lowest level operations for projects
			$this->_authManager->createOperation("createProject","create a new project");
			$this->_authManager->createOperation("readProject","read project information");
			$this->_authManager->createOperation("updateProject","update project information");
			$this->_authManager->createOperation("deleteProject","delete a project");
			//create the lowest level operations for issues
			$this->_authManager->createOperation("createIssue","create a new issue");
			$this->_authManager->createOperation("readIssue","read issue information");
			$this->_authManager->createOperation("updateIssue","update issue information");
			
			$this->_authManager->createOperation("deleteIssue","delete an issue from a project");
			
			//create the reader role and add the appropriate permissions as	children to this role
			$role=$this->_authManager->createRole("reader");
			$role->addChild("readUser");
			$role->addChild("readProject");
			$role->addChild("readIssue");
			//create the member role, and add the appropriate permissions, as well as the reader role itself, as children
			$role=$this->_authManager->createRole("member");
			$role->addChild("reader");
			$role->addChild("createIssue");
			$role->addChild("updateIssue");
			$role->addChild("deleteIssue");
			//create the owner role, and add the appropriate permissions, as well as both the reader and member roles as children
			$role=$this->_authManager->createRole("owner");
			$role->addChild("reader");
			$role->addChild("member");
			$role->addChild("createUser");
			$role->addChild("updateUser");
			$role->addChild("deleteUser");
			$role->addChild("createProject");
			$role->addChild("updateProject");
			$role->addChild("deleteProject");
			//provide a message indicating success
			
			Yii::log('Authorization hierarchy successfully generated.','info','UserIdentity.runRABC');
			}
	}
	
	//custom function to get user id
	public function getId()
    {
        return $this->_id;
    }
}