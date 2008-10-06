<?php
uses('L10n');
class AppController extends Controller
{
	var $components = array('Auth');
	//var $sessionAccountId=null;
	var $defaultEmailAddreses=array('from'=>'LKD Üye Sistemi <uyesistemi@lkd.org.tr>','reply-to'=>'uyesistemi@lkd.org.tr');
	//publicly accesable array(controllers=>array(actions))
	var $publicControllersActions=array('members'=>array('new_member','forgot_my_password'));
	/*function authenticate(){
		//Check if the session has timed out.
			$account=$this->Session->read('Account');
			$auth =& new AuthComponent();
			if(!$auth->checkAuth($account, $this->name, $this->action)){
				//if unauthorized and anonymous redirect to login
				if(!$account){
					$this->addLog("Anonymous unauthorized access try.");
					$this->Session->setFlash(__('You must login to view that area.',true));
		        	//$this->redirect($this->referer());
		        	$this->redirect(array('controller'=>'accounts','action'=>'login'));
		        	exit();
				}
				$this->addLog("Unauthorized access try.");
				$this->Session->setFlash(__('You\'re not authorized.',true));
	        	//$this->redirect($this->referer());
	        	$this->redirect(array('controller'=>'home','action'=>'index'));
	        	exit();
			}
			$this->sessionAccountId=$account['id'];
		
	}*/
	
	function beforeFilter(){
	  if (isset($this->Auth)) {
	  	/*
		 * Set the default hashing method to MD5 so that we can talk with other applications.
		 */
		Security::setHash('md5');
	  	$this->Auth->userModel = 'Member';
	  	$this->Auth->autoRedirect = true;
	    $this->Auth->loginAction = array('controller'=>'members','action'=>'login');
	    $this->Auth->loginRedirect = array('controller'=>'members','action'=>'index');
	    $this->Auth->fields = array('username' => 'lotr_alias','password'=>'password');
	    $this->Auth->authorize = 'controller';
	    $this->Auth->authError="You are not authorized to do this action. ".$this->Auth->action();
	    $this->Auth->loginError="Wrong username/password.";
	    if (in_array(low($this->params['action']), $this->publicControllersActions[low($this->params['controller'])])) {
	    	$this->Auth->allow();
      	}
	  }
	}
	
    function isAuthorized() {
        return true;
    }
	
	function findFileExtension ($filename)
	{
		$filename = strtolower($filename) ;
		$exts = split("[/\\.]", $filename) ;
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
	} 
		
	function findIp() {
      if(getenv("HTTP_CLIENT_IP"))
        return getenv("HTTP_CLIENT_IP"); 
      elseif(getenv("HTTP_X_FORWARDED_FOR"))
        return getenv("HTTP_X_FORWARDED_FOR"); 
      else 
        return getenv("REMOTE_ADDR"); 
    } 
    
	function success($text=null) {
		header("HTTP/1.0 200 Success", null, 200);
		echo $text;
		exit;
	}
	
	function failure() {
		header("HTTP/1.0 404 Failure", null, 404);
		exit;
	}
	
	function failure500() {
		header("HTTP/1.1 500 Internal Server Error", null, 500);
		echo"asd";
		exit;
	}
	

	
}
?>