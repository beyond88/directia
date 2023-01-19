<div class="directia-cards">
    <?php 
        if( ! empty($listing) ) :
            foreach( $listing as $item ): 
    ?>
    <div class="directia-card">
        <div class="directia-card-thumb">
            <a href="https://radiustheme.com/demo/wordpress/classifiedpro/listing/apartment-for-buy/">
                <img width="270" height="200" src="https://radiustheme.com/demo/wordpress/classifiedpro/wp-content/uploads/classified-listing/2020/10/product_10-270x200.jpg" class="rtcl-thumbnail" alt="" decoding="async" loading="lazy">
            </a>
        </div>
        <div class="item-content" >
            <div class="rtcl-listing-badge-wrap" >
                <span class="badge rtcl-badge-popular popular-badge badge-success">Admin</span>
            </div>
            <h3 class="item-title">
                <a href="https://radiustheme.com/demo/wordpress/classifiedpro/listing/apartment-for-buy/">Apartment for Buy</a>
            </h3>
            <ul class="entry-meta">
                <li class="">
                    <i class="fas fa-clock"></i> 3 years ago
                </li>
            </ul>
            <div class="item-price" >
                <div class="rtcl-price price-type-on_call" >
                    <span class="rtcl-price-meta">
                        <span class="rtcl-price-type-label rtcl-on_call">On Call</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>    