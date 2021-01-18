<div class="box" style="max-width:400px;">
<form method="POST">
  <h3>DELETE FILE</h3><img src="main/img/delete.png" alt="Files" style="height:46px" /><br />
  <p><?=htmlspecialchars($info['real_filename'])?></p>
  <div hidden>
  <img src="?captcha=<?=rand(1000000000,9999999999)?>"><input type="text" style="text-align:center;" name="captcha" placeholder="ENTER CAPTCHA" />
  </div>
  <input type="submit" class="submit action-button" value="DELETE"/>
</form>
</div>