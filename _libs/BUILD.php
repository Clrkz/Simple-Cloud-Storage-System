<?php
error_reporting(E_ALL ^ E_DEPRECATED);
date_default_timezone_set("Asia/Manila");

Class Build{
		private $Login_Check = false;
	private $msg = null;
    private $Options;
	
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
	 
	function Build(){
		include 'config.php';
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
	
	function Page(){
		if(isset($_GET['p'])){
			if($_GET['p'] != null){
				return $_GET['p'];
			}
		}
		return 'home';
	}
	
	function Valid($filename){
		if($filename != null){
		    $get = mysql_query("SELECT * FROM box_files WHERE filename = '".$this->Escape($filename)."' ;");
		    if(mysql_num_rows($get) == 1){
		    	return mysql_fetch_array($get);
		    }
		}
		return false;
	}
	
	function removePOST()
	{
		$captcha = null;
		
		if(isset($_POST['captcha']))
		{
			//if(strtoupper($_POST['captcha']) == $captcha)
			if(strtoupper($_POST['captcha']) ==strtoupper($_POST['captcha']))
			{
				return true;
			}
			else
			{
			//	$this->msg['err'] = '<center><div class="alert-message error">'.$this->Opt('error_captcha').'</div></center>';
				return false;
			}
		}
	}
	
	function ValidRemoveHash($hash)
	{
		if($hash != null){
		    $get = mysql_query("SELECT * FROM box_files WHERE removeHash = '".$this->Escape($hash)."' ;");
		    if(mysql_num_rows($get) == 1){
		    	return mysql_fetch_array($get);
		    }
		}
		
		return false;
	}
	
	function Open($file){
		  if(file_exists($file)){
		  	include $file;
		  }else{
			$this->Open('main/error404.php');
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

	function ValidEmail($email){
		$regex = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD'; 
        if (preg_match($regex, $email) == FALSE) { 
           return false;
        }
		return true;
	}
	
	function DownloadFile(){		
		$check = mysql_query("SELECT real_filename,password,filename FROM box_files WHERE filename='".$this->Escape($_POST['filename'])."' ;");
		if(mysql_num_rows($check) == 1){
			$info = mysql_fetch_array($check);
			$pass = null;
			if(isset($_POST['p'])){
				$pass = $_POST['p'];
			}
			if($info['password'] == '' || $info['password'] == $this->Pass_Crypt($pass)){
				if(file_exists('uploads/'.$info['filename'])){
					ob_clean();
					header('Content-Description: File Transfer');
                    header("Content-Type: application/octet-stream");
					header("Content-Transfer-Encoding: Binary"); 
                    header('Content-Disposition: attachment; filename='.$info['real_filename']);
                    header('Content-Length: ' . filesize('uploads/'.$info['filename']));
                    readfile('uploads/'.$info['filename']);
					exit;
				}
			}else{
				$this->msg['err'] = '<center><div class="alert-message error">Wrong password!</div></center>';
			}
		}
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
			case "EMAILS":
			$return = null;
			if(isset($_POST[$header])){
				$a = 0;
				if(is_array($_POST[$header])){
				    for($i = 0;$i < count($_POST[$header]); ++$i){
						$a = 1;
				    	$return .= '<div id="TextBoxDiv1"><input type="text" name="emails[]" style="text-align:center;" placeholder="SEND VIA EMAIL (OPTIONAL)" value="'.htmlspecialchars($_POST[$header][$i]).'" /></div>';
				    }
				}
				
				if($a == 0){
					$return = '<div id="TextBoxDiv1"><input type="text" name="emails[]" style="text-align:center;" placeholder="SEND VIA EMAIL (OPTIONAL)" /></div>';
				}
			}else{
				$return = '<div id="TextBoxDiv1"><input type="text" name="emails[]" style="text-align:center;" placeholder="SEND VIA EMAIL (OPTIONAL)" /></div>';
			}
			
			return $return;
			
			break;
		}
		
		return $not;
	}
	
	function UploadFile(){
		
		$dont_allowed = explode(',', $this->Opt('extension_reject'));
		if(!empty($_FILES['file']['name'])){
			$captcha = null;
			if($this->Opt('upload_captcha') == 1){
				if(isset($_SESSION['captcha_string'])){
					$captcha = strtoupper($_SESSION['captcha_string']);
				}else{
		    	//    $this->msg['err'] = '<center><div class="alert-message error">'.$this->Opt('error_captcha').'</div></center>';
					return;
		        }
			}

            if($this->Opt('upload_captcha') == 2 || strtoupper($_POST['captcha']) == $captcha){
		   // 	session_destroy();
                $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				if($_FILES["file"]["size"] > $this->Opt('max_upload_kb')*1024){
					$this->msg['err'] = '<center><div class="alert-message error">'.$this->Opt('error_large_file').'</div></center>';
				}else{
                    if(in_array(strtolower($extension), $dont_allowed)){
                    	$this->msg['err'] = '<center><div class="alert-message error">'.$this->Opt('error_extension',array('{ext}' => htmlspecialchars($extension))).'</div></center>';
                    }else{
		            	$pass = null;
		            	if($_POST['password'] != null){
		            		$pass = $this->Pass_Crypt($_POST['password']);
		            	}
				    	
		            	$filename = time() + rand(1111111111,9999999999);
		            	
		            	if(move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$filename)){
						   $removeHash = $this->Pass_Crypt(time().rand(100000000000000,999999999999999)."_dropbox_".$filename.$_FILES['file']['tmp_name']);
						   if($this->Login_Check){
							   mysql_query("INSERT INTO box_files (filename,real_filename,password,message,date,removeHash,ip,owner) VALUES ('".$filename."','".$this->Escape($_FILES['file']['name'])."','".$pass."','".$this->Escape($_POST['message'])."','".time()."', '".$removeHash."', '".$_SERVER['REMOTE_ADDR']."','".$_SESSION['loged']."');");
		            	  }else{
                    	   mysql_query("INSERT INTO box_files (filename,real_filename,password,message,date,removeHash,ip) VALUES ('".$filename."','".$this->Escape($_FILES['file']['name'])."','".$pass."','".$this->Escape($_POST['message'])."','".time()."', '".$removeHash."', '".$_SERVER['REMOTE_ADDR']."');");
		            	   }
						   $link = $this->Opt('domain').'/?p=file&f='.$filename;
				    	   $this->msg['ok'] = '<center><div class="alert-message success">'.$this->Opt('upload_success',array('{link}' => $link, '{filename}' => htmlspecialchars($_FILES['file']['name']))).'</div><br /><center><div class="alert-message warning">You can delete your file from the following link: <a href="'.$this->Opt('domain').'?p=remove_file&hash='.$removeHash.'" target="new_blank">'.$this->Opt('domain').'?p=remove_file&hash='.$removeHash.'</a></div></center>';
				    	 
                        }else{
		            		$this->msg['err'] = '<center><div class="alert-message error">'.$this->Opt('error_upload').'</div></center>';
		            	}
		            }
				}
		    }else{
		    	//$this->msg['err'] = '<center><div class="alert-message error">'.$this->Opt('error_captcha').'</div></center>';
		    }
		    
		}else{
			$this->msg['err'] = '<center><div class="alert-message warning">'.$this->Opt('file_not_select').'</div></center>';
		}
	}
	
	function Opt($name,$replace = array()){
		if(isset($this->Options[$name])){
			$return = $this->Options[$name];
			foreach($replace as $key => $value){
				$return = str_replace($key, $value, $return);
			}
			
			return $return;
		}
		
		return '{'.$name.'}';
	}
	
	function Options_Install(){
		$options = mysql_query("SELECT * FROM box_options;");
		while($info = mysql_fetch_array($options)){
			$this->Options[$info['name']] = $info['value'];
		}
	}
	
		function LoginCheck(){
		if(isset($_SESSION['loged']) && isset($_SESSION['pass'])){
			$this->Login_Check = true;
			$this->user = $_SESSION['loged'];
			$this->pass = $_SESSION['pass'];
		}
	}
	
	function Headers_Operations(){
		$this->Options_Install();
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
		
		if(isset($_POST['filename'])){
			$this->DownloadFile();
		}
		
        if(isset($_FILES['file']) && isset($_POST['emails']) && isset($_POST['password']) && isset($_POST['message']) && isset($_POST['captcha'])){
			
			$this->UploadFile();
        }
	}
	
	function CaptchaRand(){
		return time().rand(111111111,999999999);
	}
	
    function create_image()
    {
		ob_clean();
        $image = imagecreatetruecolor(200, 50) or die("Cannot Initialize new GD image stream");
        
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $line_color = imagecolorallocate($image, 64, 64, 64);
        
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color);
        
        for ($i = 0; $i < 3; $i++) {
            imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
        }
        
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $len = strlen($letters);
        $letter = $letters[rand(0, $len - 1)];
        
        
        $word = "";
		
        for ($i = 0; $i < 6; $i++) {
            $letter = $letters[rand(0, $len - 1)];
			$text_color = imagecolorallocate($image, mt_rand(50,200), mt_rand(50,200), mt_rand(50,200));
            imagestring($image, 7, 5 + ($i * 30), 20, $letter, $text_color);
            $word .= $letter;
        }
        $_SESSION['captcha_string'] = $word;
	    header("Content-Type: image/jpeg"); 
        
        //Output the newly created image in jpeg format 
        ImageJpeg($image); 
        
        //Free up resources
        ImageDestroy($image);
	    exit;
    }
}

?>