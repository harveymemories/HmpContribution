<?php echo head(array(
    'title' => 'Thank You',
    'bodyclass' => 'page')); ?>
<div id="primary">
	<h1><?php echo __("Thank you for contributing!"); ?></h1>
	<p><?php echo __("Your contribution will show up in the archive once an administrator approves it. Meanwhile, feel free to %s or %s ." , contribution_link_to_contribute(__('make another contribution')), "<a href='" . url('items/browse') . "'>" . __('browse the archive') . "</a>"); ?>
	</p>
    <p>To help us learn more about the project's effectiveness, you can also <a href="https://riceuniversity.co1.qualtrics.com/jfe/form/SV_3fVJXuOocYVISln">take our survey</a> about your experience on the site. The survey is short, optional, and anonymous. Your answers will not be linked in any way to your contribution or your account.</p>
	<?php if(get_option('contribution_open') && !current_user()): ?>
	<p><?php echo __("If you would like to interact with the site further, you can use an account that is ready for you. Visit %s, and request a new password for the email you used", "<a href='" . url('users/forgot-password') . "'>" . __('this page') . "</a>"); ?>
	<?php endif; ?>
</div>
<?php echo foot(); ?>
