<?php
?>
<table border="1">
   <caption>History Exchange</caption>
   <tr>
    <th>ccy</th>
    <th>base_ccy</th>
    <th>buy</th>
    <th>sale</th>
    <th>date</th>
   </tr>
<?php foreach ($data as $value) {?>
  <tr>
       <td><?= $value['ccy'] ?></td>
       <td><?= $value['base_ccy'] ?></td>
       <td><?= $value['buy'] ?></td>
       <td><?= $value['sale'] ?></td>
       <td><?= $value['created_at'] ?></td>
   </tr> 
<?php } ?>
</table>
