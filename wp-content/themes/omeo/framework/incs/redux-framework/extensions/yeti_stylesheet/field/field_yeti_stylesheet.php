<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ReduxFramework_yeti_stylesheet')) {
    class ReduxFramework_yeti_stylesheet
    {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since ReduxFramework 1.0.0
         */
        function __construct($field = array(), $value = '', $parent)
        {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if (empty($this->extension_dir)) {
                $extension_dir = get_template_directory() . '/framework/incs/redux-framework/extensions/yeti_stylesheet';
                $this->extension_dir = trailingslashit(str_replace('\\', '/', $extension_dir));
                $this->extension_url = site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', $this->extension_dir));
            }

        } //function

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since ReduxFramework 1.0.0
         */


        function render()
        {
            ?>
            <fieldset id="<?php echo esc_attr($this->field['id'])?>" class="yeti_stylesheet-container" data-id="<?php echo esc_attr($this->field['id'])?>">

                <?php if ( ! empty( $this->field['options'] ) ) : ?>
                    <select id="yeti_stylesheet_reset_data" data-placeholder="Select a stylesheet" class="redux-select-item ">
                        <option></option>
                        <?php foreach ( $this->field['options'] as $k => $v ) : ?>
                        <option value="<?php echo esc_attr($k)?>"><?php echo esc_html($v)?></option>
                        <?php endforeach;?>
                    </select>
                <?php endif?>

                <button class="button" id="reset_stylesheet_button">Reset</button>

            </fieldset>

            <?php
        } //function

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since ReduxFramework 1.0.0
         */
        function enqueue()
        {
            wp_enqueue_script(
                'redux-field-yeti_stylesheet-js',
                $this->extension_url . 'field/field_yeti_stylesheet.js',
                array('jquery', 'select2-js', 'redux-js'),
                time(),
                true
            );

            if ($this->parent->args['dev_mode']) {
                wp_enqueue_style(
                    'redux-field-dimensions-css',
                    ReduxFramework::$_url . 'inc/fields/dimensions/field_dimensions.css',
                    array(),
                    time(),
                    'all'
                );
            }
        }

        public function output()
        {

            // if field units has a value and IS an array, then evaluate as needed.
            if (isset($this->field['units']) && !is_array($this->field['units'])) {

                //if units fields has a value but units value does not then make units value the field value
                if (isset($this->field['units']) && !isset($this->value['units']) || $this->field['units'] == false) {
                    $this->value['units'] = $this->field['units'];

                    // If units field does NOT have a value and units value does NOT have a value, set both to blank (default?)
                } else if (!isset($this->field['units']) && !isset($this->value['units'])) {
                    $this->field['units'] = 'px';
                    $this->value['units'] = 'px';

                    // If units field has NO value but units value does, then set unit field to value field
                } else if (!isset($this->field['units']) && isset($this->value['units'])) {
                    $this->field['units'] = $this->value['units'];

                    // if unit value is set and unit value doesn't equal unit field (coz who knows why)
                    // then set unit value to unit field
                } elseif (isset($this->value['units']) && $this->value['units'] !== $this->field['units']) {
                    $this->value['units'] = $this->field['units'];
                }

                // do stuff based on unit field NOT set as an array
            } elseif (isset($this->field['units']) && is_array($this->field['units'])) {
                // nothing to do here, but I'm leaving the construct just in case I have to debug this again.
            }

            $units = isset($this->value['units']) ? $this->value['units'] : "";

            $height = isset($this->field['mode']) && !empty($this->field['mode']) ? $this->field['mode'] : 'height';
            $width = isset($this->field['mode']) && !empty($this->field['mode']) ? $this->field['mode'] : 'width';

            $cleanValue = array(
                $height => isset($this->value['height']) ? filter_var($this->value['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '',
                $width => isset($this->value['width']) ? filter_var($this->value['width'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '',
            );

            $style = "";

            foreach ($cleanValue as $key => $value) {
                // Output if it's a numeric entry
                if (isset($value) && is_numeric($value)) {
                    $style .= $key . ':' . $value . $units . ';';
                }
            }

            if (!empty($style)) {
                if (!empty($this->field['output']) && is_array($this->field['output'])) {
                    $keys = implode(",", $this->field['output']);
                    $this->parent->outputCSS .= $keys . "{" . $style . '}';
                }

                if (!empty($this->field['compiler']) && is_array($this->field['compiler'])) {
                    $keys = implode(",", $this->field['compiler']);
                    $this->parent->compilerCSS .= $keys . "{" . $style . '}';
                }
            }
        } //function
    } //class
}


