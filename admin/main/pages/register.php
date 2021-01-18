
<?php

echo $this->ShowMsg();
if(isset($_POST['submit'])){
if(isset($_POST['reg_user']) && isset($_POST['reg_pass'])){
			if($_POST['reg_pass']!=$_POST['reg_pass2']){
				echo '<center><div class="alert-message error">Password Not Matched!</div></center>';
			}else{
				$this->AddUser($_POST['reg_user'], $_POST['reg_pass']);
			}
			}
			
			
}
	
?>
<div class="box">
<form method="POST">
	  <h2 style="margin-bottom:10px;">CREATE ACCOUNT</h2>
<input type="text" name="reg_user" placeholder="Username">
<input type="password" name="reg_pass" placeholder="Password">
<input type="password" name="reg_pass2" placeholder="Confirm Password">
<input type="submit" value="Register" name="submit" class="submit action-button" style="width:90%;">
</form>

</div>
