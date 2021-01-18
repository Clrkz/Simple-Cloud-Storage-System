<?php
date_default_timezone_set("Asia/Manila");
error_reporting(0);
Class Admin{
	private $Login_Check = false;
	private $msg = null;
	private $Options = array( 
	  'big_title' => array('type' => 'string', 'text' => 'Big title'),
	  'website_title' => array('type' => 'string', 'text' => 'Website title'), 
	  //'upload_captcha' => array('type' => 'bool', 'text' => 'Captcha status'),
	  'max_upload_kb' => array('type' => 'int', 'text' => 'Max-upload size (KB)'), 
	  'error_large_file' => array('type' => 'string', 'text' => 'Error message on large size'), 
	  'upload_success' => array('type' => 'string', 'text' => 'Upload success message'), 
	  //'email_msg' => array('type' => 'string_area', 'text' => 'Email message'), 
	  'error_upload' => array('type' => 'string_area', 'text' => 'Error uploading'),
	  //'error_captcha' => array('type' => 'string', 'text' => 'Incorrect captcha'),
	  'file_not_select' => array('type' => 'string', 'text' => 'File not select'),
	  'error_extension' => array('type' => 'string', 'text' => 'Error extension'),
	  'extension_reject' => array('type' => 'string', 'text' => 'Extension reject'),
	  //'send_emails' => array('type' => 'bool', 'text' => 'Email function'),
	  //'max_emails' => array('type' => 'int', 'text' => 'Max emails'),
	  'domain' => array('type' => 'string', 'text' => 'Domain')
	);

	
	private $user = 0;
	private $pass = 0;
	
	private $config;
	
	private function Escape($arr){
		if(is_array($arr)){
			foreach($arr as $key=>$value){
				if(is_array($arr[$key])){
					$arr[$key] = $this->Escape($arr[$key]);
				}else{
					$arr[$key] = htmlspecialchars(mysql_real_escape_string($value));
				}
			}
			return $arr;
		}else{
			return htmlspecialchars(mysql_real_escape_string($arr));
		}
	}
	 
	function Admin(){
		include '../config.php';
		$this->config = $config;
		$this->connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['pass'],$config['mysql']['db']);
	}
	
	public function connect($host,$user,$pass,$db){
       mysql_connect($host,$user,$pass) or die("Cannot connect!") ;
       mysql_select_db($db) or die("Cannot connect to Database!") ;
       mysql_set_charset('utf8');
    } 
	
	function ShowMsg(){
		if(isset($this->msg['err'])){
			return $this->msg['err'];
		}elseif(isset($this->msg['ok'])){
			return $this->msg['ok'];
		}
		return null;
	}
	
	function Open($file){
		if(file_exists('../'.$file)){
		   include '../'.$file;
		}else{
		   $this->Open('../admin/main/error404.php');
		}
	}
	
	function Pass_Crypt($pass){
		for($i = 0;$i <= 5;$i++){
			$pass = base64_encode($pass);
		}
		
		for($i = 0;$i <= 3;$i++){
			$pass = md5($pass);
		}
		
		return $pass;
	}
	
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' Bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' Byte';
        }
        elseif ($bytes == 0)
        {
            $bytes = '0 Bytes';
        }
		else
		{
			$bytes = '0 Bytes';
		}
        
        return $bytes;
    }
	
	function Search(){
		if(isset($_GET['search'])){
			if(trim($_GET['search']) == null){
				return ' ';
			}
			return " WHERE real_filename like '%".$this->Escape($_GET['search'])."%' ";
		}
		return ' ';
	}
	
	function Auto($type,$header,$not){
		switch(strtoupper($type)){
			case "GET":
			if(isset($_GET[$header])){
				return $_GET[$header];
			}
			break;
			case "POST":
			if(isset($_POST[$header])){
				return $_POST[$header];
			}
			break;
		}
		
		return $not;
	}
	
    function Login_Post(){
	    $user = $_POST['user'];
		$pass = $_POST['pass'];
		
		if($this->config['captcha_admin']){
		    //$captcha = $_POST['captcha'];
		    $captcha = "";
		    if(isset($_SESSION['captcha_string'])){
		    	//if(strtoupper($_SESSION['captcha']) != strtoupper($captcha)){
					
		    	if($captcha != strtoupper($captcha)){
		    		$this->msg['err'] = '<center><div class="alert-message error">Invalid captcha code!</div></center>';
		    		return false;
		    	}
		    }else{
		    	$this->msg['err'] = '<center><div class="alert-message error">Invalid captcha code!</div></center>';
		    	return false;
		    }
		}
		
		if($user != null && $pass != null){
		    $check = mysql_query("SELECT * FROM box_admins WHERE user='".$this->Escape($user)."' AND pass='".$this->Pass_Crypt($pass)."' ;");
			if(mysql_num_rows($check) == 1){
			    $this->Login_Check = true;
				$info = mysql_fetch_array($check);
				$_SESSION['loged'] = $info['user'];
				$_SESSION['pass'] = $info['pass'];
				header('Location: ./');
			}else{
			    $this->msg['err'] = '<center><div class="alert-message error">WRONG USERNAME OR PASSWORD</div></center>';
			}
		}else{
		    $this->msg['err'] = '<center><div class="alert-message warning">PLEASE WRITE ALL THE INFORMATION</div></center>';
		}
	}
	
	function LoginCheck(){
		if(isset($_SESSION['loged']) && isset($_SESSION['pass'])){
			$this->Login_Check = true;
			$this->user = $_SESSION['loged'];
			$this->pass = $_SESSION['pass'];
		}
	}
	
	function Options_Update(){
		if(is_array($_POST['opt'])){
			foreach($_POST['opt'] as $name=>$value){
				if(isset($this->Options[$name])){
					$up = false;
					
					switch($this->Options[$name]['type']){
						case "string":
						$up = true;
						break;
						
						case "string_area":
						$up = true;
						break;
						
						case "bool":
						if($value == 1 || $value == 2){
							$up = true;
						}
						break;
						
						case "int":
						if(is_numeric($value)){
							$up = true;
						}
						break;
					}
					
					if($up){
						mysql_query("UPDATE box_options SET value='".mysql_real_escape_string($value)."' WHERE name='".$this->Escape($name)."' ;");
					}
				}
			}
			$this->msg['ok'] = '<center><div class="alert-message success">Updated successful.</div></center>';
		}
	}
	
	function DeleteFile(){
		if(is_array($_GET['delete'])){
			$this->msg['err'] = '<center><div class="alert-message error">Error!</div></center>';
			return;
		}
		
		$filename = $this->Escape($_GET['delete']);
		
		$query = mysql_query("SELECT filename,real_filename FROM box_files WHERE filename='".$filename."';");
		
		if(mysql_num_rows($query) == 1){
			$info = mysql_fetch_array($query);
			if(file_exists('../uploads/'.$info['filename'])){
				mysql_query("DELETE FROM box_files WHERE filename='".$filename."';");
				unlink('../uploads/'.$info['filename']);
				$this->msg['ok'] = '<center><div class="alert-message success">File deleted successful.</div></center>';
			}else{
				$this->msg['err'] = '<center><div class="alert-message error">File not found!</div></center>';
			}
		}
	}
	
	function DownloadFile(){
		if(is_array($_GET['download'])){
			$this->msg['err'] = '<center><div class="alert-message error">Error!</div></center>';
			return;
		}
		
		$filename = $this->Escape($_GET['download']);
		
		$query = mysql_query("SELECT real_filename FROM box_files WHERE filename='".$filename."';");
		
		if(mysql_num_rows($query) == 1){
			$info = mysql_fetch_array($query);
			if(file_exists('../uploads/'.$filename)){
				ob_clean();
				header('Content-Description: File Transfer');
                header("Content-Type: application/octet-stream");
				header("Content-Transfer-Encoding: Binary"); 
                header('Content-Disposition: attachment; filename='.$info['real_filename']);
                header('Content-Length: ' . filesize('../uploads/'.$filename));
                readfile('../uploads/'.$filename);
				exit;
			}else{
				$this->msg['err'] = '<center><div class="alert-message error">File not found!</div></center>';
			}
		}else{
			$this->msg['err'] = '<center><div "class="alert-message error">File not found in database!</div></center>';
		}
	}
	
	function PageListHeaders($limit){
		$return = array(0 => 0,1 => null);
		if(isset($_GET['s'])){
			if(is_numeric($_GET['s'])){
				if($_GET['s'] == 0){
					$_GET['s'] = 1;
				}
				$return[0] = ($_GET['s'] - 1)*$limit;
			}
		}
		$return[1] = "LIMIT ".$return[0].",".$limit;
		return $return;
	}
	
	function PageList($count,$start_from,$limit,$task){
		$start_from = $start_from/$limit;
		if($count > $start_from){
			$page = '';
			if(isset($_GET['p'])){
					$page = htmlspecialchars($_GET['p']);
			}
			
			echo '<center><nav><ul class="pagination">';
			
			if(($start_from*$limit - $limit) < $count && ($start_from*$limit - $limit) >= 0){
				echo '<li><a href="?p='.$page.'&s='.(($start_from)).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}else{
				echo '<li class="disabled"><a aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			
			$i1 = $start_from + $task + 1;
			$last_i = 0;
			
			
			//Numbers 
			$all = ceil($count/$limit);
			
			for($i = $start_from - $task;$i < $i1;$i++){
				if($i < $all && $i >= 0){
					$class = null;
				    if($i == $start_from){
				    	$class = 'class="active"';
				    }
					
					echo '<li '.$class.'><a href="?p='.$page.'&s='.($i + 1).'">'.($i + 1).'</a></li>';
				}
			}
			
			if($i1 < $all){
				 echo '<li><a>..</a></li>';
				 echo '<li><a href="?p='.$page.'&s='.$all.'">'.$all.'</a></li>';
			}
			
			//Numbers
			
			if($start_from*$limit + $limit < $count){
				echo '<li><a href="?p='.$page.'&s='.(($start_from + 2)).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}else{
				echo '<li class="disabled"><a aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			
			echo '</ul></nav></center>';
		}
	}
	
	function ChangePass(){
		if($_POST['pass'] != null && $_POST['new-pass'] != null && $_POST['new-pass-re'] != null){
			if($_POST['new-pass'] == $_POST['new-pass-re']){
			    if($this->Pass_Crypt($_POST['pass']) == $this->pass){
			    	mysql_query("UPDATE box_admins SET pass='".$this->Pass_Crypt($_POST['new-pass'])."' WHERE user='".$this->user."' ;");
					session_destroy();
					header('Location: ./');
			    }else{
			    	$this->msg['err'] = '<center><div class="alert-message error">Old password is wrong!</div></center>';
			    }
			}else{
				$this->msg['err'] = '<center><div class="alert-message error">Passwords do not match!</div></center>';
			}
		}else{
			$this->msg['err'] = '<center><div class="alert-message error">Please write all information!</div></center>';
		}
	}
	
	function AddUser($user, $pass){
		$this->LoginCheck();
		if($user != null && $pass != null){
			$user = $this->Escape($user);
			$pass = $this->Pass_Crypt($pass);
			$check = mysql_query("SELECT id FROM box_admins WHERE user='".$user."' ;");
			if(mysql_num_rows($check) == 0){
				mysql_query("INSERT INTO box_admins (user,pass) VALUES ('".$user."','".$pass."') ;");
				 if($_SESSION['loged']=="admin"){
				header('Location: ?p=accounts');
				 }else{echo '<center><div class="alert-message success">Successfully Registered</div></center>';}
			}else{
				 if($_SESSION['loged']=="admin"){
				$this->msg['err'] = '<center><div class="alert-message error">Username already exist!</div></center>';
				 }else{echo '<center><div class="alert-message error">Username already exist!</div></center>';}
			}
		}else{
			 if($_SESSION['loged']=="admin"){
			$this->msg['err'] = '<center><div class="alert-message error">Please write all information!</div></center>';
			 }else{echo '<center><div class="alert-message error">Please write all information!</div></center>';}
		}
	}
	
	function DelUser($u){
		if($u != null){
			$user = $this->Escape($u);
			$check = mysql_query("SELECT private FROM box_admins WHERE user='".$user."';");
			if(mysql_num_rows($check) == 1){
				$info = mysql_fetch_array($check);
				if($info['private'] != 1){
					mysql_query("DELETE FROM box_admins WHERE user='".$user."' ;");
					if($_SESSION['loged'] == $u){
						session_destroy();
					}
					header('Location: ?p=accounts');
				}else{
					$this->msg['err'] = '<center><div class="alert-message error">This account is private!</div></center>';
				}
			}
		}
	}
	
	function Headers_Operations(){
		$this->LoginCheck();
		
		if($this->Login_Check){
			if(isset($_GET['logout'])){
				session_destroy();
				$this->Login_Check = false;
			}
			
			if(isset($_POST['opt'])){
				if($_SESSION['loged'] == 'demo'){ $this->msg['err'] = '<center><div class="alert-message error">Cannot make changes on demo account!</div></center>'; }else{
				$this->Options_Update();
				}
			}
			
			if(isset($_GET['download'])){
				$this->DownloadFile();
			}
			
			if(isset($_GET['delete'])){
				if($_SESSION['loged'] == 'demo'){ $this->msg['err'] = '<center><div class="alert-message error">Cannot make changes on demo account!</div></center>'; }else{
				$this->DeleteFile();
				}
			}
			
			if(isset($_POST['pass']) && isset($_POST['new-pass']) && isset($_POST['new-pass-re'])){
				if($_SESSION['loged'] == 'demo'){ $this->msg['err'] = '<center><div class="alert-message error">Cannot make changes on demo account!</div></center>'; }else{
				$this->ChangePass();
				}
			}
			
			if(isset($_POST['reg_user']) && isset($_POST['reg_pass'])){
				if($_SESSION['loged'] == 'demo'){ $this->msg['err'] = '<center><div class="alert-message error">Cannot make changes on demo account!</div></center>'; }else{
				$this->AddUser($_POST['reg_user'], $_POST['reg_pass']);
				}
			}
			
			if(isset($_GET['del_adm'])){
				if($_SESSION['loged'] == 'demo'){ $this->msg['err'] = '<center><div class="alert-message error">Cannot make changes on demo account!</div></center>'; }else{
				$this->DelUser($_GET['del_adm']);
				}
			}
			
		}else{
		    //if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['captcha'])){
		    if(isset($_POST['user']) && isset($_POST['pass'])){
		        $this->Login_Post();
		    }
		}
	}
	
	function CaptchaRand(){
		return time().rand(111111111,999999999);
	}
	
}


?>