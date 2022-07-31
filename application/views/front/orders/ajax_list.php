
<?php if(count($orders)>0){
    foreach ($orders as $key => $value) {
      ?>
    <tr>
      <th scope="row"><?php echo $value->order_id; ?></th>
    
   
      <td>₹<?php echo $value->total_amount; ?> </td>
        <td><?php echo date('jS M, Y',strtotime($value->created_at));?></a></td>
         
           <td><?php echo $value->title; ?></i></td>
            <td><i class="badge badge-warning"><?php echo $value->payment_status; ?></i></td>
       <td><a  class="genric-btn primary-border medium">View</a></td>
    </tr>
   <?php } }else{ ?>
<tr>
      <th scope="row"></th>
    
   <td></td><td></td><td> No Data</td><td></td><td></td>
    </tr>
   <?php } ?>
