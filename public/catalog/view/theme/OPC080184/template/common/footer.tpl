<footer>
  <div id="footer" class="container">
  
  <?php echo $footertop; ?>
     <div class="row d-none" style="display: none;">
	 <?php echo $footerleft; ?>
	
      <?php if ($informations) { ?>
      <div class="col-sm-3 column">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
		  <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <?php } ?>
      <?php /*?><div class="col-sm-3 column">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          
        </ul>
      </div><?php */?>
      <div class="col-sm-3 column">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <?php /*?><li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li><?php */?>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
		  <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
      <?php /*?><div class="col-sm-3 column">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          
        </ul>
      </div><?php */?>
	
	  <?php echo $footerright; ?>
	  
    </div>
    
	
  </div>
  <div class="footer_bottom_links">
	<div class="footer_bottom container">
	  <div id="links">
  		<ul>
		<li class="first"><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>   
		<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>    
		<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>    
		<li class="last"><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
		</ul>
	</div>	
	  <p><?php echo $powered; ?></p> 
	  </div>
	  </div>
	
	<?php /*?><?php echo $footerbottom; ?><?php */?>
	
	
</footer>

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//--> 

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->

</body></html>