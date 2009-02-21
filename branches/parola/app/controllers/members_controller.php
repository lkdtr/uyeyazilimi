<?php
class MembersController extends AppController {

	var $name = 'Members';
	var $helpers = array('Html', 'Form');
	var $components = array('Email');
	var $pageTitle="Parola İşlemleri";

	/*function login(){
	}
	
    function logout() {
    	$this->Auth->logout();
        $this->Session->setFlash('You have been logged out. ');
        $this->redirect(array('action'=>'login'));
        exit;
    }*/
    
    function index(){
    	
    }
	
	function new_member(){
		$this->pageTitle="Yeni Parola Oluşturma";
		//import sanitization class, cake-style
		App::import('Sanitize');
		//get the alias
		$UserName = $this->data['Member']['lotr_alias'];
		//delete everything non-alphanumeric except period (.)
        $UserName = Sanitize::paranoid($UserName, array('.')); 
        if (!empty($UserName)) {
        	//lets get the user data from alias, the password must be NULL
        	//so we dont overwrite previous password
        	$this->Member->recursive=-1;
        	$user=$this->Member->find('first',array('conditions'=>array('Member.lotr_alias'=>$UserName,'Member.password IS NULL')));
	        if (empty($user)) {
   				$this->Session->setFlash('Böyle bir üye bulunamadı veya üyeye daha önce parola atanmış. Parolanızı unuttuysanız "Parolamı Unuttum"a tıklayın.');
				$this->redirect(array('action'=>'index'));
        	} else {
				$this->set('user',$user);
	    		$NewPassword = $this->__generatePassword();
	    		$this->Email->to = $UserName.'@linux.org.tr';
	    		$this->Email->subject = 'Linux Kullanıcıları Derneği Üye Sistemi Parolanız';
	    		$this->Email->replyTo = $this->defaultEmailAddreses['reply-to'];
	    		$this->Email->from = $this->defaultEmailAddreses['from'];
	    		$this->Email->template = 'new_member_password'; //in /views/elements/email/text/new_member_password.ctp
	    		$this->Email->sendAs = 'text'; 
	    		//set password
	    		$this->set('Password',$NewPassword);
	    
	    		/*
	    		 * SMTP Options
	    		 * Enable if we are sending via SMTP
	    		 
	    		$this->Email->smtpOptions = array(
	    			'port'=>'25', 
	    			'timeout'=>'30',
	    			'host' => 'localhost',);
	    		
	    		/* Set delivery method 
	    		$this->Email->delivery = 'smtp';*/
			
	    		/* Do not pass any args to send() */
			
	    		/* Check for SMTP errors. */
	    		//$this->set('smtp-errors', $this->Email->smtpError);
	            $user['Member']['password']= md5($NewPassword);
       			$this->Member->create();
       			//save only password without validation
	            if($this->Member->save($user,false,array('password'))){
   		    		//send mail after saving
	            	$this->Email->send();
   	   				$this->Session->setFlash('Parolanız oluşturulmuş ve e-posta adresinize gönderilmiştir.');
					$this->redirect(array('action'=>'index'));
	            }
	            $this->Session->setFlash('Parolanız oluşturulurken bir hata oluşmuştur. Lütfen tekrar deneyiniz.');
	        }
        }
	}

	function forgot_my_password() {
		$this->pageTitle="Parolamı Unuttum";
		if (!empty($this->data)) {
			App::import('Sanitize');
			$this->data['Member']['lotr_alias'] = Sanitize::paranoid($this->data['Member']['lotr_alias'], array('.'));
			$member = $this->Member->find(array('lotr_alias'=>$this->data['Member']['lotr_alias']));
		 	//Girilen mail veritabaninda yoksa veya boş veri gönderilmişse hata ver.
		 	if (empty ($member)) {
				$this->Session->setFlash("Böyle bir üye bulunamadı.");//Hata mesajı
				$this->redirect(array('action'=>'forgot_my_password'));	//yeni bir email girmek için forgot_my_password'e geri dön.
		 	}
			else {
				//Password Confirmation modelini çağır ve sınıfı initialize et..
				App::import('Model','PasswordConfirmation');
				$passwordConfirmation = & new PasswordConfirmation();
				//confirmation oluştur
				$hash=$passwordConfirmation->newHash($member['Member']['id']);
				//Kullanıcıya gönderilecek mail için gerekli olan fonksiyon çağırılır.
				$this->__send_forgot_my_password_email($member, $hash);
				$this->Session->setFlash('E-posta adresinize parolanızı tekrar oluşturmak için bir bağlantı gönderildi. Lütfen e-posta kutunuzu kontrol ediniz.');
				$this->redirect(array('action'=>'index'));
			}
		}
	}
	
