<?php 
$head = array('title' => __('Contribution Terms of Service'), 'bodyclass' => 'page');
echo head($head);
?>

<div id="primary">
<h1><?php echo $head['title']; ?></h1>
<?php echo get_option('contribution_consent_text'); ?>
</div>
<?php echo foot(); ?>
