<?php

$configuration = $this->registry->get_configuration_items();
$configuration = $this->helper->group_items( $configuration );

?>

<script src="<?php echo WPCFM_URL; ?>/assets/js/admin.js"></script>
<script src="<?php echo WPCFM_URL; ?>/assets/js/multiple-select/jquery.multiple.select.js"></script>
<script src="<?php echo WPCFM_URL; ?>/assets/js/pretty-text-diff/diff_match_patch.js"></script>
<script src="<?php echo WPCFM_URL; ?>/assets/js/pretty-text-diff/jquery.pretty-text-diff.js"></script>

<link href="<?php echo WPCFM_URL; ?>/assets/css/admin.css" rel="stylesheet">
<link href="<?php echo WPCFM_URL; ?>/assets/js/multiple-select/multiple-select.css" rel="stylesheet">

<div class="wrap">
    <h2>
        Configuration Management <span>by <a href="http://forumone.com/" target="_blank">Forum One Communications</a></span>
    </h2>

    <?php if ( !empty ( $this->readwrite->error ) ) : ?>
    <div class="wpcfm-error"><?php echo $this->readwrite->error; ?></div>
    <?php endif; ?>

    <div class="wpcfm-response"></div>

    <div class="wpcfm-bundles">
        <div class="wpcfm-action-buttons">
            <div style="float:right">
                <a class="button-primary wpcfm-save"><?php _e( 'Save Changes', 'wpcfm' ); ?></a>
            </div>
            <a class="button add-bundle"><?php _e( 'Add Bundle', 'wpcfm' ); ?></a>
            <div class="clear"></div>
        </div>

        <div class="bundle-row row-all" data-bundle="all">
            <div class="bundle-header">
                <div class="bundle-actions">
                    <a class="button diff-bundle" title="Compare differences"><?php _e( 'Diff', 'wpcfm' ); ?></a> &nbsp;
                    <a class="button push-bundle" title="Write database changes to the filesystem"><?php _e( 'Push', 'wpcfm' ); ?></a> &nbsp;
                    <a class="button pull-bundle" title="Import file changes into the database"><?php _e( 'Pull', 'wpcfm' ); ?></a>
                </div>
                <div class="bundle-toggle">All Bundles</div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <!-- clone settings -->

    <div class="bundles-hidden">
        <div class="bundle-row" data-bundle="new_bundle">
            <div class="bundle-header">
                <div class="bundle-actions">
                    <span class="no-actions">Save to see actions</span>
                    <a class="button diff-bundle" title="Compare differences"><?php _e( 'Diff', 'wpcfm' ); ?></a> &nbsp;
                    <a class="button push-bundle" title="Write database changes to the filesystem"><?php _e( 'Push', 'wpcfm' ); ?></a> &nbsp;
                    <a class="button pull-bundle" title="Import file changes into the database"><?php _e( 'Pull', 'wpcfm' ); ?></a>
                </div>
                <div class="bundle-toggle">New bundle</div>
                <div class="clear"></div>
            </div>
            <div class="bundle-row-inner">
                <input type="text" class="bundle-label" value="New bundle" />
                <input type="text" class="bundle-name" value="new_bundle" />
                <div class="bundle-select-wrapper">
                    <select class="bundle-select" multiple="multiple">
                    <?php foreach ( $configuration as $group => $config ) : ?>
                        <optgroup label="<?php echo $group; ?>">
                            <?php foreach ( $config as $key => $data ) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                    </select>
                </div>
                <a class="remove-bundle"><?php _e( 'Delete Bundle', 'wpcfm' ); ?></a>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<!-- diff modal -->

<div class="media-modal">
    <a class="media-modal-close"><span class="media-modal-icon"></span></a>
    <div class="media-modal-content">
        <div class="media-frame">
            <div class="media-frame-title">
                <h1>Diff Viewer</h1>
            </div>
            <div class="media-frame-router">
                <div class="media-router">
                    Compare file and database versions. Changes marked in <span style="background:#c6ffc6">GREEN</span> exist in the database but not the filesystem.
                </div>
            </div>
            <div class="media-frame-content">
                <div class="wpcfm-diff">
                    <pre class="original"></pre>
                    <pre class="changed"></pre>
                    <pre class="diff"></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="media-modal-backdrop"></div>
