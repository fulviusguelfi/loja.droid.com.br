<div class="hometab">
    <div id="tabs" class="htabs">
        <ul class='etabs'>
            <li class='tab'>
                <?php if($bestsellersproducts){ ?>
                <a href="#tab-bestseller"><?php echo $tab_bestseller; ?></a>
                <?php } ?>
            </li>
            <li class='tab'>
                <?php if($latestproducts){ ?>
                <a href="#tab-latest"><?php echo $tab_latest; ?></a>
                <?php } ?>
            </li>
            <li class='tab'>
                <?php if($specialproducts){ ?>
                <a href="#tab-special"><?php echo $tab_special; ?></a>
                <?php } ?>
            </li>
        </ul>
    </div>
    <?php if($bestsellersproducts){ ?>
    <div id="tab-bestseller" class="tab-content">
        <div class="box">
            <div class="box-content">
                <?php 
                $sliderFor = 5;
                $productCount = sizeof($bestsellersproducts); 
                ?>
                <?php if ($productCount >= $sliderFor): ?>
                <div class="customNavigation">
                    <a class="btn prev">&nbsp;</a>
                    <a class="btn next">&nbsp;</a>
                </div>	
                <?php endif; ?>	

                <div class="box-product <?php if ($productCount >= $sliderFor){?>product-carousel<?php }else{?>productbox-grid<?php }?>" id="<?php if ($productCount >= $sliderFor){?>tabbestseller-carousel<?php }else{?>tabbestseller-grid<?php }?>">

                    <?php $temp=0; ?>

                    <?php foreach ($bestsellersproducts as $product) { ?>

                    <?php if ($productCount >= $sliderFor){?>
								<?php if($productCount > 8 && $temp % 2 == 0) { ?>
								<div class="slider-item">
									<div>
								<?php } else if($productCount <= 8) { ?>
                    <div class="slider-item">
                        <?php } ?>
                        <?php } else {?>
							<div class="product-items">
							<?php } ?>

                        <div class="product-block product-thumb transition">
                            <div class="product-block-inner">
                                <div class="product-image-block-inner">
                                    <div class="image">
                                        <a href="<?php echo $product['href']; ?>">
                                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />					</a>
                                        <?php if (!$product['special']) { ?>       
                                        <?php } else { ?>
                                        <span class="saleicon sale">Promoção</span>         
                                        <?php } ?>	
                                        <div class="product_hover_block">
                                            <div class="button-group">
                                                <button class="cart_button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                                                <button class="wishlist_button" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"></button>
                                                <button class="compare_button" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                                    <?php if ($product['price']) { ?>
                                    <p class="price">
                                        <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                        <span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span> 
                                        <?php } ?>
                                        <?php if ($product['tax']) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                        <?php } ?>
                                    </p>
                                    <?php } ?>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <?php if ($product['rating'] < $i) { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
                                        <?php } ?>
                                        <?php } ?>
                                        <a class="review-count" href="<?php echo $product['href']; ?>"><?php echo $product['reviews']; ?></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php if ($productCount >= $sliderFor){?>
								<?php if($productCount > 8 && $temp % 2 != 0) { ?>
								</div>
								</div>
								<?php } else if($productCount <= 8) { ?>
                    </div>
                    <?php } $temp++; ?>
                    <?php } else {?>
								</div>
							<?php } ?>

                    <?php } ?>

                    <?php if($productCount > 8 && $temp % 2 != 0) {?>
							</div>
							</div>
						<?php }?>
                </div>
            </div>
        </div>
        <span class="tabbestseller_default_width" style="display:none; visibility:hidden"></span> 
    </div>
    <?php } ?>
    <?php if($latestproducts){ ?>
    <div id="tab-latest" class="tab-content">
        <div class="box">
            <div class="box-content">
                <?php 
                $sliderFor = 9;
                $productCount = sizeof($latestproducts); 
                ?>
                <?php if ($productCount >= $sliderFor): ?>
                <div class="customNavigation">
                    <a class="btn prev">&nbsp;</a>
                    <a class="btn next">&nbsp;</a>
                </div>	
                <?php endif; ?>	
                <div class="box-product <?php if ($productCount >= $sliderFor){?>product-carousel<?php }else{?>productbox-grid<?php }?>" id="<?php if ($productCount >= $sliderFor){?>tablatest-carousel<?php }else{?>tablatest-grid<?php }?>">

                    <?php $temp2=0; ?>

                    <?php foreach ($latestproducts as $product) { ?>

                    <?php if ($productCount >= $sliderFor){?>
								<?php if($productCount > 8 && $temp2 % 2 == 0) { ?>
								<div class="slider-item">
									<div>
								<?php } else if($productCount <= 8) { ?>
                    <div class="slider-item">
                        <?php } ?>
                        <?php } else {?>
							<div class="product-items">
							<?php } ?>

                        <div class="product-block product-thumb transition">
                            <div class="product-block-inner">
                                <div class="product-image-block-inner">
                                    <div class="image">
                                        <a href="<?php echo $product['href']; ?>">
                                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />					</a>
                                        <?php if (!$product['special']) { ?>       
                                        <?php } else { ?>
                                        <span class="saleicon sale">Promoção</span>         
                                        <?php } ?>	
                                        <div class="product_hover_block">
                                            <p class="text-left product_hover_block_description">
                                                <?php echo $product['description'];?>
                                            </p>
                                            <div class="button-group">
                                                <button class="cart_button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                                                <button class="wishlist_button" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"></button>
                                                <button class="compare_button" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                                    <?php if ($product['price']) { ?>
                                    <p class="price">
                                        <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                        <span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span> 
                                        <?php } ?>
                                        <?php if ($product['tax']) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                        <?php } ?>
                                    </p>
                                    <?php } ?>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <?php if ($product['rating'] < $i) { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
                                        <?php } ?>
                                        <?php } ?>
                                        <a class="review-count" href="<?php echo $product['href']; ?>"><?php echo $product['reviews']; ?></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php if ($productCount >= $sliderFor){?>
								<?php if($productCount > 8 && $temp2 % 2 != 0) { ?>
								</div>
								</div>
								<?php } else if($productCount <= 8) { ?>
                    </div>
                    <?php } $temp2++; ?>
                    <?php } else {?>
								</div>
							<?php } ?>

                    <?php } ?>

                    <?php if($productCount > 8 && $temp2 % 2 != 0) {?>
							</div>
							</div>
						<?php }?>
                </div>
            </div>
        </div>
        <span class="tablatest_default_width" style="display:none; visibility:hidden"></span>
    </div>
    <?php } ?>
    <?php if($specialproducts){ ?>
    <div id="tab-special" class="tab-content">
        <div class="box">
            <div class="box-content">
                <?php 
                $sliderFor = 5;
                $productCount = sizeof($specialproducts); 
                ?>
                <?php if ($productCount >= $sliderFor): ?>
                <div class="customNavigation">
                    <a class="btn prev">&nbsp;</a>
                    <a class="btn next">&nbsp;</a>
                </div>	
                <?php endif; ?>	
                <div class="box-product <?php if ($productCount >= $sliderFor){?>product-carousel<?php }else{?>productbox-grid<?php }?>" id="<?php if ($productCount >= $sliderFor){?>tabspecial-carousel<?php }else{?>tabspecial-grid<?php }?>">

                    <?php $temp3=0; ?> 

                    <?php foreach ($specialproducts as $product) { ?>

                    <?php if ($productCount >= $sliderFor){?>
								<?php if($productCount > 8 && $temp3 % 2 == 0) { ?>
								<div class="slider-item">
									<div>
								<?php } else if($productCount <= 8) { ?>
                    <div class="slider-item">
                        <?php } ?>
                        <?php } else {?>
							<div class="product-items">
							<?php } ?>

                        <div class="product-block product-thumb transition">
                            <div class="product-block-inner">
                                <div class="product-image-block-inner">
                                    <div class="image">
                                        <a href="<?php echo $product['href']; ?>">
                                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />					</a>
                                        <?php if (!$product['special']) { ?>       
                                        <?php } else { ?>
                                        <span class="saleicon sale">Promoção</span>         
                                        <?php } ?>	
                                        <div class="product_hover_block">
                                            <div class="button-group">
                                                <button class="cart_button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                                                <button class="wishlist_button" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"></button>
                                                <button class="compare_button" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                                    <?php if ($product['price']) { ?>
                                    <p class="price">
                                        <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                        <span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span> 
                                        <?php } ?>
                                        <?php if ($product['tax']) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                        <?php } ?>
                                    </p>
                                    <?php } ?>
                                    <div class="rating">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <?php if ($product['rating'] < $i) { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
                                        <?php } else { ?>
                                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
                                        <?php } ?>
                                        <?php } ?>
                                        <a class="review-count" href="<?php echo $product['href']; ?>"><?php echo $product['reviews']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($productCount >= $sliderFor){?>
								<?php if($productCount > 8 && $temp3 % 2 != 0) { ?>
								</div>
								</div>
								<?php } else if($productCount <= 8) { ?>
                    </div>
                    <?php } $temp3++; ?>
                    <?php } else {?>
								</div>
							<?php } ?>

                    <?php } ?>

                    <?php if($productCount > 8 && $temp3 % 2 != 0) {?>
							</div>
							</div>
						<?php }?>
                </div>
            </div>
        </div>
        <span class="tabspecial_default_width" style="display:none; visibility:hidden"></span> 
    </div>
    <?php } ?>
</div>
<script type="text/javascript">
    $('#tabs a').tabs();
</script> 