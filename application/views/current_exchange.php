<?php
?>
<table border="1">
   <caption>Current Exchange</caption>
   <tr>
    <th>ccy</th>
    <th>base_ccy</th>
    <th>buy</th>
    <th>sale</th>
   </tr>
<?php foreach ($data as $value) {?>
  <tr>
       <td><?= $value['ccy'] ?></td>
       <td><?= $value['base_ccy'] ?></td>
       <td><?= $value['buy'] ?></td>
       <td><?= $value['sale'] ?></td>
   </tr> 
<?php } ?>
</table>

