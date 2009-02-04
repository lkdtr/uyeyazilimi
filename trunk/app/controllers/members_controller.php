<?php
class MembersController extends AppController {

	var $name = 'Members';
	var $helpers = array('Html', 'Form');
	var $components = array('Email');
	var $pageTitle="Üyeler";

	function index() {
		$this->Member->recursive = 0;
		$this->set('members', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Member.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('member', $this->Member->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Member->create();
			if ($this->Member->save($this->data)) {
				$this->Session->setFlash(__('The Member has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Member could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Member', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Member->save($this->data)) {
				$this->Session->setFlash(__('The Member has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Member could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Member->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Member', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Member->del($id)) {
			$this->Session->setFlash(__('Member deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function login(){
	}
	
    function logout() {
    	$this->Auth->logout();
        $this->Session->setFlash('You have been logged out. ');
        $this->redirect(array('action'=>'login'));
        exit;
    }
	
	function new_member(){
		$this->pageTitle="Yeni Şifre Oluşturma";
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
   				$this->Session->setFlash('Böyle bir üye bulunamadı veya üyeye daha önce şifre atanmış. Şifrenizi unuttuysanız "Şifremi Unuttum"a tıklayın.');
				$this->redirect(array('action'=>'login'));
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
	            if($this->Member->save($user,false)){
   		    		//send mail after saving
	            	$this->Email->send();
   	   				$this->Session->setFlash('Şifreniz oluşturulmuştur ve eposta adresinize gönderilmiştir.');
					$this->redirect(array('action'=>'login'));
	            }
	            $this->Session->setFlash('Şifreniz oluşturulurken bir hata oluşmuştur. Lütfen tekrar deneyiniz.');
	        }
        }
	}

	function forgot_my_password() {
		if (!empty($this->data)) {
		 	$member = $this->Member->find(array('lotr_alias'=>$this->data['Member']['lotr_alias']));
		 	//Girilen mail veritabaninda yoksa veya boş veri gönderilmişse hata ver.
		 	if (empty ($member)) {
				$this->Session->setFlash(__('The email you have entered is not registered with us.',true));//Hata mesajı
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
				$this->Session->setFlash(__('A link has been sent to your email address to reset your password. Please check your email.', true));
				$this->redirect(array('action'=>'login'));
			}
		}
	}
	
	function confirm_password_change($incominghash=null) {		
		if (!empty ($incominghash)){ 
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
				$this->Session->setFlash(__('Your new password has been sent to your email. Please check your email.', true));//İşlem yapıldı mesajı.
				$this->redirect(array('action'=>'login'));
			}		
		}
		//bir incominghash yoksa veya eşleşme yoksa hata ver.
		$this->Session->setFlash(__('Your new password request may have expired. Please re-request your password.', true));
		$this->redirect(array('action'=>'login'));
	}	

	function cancel_password_change($incominghash=null){	
		if(!empty ($incominghash)){
		App::import('Model','PasswordConfirmation'); 
		$passwordConfirmation = & new PasswordConfirmation(); 
		$memberId=$passwordConfirmation->checkAndDelete($incominghash);
			if (is_numeric($memberId)) { 
				$this->Session->setFlash(__('Your request for a new password has been deleted.', true));
				$this->redirect(array('action'=>'login'));				
			}
		}
		$this->Session->setFlash(__('Your new password request may have expired. Please re-request your password.', true));
		$this->redirect(array('action'=>'login'));
	}
	
	
	function __send_new_password($member, $pass){	
		$this->Email->layout="default";
    	$this->Email->to = $member['Member']['lotr_alias'].'@linux.org.tr';
    	$this->Email->subject = 'Linux Kulla�nıcıları Derneği Üye Sistemi İçin Yeni Şifreniz';
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
    	$this->Email->subject = 'LKD Üye Sistemi İçin Yeni Şifre İsteği';
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

	
    function isAuthorized() {
    	$allowedActions=array('member'=>array('index','logout'),
    					'admin'=>array('index','logout')
    	);
    	if(parent::isAuthorized()){
    		if(in_array($this->params['action'],$allowedActions[$this->Auth->user('member_type')])) return true;
    	}
		return false;
    }
}
?>
