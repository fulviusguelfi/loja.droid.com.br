<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>

<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600italic,600,400italic,700,700italic,900' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Raleway:400,500' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
<link href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/stylesheet.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/carousel.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/custom.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/bootstrap.min.css" />

<?php if($direction=='rtl'){ ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/stylesheet/megnor/rtl.css">
<?php }?>

<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>



<!-- Megnor www.templatemela.com - Start -->
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery.custom.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/custom.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jstree.min.js"></script>
<script src="catalog/view/javascript/megnor/tabs.js" type="text/javascript"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/carousel.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/megnor.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/scrolltop.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/megnor/jquery.formalize.min.js"></script> 
<!-- Megnor www.templatemela.com - End -->

<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>


<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
	<?php echo $analytic; ?>
	<?php } ?>
</head>

<?php if ($column_left && $column_right) { ?>
<?php $layoutclass = 'layout-3'; ?>
<?php } elseif ($column_left || $column_right) { ?>
<?php if ($column_left){ ?>
<?php $layoutclass = 'layout-2 left-col'; ?>
<?php } elseif ($column_right) { ?>
<?php $layoutclass = 'layout-2 right-col'; ?>
<?php } ?>
<?php } else { ?>
<?php $layoutclass = 'layout-1'; ?>
<?php } ?>

<body class="<?php echo $class;echo " " ;echo $layoutclass; ?>">
<nav id="top">
  <div class="container">
    <?php echo $language; ?>
	 <?php echo $currency; ?>
    <div id="top-links" class="nav pull-right">
      <ul class="list-inline">
        <li><a href="<?php echo $contact; ?>"><i class="fa fa-phone"></i></a><?php echo $text_call; ?> <span class="hidden-xs hidden-sm hidden-md"><?php echo $telephone; ?></span></li>
		<li><i class="fa fa-envelope"></i><?php echo $text_mail; ?> <span class="hidden-xs hidden-sm hidden-md"><a href="<?php echo $contact; ?>"><?php echo $email; ?></a></span></li>       
      </ul>
    </div>
  </div>
</nav>
<header>
  <div class="container">
    <div class="row">
      <div class="col-sm-4 header_logo">
        <div id="logo">
          <?php if ($logo) { ?>
          <a href="/"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
          <?php } else { ?>
          <h1><a href="/"><?php echo $name; ?></a></h1>
          <?php } ?>
        </div>
      </div>
	  <?php echo $headertop; ?>
      </div>
    </div>
</header>
<nav class="nav-container" role="navigation">
<div class="nav-inner">
<div class="nav-inner-container">
<!-- ======= Menu Code START ========= -->
<?php if ($categories) { ?>
<!-- Opencart 3 level Category Menu-->
<div class="container">
<div id="menu" class="main-menu">

<div class="nav-responsive"><span>Menu</span><div class="expandable"></div></div>

  <ul class="main-navigation">
  	<li> <a href="/"><?php echo $text_home; ?></a></li>
    <?php foreach ($categories as $category_1) { ?>
		<li class="level0">
			<a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
  			 <?php if ($category_1['children']) { ?>
			   <?php $i = count($category_1['children']); ?>
					<span class="active_menu"></span>
					<div class="categorybg">
				<!--	<span class="active_menu"></span>-->
						 <div class="categoryinner">
						 
								<?php $i=1; ?>
								<?php foreach ($category_1['children'] as $category_2) { ?>
								<ul>
								<li class="categorycolumn"><b><a class="submenu1" href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a></b>
								
								  <?php if($category_2['children']) { ?>
									<?php $j = count($category_2['children']); ?>
									<?php if($j<=10) { ?>
									
									<div class="cate_inner_bg">
									  <ul>
										 <?php foreach ($category_2['children'] as $category_3) { ?>
										 <li style="padding-right:6px;"><a class="submenu2" href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
										 <?php } ?>
									  </ul>
									</div>
								
									<?php } else { ?>
									
									<div>
									  <ul>
									  <?php $j=0; ?>
										 <?php foreach ($category_2['children'] as $category_3) { ?>
										 <li style="padding-right:6px;"><a class="submenu2" href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
										 <?php if (++$j == 10) ?>
										 <?php } ?>
										 <li style="padding-right:6px;"><a class="submenu2" href="<?php echo $category_2['href']; ?>">More....</a></li>
									  </ul>
									</div>
									<?php } ?>
									
								</li>
								<?php } ?>
								</ul>
								<?php } ?>
					
		
							
						</div>
					</div>
				
				<?php } ?>
	  		<?php } ?>
	  	</li> 
  </ul>
  
</div>
<?php } ?>
<!--  =============================================== Mobile menu start  =============================================  -->
<div id="res-menu" class="main-menu nav-container1">
<div id="res-menu1" class="main-menu1 nav-container2">
	<div class="nav-responsive"><span>Menu</span><div class="expandable"></div></div>
    <ul class="main-navigation">
      <?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>

        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>										
				<li>
				<?php if(count($category['children'][$i]['children'])>0){ ?>
					<a href="<?php echo $category['children'][$i]['href']; ?>" class="activSub" <?php /*?>onmouseover='JavaScript:openSubMenu("<?php echo $category['children'][$i]['id']; ?>")'<?php */?>><?php echo $category['children'][$i]['name'];?></a> 					
				<?php } else { ?>				
					<a href="<?php echo $category['children'][$i]['href']; ?>" <?php /*?>onmouseover='JavaScript:closeSubMenu()'<?php */?> ><?php echo $category['children'][$i]['name']; ?></a>
				<?php } ?>

				<?php if ($category['children'][$i]['children']) { ?>
				<?php /*?><div class="submenu" id="id_menu_<?php echo $category['children'][$i]['id']; ?>"><?php */?>
				<ul>
				<?php for ($wi = 0; $wi < count($category['children'][$i]['children']); $wi++) { ?>
					<li><a href="<?php echo $category['children'][$i]['children'][$wi]['href']; ?>"  ><?php echo $category['children'][$i]['children'][$wi]['name']; ?></a></li>
				 <?php } ?>
				</ul>
				<?php /*?></div><?php */?>
			  <?php } ?>		  
			</li>		
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>

      <?php } ?>
    </li>
    <?php } ?>
    </ul>
	</div>

</div>
<!--  ================================ Mobile menu end   ======================================   --> 
<!-- ======= Menu Code END ========= -->
<div class="col-sm-3 cart"><?php echo $cart; ?></div>
</div>
</div>
</div>
</nav> 

<div class="container" id="header-bottom">
<div class="header-bottom-inner">
<div class="header-bottom-left">
<ul class="list-inline">
<li class="dropdown myaccount"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_account; ?></span> <span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-menu-right myaccount-menu">
            <?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
            <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <li class="header_wishlist"><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_wishlist; ?></span></a></li>
        <li class="header_checkout"><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_checkout; ?></span></a></li>
</ul>
</div>
<div class="header-bottom-right">
<div class="search-title">Buscar</div>
<div class="col-sm-5 search"><?php echo $search; ?>
</div>
</div>
</div>
</div>  
