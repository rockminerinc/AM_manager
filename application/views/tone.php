<div id="content">

  <script language="javascript">
    function delcfm() {
        if (!confirm("Do delete??")) {
            window.event.returnValue = false;
        }
    }
  </script>

 <B><CENTER>IPs:<?= $rows_num;?>|Blades:<?= $hash_sum->blades;?>|hash total:<?= $hash_sum->hashavg*0.001;?>T  </B></CENTER>

 <table cellpadding="0" cellspacing="0" border="1" width="100%">
<tr style="text-align:center">
	<td width="20px"  >
	ID
	</td>

	<td >
	<a href="?c=home&m=index&orderby=ip&sort=<?= $sort ?>" class="btn btn-primary	">IP</a>
	</td>
 
 

	<td  >
	<a href="?c=home&m=index&orderby=hash&sort=<?= $sort ?>"  class="btn btn-primary">HASH GHS</a>
	</td>
	<td  >
	<a href="?c=home&m=index&orderby=hws&sort=<?= $sort ?>"  class="btn btn-primary">HWS</a>
	</td>
	<td  >
	<a href="?c=home&m=index&orderby=efi&sort=<?= $sort ?>"  class="btn btn-primary">EFI</a>
	</td>
	
	<td  >
	<a href="?c=home&m=index&orderby=time&sort=<?= $sort ?>"  class="btn btn-primary">Time</a>
	</td>

	<td  >
	<a href="?c=home&m=index&orderby=devnum&sort=<?= $sort ?>" class="btn btn-primary">devs num</a>
	</td>	
	
	<td  >
	server
	</td>		
  	
	<td  >

	<span  class="btn btn-primary">Actions</span>
	</td>


</tr>
<?php
$id=1;
?>
<?php foreach($datas as $row) : ?>

<tr	 onMouseOver="style.color='#0000ff'"  onmouseout="style.color='#000'"
<?php
	if($row->dev_num != 0&&$row->hash!=0) 
	{
		if(($row->hash/$row->dev_num) < 187) 
		echo 'style="background:yellow"'; 
		else if(($row->dev_num%4==0)&&($row->hash/$row->dev_num) >=187) 
		echo 'style="background:rgb(135, 211, 135)"';
	}
	else
	echo 'style="background:rgb(216, 216, 216)"';
	
	?>

>
	<td> 
 
	<?php echo $id;$id++;  ?> 
	</td>
	<td  >
	<a href="http://<?= $row->ip_address ?>:8000" target="_blank"><?= $row->ip_address ?></a>
	</td>

 

	<td  width="30px"	>
	<?= floor($row->hash) ?> 
	</td>
	<td  width="30px"	>
	<?= $row->hws ?>%
	</td>
	<td  width="30px"	>
	<?= floor($row->efi) ?>%
	</td>

 
 
	<td  >
	<?= timediff(time()-$row->event_time)   ?> Ago
	</td>	
	
	 

	<td width="15px" <?php if(($row->dev_num>1&&$row->dev_num<4)||($row->dev_num>4&&$row->dev_num<8))  echo 'style="background:red;color:yellow"' ;?>  >
	<?= $row->dev_num ?> 
	</td>
 
 	<td  >
	<?= $row->server   ?> 
	</td>	
	
	
	
	<td  >
	
 	<a href="?c=home&m=rebootTone&ip=<?= $row->ip_address ?> " target="_blank" >Reboot</a>
 	<a href="http://<?= $row->ip_address ?>:8000/Settings/ " target="_blank" >Setting</a>
 	<a href="http://<?= $row->ip_address ?>:8000/FlashMega" target="_blank">FlashMega</a>
	<a href="?c=home&m=deltone&tid=<?= $row->tid ?> " onclick="delcfm()" >Delete</a>

	</td>

 

</tr>


<?php endforeach;?>
 

</table>

 

<?php echo $page_links;?>

	</div>
 