	function confirm_password_change($incominghash=null) {
		if (!empty ($incominghash)){
		App::import('Sanitize');
		$incominghash = Sanitize::paranoid($incominghash);
		App::import('Model','PasswordConfirmation'); 
		$passwordConfirmation = & new PasswordConfirmation(); 
		$memberId=$passwordConfirmation->checkAndDelete($incominghash);
			if (is_numeric($memberId)) { 
				$pass = $this->__generatePassword();
				$newpass = Security::hash($pass,null,true); //yeni şifreyi hashler..
				//Kullanıcının şifresini değiştirir.
				$this->Member->updateAll(array('Member.password' => "'$newpass'") , array('Member.id' => $memberId));  
				//Kullanıcının bütün bilgilerini okur. Bu bilgiler mail atarken kullanılacak. (isim, soyisim, mail)
				$member = $this->Member->read(null, $memberId);				
				$this->__send_new_password($member, $pass);	//send_new_password fonksiyonunu çağırır.
				$this->Session->setFlash('Yeni parolanız e-posta adresinize gönderildi. Lütfen e-posta kutunuzu kontrol ediniz.');//İşlem yapıldı mesajı.
				$this->redirect(array('action'=>'index'));
			}		
		}
		//bir incominghash yoksa veya eşleşme yoksa hata ver.
		$this->Session->setFlash('Parola isteğiniz zaman aşımına uğramış olabilir. Lütfen yeniden parola isteğinde bulununuz.');
		$this->redirect(array('action'=>'index'));
	}	

	function cancel_password_change($incominghash=null){	
		if(!empty ($incominghash)){
		App::import('Sanitize');
		$incominghash = Sanitize::paranoid($incominghash);
		App::import('Model','PasswordConfirmation'); 
		$passwordConfirmation = & new PasswordConfirmation(); 
		$memberId=$passwordConfirmation->checkAndDelete($incominghash);
			if (is_numeric($memberId)) { 
				$this->Session->setFlash('Yeni parola talebiniz iptal edilmiştir.');
				$this->redirect(array('action'=>'index'));				
			}
		}
		$this->Session->setFlash('Parola isteğiniz zaman aşımına uğramış olabilir. Lütfen yeniden parola isteğinde bulununuz.');
		$this->redirect(array('action'=>'index'));
	}
	
	
	function __send_new_password($member, $pass){	
		$this->Email->layout="default";
    	$this->Email->to = $member['Member']['lotr_alias'].'@linux.org.tr';
    	$this->Email->subject = 'Linux Kullanıcıları Derneği Üye Sistemi İçin Yeni Parolanız';
    	$this->Email->from = $this->defaultEmailAddreses['from'];
   		$this->Email->replyTo = $this->defaultEmailAddreses['reply-to'];
    	$this->Email->template = 'new_password'; 
    	$this->Email->sendAs = 'text';
    	$this->set('member', $member);
    	$this->set('new_password', $pass);
    	$this->Email->send();
    	return;
	}
	
	function __send_forgot_my_password_email($member, $hash) {
		$this->Email->layout="default";
    	$this->Email->to = $member['Member']['lotr_alias'].'@linux.org.tr';
    	$this->Email->subject = 'LKD Üye Sistemi İçin Yeni Parola İsteği';
    	$this->Email->from = $this->defaultEmailAddreses['from'];
   		$this->Email->replyTo = $this->defaultEmailAddreses['reply-to'];
    	$this->Email->template = 'request_new_password';
    	$this->Email->sendAs = 'text'; 
    	$this->set('member', $member);
    	$this->set('hash', $hash);
	    $this->Email->send();
	    return;
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

	
    /*function isAuthorized() {
    	$allowedActions=array('member'=>array('index','logout'),
    					'admin'=>array('index','logout')
    	);
    	if(parent::isAuthorized()){
    		if(in_array($this->params['action'],$allowedActions[$this->Auth->user('member_type')])) return true;
    	}
		return false;
    }*/
}
?>
