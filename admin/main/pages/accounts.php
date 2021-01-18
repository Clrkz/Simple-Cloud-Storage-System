<div class="box">
<?php
$list = mysql_query("SELECT * FROM box_admins ;");
if(mysql_num_rows($list) > 0){
	  echo '<table class="tb"><thead><tr>
       <th>ID</th>
       <th>Username</th>		
	   <th>Delete</th>		
     </tr>
     </thead>  
     <tbody>';
	while($info = mysql_fetch_array($list)){
		$usr = $info['user'];
		if($info['private'] == 1){
			$info['user'] = '<span style="color:red;">'.$info['user'].'</span>';
		}
		echo '<tr> <td>'.$info['id'].'</td> <td><u><a href="?p=user-files&user='.$usr.'">'.$info['user'].'</a></u></td> <td><a href="?p=accounts&del_adm='.$usr.'"><img src="../main/img/delete.png" alt="Delete" style="height:20px;margin-top:6px;" /></a></td> </td>';
	}
	echo '</tbody></table>';
}else{
	echo 'Not found results in system!';
}
?>
<br><hr><br>
<form method="POST">
<input type="text" name="reg_user" placeholder="Username">
<input type="password" name="reg_pass" placeholder="Password">
<input type="submit" value="Add" class="submit action-button" style="width:90%;">
</form>

</div>