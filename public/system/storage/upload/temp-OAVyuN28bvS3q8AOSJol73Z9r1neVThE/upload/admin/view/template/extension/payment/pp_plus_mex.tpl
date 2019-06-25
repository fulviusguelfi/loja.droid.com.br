<?php
/*
Payment Method PayPalPlus México by Treebes
Author: Juan Lanzagorta FV
www.treebes.com
Ver 1.0 
15 November 2017

Code is distributed as is.
It is not permited to re-distribute this code.

Support only available for buyers in our database,
via email soporte@treebes.com and having available
support hours in the included support contract.

NOTES:
+ Only available for Mexican Pesos (MXN)
+ Only available for Mexican Credit Cards
+ Only one status of payment is managed (no cancelation, no refund, no resend, no re-authorise, etc.)

Treebes nor the Authors ARE NOT responsible for the use or consecuences of the use of this code.
*/

echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pp-plus-iframe-uk" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pp-plus-iframe-uk" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
            <li><a href="#tab-order-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
            <li><a href="#tab-instrucciones" data-toggle="tab"><?php echo $tab_instrucciones; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <span class="col-sm-2"></span>
              <label class="col-sm-10"><?php echo $tab_important_message; ?><br><br></label>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-live-demo"><span data-toggle="tooltip" title="<?php echo $help_test; ?>"><?php echo $entry_test; ?></span></label>
                <div class="col-sm-10">
                  <select name="pp_plus_mex_test" id="input-live-demo" class="form-control">
                    <?php if ($pp_plus_mex_test) { ?>
                    <option value="1" selected="selected">SANDBOX</option>
                    <option value="0">LIVE</option>
                    <?php } else { ?>
                    <option value="1">SANDBOX</option>
                    <option value="0" selected="selected">LIVE</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="entry-clientid"><?php echo $entry_clientid; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_plus_mex_clientid" value="<?php echo $pp_plus_mex_clientid; ?>" placeholder="<?php echo $entry_clientid; ?>" id="entry-clientid" class="form-control"/>
                  <?php if (isset($error['clientid'])) { ?>
                  <div class="text-danger"><?php echo $error['clientid']; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="entry-secret"><?php echo $entry_secret; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_plus_mex_secret" value="<?php echo $pp_plus_mex_secret; ?>" placeholder="<?php echo $entry_secret; ?>" id="entry-secret" class="form-control"/>
                  <?php if (isset($error['secret'])) { ?>
                  <div class="text-danger"><?php echo $error['secret']; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="entry-experience_profile_id"><?php echo $entry_experience_profile_id; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_plus_mex_experience_profile_id" value="<?php echo $pp_plus_mex_experience_profile_id; ?>" placeholder="<?php echo $entry_experience_profile_id; ?>" id="entry-experience_profile_id" class="form-control" readonly/>
                  <?php if (isset($error['experience_profile_id'])) { ?>
                  <div class="text-danger"><?php echo $error['experience_profile_id']; ?></div>
                  <?php } ?>
                  <button onclick="genera_profile_id();" type="button">Seleccionar Profile ID</button>
                  <button onclick="borra_profile_id();" type="button">Borrar Profile ID</button>
                  <div id="perfiles_a_seleccionar"></div>
                  <script>
                    function genera_profile_id(){
                      pid = $('#entry-experience_profile_id').val();
                      clientId = $('#entry-clientid').val();
                      secret = $('#entry-secret').val();
                      paypalMode = $('#input-live-demo').val();
                      //Verifica
                      $('#perfiles_a_seleccionar').html('Loading....'); 
                      $.ajax({
                          url: "./view/template/extension/payment/pp_plus_mex_functions.php",
                          type: "POST",
                          dataType: "json",
                          data: {
                            action: "getProfileIds",
                            clientId: clientId,
                            secret: secret,
                            paypalMode: paypalMode
                          },
                          success: function(result){
                            //alert('CHIDO: '+JSON.stringify(result, null, 4));
                            pinta='SELECT A ProfileID<br><ul>';
                            pinta+='<li><a onclick="$(\'#perfiles_a_seleccionar\').html(\'\');">CANCEL</a></li>';
                            for (pid in result){
                              pinta+='<li><a onclick="seleccionapid(\''+result[pid].id+'\')">'+result[pid].id+' ('+result[pid].name+')'+'</a></li>';
                            }
                            pinta+='</ul>';
                            //alert(pinta);
                            if (result[1]){
                              $('#perfiles_a_seleccionar').html(pinta);
                            }else if(result[0]){
                              $('#entry-experience_profile_id').val(result[0].id);
                              $('#perfiles_a_seleccionar').html('');
                            }else{
                              $('#entry-experience_profile_id').val('');
                              $('#perfiles_a_seleccionar').html('ERROR: '+JSON.stringify(result, null, 4));                              
                            }
                            
                          },
                          error: function(error){
                            console.log("Error:");
                            console.log(error);
                            alert('ERROR: '+JSON.stringify(error, null, 4));
                            $('#perfiles_a_seleccionar').html('');    
                          }
                      });
                    }
                    function seleccionapid(pid){
                      $('#entry-experience_profile_id').val(pid);
                      $('#perfiles_a_seleccionar').html('');
                    }

                    function borra_profile_id(){
                      pid = $('#entry-experience_profile_id').val();
                      clientId = $('#entry-clientid').val();
                      secret = $('#entry-secret').val();
                      paypalMode = $('#input-live-demo').val();
                      profile_id = $('#entry-experience_profile_id').val();
                      
                      //Verifica
                      $('#perfiles_a_seleccionar').html('Loading....'); 
                      $.ajax({
                          url: "./view/template/extension/payment/pp_plus_mex_functions.php",
                          type: "POST",
                          dataType: "json",
                          data: {
                            action: "deleteProfileIds",
                            clientId: clientId,
                            secret: secret,
                            paypalMode: paypalMode,
                            profile_id: profile_id
                          },
                          success: function(result){
                            $('#entry-experience_profile_id').val('');
                            $('#perfiles_a_seleccionar').html('');
                            alert('READY: '+JSON.stringify(result, null, 4));
                          },
                          error: function(error){
                            $('#entry-experience_profile_id').val('');
                            $('#perfiles_a_seleccionar').html('');    
                            console.log("Error:");
                            console.log(error);
                            alert('ERROR: '+JSON.stringify(error, null, 4));
                          }
                      });
                    }

                  </script>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-debug"><span data-toggle="tooltip" title="<?php echo $help_debug; ?>"><?php echo $entry_debug; ?></span></label>
                <div class="col-sm-10">
                  <select name="pp_plus_mex_debug" id="input-debug" class="form-control">
                    <?php if ($pp_plus_mex_debug) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_plus_mex_total" value="<?php echo $pp_plus_mex_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="pp_plus_mex_sort_order" value="<?php echo $pp_plus_mex_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="pp_plus_mex_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                      <?php if ($geo_zone['geo_zone_id'] == $pp_plus_mex_geo_zone_id) { ?>
                      <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="pp_plus_mex_status" id="input-status" class="form-control">
                    <?php if ($pp_plus_mex_status) { ?>
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
            <div class="tab-pane" id="tab-order-status">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_completed_status; ?></label>
                <div class="col-sm-10">
                  <select name="pp_plus_mex_completed_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $pp_plus_mex_completed_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-instrucciones">
              <div class="form-group">
                <span class="col-sm-2">Instrucciones en <a href="https://treebes.com/servicios/paypal-plus/" target="_blank">treebes.com</a></span>
                <div class="col-sm-10">
                  Sigue las instrucciones en <a href="https://treebes.com/servicios/paypal-plus/" target="_blank">esta liga</a>.
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