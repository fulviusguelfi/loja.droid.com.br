
<!--
/**
 * Controlle principal OpencartML 
 * Versão 1.1
 * Situação: Production
 * Autor / Flavio Lima  bhlims2 gmail com
 * Alterado por Flavio Lima  bhlima/gmail/com
 * Alterado por Thiago Guelfi  thiagovalentoni@gmail.com
 */
-->
<?php echo $header; ?> <?php echo $column_left; ?>

<div id="content"><!-- Page Content -->


    <div class="page-header"><!-- Page Header -->      
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-moip" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="#" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>	
                <a href="<?php echo $configure;?>" data-toggle="tooltip" title="Configurar APP" class="btn btn-default"><i class="fa fa-cogs"></i> Configurar APP ML</a>	
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach($breadcrumbs as $breadcrumb): ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div><!-- Page Header -->

    <!-- Container -->
    <div class="container-fluid">


        <!-- Error -->
        <?php if(!empty($warning)):?>
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> <?php echo $warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif;?>     

        <!-- Panel -->
        <div class="panel panel-default">

            <!-- Title -->
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3> 
            </div>

            <!-- Body -->
            <div class="panel-body">
                <!-- Nav -->
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#config"><?php echo $tab_config; ?></a></li>
                    <li><a data-toggle="tab" href="#browse"><?php echo $tab_listing_config; ?></a></li>
                    <li><a data-toggle="tab" href="#automation"><?php echo $tab_ml_automation; ?></a></li>
                    <li><a data-toggle="tab" href="#orders"><?php echo $tab_order_config; ?></a></li>
                    <!--
                   <li><a data-toggle="tab" href="#messages"><?php echo $tab_ml_menssages; ?></a></li>
                   <li><a data-toggle="tab" href="#templates"><?php echo $tab_template; ?></a></li>
                    -->
                    <li><a data-toggle="tab" href="#autorization"><?php echo $tab_ml_autorization; ?></a></li>
                </ul>


                <!-- Form -->
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-moip" class="form-horizontal">
                    <div class="tab-content">                        
                        <div class="tab-pane" id="config"><!-- Tab Config -->
                            <!-- Client_id -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_client_id; ?>"><?php echo $entry_client_id; ?></span></label>
                                <div class="col-sm-10">
                                    <input name="module_opencartml_client_id" type="text" class="form-control" value="<?php echo $module_opencartml_client_id; ?>" />
                                    <?php if(@$error['client_id']): ?>
                                    <div class="text-danger"><?php echo $error['client_id']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Client_secret -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_client_secret; ?>"><?php echo $entry_client_secret; ?></span></label>
                                <div class="col-sm-10">

                                    <input name="module_opencartml_client_secret" type="text" class="form-control" value="<?php echo $module_opencartml_client_secret; ?>" />
                                    <?php if(@$error['client_secret']): ?>
                                    <div class="text-danger"><?php echo $error['client_secret']; ?></div>
                                    <?php endif; ?>

                                </div>
                            </div>


                            <!-- Debug -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_debug; ?>"><?php echo $entry_debug; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_debug" class="form-control">
                                        <?php if($module_opencartml_debug): ?>
                                        <option value="1" selected><?php echo $text_yes; ?></option>
                                        <?php else: ?>
                                        <option value="1"><?php echo $text_yes; ?></option>
                                        <?php endif; ?>                   
                                        <?php if(!$module_opencartml_debug): ?>
                                        <option value="0" selected><?php echo $text_no; ?></option>
                                        <?php else: ?>
                                        <option value="0"><?php echo $text_no; ?></option>
                                        <?php endif; ?>                   
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_status" class="form-control">
                                        <?php if($module_opencartml_status): ?>
                                        <option value="1" selected><?php echo $text_enabled; ?></option>
                                        <?php else: ?>
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        <?php endif; ?> 
                                        <?php if(!$module_opencartml_status): ?>
                                        <option value="0" selected><?php echo $text_disabled; ?></option>
                                        <?php else: ?>
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php endif; ?> 
                                    </select>
                                </div>
                            </div>     

                            <!-- Custom Field (Número) -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_number; ?>"><?php echo $entry_ml_number; ?></span></label>
                                <div class="col-sm-10">
                                    <span class="input-group">
                                        <select name="module_opencartml_ml_number" class="form-control">
                                            <?php foreach($custom_fields as $custom_fields):?>
                                            <?php if ($custom_field['custom_field_id'] == 'module_opencartml_ml_number'): ?>
                                            <option value="<?php echo $custom_field['custom_field_id']; ?>" selected><?php echo $custom_field['name']; ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                                            <?php endif; ?>
                                            <?php endforeach;?>
                                        </select>

                                        <span class="input-group-btn">
                                            <a href="<?php echo $link_custom_field; ?>" class="btn btn-primary"><?php echo $text_ml_custom_field; ?></a>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- Custom Field (Data de Nascimento) -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_data_nascimento; ?>"><?php echo $entry_ml_data_nascimento; ?></span></label>
                                <div class="col-sm-10">
                                    <span class="input-group">
                                        <select name="module_opencartml_ml_data_nascimento" class="form-control">
                                            <?php foreach($custom_fields as $custom_fields):?>
                                            <?php if ($custom_field['custom_field_id'] == 'module_opencartml_ml_data_nascimento'): ?>
                                            <option value="<?php echo $custom_field['custom_field_id']; ?>" selected><?php echo $custom_field['name']; ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                                            <?php endif; ?>
                                            <?php endforeach;?>
                                        </select>

                                        <span class="input-group-btn">
                                            <a href="<?php echo $link_custom_field; ?>" class="btn btn-primary"><?php echo $text_ml_custom_field; ?></a>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- Custom Field (CPF) -->
                            <div class="form-group required">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_cpf; ?>"><?php echo $entry_ml_cpf; ?></span></label>
                                <div class="col-sm-10">
                                    <span class="input-group">
                                        <select name="module_opencartml_ml_cpf" class="form-control">
                                            <?php foreach($custom_fields as $custom_fields):?>
                                            <?php if ($custom_field['custom_field_id'] == 'module_opencartml_ml_data_nascimento'): ?>
                                            <option value="<?php echo $custom_field['custom_field_id']; ?>" selected><?php echo $custom_field['name']; ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></option>
                                            <?php endif; ?>
                                            <?php endforeach;?>
                                        </select>

                                        <span class="input-group-btn">
                                            <a href="<?php echo $link_custom_field; ?>" class="btn btn-primary"><?php echo $text_ml_custom_field; ?></a>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- URL de Retorno -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo $entry_ml_url_retorno; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" disabled value="<?php echo $uri_retorno; ?>" class="form-control" />
                                </div>
                            </div>

                        </div> <!-- Tab Config -->

                        <div class="tab-pane" id="browse"><!-- Tab Feedback --> 
                            <div class="form-group required">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_category; ?>"><?php echo $entry_ml_category; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_category" class="form-control">
                                        {% for categorie in categories %}
                                        {% if categorie.id == module_opencartml_category %}
                                        <option value="<?php echo $categorie.id; ?>" selected><?php echo $categorie.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $categorie.id; ?>"><?php echo $categorie.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>                                    



                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_subcategory; ?>"><?php echo $entry_ml_subcategory; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_subcategory" class="form-control">
                                        <option value="1" selected><?php echo $text_enabled; ?></option>
                                        <option value="0"><?php echo $text_enabled; ?></option>
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_currency; ?>"><?php echo $entry_ml_currency; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_currency" class="form-control">
                                        {% for currencie in currencies %}
                                        {% if currencie.id == module_opencartml_currency %}
                                        <option value="<?php echo $currencie.id; ?>" selected><?php echo $currencie.description; ?></option>
                                        {% else %}
                                        <option value="<?php echo $currencie.id; ?>"><?php echo $currencie.description; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_adtype; ?>"><?php echo $entry_ml_adtype; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_adtype" class="form-control">
                                        {% for listing_type in listing_types %}                                           
                                        {% if listing_type.id == module_opencartml_adtype %}
                                        <option value="<?php echo $listing_type.id; ?>" selected><?php echo $listing_type.name; ?></option>                                       
                                        {% else %}
                                        <option value="<?php echo $listing_type.id; ?>"><?php echo $listing_type.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_itemcondition; ?>"><?php echo $entry_ml_itemcondition; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_itemcondition" class="form-control">
                                        {% if module_opencartml_itemcondition %}    
                                        <option value="1" selected><?php echo $text_ml_new; ?></option>
                                        {% else %}
                                        <option value="1"><?php echo $text_ml_new; ?></option>               
                                        {% endif %}
                                        {% if not module_opencart_itemcondition%}
                                        <option value="0" selected> <?php echo $text_ml_used; ?></option>                                    
                                        {% else %}
                                        <option value="0"> <?php echo $text_ml_used; ?></option>                                           
                                        {% endif %}
                                    </select>
                                </div>
                            </div>   

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-description1"><?php echo $entry_ml_template_default; ?></label>
                                <div class="col-sm-10">
                                    <textarea name="module_opencartml_template_default" placeholder="Description" id="input-description1" data-toggle="summernote" data-lang="" class="form-control">
                                    </textarea>
                                </div>
                            </div>

                        </div><!-- Status -->



                        <div class="tab-pane" id="automation"><!-- Tab Feedback --> 

                            <div class="form-group required"><!-- Status -->
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_feedback_status; ?>"><?php echo $entry_ml_feedback_status; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_feedback_status" class="form-control">
                                        {% if module_opencartml_feedback_status %}
                                        <option value="1" selected><?php echo $text_enabled; ?></option>
                                        {% else %}
                                        <option value="1"><?php echo $text_enabled; ?></option>
                                        {% endif %}
                                        {% if not module_opencartml_feedback_status %}
                                        <option value="0" selected><?php echo $text_disabled; ?></option>
                                        {% else %}
                                        <option value="0"><?php echo $text_disabled; ?></option>
                                        {% endif %}
                                    </select>
                                </div>
                            </div><!-- Status -->  


                            <div class="form-group required"><!-- Status -->
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_feedback_status_post; ?>"><?php echo $entry_ml_feedback_status_post; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_feedback_status_post" class="form-control">
                                        {% if module_opencartml_feedback_status_post %}
                                        <option value="1" selected><?php echo $entry_ml_feedback_arrival; ?></option>
                                        {% else %}
                                        <option value="1"><?php echo $entry_ml_feedback_arrival; ?></option>
                                        {% endif %}
                                        {% if not module_opencartml_feedback_status_post %}
                                        <option value="0" selected><?php echo $entry_ml_feedback_shipped; ?></option>
                                        {% else %}
                                        <option value="0"><?php echo $entry_ml_feedback_shipped; ?></option>
                                        {% endif %}
                                    </select>
                                </div>
                            </div><!-- Status -->  


                            <div class="form-group required"><!-- Status -->
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_feedback_rating; ?>"><?php echo $entry_ml_feedback_rating; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_feedback_rating" class="form-control">
                                        {% if module_opencartml_feedback_rating %}
                                        <option value="positive" selected><?php echo $text_positive; ?></option>
                                        {% else %}
                                        <option value="positive"><?php echo $text_positive; ?></option>
                                        {% endif %}
                                        {% if not module_opencartml_feedback_rating %}
                                        <option value="neutral" selected><?php echo $text_neutral; ?></option>
                                        {% else %}
                                        <option value="neurtral"><?php echo $text_neutral; ?></option>
                                        {% endif %}
                                    </select>
                                </div>
                            </div><!-- Status -->                          


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-description1"><?php echo $entry_ml_feedback_message; ?></label>
                                <div class="col-sm-10">
                                    <textarea name="module_opencartml_feedback_message" placeholder="Description" id="module_opencartml_feedback_message" data-toggle="none" data-lang="" class="form-control"><?php echo $module_opencartml_feedback_message; ?></textarea>
                                </div>
                            </div>                                                      
                        </div><!-- Tab Feedback -->   


                        <div class="tab-pane" id="orders">

                            <!-- Aguardando Pagamento -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_aguardando_pagamento; ?>"><?php echo $entry_ml_aguardando_pagamento; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_aguardando_pagamento" class="form-control">
                                        {% for status in statuses %}
                                        {% if module_opencartml_aguardando_pagamento == status.order_status_id %}
                                        <option value="<?php echo $status.order_status_id; ?>" selected><?php echo $status.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $status.order_status_id; ?>"><?php echo $status.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>

                            <!-- Em Análise -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_analise; ?>"><?php echo $entry_ml_analise; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_analise" class="form-control">
                                        {% for status in statuses %}
                                        {% if module_opencartml_analise == status.order_status_id %}
                                        <option value="<?php echo $status.order_status_id; ?>" selected><?php echo $status.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $status.order_status_id; ?>"><?php echo $status.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>

                            <!-- Pago -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_completed; ?>"><?php echo $entry_ml_completed; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_completed" class="form-control">
                                        {% for status in statuses %}
                                        {% if module_opencartml_completed == status.order_status_id %}
                                        <option value="<?php echo $status.order_status_id; ?>" selected><?php echo $status.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $status.order_status_id; ?>"><?php echo $status.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>

                            <!-- Disponível -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_shiped; ?>"><?php echo $entry_ml_shiped; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_shiped" class="form-control">
                                        {% for status in statuses %}
                                        {% if module_opencartml_shiped == status.order_status_id %}
                                        <option value="<?php echo $status.order_status_id; ?>" selected><?php echo $status.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $status.order_status_id; ?>"><?php echo $status.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>


                            <!-- Devolvida -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_ml_delivered; ?>"><?php echo $entry_ml_delivered; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_delivered" class="form-control">
                                        {% for status in statuses %}
                                        {% if module_opencartml_delivered == status.order_status_id %}
                                        <option value="<?php echo $status.order_status_id; ?>" selected><?php echo $status.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $status.order_status_id; ?>"><?php echo $status.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>

                            <!-- Cancelada -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><span data-toggle="tooltip" data-html="true" title="<?php echo $entry_ml_canceled; ?>"><?php echo $entry_ml_canceled; ?></span></label>
                                <div class="col-sm-10">
                                    <select name="module_opencartml_canceled" class="form-control">
                                        {% for status in statuses %}
                                        {% if module_opencartml_canceled == status.order_status_id %}
                                        <option value="<?php echo $status.order_status_id; ?>" selected><?php echo $status.name; ?></option>
                                        {% else %}
                                        <option value="<?php echo $status.order_status_id; ?>"><?php echo $status.name; ?></option>
                                        {% endif %}
                                        {% endfor %}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="autorization">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i>
                                        {% if auth_code %}
                                        <?php echo $text_ml_grant_access; ?>
                                        {% else %}                                         
                                        <?php echo $text_ml_autorization; ?>
                                        {% endif %}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="panel-body">

                                    {% if auth_code %}
                                    <p>Você já esta autorizado sob o código :: <?php echo $auth_code; ?></p>                                    
                                    <p><strong>Id da sua conta: </strong><?php echo $account.id; ?></p>
                                    <p><strong>Seu pelino: </strong><?php echo $account.nickname; ?></p>
                                    <p><strong>Sua página no Mercado Livre: </strong><a href="<?php echo $account.permalink; ?>" target="_blank"><?php echo $account.permalink; ?></a></p></p>    




                                    {% else %}    
                                    <span class="input-group-btn">
                                        <a href="<?php echo $auth_link; ?>" class="btn btn-primary"><?php echo $text_ml_b_auth; ?></a>
                                    </span>
                                    {% endif %}
                                </div>
                            </div>
                        </div>
                    </div><!-- tab Content -->
                </form> <!-- /Form -->   
            </div><!-- /.panel-body -->
        </div><!-- /.panel.panel-default -->
    </div><!-- /.container-fluid -->
</div><!-- /#content -->

<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/summernote-image-attributes.js"></script> 
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script> 

<script type="text/javascript">
    $('fieldset legend').css('cursor', 'pointer');
    $('.nav-tabs li:first').addClass('active');
    $('.tab-content div:first').addClass('active');
    $('fieldset legend').click(function () {
        $(this).parent().find('div').slideToggle('slow');
    });
</script>

<?php echo $footer; ?>
