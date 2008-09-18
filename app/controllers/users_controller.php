<?php
App::import('Sanitize');
class UsersController extends AppController {
	var $name = 'Users';
	var $components = array('Email');
	function login() {
	}
	function logout(){
		$this->redirect($this->Auth->logout());
    }
	function __generatePassword($length=9, $strength=4) {
	    $vowels = 'aeuy';
	    $consonants = 'bdghjmnpqrstvz';
	    if ($strength & 1) {
		    $consonants .= 'BDGHJLMNPQRSTVWXZ';
	    }
	    if ($strength & 2) {
		    $vowels .= "AEUY";
	    }
	    if ($strength & 4) {
		    $consonants .= '23456789';
	    }
	    if ($strength & 8) {
		    $consonants .= '@#$%';
	    }
	
	    $password = '';
	    $alt = time() % 2;
	    for ($i = 0; $i < $length; $i++) {
		    if ($alt == 1) {
		        $password .= $consonants[(rand() % strlen($consonants))];
		        $alt = 0;
		    } else {
		        $password .= $vowels[(rand() % strlen($vowels))];
		        $alt = 1;
		    }
	    }
	    return $password;
	}

	function newuser(){
		//$User = $this->User->read(null,$id);
		//$this->Email->to = $User['User'][0]['email'];
		$UserName = $this->params['data']['User']['username'];
        $UserName = Sanitize::paranoid($UserName, array('.', '@')); 
        if (!empty($UserName)) {
	$this->set('user', $this->User->find('first',array('conditions'=>array('username'=>$UserName))));
        if (empty($this->user)) {
            $this->flash('Bu kullanıcıya ait bir kayıt bulunamadı!','/users/login');
        } else {

    		$NewPassword = $this->__generatePassword();
    		$this->Email->to = $UserName;
            //$this->flash($username, '/users/newuser');
    		//$this->Email->bcc = array('secret@example.com');  // note
    								// this could be just a string too
    		$this->Email->subject = 'Linux Kullanıcıları Derneği Üye Sistemi';
    		$this->Email->replyTo = 'ktoksoz@koraytoksoz.com';
    		$this->Email->from = 'LKD <ktoksoz@koraytoksoz.com>';
    		$this->Email->template = 'simple_message'; // note no '.ctp'
    		//Send as 'html', 'text' or 'both' (default is 'text')
    		$this->Email->sendAs = 'text'; // because we like to send pretty mail
    		//Set view variables as normal
    		//$this->set('User',$this->user );
    		$this->set('Password',$NewPassword);
    		//Do not pass any args to send()
    
    		/* SMTP Options */
    		$this->Email->smtpOptions = array(
    			'port'=>'25', 
    			'timeout'=>'30',
    			'host' => 'localhost',);
    		
    		/* Set delivery method */
    		$this->Email->delivery = 'smtp';
		
    		/* Do not pass any args to send() */
    		$this->Email->send();
		
    		/* Check for SMTP errors. */
    		$this->set('smtp-errors', $this->Email->smtpError);
            $this->user['password']= $NewPassword;
            $this->User->save($this->user);
            $this->flash("Pass: ".$this->user['password'],'/users/login');
            //$this->flash('Kullanıcı bilgileriniz eposta adresinize gönderildi.', '/users/login');
        }
        }
	}

}
