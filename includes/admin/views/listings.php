<div class="wrap">
	<h2>
        <?php echo __( 'Listings', 'directia' ); ?>
	</h2>

	<form class="" method="post">
		<?php
			if(! isset($listing)) { return; }
			$listing->process_bulk_action();
			$listing->prepare_items();
			$listing->search_box( __('Search listings', 'directia'), $listing->searchColumn );
			$listing->views();
			$listing->display();
		?>
	</form>
</div>