<?php
  $query = mysql_query("SELECT * FROM box_files WHERE ip='".$_SERVER['REMOTE_ADDR']."' ORDER by date;");
?>

<div class="box" style="max-width:700px;">
  <h3>ABOUT US</h3><img src="main/img/user.png" alt="About" style="height:46px" /><br />
 </div>

