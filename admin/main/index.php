<!DOCTYPE HTML>
<html>
	<head>
		<title>CLD Cloud Storage</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="../main/css/main.css" />
		<link rel="stylesheet" href="../main/css/alertboxes.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1" /> 
		<link rel="shortcut icon" href="../main/img/favicon.ico" type="image/x-icon" />
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
		<a href="./"><h1 class="logo" style="<?php if($this->Login_Check){ echo 'margin:0px;';} ?>"><label style="color: #ffb2b2;">CL</label>OU<label style="color: #ffb2b2;">D</label> FILE STORAGE</h1></a>
			
			
		<p class="below">Upload and share files without registration</p>
		<?php
			echo $this->ShowMsg();
			
			if($this->Login_Check){
				if(isset($_GET['p'])){
					switch($_GET['p']){
						case "files":
						$this->Open('admin/main/pages/files.php');
						break;
						
						case "user-files":
						$this->Open('admin/main/pages/user-files.php');
						break;
						
						case "accounts":
						$this->Open('admin/main/pages/accounts.php');
						break;
						
						default:
						$this->Open('admin/main/pages/panel.php');
						break;
					}
				}else{
					$this->Open('admin/main/pages/panel.php');
				} 
			}else{
			    		if(isset($_GET['p'])){
					switch($_GET['p']){
						case "register":
						$this->Open('admin/main/pages/register.php');
						break;
					
						
					}
				}else{
					$this->Open('admin/main/pages/login.php');
				}
            } 
			
		
			
			?>
	</body>
</html>