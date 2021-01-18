<!DOCTYPE HTML>
<html>
	<head>
		<title><?=$this->Opt('website_title')?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="main/css/main.css" />
		<link rel="stylesheet" href="main/css/alertboxes.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1" /> 
		<link rel="shortcut icon" href="main/img/favicon.ico" type="image/x-icon" />
		<style>
	.nav ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: transparent;
}

.nav li {
  float: right;
}

.nav li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.nav li a:hover {
  background-color: #ecf0f1;
  background: none repeat scroll 0% 0% rgba(0, 0, 0, 0.1);
}
		</style>
	</head>
	<body>
	<div class="nav">
	<ul>
	 <?php
			if($this->Login_Check){
				?>
			  <li><a  href="/admin/"><?=$_SESSION['loged']?></a></li>
			  <?php
			}else{
			    	?>
			  <li><a  href="/admin/">Login</a></li>
			  <?php
            } 
			?>
  <li><a href="/?p=about">About</a></li>
  <li><a href="/">Home</a></li>
</ul>
<hr>
</div>
		<a href="./"><h1 class="logo"><?=$this->Opt('big_title')?></h1></a>
		<p class="below">Upload and share files without registration</p>
			<?php
			echo $this->ShowMsg();
			
			switch($this->Page()){
				default:
				$this->Open('main/pages/home.php');
				break;
				
				case "file":
				$info = false;
				if(isset($_GET['f'])){
					$info = $this->Valid($_GET['f']);
				}
				
				if($info == false){
					header("Location: ./");
				}else{
					include 'main/pages/v.php';
				}
				
				break;
				
				case "myfiles":
				include 'main/pages/myfiles.php';
				break;
				
				case "about":
				include 'main/pages/about.php';
				break;
				
				case "remove_file":
				$info = false;
				
				if(isset($_GET['hash']))
				{
					$info = $this->ValidRemoveHash($_GET['hash']);
				}
				
				if($info == false){
					header("Location: ./");
				}else{
					$check = $this->removePOST();
					
					echo $this->ShowMsg();
					if($check === true)
					{
						unlink('uploads/'.$info['filename']);
						mysql_query("DELETE FROM box_files WHERE removeHash = '".$info['removeHash']."' ;");
						header('Location: ./?p=myfiles');
					
					}
					include 'main/pages/remove_file.php';
				}
				
				break;
			}
			
			?>
       
	</body>
</html>