
<?php $user = current_user(); ?>
<?php if(( get_option('contribution_open') || get_option('contribution_strict_anonymous') ) && !$user) : ?>
<div class="field">
    <div class="two columns alpha">
    <?php
        if (get_option('contribution_strict_anonymous')) {
            echo $this->formLabel('contribution_email', __('Email (Optional)')); 
        } else {
            echo $this->formLabel('contribution_email', __('Email (Required)'));
        }
    ?>
    </div>
    <div class="inputs five columns omega">
    <p class="explanation">Providing your email helps us contact you and gives you the option to create an account to view your contributions. We will never share your email publicly.</p>
    <?php
        if(isset($_POST['contribution_email'])) {
            $email = $_POST['contribution_email'];
        } else {
            $email = '';
        }
        echo $this->formText('contribution_email', $email );
    ?>
    </div>
</div>

<?php else: ?>
    <p><?php echo __('You are logged in as: %s', metadata($user, 'name')); ?>
<?php endif; ?>
    <?php
    //pull in the user profile form if it is set
    if( isset($profileType) ): ?>

    <script type="text/javascript" charset="utf-8">
    //<![CDATA[
    jQuery(document).bind('omeka:elementformload', function (event) {
         Omeka.Elements.makeElementControls(event.target, <?php echo js_escape(url('user-profiles/profiles/element-form')); ?>,'UserProfilesProfile'<?php if ($id = metadata($profile, 'id')) echo ', '.$id; ?>);
         Omeka.Elements.enableWysiwyg(event.target);
    });
    //]]>
    </script>

        <h2 class='contribution-userprofile <?php echo $profile->exists() ? "exists" : ""  ?>'><?php echo  __('Your %s profile', $profileType->label); ?></h2>
        <p id='contribution-userprofile-visibility'>
        <?php if ($profile->exists()) :?>
            <span class='contribution-userprofile-visibility'><?php echo __('Show'); ?></span><span class='contribution-userprofile-visibility' style='display:none'><?php echo __('Hide'); ?></span>
            <?php else: ?>
            <span class='contribution-userprofile-visibility' style='display:none'><?php echo __('Show'); ?></span><span class='contribution-userprofile-visibility'><?php echo __('Hide'); ?></span>
        <?php endif; ?>
        </p>
        <div class='contribution-userprofile <?php echo $profile->exists() ? "exists" : ""  ?>'>
        <p class="user-profiles-profile-description"><?php echo $profileType->description; ?></p>
        <fieldset name="user-profiles">
        <?php
        foreach($profileType->Elements as $element) {
            echo $this->profileElementForm($element, $profile);
        }
        ?>
        </fieldset>
        </div>
        <?php endif; ?>

<?php if (!$type): ?>
<p><?php echo __('You must choose a contribution type to continue.'); ?></p>
<?php else: ?>
<h2><?php echo __('Contribute Your %s', $type->display_name); ?></h2>

<div class="inputs">
     <p id="alert">Anything you enter in the form below may appear publicly after your submission. All parts are optional.</p>
</div>

<?php
if ($type->isFileRequired()):
    $required = true;
?>

<div class="field">
    <div class="two columns alpha">
        <?php echo $this->formLabel('contributed_file', __('Upload a file')); ?>
    </div>
    <div class="inputs five columns omega">
        <?php echo $this->formFile('contributed_file', array('class' => 'fileinput')); ?>
    </div>
</div>

<?php endif; ?>

<?php
foreach ($type->getTypeElements() as $contributionTypeElement) {
    echo $this->elementForm($contributionTypeElement->Element, $item, array('contributionTypeElement'=>$contributionTypeElement));
}
?>

<?php
if (!isset($required) && $type->isFileAllowed()):
?>
<div class="field">
        <div class="two columns alpha">
            <?php echo $this->formLabel('contributed_file', __('Upload a file (Optional)')); ?>
        </div>
        <div class="inputs five columns omega">
        <p class="explanation">You may wish to upload relevant images or documents to attach to your item. (Note: You can upload multiple files from a single directory by holding the CTRL key (Windows) or COMMAND key (Mac) down while clicking on the files.)</p>
            <?php echo $this->formFile('contributed_file[]', array('class' => 'fileinput', 'multiple' => 'multiple')); ?>
        </div>
</div>
<?php endif; ?>


<?php
// Allow other plugins to append to the form (pass the type to allow decisions
// on a type-by-type basis).
fire_plugin_hook('contribution_type_form', array('type'=>$type, 'view'=>$this));
?>
<?php endif; ?>


<?php
// Enable Datepicker calendar in date fields
echo js_tag('datepicker');
?>

<?php
// Add explanation for geolocation form
echo js_tag('geolocation-explainer');
?>
