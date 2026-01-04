<?php

define('WYSIWYG_META_BOX_ID', 'dbt_press_links');
define('WYSIWYG_EDITOR_ID', 'myeditor'); //Important for CSS that this is different
define('WYSIWYG_META_KEY', 'dbt_press_links');

add_action('admin_init', 'wysiwyg_register_meta_box');
function wysiwyg_register_meta_box(){
        add_meta_box(WYSIWYG_META_BOX_ID, __('Press release links', 'wysiwyg'), 'wysiwyg_render_meta_box', 'post');
}

function wysiwyg_render_meta_box(){

        global $post;

        $meta_box_id = WYSIWYG_META_BOX_ID;
        $editor_id = WYSIWYG_EDITOR_ID;

        echo "<p>Add press release links here using the 'insert link' tool on the toolbar (new line for each link)</p>";
        //Add CSS & jQuery goodness to make this work like the original WYSIWYG
        echo "
                <style type='text/css'>
                        #$meta_box_id #edButtonHTML, #$meta_box_id #edButtonPreview {background-color: #F1F1F1; border-color: #DFDFDF #DFDFDF #CCC; color: #999;}
                        #$editor_id{width:100%;}
                        #$meta_box_id #editorcontainer{background:#fff !important;}
                        #$meta_box_id #$editor_id_fullscreen{display:none;}
                </style>

                <script type='text/javascript'>
                        jQuery(function($){
                                $('#$meta_box_id #editor-toolbar > a').click(function(){
                                        $('#$meta_box_id #editor-toolbar > a').removeClass('active');
                                        $(this).addClass('active');
                                });

                                if($('#$meta_box_id #edButtonPreview').hasClass('active')){
                                        $('#$meta_box_id #ed_toolbar').hide();
                                }

                                $('#$meta_box_id #edButtonPreview').click(function(){
                                        $('#$meta_box_id #ed_toolbar').hide();
                                });

                                $('#$meta_box_id #edButtonHTML').click(function(){
                                        $('#$meta_box_id #ed_toolbar').show();
                                });

				//Tell the uploader to insert content into the correct WYSIWYG editor
				$('#media-buttons a').bind('click', function(){
					var customEditor = $(this).parents('#$meta_box_id');
					if(customEditor.length > 0){
						edCanvas = document.getElementById('$editor_id');
					}
					else{
						edCanvas = document.getElementById('content');
					}
				});
                        });
                </script>
        ";

        //Create The Editor
        $content = get_post_meta($post->ID, WYSIWYG_META_KEY, true);
        wp_editor($content, $editor_id);

        //Clear The Room!
        echo "<div style='clear:both; display:block;'></div>";
}

add_action('save_post', 'wysiwyg_save_meta');
function wysiwyg_save_meta(){

        $editor_id = WYSIWYG_EDITOR_ID;
        $meta_key = WYSIWYG_META_KEY;

        if(isset($_REQUEST[$editor_id]))
                update_post_meta($_REQUEST['post_ID'], WYSIWYG_META_KEY, $_REQUEST[$editor_id]);

}

add_filter( 'dbt_press_contact', 'make_clickable', 9 );

function customadmin_feeguide() {
	if ( is_admin() ) {
		$script = "
			<script type='text/javascript'>
				jQuery(document).ready(function($) {
					$('.item_dbt_press_contact,#dbt_press_links').hide();
					$('#in-category-6, #in-category-1189').is(':checked') ? $('.item_dbt_press_contact,#dbt_press_links').show() : $('.item_dbt_press_contact,#dbt_press_links').hide();
					$('#in-category-6, #in-category-1189').click(function() {
						$('.item_dbt_press_contact,#dbt_press_links').toggle(this.checked);
					});
				});
		</script>";
		echo $script;
    }
}
add_action('admin_footer', 'customadmin_feeguide');

$prefix = 'dbt_';

$meta_box = array(
    'id' => 'my-meta-box',
    'title' => 'Extras',
    'pages' => $post_types, // multiple post types, accept custom post types
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Press release contact details',
            'id' => $prefix . 'press_contact',
            'type' => 'textarea'
        ),
        array(
            'name' => 'Tick if gated',
            'id' => $prefix . 'checkbox_gated',
            'type' => 'checkbox'
        )
        //array(
            //'name' => 'Enter Google conversion label e.g: tSwUCKDsugMQ4L7f4gM',
            //'id' => $prefix . 'ga_tracking_label',
            //'type' => 'text'
        //)
    )
);

add_action('admin_menu', 'mytheme_add_box');

// Add meta box
function mytheme_add_box() {
	global $meta_box;

	foreach ($meta_box['pages'] as $page) {
		add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $page, $meta_box['context'], $meta_box['priority']);
	}
}

// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr class="item_' . $field['id'] . '">',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {

            case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
							break;
            case 'text' :
				echo '<input type="text" name="'. $field['id']. '" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) . '" size="30" style="width:40%" />'. $field['desc'];
              break;
             case 'textarea':
        echo '<textarea cols="48" rows="7" name="'. $field['id']. '" id="'. $field['id'] .'">'. ($meta ? $meta : $field['default']) . '</textarea>';
             break;
        }
        echo    '<td>',
            '</tr>';
    }

    echo '</table>';
}

add_action('save_post', 'mytheme_save_data');

// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $postID;
    }
    else
    {
        // called after a post or page is saved and not on autosave
        if($parent_id = wp_is_post_revision($postID))
        {
        $postID = $parent_id;
        }
        if ($_POST['postVideo'])
        {
            update_custom_meta($postID, $_POST['postVideo'], 'postVideo');
        }
        else
        {
            update_custom_meta($postID, '', 'postVideo');
        }
    }

  }
    function update_custom_meta($postID, $newvalue, $field_name) {
    // To create new meta
    if(!get_post_meta($postID, $field_name)){
    add_post_meta($postID, $field_name, $newvalue);
    }else{
    // or to update existing meta
    update_post_meta($postID, $field_name, $newvalue);
    }
}

?>
