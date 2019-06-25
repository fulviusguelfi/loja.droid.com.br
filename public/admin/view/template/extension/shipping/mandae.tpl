<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">

            <?php if (isset($success)) { ?>
                <?php if ( is_array($success)) { ?>
                    <?php foreach($success as $success_message) { ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i>
                            <?php echo $success_message; ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i>
                        <?php echo $success; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?></div>
            <?php } ?>

            <div class="pull-right">

                <button type="submit" form="form-koin" data-toggle="tooltip"
                        title="<?php echo $button_save; ?>" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                </button>

                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default">
                    <i class="fa fa-reply"></i>
                </a>
            </div>

            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <?php if ($error_warning) { ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-pencil"></i>
                    <?php echo $text_edit; ?>
                </h3>
            </div>
            <div class="panel-body">

                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-koin" class="form-horizontal">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <li><a href="#tab-units" data-toggle="tab"><?php echo $tab_units; ?></a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB GENERAL SETTINGS -->
                        <div class="tab-pane active" id="tab-general">
                            <!-- STATUS -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-status">
                                    <?php echo $entry_status; ?>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_status" id="input-status" class="form-control">
                                        <?php if ($mandae_status) { ?>
                                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- TOKEN -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-token">
                                    <span data-toggle="tooltip" title="<?php echo $help_token; ?>">
                                        <?php echo $entry_token; ?>
                                    </span>
                                </label>

                                <div class="col-sm-10">
                                    <input type="text" name="mandae_token"
                                           value="<?php echo $mandae_token; ?>"
                                           placeholder="<?php echo $entry_token; ?>" id="input-token" class="form-control"/>
                                    <?php if ($error_token) { ?>
                                        <div class="text-danger"><?php echo $error_token; ?></div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- METHOD TITLE -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-method-title">
                                    <span data-toggle="tooltip" title="<?php echo $help_method_title; ?>">
                                        <?php echo $entry_method_title; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_method_title"
                                           value="<?php echo $mandae_method_title; ?>"
                                           placeholder="<?php echo $entry_method_title; ?>"
                                           id="input-method-title" class="form-control"/>
                                </div>
                            </div>

                            <!-- DEADLINE TEXT-->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-deadline-text">
                                    <span data-toggle="tooltip" title="<?php echo $help_deadline_text; ?>">
                                        <?php echo $entry_deadline_text; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_deadline_text"
                                           value="<?php echo $mandae_deadline_text; ?>"
                                           placeholder="<?php echo $entry_deadline_text; ?>"
                                           id="input-deadline-text" class="form-control"/>
                                </div>
                            </div>

                            <!-- TEST OR PRODUCTION -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_environment; ?>">
                                        <?php echo $entry_environment; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_environment" id="input-mandae-environment" class="form-control">
                                        <option value="test" <?php echo ($mandae_environment == 'test') ? 'selected="selected"' : null;?>><?php echo $entry_test; ?></option>
                                        <option value="production" <?php echo ($mandae_environment == 'production') ? 'selected="selected"' : null;?>><?php echo $entry_production; ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- DECLARED VALUE -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_declared_value; ?>">
                                        <?php echo $entry_declared_value; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_declared_value" id="input-mandae-declared-value" class="form-control">
                                        <option value="0" <?php echo ($mandae_declared_value == '0') ? 'selected="selected"' : null;?>><?php echo $text_no; ?></option>
                                        <option value="1" <?php echo ($mandae_declared_value == '1') ? 'selected="selected"' : null;?>><?php echo $text_yes; ?></option>
                                    </select>
                                </div>
                            </div>


                            <!-- HANDLING TIME -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_handling_time; ?>">
                                        <?php echo $entry_handling_time; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_handling_time"
                                           value="<?php echo $mandae_handling_time; ?>"
                                           placeholder="<?php echo $entry_handling_time; ?>"
                                           id="input-handling-time" class="form-control"/>
                                </div>
                            </div>


                            <!-- HANDLING TYPE -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_handling_type; ?>">
                                        <?php echo $entry_handling_type; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_handling_type" id="input-mandae-handling-type" class="form-control">
                                        <option value="none" <?php echo ($mandae_handling_type == 'none') ? 'selected="selected"' : null;?>><?php echo $text_none; ?></option>
                                        <option value="percent" <?php echo ($mandae_handling_type == 'percent') ? 'selected="selected"' : null;?>><?php echo $text_percent; ?></option>
                                        <option value="fixed" <?php echo ($mandae_handling_type == 'fixed') ? 'selected="selected"' : null;?>><?php echo $text_fixed; ?></option>
                                    </select>
                                </div>
                            </div>

                            <!-- HANDLING FEE -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-handling-fee">
                                    <span data-toggle="tooltip" title="<?php echo $help_handling_fee; ?>">
                                        <?php echo $entry_handling_fee; ?>
                                    </span>
                                </label>

                                <div class="col-sm-10">
                                    <input type="text" name="mandae_handling_fee"
                                           value="<?php echo $mandae_handling_fee; ?>"
                                           placeholder="<?php echo $entry_handling_fee; ?>"
                                           id="input-handling-fee"
                                           class="form-control"/>
                                </div>
                            </div>

                            <!-- GEO ZONE -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-geo-zone">
                                    <?php echo $entry_geo_zone; ?>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_geo_zone_id" id="input-geo-zone" class="form-control">
                                        <option value="0"><?php echo $text_all_zones; ?></option>
                                        <?php foreach ($geo_zones as $geo_zone) { ?>
                                        <?php if ($geo_zone['geo_zone_id'] == $mandae_geo_zone_id) { ?>
                                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- GEO ZONE -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-geo-zone">
                                    <?php echo $entry_tax_class; ?>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_tax_class_id" id="input-tax-class" class="form-control">
                                        <option value="0"><?php echo $text_none; ?></option>
                                        <?php foreach ($tax_classes as $tax_class) { ?>
                                        <?php if ($tax_class['tax_class_id'] == $mandae_tax_class_id) { ?>
                                        <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- ORDER -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-sort-order">
                                    <?php echo $entry_sort_order; ?>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_sort_order"
                                           value="<?php echo $mandae_sort_order; ?>"
                                           placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order"
                                           class="form-control"/>
                                </div>
                            </div>

                            <!-- LOG -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-logging">
                                    <?php echo $entry_logging; ?>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_logging" id="input-logging" class="form-control">
                                        <?php if ($mandae_logging) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- TAB CC -->
                        <div class="tab-pane" id="tab-units">

                            <!-- USE DEFAULT DIMENSIONS -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_use_default_dimensions; ?>">
                                        <?php echo $entry_use_default_dimensions; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="mandae_use_default_dimensions" id="input-mandae-use-default-dimensions" class="form-control">
                                        <option value="0" <?php echo ($mandae_use_default_dimensions == '0') ? 'selected="selected"' : null;?>>
                                            <?php echo $text_no; ?>
                                        </option>
                                        <option value="1" <?php echo ($mandae_use_default_dimensions == '1') ? 'selected="selected"' : null;?>>
                                            <?php echo $text_yes; ?>
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- DEFAULT WIDTH -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_default_width; ?>">
                                        <?php echo $entry_default_width; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_default_width"
                                           value="<?php echo $mandae_default_width; ?>"
                                           placeholder="<?php echo $entry_default_width; ?>" id="input-sort-order"
                                           class="form-control"/>
                                </div>
                            </div>

                            <!-- DEFAULT HEIGHT -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_default_height; ?>">
                                        <?php echo $entry_default_height; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_default_height"
                                           value="<?php echo $mandae_default_height; ?>"
                                           placeholder="<?php echo $entry_default_height; ?>" id="input-sort-order"
                                           class="form-control"/>
                                </div>
                            </div>

                            <!-- DEFAULT LENGTH -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <span data-toggle="tooltip" title="<?php echo $help_default_length; ?>">
                                        <?php echo $entry_default_length; ?>
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="mandae_default_length"
                                           value="<?php echo $mandae_default_length; ?>"
                                           placeholder="<?php echo $entry_default_length; ?>" id="input-sort-order"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>