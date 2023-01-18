<div class="directia-form">
  <div class="directia-form-container">
    <div class="directia-form-title"><?php echo __('Add listings', 'directia'); ?></div>
    <div class="directia-form-content">
      <form action="#" method="post" enctype="multipart/form-data">
        <div class="directia-form-user-details">
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"><?php echo __('Title', 'directia'); ?></span>
            <input type="text" name="listing-title" id="listing-title" class="listing-title" placeholder="<?php echo __('Title', 'directia'); ?>">
          </div>
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"><?php echo __('Content', 'directia'); ?></span>
            <textarea id="listing-content" class="listing-content" name="listing-content" cols="5" rows="5"></textarea>
          </div>
          <div class="directia-form-input-box">
            <span class="directia-form-details"><?php echo __('Image', 'directia'); ?></span>
            <input type="file" name="listing-image" id="listing-image" class="listing-image"/>
          </div>
        </div>
        <div class="directia-form-button">
          <input type="button" name="listing-submit" id="listing-submit" class="listing-submit" value="<?php echo __('Submit', 'directia');?>">
        </div>
      </form>
    </div>
  </div>
</div>