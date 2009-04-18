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

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Account', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Account->save($this->data)) {
				$this->Session->setFlash(__('The Account has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Account could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Account->read(null, $id);
		}
		$members = $this->Account->Member->find('list');
		$this->set(compact('members'));
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
		$memberId=$passwordConfirmation->checkAndDelete($incominghash);
			if (is_numeric($memberId)) { 
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