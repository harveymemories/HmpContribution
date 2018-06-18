<?php
/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Contribution
 */

queue_js_url('https://code.jquery.com/ui/1.12.1/jquery-ui.js');
queue_css_url('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');

queue_js_file('contribution-public-form');
$contributionPath = get_option('contribution_page_path');
if(!$contributionPath) {
    $contributionPath = 'contribution';
}
queue_css_file('form');

//load user profiles js and css if needed
if(get_option('contribution_user_profile_type') && plugin_is_active('UserProfiles') ) {
    queue_js_file('admin-globals');
    queue_js_file('tinymce.min', 'javascripts/vendor/tinymce');
    queue_js_file('elements');
    queue_css_string("input.add-element {display: block}");
}

$head = array('title' => 'Contribute',
              'bodyclass' => 'contribution');
echo head($head); ?>
<script type="text/javascript">
// <![CDATA[
enableContributionAjaxForm(<?php echo js_escape(url($contributionPath.'/type-form')); ?>);
// ]]>
</script>

<div id="primary">
<?php echo flash(); ?>
    
    <h1><?php echo $head['title']; ?></h1>

<p>On this page you can share your own <strong>stories</strong>, <strong>images</strong>, and <strong>audio-visual recordings</strong> from or about Hurricane Harvey. If you have a different kind of item or memory you would like to contribute, or if you would like assistance telling your story, please <a href="/contact">contact us</a>.</p> 

    <?php if(! ($user = current_user() )
              && !(get_option('contribution_open') )
            ):
    ?>
        <?php $session = new Zend_Session_Namespace;
              $session->redirect = absolute_url();
        ?>
        <p>You must <a href='<?php echo url('guest-user/user/register'); ?>'>create an account</a> or <a href='<?php echo url('guest-user/user/login'); ?>'>log in</a> before contributing. You can still leave your identity to site visitors anonymous.</p>        
    <?php else: ?>
        <form method="post" action="" enctype="multipart/form-data">
            <fieldset id="contribution-item-metadata">
                <div class="inputs">
                    <label for="contribution-type"><?php echo __("What type of item do you want to contribute?"); ?></label>
                    <?php $options = get_table_options('ContributionType' ); ?>
                    <?php $typeId = isset($type) ? $type->id : '' ; ?>
                    <?php echo $this->formSelect( 'contribution_type', $typeId, array('multiple' => false, 'id' => 'contribution-type') , $options); ?>
                    <input type="submit" name="submit-type" id="submit-type" value="Select" />
                </div>
                <div id="contribution-type-form">
                <?php if(isset($type)) { include('type-form.php'); }?>
                </div>
            </fieldset>

            <fieldset id="contribution-confirm-submit" <?php if (!isset($type)) { echo 'style="display: none;"'; }?>>
<br/>
<h2>Terms and Conditions</h2>
                <div class="inputs">
                <p class="explanation">By submitting an item, you agree that it may be published on the Harvey Memories Project. You may also choose to attach an optional Creative Commons license to your item so that others can use and distribute it more easily. Check all the boxes that apply. For more information, see the full <?php echo __("<a href='" . contribution_contribute_url('terms') . "' target='_blank'>" . __('Terms and Conditions') . ".</a>"); ?></p>
                    <?php $rightsBy = isset($_POST['contribution-rights-by']) ? $_POST['contribution-rights-by'] : 0; ?>
                    <?php echo $this->formCheckbox('contribution-rights[]', 'BY', null, array('BY', '')); ?>
                    <?php echo $this->formLabel('contribution-rights', __('Others can use and redistribute my item, with citation, in any medium or format ... ')); ?><br/>
                    <?php $rightsNc = isset($_POST['contribution-rights-nc']) ? $_POST['contribution-rights-nc'] : 0; ?>
                    <?php echo $this->formCheckbox('contribution-rights[]', $rightsNc, null, array('NC', '')); ?>
                    <?php echo $this->formLabel('contribution-rights', __('... only if the item is used for non-commercial purposes.')); ?><br/>
                    <?php $rightsSa = isset($_POST['contribution-rights-sa']) ? $_POST['contribution-rights-sa'] : 0; ?>
                    <?php echo $this->formCheckbox('contribution-rights[]', $rightsSa, null, array('SA', '')); ?>
                    <?php echo $this->formLabel('contribution-rights', __('... only if any changes to the item are shared under the same license.')); ?><br/>
                    <?php $rightsNd = isset($_POST['contribution-rights-nd']) ? $_POST['contribution-rights-nd'] : 0; ?>
                    <?php echo $this->formCheckbox('contribution-rights[]', $rightsNd, null, array('ND', '')); ?>
                    <?php echo $this->formLabel('contribution-rights', __('... only if the item is distributed exactly as it is, with no changes made.')); ?><br/>
                </div>
                <p><?php echo __("In order to contribute, you must read and agree to the %s",  "<a href='" . contribution_contribute_url('terms') . "' target='_blank'>" . __('Terms and Conditions') . ".</a>"); ?></p>
                <div class="inputs">
                    <?php $agree = isset( $_POST['terms-agree']) ?  $_POST['terms-agree'] : 0 ?>
                    <?php echo $this->formCheckbox('terms-agree', $agree, null, array('1', '0')); ?>
                    <?php echo $this->formLabel('terms-agree', __('I agree to the Terms and Conditions.')); ?>
                </div>
                <?php if(isset($captchaScript)): ?>
                    <div id="captcha" class="inputs"><?php echo $captchaScript; ?></div>
                <?php endif; ?>
                <br/>
                <?php echo $this->formSubmit('form-submit', __('Contribute'), array('class' => 'submitinput')); ?>
            </fieldset>
            <?php echo $csrf; ?>
        </form>
    <?php endif; ?>
</div>
<?php echo foot();
