<div id="content">

 
<center><a href="?c=home&m=editGroups&gid" class="btn">Add group</a>
</center>
<br>
 

<table class="table table-striped" style="margin-left:50px;width:60%">
<tr>
  <td>ID</td>
  <td>Name</td>
  <td>Rack</td>
  <td>Start</td>
  <td>End</td>
  <td>Operate</td>
 </tr>

<?php foreach($datas as $row) : ?>

  <tr>
  <td><?= $row->gid ?></td>
  <td><?= $row->name ?></td>
  <td><?= $row->rack ?></td>
  <td><?= $row->start ?></td>
  <td><?= $row->end ?></td>
  <td><a href="?c=home&m=editGroups&gid=<?= $row->gid ?>">edit</a></td>

  </tr>



  <?php endforeach; ?>

   </table>
 
	</div>
 


 