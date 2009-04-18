<?php
class AccountsController extends AppController {

	var $name = 'Accounts';
	var $helpers = array('Html', 'Form');
	var $components = array('Email');

	function index() {
		$this->Account->recursive = 0;
		$this->set('accounts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Account.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('account', $this->Account->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Account->create();
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The Account has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Account could not be saved. Please, try again.', true));
			}
		}
		$members = $this->Account->Member->find('list');
		$this->set(compact('members'));
	}

	function change_password($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Account', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Account']['password']=md5($this->data['Account']['password']);
			$this->data['Account']['confirm_password']=md5($this->data['Account']['confirm_password']);
			if($this->data['Account']['password']!=$this->data['Account']['confirm_password']){
				$this->Session->setFlash(__('Password do not match.', true));
			}
			$account=$this->Account->read(null,$this->data['Account']['id']);
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('Password has been changed', true));
				$this->redirect(array('controller'=>'members','action'=>'view',$account['Account']['member_id']));
			} else {
				$this->data=$account;
				$this->Session->setFlash(__('Password could not be changed. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Account->read(null, $id);
			$this->data['Account']['password']="";
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Account', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Account->del($id)) {
			$this->Session->setFlash(__('Account deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function toggle_active($id){
		$account=$this->Account->read(null,$id);
		if(!empty($account)){
			$this->Account->toggleAccount($id);
			if($account['Account']['active']) $this->Session->setFlash(__('Account deactivated', true));
			else $this->Session->setFlash(__('Account activated', true));
			$this->redirect(array('controller'=>'members','action'=>'view',$account['Member']['id']));
		}
		else{
			$this->redirect(array('controller'=>'members','action'=>'index'));
		}
	}
	
	function new_member(){
		$this->pageTitle="Yeni Parola Oluşturma";
		//import sanitization class, cake-style
		App::import('Sanitize');
		//get the alias
		$UserName = $this->data['Account']['lotr_alias'];
		//delete everything non-alphanumeric except period (.)
        $UserName = Sanitize::paranoid($UserName, array('.')); 
        if (!empty($UserName)) {
        	//lets get the user data from alias, the password must be NULL
        	//so we dont overwrite previous password
        	$this->Account->recursive=-1;
        	$user=$this->Account->find('first',array('conditions'=>array('Account.lotr_alias'=>$UserName,'Account.password IS NULL')));
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
	            $user['Account']['password']= Security::hash($NewPassword,'md5',false);//şifreyi md5 kullanarak salt değer eklemeden hashler
       			$this->Account->create();
       			//save only password without validation
	            if($this->Account->save($user,false,array('password'))){
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
		//sayfa başlığını belirle
		$this->pageTitle="Parolamı Unuttum";
		//eğer formdan gelen veri varsa
		if (!empty($this->data)) {
			//sanitize sınıfını başlat
			App::import('Sanitize');
			$this->data['Account']['lotr_alias'] = Sanitize::paranoid($this->data['Account']['lotr_alias'], array('.'));
			//lotr_alias'a sahip hesabı bul
			$account = $this->Account->find(array('lotr_alias'=>$this->data['Account']['lotr_alias']));
		 	//Girilen mail veritabaninda yoksa veya boş veri gönderilmişse hata ver.
		 	if (empty ($account)) {
				$this->Session->setFlash("Böyle bir üye bulunamadı.");//Hata mesajı
				$this->redirect(array('action'=>'forgot_my_password'));	//yeni bir email girmek için forgot_my_password'e geri dön.
		 	}
			else {
				//confirmation oluştur
				$hash=$this->Account->PasswordConfirmation->newHash($account['Account']['id']);
				//Kullanıcıya gönderilecek mail için gerekli olan fonksiyon çağırılır.
				$this->__send_forgot_my_password_email($account, $hash);
				$this->Session->setFlash('E-posta adresinize parolanızı tekrar oluşturmak için bir bağlantı gönderildi. Lütfen e-posta kutunuzu kontrol ediniz.');
				$this->redirect(array('action'=>'index'));
			}
		}
	}
	
	function confirm_password_change($incominghash=null) {
		if (!empty ($incominghash)){
		App::import('Sanitize');
		$incominghash = Sanitize::paranoid($incominghash);
		
		$accountId=$this->Account->PasswordConfirmation->checkAndDelete($incominghash);
			if (is_numeric($accountId)) { 
				$pass = $this->__generatePassword();
				$newpass = Security::hash($pass,'md5',false); //şifreyi md5 kullanarak salt değer eklemeden hashler
				//Kullanıcının şifresini değiştirir.
				$this->Account->updateAll(array('Account.password' => "'$newpass'") , array('Account.id' => $accountId));  
				//Kullanıcının bütün bilgilerini okur. Bu bilgiler mail atarken kullanılacak. (isim, soyisim, mail)
				$account = $this->Account->read(null, $accountId);				
				$this->__send_new_password($account, $pass);	//send_new_password fonksiyonunu çağırır.
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
		$accountId=$passwordConfirmation->checkAndDelete($incominghash);
			if (is_numeric($accountId)) { 
				$this->Session->setFlash('Yeni parola talebiniz iptal edilmiştir.');
				$this->redirect(array('action'=>'index'));				
			}
		}
		$this->Session->setFlash('Parola isteğiniz zaman aşımına uğramış olabilir. Lütfen yeniden parola isteğinde bulununuz.');
		$this->redirect(array('action'=>'index'));
	}
	
	
	function __send_new_password($account, $pass){	
		$this->Email->layout="default";
    	$this->Email->to = $account['Account']['lotr_alias'].'@linux.org.tr';
    	$this->Email->subject = 'Linux Kullanıcıları Derneği Üye Sistemi İçin Yeni Parolanız';
    	$this->Email->from = $this->defaultEmailAddreses['from'];
   		$this->Email->replyTo = $this->defaultEmailAddreses['reply-to'];
    	$this->Email->template = 'new_password'; 
    	$this->Email->sendAs = 'text';
    	$this->set('account', $account);
    	$this->set('new_password', $pass);
    	$this->Email->send();
    	return;
	}
	
	function __send_forgot_my_password_email($account, $hash) {
		$this->Email->layout="default";
    	$this->Email->to = $account['Account']['lotr_alias'].'@linux.org.tr';
    	$this->Email->subject = 'LKD Üye Sistemi İçin Yeni Parola İsteği';
    	$this->Email->from = $this->defaultEmailAddreses['from'];
   		$this->Email->replyTo = $this->defaultEmailAddreses['reply-to'];
    	$this->Email->template = 'request_new_password';
    	$this->Email->sendAs = 'text'; 
    	$this->set('account', $account);
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

}
?>