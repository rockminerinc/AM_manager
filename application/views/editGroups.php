<div id="content">

 <form action="?c=home&m=editGroups&gid=<?php if($data->gid) echo $data->gid;?>" method="post" accept-charset="utf-8">

<table align=" " border="0" cellspacing="0">
<tbody>

<tr>
	<td align="right">name</td>
	<td align="left">
		<input name="name" value="<?php if($data->name) echo $data->name;?>" size="30" type="text"   >
	</td>
</tr>

<tr>
	<td align="right">rack</td>
	<td align="left">
		<input name="rack" value="<?php if($data->rack) echo $data->rack;?>" size="30" type="text"  >
	</td>
</tr>
<tr>
	<td align="right">start</td>
	<td align="left">
		<input name="start" value="<?php if($data->start) echo $data->start;?>" size="30" type="text"  >
	</td>
</tr><tr>
	<td align="right">end</td>
	<td align="left">
		<input name="end" value="<?php if($data->end) echo $data->end;?>" size="30" type="text"  >
	</td>
</tr>


<tr>
<td align="right"></td></tr>
<tr>
<td colspan="2" align="center">
 <input name="submit" value="Submit" type="submit"  class="btn">
</td>
</tr></tbody></table>


</form>
</div>