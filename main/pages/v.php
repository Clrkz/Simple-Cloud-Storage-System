<div class="box">
 <form method="POST">
 <img src="main/img/download.png" alt="download" style="width:46px;height:46px;" />
   <br />
   <input type="text" value="<?=$info['real_filename']?>" style="text-align:center;" disabled />
   <?php if($info['message'] != null) { ?>
   <textarea readonly=true><?=($info['message'])?></textarea>
   <?php } ?>
   <?php if($info['password'] != null){ ?>
   <input type="password" name="p" placeholder="Password">
   <?php } ?>
   <br />File Size: <?=$this->formatSizeUnits(filesize('uploads/'.$info['filename']))?> 
   <br />Date: <?=date('d.m.Y H:i:s A',$info['date'])?>
	<br /><input type="hidden" name="filename" value="<?=$info['filename']?>" />
	<input type="submit" value="DOWNLOAD" class="submit action-button" >
 </form>
 <hr />
 <h4 style="margin-top:4px;">SHARE FILE</h4>
 <input type="text" onclick="this.focus();this.select()" readonly="readonly" value="cldshare.ml<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>" style="text-align:center;" />
 
 <a href="https://www.facebook.com/sharer/sharer.php?u=cldshare.ml<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>" target="_blank" class="fb stLarge"></a>
 <a href="https://twitter.com/home?status=cldshare.ml<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>" target="_blank" class="tw stLarge"></a>
 <a href="https://plus.google.com/share?url=cldshare.ml<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>" target="_blank" class="google stLarge"></a>
 <!--
 <div onclick="popupwindow('https://www.facebook.com/sharer/sharer.php?app_id=845103318867007&sdk=joey&u=<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>&ref=plugin&src=share_button','',600,302)" class="fb stLarge"></div>

 <div onclick="popupwindow('https://twitter.com/intent/tweet?text=CLD - &url=<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>','',600,444)" class="tw stLarge"></div>
 
 <div onclick="popupwindow('https://plus.google.com/share?url=<?=$this->Opt('domain')?>/?p=file&f=<?=$info['filename']?>','',600,782)" class="google stLarge"></div>
-->
 </div>
						