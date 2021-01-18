<div class="box">
	<form method="POST" action="./">
	  <h2 style="margin-bottom:10px;">LOGIN</h2>
	  <input type="text" name="user" placeholder="USERNAME" style="text-align:center;" />
	  <input type="password" name="pass" placeholder="PASSWORD" style="text-align:center;" />
	  <div hidden>
	  <?php if($this->config['captcha_admin']){ ?>
	  <center><img src="../?captcha=<?=$this->CaptchaRand()?>"><br><input type="text" name="captcha" placeholder="CAPTCHA CODE" style="text-align:center;" /></center>
      <?php }else{ echo '<input type="hidden" name="captcha">'; } ?>
	  </div>
	  <input type="submit" class="submit action-button" value="LOGIN" style="width:40%;"/>
	  <br>
	  <a href="?p=register" style="color: blue; "><u>Create Account</u></a>
	  
	  
	  
	  
	  
	</form>
</div>