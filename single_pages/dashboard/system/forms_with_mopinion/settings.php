<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>

<div class="ccm-dashboard-content-inner">
    <form method="post" action="<?php echo $this->action('save'); ?>">
        <?php
        /** @var \Concrete\Core\Validation\CSRF\Token $token */
        echo $token->output('a3020.forms_with_mopinion.settings');
        ?>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('If disabled, %s will be completely turned off.', t('Forms with Mopinion')) ?>"
                   for="isEnabled">
                <?php
                /** @var bool $isEnabled */
                echo $form->checkbox('isEnabled', 1, $isEnabled);
                ?>
                <?php echo t(/*i18n: where %s is the name of the add-on */'Enable %s', t('Forms with Mopinion')); ?>
            </label>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t('First create a form via the Mopinion website. When the form is completed, you can paste the embed code here. The embed code is the same for all forms.'); ?>"
                   for="defaultCode">
                <?php
                echo t('JavaScript embed code');
                ?>
            </label>

            <?php
            /** @var string $defaultCode */
            echo $form->textarea('defaultCode', $defaultCode, [
                'rows' => 7,
            ]);
            ?>

            <p class="text-muted small" style="margin-top: 5px;">
                <?php
                echo t(/*i18n: where %s is the link to a website */
                    'Get your embed code via %s.',
                    '<a href="https://mopinion.com" target="_blank">https://mopinion.com</a>'
                );
                ?>
            </p>
        </div>

        <div class="form-group">
            <label class="control-label launch-tooltip"
                   title="<?php echo t("When specified, the button won't be shown for these user groups.    "); ?>"
                   for="disableForUserGroups">
                <?php echo t('Disable for user groups'); ?>
            </label>

            <?php
            /** @var array $userGroupOptions */
            /** @var array $disableForUserGroups */
            echo $form->selectMultiple('disableForUserGroups', $userGroupOptions, $disableForUserGroups, [
                'style' => 'width: 100%',
            ]);
            ?>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button class="pull-right btn btn-primary" type="submit"><?php echo t('Save') ?></button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
$(function() {
    $('#disableForUserGroups').removeClass('form-control').select2();
});
</script>
