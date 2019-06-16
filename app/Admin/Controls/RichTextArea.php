<?php

namespace Diviner\Admin\Controls;


class RichTextArea extends \WP_Customize_Control
{
    /**
     * Output the rich text area for customizer control
     */
    public function render_content()
    {
        $tinymce_settings = [
            'body_class'  => 'd-content',
            'setup'       => "function (editor) {
                  var cb = function () {
                    var linkInput = document.getElementById('$this->id-link')
                    linkInput.value = editor.getContent()
                    linkInput.dispatchEvent(new Event('change'))
                  }
                  editor.on('Change', cb)
                  editor.on('Undo', cb)
                  editor.on('Redo', cb)
                  editor.on('KeyUp', cb)
                }",
        ];

        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <input id="<?php echo $this->id ?>-link" class="wp-editor-area" type="hidden" <?php $this->link(); ?>
                   value="<?php echo esc_textarea($this->value()); ?>">
            <?php
            wp_editor($this->value(), $this->id, [
                'textarea_name'    => $this->id,
                'media_buttons'    => false,
                'drag_drop_upload' => false,
                'teeny'            => true,
                'quicktags'        => false,
                'textarea_rows'    => 5,
                'tinymce'          => $tinymce_settings,
            ]);
            ?>
        </label>
        <?php

        do_action('admin_print_footer_scripts');
    }
}
