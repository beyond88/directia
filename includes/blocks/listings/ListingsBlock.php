<?php

namespace Root\Directia\Block;

/**
 * Listing block handler class
 */
class ListingsBlock {

    public function __construct() {
		add_action( 'init', [$this, 'directiaListingBlockInit'] );
	}

	function directiaListingBlockInit() {
		register_block_type( __DIR__,
		array(
			'render_callback' => [$this, 'renderBlock']
		) );
	}

	function renderBlock( $attributes ) {	
		ob_start();
		?>
	  
	  <div class="directia-cards">
		<?php if( ! empty($attributes) && $attributes['data']['success'] == 1 ): ?>
	
		<?php 
			$items = $attributes['data']['data'];
			foreach( $items as $item ):
				$page_url = site_url('/').'directia-listing-details?id='.$item['id'];	
				$img_url = $item['attachment_id'];
				$title = $item['title'];	
				$created_at = $item['created_at'];
				$author = $item['author'];	 
		?>
		<div class="directia-card">
			<div class="directia-card-thumb">
				<a href="<?php echo esc_url($page_url); ?> ">
					<img width="270" height="200" src="<?php echo esc_url($img_url); ?>" class="rtcl-thumbnail" alt="" decoding="async" loading="lazy">
				</a>
			</div>
			<div class="item-content" >
				<div class="rtcl-listing-badge-wrap" >
					<span class="badge rtcl-badge-popular popular-badge badge-success"><?php echo $author; ?></span>
				</div>
				<h3 class="item-title">
					<a href="<?php echo esc_url($page_url); ?>"><?php echo $title; ?></a>
				</h3>
				<ul class="entry-meta">
					<li class="">
						<i class="fas fa-clock"></i> <?php echo $created_at; ?>
					</li>
				</ul>
				<div class="item-price" >
					<div class="rtcl-price price-type-on_call" >
						<span class="rtcl-price-meta">
							<span class="rtcl-price-type-label rtcl-on_call"><?php echo __('On call', 'directia'); ?></span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>    
	  
		<?php return ob_get_clean();
	}


}