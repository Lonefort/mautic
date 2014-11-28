<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
if ($tmpl == 'index') {
    $view->extend('MauticInstallBundle:Install:content.html.php');
}

$js = <<<JS
MauticInstaller.toggleSpoolQueue = function() {
    if (mQuery('#install_email_step_mailer_spool_type_0').prop('checked')) {
        mQuery('#spoolPath').addClass('hide');
    } else {
        mQuery('#spoolPath').removeClass('hide');
    }
};

MauticInstaller.toggleTransportDetails = function (mailer) {
    if (mailer == 'smtp') {
        mQuery('#smtpSettings').removeClass('hide');
        if (mQuery('#install_email_step_mailer_auth_mode').val()) {
            mQuery('#authDetails').removeClass('hide');
        } else {
            mQuery('#authDetails').addClass('hide');
        }
    } else {
        mQuery('#smtpSettings').addClass('hide');

        if (mailer == 'mail' || mailer == 'sendmail') {
            mQuery('#authDetails').addClass('hide');
        } else {
            mQuery('#authDetails').removeClass('hide');
        }
    }
};

MauticInstaller.toggleAuthDetails = function(auth) {
    if (!auth) {
        mQuery('#authDetails').addClass('hide');
    } else {
        mQuery('#authDetails').removeClass('hide');
    }
};
JS;
$view['assets']->addScriptDeclaration($js);

$header = $view['translator']->trans('mautic.install.heading.email.configuration');
?>

<h2 class="page-header">
    <?php echo $header; ?>
</h2>

<?php echo $view['form']->start($form); ?>

<div class="panel panel-primary">
    <div class="panel-heading pa-10">
        <h4><?php echo $view['translator']->trans('mautic.install.email.header.emailfrom'); ?></h4>
        <h6><?php echo $view['translator']->trans('mautic.install.email.subheader.emailfrom'); ?></h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $view['form']->row($form['mailer_from_name']); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $view['form']->row($form['mailer_from_email']); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading pa-10">
        <h4><?php echo $view['translator']->trans('mautic.install.email.header.spooler'); ?></h4>
        <h6><?php echo $view['translator']->trans('mautic.install.email.subheader.spooler'); ?></h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-5">
                <?php echo $view['form']->row($form['mailer_spool_type']); ?>
            </div>
            <?php $hide = ($form['mailer_spool_type']->vars['data'] == 'queue') ? '' : ' hide'; ?>
            <div class="col-sm-7<?php echo $hide; ?>" id="spoolPath">
                <?php echo $view['form']->row($form['mailer_spool_path']); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading pa-10">
        <h4><?php echo $view['translator']->trans('mautic.install.email.header.smtp'); ?></h4>
        <h6><?php echo $view['translator']->trans('mautic.install.email.subheader.smtp'); ?></h6>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <?php echo $view['form']->row($form['mailer_transport']); ?>
            </div>
        </div>
        <?php $hide = ($form['mailer_transport']->vars['data'] == 'smtp') ? '' : ' class="hide"'; ?>
        <div id="smtpSettings"<?php echo $hide; ?>>
            <div class="row">
                <div class="col-sm-9">
                    <?php echo $view['form']->row($form['mailer_host']); ?>
                </div>
                <div class="col-sm-3">
                    <?php echo $view['form']->row($form['mailer_port']); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?php echo $view['form']->row($form['mailer_encryption']); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $view['form']->row($form['mailer_auth_mode']); ?>
                </div>
            </div>
        </div>
        <?php
        $authMode = $form['mailer_auth_mode']->vars['data'];
        $mailer   = $form['mailer_transport']->vars['data'];
        $hide = (!in_array($mailer, array('mail', 'sendmail')) || ($mailer == 'smtp' && !empty($authMode))) ? '' : ' class="hide"';
        ?>
        <div id="authDetails"<?php echo $hide; ?>>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $view['form']->row($form['mailer_user']); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $view['form']->row($form['mailer_password']); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-20">
    <div class="col-sm-6">

    </div>
    <div class="col-sm-6 mt-20">
        <?php echo $view['form']->row($form['buttons']); ?>
    </div>
</div>

<?php echo $view['form']->end($form); ?>
