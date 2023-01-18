<div class="directia-form">
  <div class="directia-form-container">
    <div class="directia-form-title"><?php echo __('Add listings', 'directia'); ?></div>
    <div class="directia-form-content">
      <form action="#" method="post" enctype="multipart/form-data" id="add-listing-form">
        <div class="directia-form-user-details">
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"><?php echo __('Title', 'directia'); ?></span>
            <input type="text" name="listing-title" id="listing-title" class="listing-title" placeholder="<?php echo __('Title', 'directia'); ?>">
          </div>
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"><?php echo __('Content', 'directia'); ?></span>
            <!-- <textarea id="listing-content" class="listing-content" name="listing-content" cols="5" rows="5"></textarea> -->
            <?php 
              $settings = array( 'textarea_name' => 'listing-content' );
              wp_editor( $content, 'listing-content', $settings );
            ?>
          </div>
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"></span>
            <img id="listing-image-preview" class="listing-image-preview" />
          </div>
          <div class="directia-form-input-box">
            <span class="directia-form-details"><?php echo __('Image', 'directia'); ?></span>
            <input type="file" name="listing-image" id="listing-image" class="listing-image" accept="image/png, image/gif, image/jpeg"/>
          </div>
        </div>
        <div class="directia-form-button">
          <span class="directia-field-required"></span>
          <input type="button" name="listing-submit" id="listing-submit" class="listing-submit" value="<?php echo __('Submit', 'directia');?>">
        </div>
      </form>
    </div>
  </div>
</div>