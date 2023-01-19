<div class="wrap">
	<h2>
        <?php echo __( 'Listing details', 'directia' ); ?>
	</h2>

	<form class="" method="post">
		<?php
            if( count( $listing->getListing() ) ) {

                $listing_details = $listing->getListing();
                $title = $listing_details[0]['title'];
                $content = $listing_details[0]['content'];
                $attachment_id = $listing_details[0]['attachment_id'];
                $created_at = $listing_details[0]['created_at'];
                $updated_at = $listing_details[0]['updated_at'];
                $total_word = str_word_count($content);
                $status = $listing_details[0]['status'];
                $status_label = $listing->getListingStatus($status);
                $image = wp_get_attachment_image_src($attachment_id, 'thumbnail');
                $img_src = '';
                if( is_array($image) ){
                    $img_src = $image[0];
                }
        ?>

        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content" style="position: relative;">
                    <div id="titlediv">
                        <div id="titlewrap">
                            <input type="text" name="post_title" size="30" value="<?php echo esc_html($title); ?>" id="title" spellcheck="true" autocomplete="off">
                        </div>
                    </div>
                    <!-- /titlediv -->
                    <div id="postdivrich" class="postarea wp-editor-expand">
                        
                        <textarea style="display:none" name="post_text" id="posttext" rows="3"><?php echo $content; ?></textarea>   
                        <?php 
                            $settings = array( 'textarea_name' => 'post_text', 'media_buttons' => false, 'drag_drop_upload' => false );
                            wp_editor( $content, 'posttext', $settings );
                        ?>
                        <table id="post-status-info" style="">
                        <tbody>
                            <tr>
                                <td id="wp-word-count" class="hide-if-no-js">
                                    <?php echo __('Word count:', 'directia'); ?><span class="word-count"> <?php echo $total_word; ?></span>	
                                </td>
                                <td class="autosave-info">
                                    <span class="autosave-message">&nbsp;</span>
                                    <span id="last-edit"><?php echo sprintf(__('Last edited by admin on %s', 'directia'), $updated_at); ?></span>	
                                </td>
                                <td id="content-resize-handle" class="hide-if-no-js"><br></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- /post-body-content -->
                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
                        <div id="submitdiv" class="postbox ">
                        <div class="postbox-header">
                            <h2 class="hndle ui-sortable-handle"><?php echo $status_label; ?></h2>
                        </div>
                        <div class="inside">
                            <div class="submitbox" id="submitpost">
                                <div id="minor-publishing">
                                    <div id="misc-publishing-actions">
                                    <div class="misc-pub-section misc-pub-post-status">
                                        <?php echo __('Status:', 'directia'); ?><span id="post-status-display"> <?php echo $status_label; ?></span>
                                    </div>
                                    <div class="misc-pub-section curtime misc-pub-curtime">
                                        <span id="timestamp">
                                        <?php echo __('Published on:', 'directia'); ?> <b><?php echo $created_at; ?></b></span>
                                    </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div id="major-publishing-actions">
                                    <div id="delete-action">
                                        <a class="submitdelete deletion" href="#"><?php echo __('Move to Trash', 'directia'); ?></a>
                                    </div>
                                    <!-- <div id="publishing-action">
                                        <span class="spinner"></span>
                                        <input name="original_publish" type="hidden" id="original_publish" value="Update">
                                        <input type="submit" name="save" id="publish" class="button button-primary button-large" value="Update">				
                                    </div> -->
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        <div id="postimagediv" class="postbox ">
                            <div class="postbox-header">
                                <h2 class="hndle ui-sortable-handle"><?php echo __('Featured image', 'directia'); ?></h2>
                            </div>
                            <div class="inside">
                                <p class="hide-if-no-js">
                                    <a href="#" id="set-post-thumbnail" aria-describedby="set-post-thumbnail-desc" class="thickbox">
                                        <img width="214" height="266" src="<?php echo esc_url($img_src); ?>" class="attachment-266x266 size-266x266" alt="" decoding="async" loading="lazy">
                                    </a>
                                </p>
                                <input type="hidden" id="_thumbnail_id" name="_thumbnail_id" value="<?php echo $attachment_id; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /post-body -->
            <br class="clear">
        </div>
        <?php } else { ?>
            <p><?php echo __('Request invalid! Please check listing id.', 'directia'); ?></p>  
        <?php } ?>
	</form>
</div>