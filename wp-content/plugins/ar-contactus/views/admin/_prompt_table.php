<table class="wp-list-table widefat fixed striped" id="arcontactus-prompt-table">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-name column-primary"><?php echo __('Position', 'ar-contactus') ?></th>
            <th scope="col" class="manage-column column-description"><?php echo __('Message', 'ar-contactus') ?></th>
            <th scope="col" class="manage-column column-description"><?php echo __('Active', 'ar-contactus') ?></th>
            <th scope="col" class="manage-column column-description"></th>
        </tr>
    </thead>

    <tbody id="the-list">
        <?php foreach ($items as $item){?>
        <tr data-id="<?php echo $item->id ?>">
            <td class="">
                <span class="drag-handle">
                    <i class="icon move"></i>
                    <span class="position">
                        <?php echo $item->position ?>
                    </span>
                </span>
            </td>
            <td>
                <?php echo $item->message ?>
            </td>
            <td>
                <a href="#" onclick="arCU.prompt.toggle(<?php echo $item->id ?>); return false;" class="<?php echo $item->status? 'lbl-success' : 'lbl-default' ?>">
                    <?php echo $item->status? __('Yes', 'ar-contactus') : __('No', 'ar-contactus') ?>
                </a>
            </td>
            <td>
                <a href="#" title="Edit" onclick="arCU.prompt.edit(<?php echo $item->id ?>); return false;" class="edit btn btn-default" data-id="<?php echo $item->id ?>">
                    <i class="icon-pencil"></i> <?php echo __('Edit', 'ar-contactus') ?>
                </a>

                <a href="#" title="Delete" onclick="arCU.prompt.remove(<?php echo $item->id ?>); return false;" data-id="<?php echo $item->id ?>" class="delete">
                    <i class="icon-trash"></i> <?php echo __('Delete', 'ar-contactus') ?>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <th scope="col" class="manage-column column-name column-primary"><?php echo __('Position', 'ar-contactus') ?></th>
            <th scope="col" class="manage-column column-description"><?php echo __('Message', 'ar-contactus') ?></th>
            <th scope="col" class="manage-column column-description"><?php echo __('Active', 'ar-contactus') ?></th>
            <th scope="col" class="manage-column column-description"></th>
        </tr>
    </tfoot>
</table>