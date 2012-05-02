<?php echo css('css/admin/products.css') ?>

<div>
	<div><?php echo $page['back'] ?></div>
	<div class='success'><?php echo $page['success'] ?> products imported successfully.</div>
	<?php if( $page['fail'] > 0 ) { ?>
		<div class='error'>
			<p><?php echo $page['fail'] ?> products resulted in failure:</p>
			<p>
				<?php foreach( $page['fail_log'] as $log ){
					echo "&gt;" . $log . "<br/>";
				} ?>
			</p>
		</div>
	<?php } ?>
	<div><?php echo $page['back'] ?></div>
</div>