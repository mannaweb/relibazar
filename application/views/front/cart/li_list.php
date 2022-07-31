  <?php if($cartVal){?>
  <?php if($type == 'appened'){?>
    <tr id="cart_li_<?php echo $cartVal->id; ?>">
  <?php }?>
   

    
                  <th scope="row" class="border-0">
                    <div class="p-2">
                      <img src="<?php echo productFileExists('uploads/products/'.$cartVal->product_image,$cartVal->product_image);?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle"><?php echo ucwords($cartVal->product_name); ?></a></h5><span class="text-muted font-weight-normal font-italic d-block">Category: Watches</span>
                      </div>
                    </div>
                  </th>
                  <td class="border-0 align-middle"><strong><?php echo number_format((float)$cartVal->product_price, 2, '.', ''); ?></strong></td>
                  <td class="border-0 align-middle"><strong><div class="number-spinner" data-id="<?php echo $cartVal->id; ?>">
          <button class="btn" data-dir="dwn" id="<?php echo $cartVal->id; ?>"><span class="fal fa-minus-circle"></span></button>
          <input type="text" class="formcontrol" id="formcontrol_<?php echo $cartVal->id; ?>" value="<?php echo $cartVal->quantity; ?>" readonly>
          <input type="hidden" name="pid" class="pid" id="pid_<?php echo $cartVal->id; ?>" value="<?php echo $cartVal->product_id; ?>">
          <input type="hidden" name="key" class="key" id="key_<?php echo $cartVal->id; ?>" value="<?php echo $cartVal->price_key; ?>">
          <button class="btn" data-dir="up" id="<?php echo $cartVal->id; ?>"><span class="fal fa-plus-circle"></span></button>
        </div></strong></td>
                  <td class="border-0 align-middle"><?php echo number_format((float)$cartVal->total, 2, '.', ''); ?></td>
               

  
 <?php } ?>
 <?php if($type == 'appened'){?>
  </tr>
  <?php }?>
