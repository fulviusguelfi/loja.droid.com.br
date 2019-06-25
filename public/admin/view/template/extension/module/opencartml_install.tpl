<!--
/**
 * Controlle principal OpencartML 
 * Versão 1.1
 * Situação: Production
 * Autor por Thiago Guelfi  thiagovalentoni@gmail.com
 */
-->

<?php echo $header; ?> <?php echo $column_left; ?>
<div id="content"><!-- Page Content -->


    <div class="page-header"><!-- Page Header -->      
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-moip" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="#" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>	
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach($breadcrumbs as $breadcrumb): ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div><!-- Page Header -->

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
                <form method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                    <div class="form-group required">
                        <label class="col-sm-2 control-label">
                            <span data-toggle="tooltip" data-html="true" title="APP Client ID">
                                APP Client ID
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" required="" placeholder="APP Client ID" name="module_opencartml_client_id" value="<?php echo $module_opencartml_client_id; ?>"/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label">
                            <span data-toggle="tooltip" data-html="true" title="APP Key Secret">
                                APP Key Secret
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" required="" placeholder="APP Key Secret" name="module_opencartml_client_secret" value="<?php echo $module_opencartml_client_secret; ?>"/>
                        </div>
                    </div>
                    <button type="submit" data-toggle="tooltip" title="Salvar" class="btn btn-primary"><i class="fa fa-save"></i> Salvar</button>
                </form>
            </div><!-- /.panel-body -->
        </div><!-- /.panel.panel-default -->
    </div><!-- /.container-fluid -->
</div><!-- /#content -->
<?php echo $footer; ?>
