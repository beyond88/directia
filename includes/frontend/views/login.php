<div class="directia-form">
  <div class="directia-form-container">
    <div class="directia-form-title"><?php echo __('Login', 'directia'); ?></div>
    <div class="directia-form-content">
      <form action="#" method="post">
        <div class="directia-form-user-details">
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"><?php echo __('Username or email address', 'directia'); ?></span>
            <input type="text" name="listing-username" id="listing-username" class="listing-username" placeholder="<?php echo __('Username or email address', 'directia'); ?>" maxlength="100">
          </div>
          <div class="directia-form-input-box-full">
            <span class="directia-form-details"><?php echo __('Password', 'directia'); ?></span>
            <input type="text" name="listing-password" id="listing-password" class="listing-password" placeholder="<?php echo __('Password', 'directia'); ?>" maxlength="50">
          </div>
        </div>
        <div class="directia-form-button">
          <span class="directia-field-required"></span>
          <input type="button" name="listing-login" id="listing-login" class="listing-login" value="Login">
        </div>
      </form>
    </div>
  </div>
</div>