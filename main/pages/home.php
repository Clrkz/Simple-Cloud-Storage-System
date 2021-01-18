				<form id="msform" method="POST" enctype="multipart/form-data">
				
				<strong>
                	<ul id="progressbar">
                		<li class="active">SELECT FILE</li>
                		<li class="active">OPTIONS</li>
                		<li class="active">UPLOAD</li>
                	</ul>
					</strong>
                	<fieldset>
                	    <img src="main/img/upload.png" alt="CLD" style="width:46px;height:46px;" />
                		<h2 class="fs-title">SELECT FILE FROM YOUR COMPUTER</h2>
                		<input type="file" name="file" placeholder="File"/>
						
						<h2 class="fs-title">FILE OPTIONS</h2>
                		<input type="password" name="password" style="text-align:center;" placeholder="PASSWORD (OPTIONAL)" value="<?=$this->Auto('POST','password','')?>"/>
                		<textarea name="message" style="text-align:center;" placeholder="DESCRIPTION (OPTIONAL)"><?=$this->Auto('POST','message','')?></textarea>
                		
						
						  <h2 class="fs-title">UPLOAD SELECTED FILE</h2>
						<?php if($this->Opt('upload_captcha') == 1){ ?>
                		<img src="?captcha=<?=$this->CaptchaRand()?>"><input type="text" style="text-align:center;" name="captcha" placeholder="ENTER CAPTCHA" />
                		<?php }else{ echo '<input type="hidden" name="captcha">'; } ?>
                		<input type="submit" class="submit action-button" value="UPLOAD"/>
						<div style="color:#1E90FF";"">You can view your files from <a href="?p=myfiles"><label style="color: red;"><u>here</u></label></a>.</div> 
                	</fieldset>
					
					
					
                	<fieldset>
                		<h2 class="fs-title">FILE OPTIONS</h2>
                		
						<?php if($this->Opt('send_emails') == 1){ ?>
						<div id='TextBoxesGroup'>
                		  <?=$this->Auto('emails','emails','')?>
                		</div>
                		<input type='button' value='ADD EMAIL' style="text-align:center;" id='addButton'>
                		<?php } ?>
						
                		<input type="button" name="previous" class="previous action-button" value="PREVIOUS" />
                		<input type="button" name="next" class="next action-button" value="NEXT" />
                	</fieldset>
                	<fieldset>
                	    <h2 class="fs-title">UPLOAD SELECTED FILE</h2>
						<?php if($this->Opt('upload_captcha') == 1){ ?>
                		<img src="?captcha=<?=$this->CaptchaRand()?>"><input type="text" style="text-align:center;" name="captcha" placeholder="ENTER CAPTCHA" />
                		<?php }else{ echo '<input type="hidden" name="captcha">'; } ?>
						<input type="button" name="previous" class="previous action-button" value="PREVIOUS" />
                		<input type="submit" class="submit action-button" value="UPLOAD"/>
                	</fieldset>
                </form>
				
				