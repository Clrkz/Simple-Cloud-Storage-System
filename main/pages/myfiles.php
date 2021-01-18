<?php
error_reporting(0);
if($_SESSION['loged']=="admin"){
	//$query = mysql_query("SELECT * FROM box_files WHERE ip='".$_SERVER['REMOTE_ADDR']."' ORDER by date;");
	$query = mysql_query("SELECT * FROM box_files WHERE 1 ORDER by date;");
}else if($_SESSION['loged']==""){
  $query = mysql_query("SELECT * FROM box_files WHERE ip='".$_SERVER['REMOTE_ADDR']."'  and owner=''  ORDER by date;");
}else if($_SESSION['loged']!="admin"){
	  $query = mysql_query("SELECT * FROM box_files WHERE  owner='".$_SESSION['loged']."'  ORDER by date;");
}else{
  $query = mysql_query("SELECT * FROM box_files WHERE ip='".$_SERVER['REMOTE_ADDR']."'  and owner=''  ORDER by date;");
} 
?>

<div class="box" style="max-width:700px;">
  <h3> <?=mysql_num_rows($query); ?> FILES</h3><img src="main/img/files.png" alt="Files" style="height:46px" /><br />
  <?php
  if(mysql_num_rows($query) > 0){
     echo '<table class="tb"><thead><tr>
       <th>ID</th>
       <th>FILE NAME</th>		
       <th>DATE / TIME</th>
	   <th>REMOVE</th>
	   <th>DOWNLOAD</th>
     </tr>
     </thead>
     <tbody>';
     while($info = mysql_fetch_array($query)){
	      echo '<tr><td>'.$info['id'].'</td>';
	      echo '<td>'.$info['real_filename'].'</td>';
	      echo '<td>'.date("d.m.Y H:i:s A", $info['date']).'</td>';
		  echo '<td><a href="?p=remove_file&hash='.$info['removeHash'].'" target="new_blank"><img src="main/img/delete.png" alt="Delete" style="height:20px;margin-top:6px;" /></a></td>';
	      echo '<td><a href="?p=file&f='.$info['filename'].'" target="new_blank"><img src="main/img/download.png" alt="Download" style="height:20px;margin-top:6px;" /></a></td>';
     }
     echo '</tbody></table>';
  }else{
	  echo '<center>NO RESULTS FOUND IN THE SYSTEM DATABASE</center>';
  }
  ?>
  </div>

