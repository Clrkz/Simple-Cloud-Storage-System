<div class="box" style="max-width:760px;">
  <h3>Hello <?=$_SESSION['loged']?></h3></h3><img src="../main/img/user.png" alt="Account" style="height:46px" />
  <form method="POST">
  <input type="password" name="pass" placeholder="CURRENT PASSWORD" style="text-align:center;" />
  <input type="password" name="new-pass" placeholder="NEW PASSWORD" style="text-align:center;" />
  <input type="password" name="new-pass-re" placeholder="REPEAT NEW PASSWORD" style="text-align:center;" />
  <input type="submit" class="submit action-button" value="CHANGE PASSWORD" style="width:96%;" style="text-align:center;" /></form>
  <hr />
  <?php
  if($_SESSION['loged']=="admin"){
  $query = mysql_query("SELECT * FROM box_options;");
  echo '<h3 style="margin-top:10px;">SITE OPTIONS & SETTINGS</h3><img src="../main/img/options.png" alt="Options" style="height:46px;" /><form method="POST"><table style="width:100%;">';
  while($info = mysql_fetch_array($query)){
	  if(isset($this->Options[$info['name']])){
		  switch($this->Options[$info['name']]['type']){
			  case "string":
			  echo '<tr><td>'.$this->Options[$info['name']]['text'].'</td><td><input type="text" name="opt['.$info['name'].']" value="'.htmlspecialchars($info['value']).'"></td></tr>';
			  break;
			  
			  case "string_area":
			  echo '<tr><td>'.$this->Options[$info['name']]['text'].'</td><td><textarea name="opt['.$info['name'].']">'.htmlspecialchars($info['value']).'</textarea></td></tr>';
			  break;
			  
			  case "int":
			  echo '<tr><td>'.$this->Options[$info['name']]['text'].'</td><td><input type="number" name="opt['.$info['name'].']" value="'.$info['value'].'"></td></tr>';
			  break;
			  
			  case "bool":
			  $first = '<div class="block"> <input type="radio" name="opt['.$info['name'].']" value="1" id="e_'.$info['name'].'"> <label for="e_'.$info['name'].'">ENABLE</label></div> ';
			  $second = '<div class="block"><input type="radio" name="opt['.$info['name'].']" value="2" id="d_'.$info['name'].'"> <label for="d_'.$info['name'].'">DISABLE</label></div> ';
			  if($info['value'] == 1){
				  $first = '<div class="block"> <input type="radio" name="opt['.$info['name'].']" value="1" checked id="e_'.$info['name'].'"> <label for="e_'.$info['name'].'">ENABLE</label></div> ';
			  }else{
				  $second = '<div class="block"> <input type="radio" name="opt['.$info['name'].']" value="2" checked id="d_'.$info['name'].'"> <label for="d_'.$info['name'].'">DISABLE</label></div> ';
			  }
			  
			  echo '<tr><td>'.$this->Options[$info['name']]['text'].'</td><td>'.$first.$second.'</td></tr>';
			  break;
		  }
	  }
  }
  echo '</table><input type="submit" class="submit action-button" value="SAVE" style="width:96%;" /></form>';
  }
  ?>
  <hr /><h3 style="margin-top:10px;">UPLOADED FILES</h3><img src="../main/img/files.png" alt="Files" style="height:46px;margin-bottom:10px;" />
  <br /><a class="submit action-button" href="?p=files">OPEN FILE MANAGER</a><br />
  <?php
  if($_SESSION['loged']=="admin"){
  ?>
  <br /><hr /><h3 style="margin-top:10px;">ACCOUNTS</h3><img src="../main/img/add.jpg" alt="Files" style="height:46px;margin-bottom:10px;" />
  <br /><a class="submit action-button" href="?p=accounts">OPEN ACCOUNT MANAGER</a><br />
  <br />
    <hr />
  <?php
  }
  ?>

  <br />
  <a class="submit action-button" href="?logout">LOGOUT</a>
</div>
<br />