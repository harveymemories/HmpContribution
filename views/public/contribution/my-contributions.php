<?php
$pageTitle = __('My Contributions');
echo head(array(
    'title' => $pageTitle,
    'bodyclass' => 'contributions browse page',
)); ?>
<div id="primary">
<?php echo flash(); ?>
<h1><?php echo $pageTitle;?> <?php echo __('(%s total)', $total_results); ?></h1>
<?php if ($total_results): ?>
<p class="explanation">Unchecking <strong>Public</strong> will remove the item from public view, but it will still be visible to administrators.</p>
<p class="explanation">Checking <strong>Anonymous</strong> will not remove identifying information from your item, such as your name if it is listed, but it will unlink the item from your User Account and Username.</p>
<form method='post'>
    <table>
        <thead>
            <tr>
                <th><?php echo __('Public'); ?></th>
                <th><?php echo __('Anonymous'); ?></th>
                <th><?php echo __('Item'); ?></th>
                <th><?php echo __('Added'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach(loop('contrib_items') as $contribItem): ?>
            <?php $item = $contribItem->Item; ?>
            <tr>
                <td><?php echo $this->formCheckbox("contribution_public[{$contribItem->id}]", null, array('checked'=>$contribItem->public) ); ?>
                </td>
                <td><?php echo $this->formCheckbox("contribution_anonymous[{$contribItem->id}]", null, array('checked'=>$contribItem->anonymous) ); ?>
                </td>                
                <td><?php echo link_to($item, 'show', metadata($item, array('Dublin Core', 'Title'))); ?></td>
                <td><?php echo metadata($item, 'added'); ?></td>
            
            </tr>
            
            <?php endforeach; ?>
        </tbody>
    </table>
    <input id="save-changes" class="submit big button" type="submit" value="Save Changes" name="submit">
</form>
<?php else: ?>
<p>
    <?php echo __('No contribution yet, or removed contributions.'); ?>
</p>
<p>
    <?php echo __('Feel free to %scontribute%s or %sbrowse the archive%s.',
        '<a href="' . contribution_contribute_url() . '">', '</a>',
        '<a href="' . url('items/browse') . '">', '</a>'); ?>
</p>
<?php endif; ?>
</div>
<?php echo foot();
