<li>
    <div class="item">
        <?php
        if ($input['type'] != 'custom') {
            if ($page_details->type == 2) {
                $title = $page_details->title;
            }else{
                $title = $page_details->title;
            }
        }else{
            $title = $input['text'];
        }
        ?>
        <div class="item-title"><?php echo $title; ?><a href="javascript:void(0)" class="item-trigger" onclick="toggleMenu(this)"><i class="far fa-fw fa-angle-down"></i></a></div>
        <div class="item-body">
            <div class="form-group">
                <label class="control-label">Name</label>
                <input class="form-control title" type="text" value="<?php echo $title;?>">
            </div>
            <input type="hidden" class="type" value="<?php echo $input['type']; ?>">
            <input type="hidden" class="id" value="<?php echo ($input['type'] != 'custom')?$input['id']:''; ?>">
            <?php if ($input['type'] != 'custom') {?><input class="form-control href" type="hidden" value="" /><?php } ?>            
            <?php if ($input['type'] == 'custom') {?>
            <div class="form-group">
                <label class="control-label">Url</label>
                <input class="form-control href" type="text" value="<?php echo $input['href']; ?>" />
            </div>
            <?php } ?>
            <div class="form-group">
                <label class="control-label">Class</label>
                <input class="form-control class" type="text" value="">
            </div>
            <div class="action-group"><a href="javascript:void(0)" class="btn-remove" onclick="removeMenu(this)">Remove</a><a href="javascript:void(0)" class="btn-cancel" onclick="cancelMenu(this)">Cancel</a></div>
        </div>
    </div>
</li>