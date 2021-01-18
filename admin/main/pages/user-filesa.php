<?php
  $limit = 40; // Results per page
  $list_info = array(0 => 0,1 => null);
  $list_info = $this->PageListHeaders($limit);
  $user = $_GET['user'];
  $search = $this->Search();
  if($_SESSION['loged']=="admin"){[
 $query = mysql_query("SELECT * FROM box_files".$search." WHERE owner='$user' ORDER by date desc ".$list_info[1]."  ;");
  $count = mysql_fetch_array(mysql_query("SELECT count(id) FROM box_files".$search.";"));
  $count = $count[0];
  }else{
   $query = mysql_query("SELECT * FROM box_files".$search."   WHERE owner='".$_SESSION['loged']."'  ORDER by date desc ".$list_info[1]." ;");
   
  $count = mysql_fetch_array(mysql_query("SELECT count(id) FROM box_files".$search."   WHERE owner='".$_SESSION['loged']."' ;"));
  $count = $count[0];
  }
?>

<div class="box" style="max-width:1200px;">
  <h3>FILE MANAGER / <?=$count?> FILES</h3><a href="?p=files"><img src="../main/img/files.png" alt="Files" style="height:46px" /></a><br />
  <?php
  if(mysql_num_rows($query) > 0){
     echo '<center>
	 <form method="GET">
	 <input type="hidden" name="p" value="files">
	 <input type="text" name="search" value="'.$this->Auto('GET','search','').'" placeholder="Search filename">
	 <input type="submit" value="Search" class="submit action-button" style="width:100%;margin-left:0px;">
	 </form>
	 <br>
	 </center>
	 <table class="tb"><thead><tr>
       <th>ID</th> 
       <th>FILE NAME</th>		
	   <th>IP</th>
       <th>DATE / TIME</th>
	   <th>DOWNLOAD</th>
	   <th>DELETE</th>
     </tr>
     </thead>
     <tbody>';
     while($info = mysql_fetch_array($query)){
	      echo '<tr><td>'.$info['id'].'</td>'; 
	      echo '<td>'.$info['real_filename'].'</td>';
	      echo '<td>'.$info['ip'].'</td>';
	      echo '<td>'.date("d.m.Y H:i:s A", $info['date']).'</td>';
	      echo '<td><a href="?download='.$info['filename'].'"><img src="../main/img/download.png" alt="Delete" style="height:20px;margin-top:6px;" /></a></td>';
	      echo '<td><a href="?p=files&delete='.$info['filename'].'"><img src="../main/img/delete.png" alt="Delete" style="height:20px;margin-top:6px;" /></a></td></tr>';
     }
     echo '</tbody></table>';
     if($search == ' '){
          $this->PageList($count,$list_info[0],$limit,3);
	 }
  }else{
	  echo '<center>NO RESULTS FOUND IN THE SYSTEM DATABASE</center>';
  }
  ?>
  </div>
  <br />