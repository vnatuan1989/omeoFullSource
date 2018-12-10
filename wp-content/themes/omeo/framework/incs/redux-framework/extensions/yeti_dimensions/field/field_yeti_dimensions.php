<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('ReduxFramework_yeti_dimensions')) {
    class ReduxFramework_yeti_dimensions
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
                $extension_dir = get_template_directory() . '/framework/incs/redux-framework/extensions/custom_field/yeti_dimensions';
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

            /*
             * So, in_array() wasn't doing it's job for checking a passed array for a proper value.
             * It's wonky.  It only wants to check the keys against our array of acceptable values, and not the key's
             * value.  So we'll use this instead.  Fortunately, a single no array value can be passed and it won't
             * take a dump.
             */

            // No errors please
            $defaults = array(
                'width' => true,
                'height' => true,
                'drop' => true,
                'mode' => array(
                    'width' => false,
                    'height' => false,
                ),
            );

            $this->field = wp_parse_args($this->field, $defaults);

            $defaults = array(
                'width' => '',
                'height' => '',
                'drop' => '',
            );

            $this->value = wp_parse_args($this->value, $defaults);

            /*
             * Since units field could be an array, string value or bool (to hide the unit field)
             * we need to separate our functions to avoid those nasty PHP index notices!
             */

            echo '<fieldset id="' . $this->field['id'] . '" class="redux-dimensions-container" data-id="' . $this->field['id'] . '">';

            /**
             * Width
             * */
            if ($this->field['width'] === true) {
                if (!empty($this->value['width'])) {
                    $this->value['width'] = filter_var($this->value['width'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }
                echo '<div class="field-dimensions-input input-prepend">';
                echo '<span class="add-on"><i class="el el-resize-horizontal icon-large"></i></span>';
                echo '<input type="text" class="redux-dimensions-input redux-dimensions-width mini ' . $this->field['class'] . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '[width]' . '" placeholder="' . esc_attr__('Width', 'omeo') . '" rel="' . $this->field['id'] . '-width" value="' . $this->value['width'] . '">';
                echo '</div>';
            }

            /**
             * Height
             * */
            if ($this->field['height'] === true) {
                if (!empty($this->value['height'])) {
                    $this->value['height'] = filter_var($this->value['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }
                echo '<div class="field-dimensions-input input-prepend">';
                echo '<span class="add-on"><i class="el el-resize-vertical icon-large"></i></span>';
                echo '<input type="text" class="redux-dimensions-input redux-dimensions-height mini ' . $this->field['class'] . '" placeholder="' . esc_attr__('Height', 'omeo') . '" name="' . $this->field['name'] . $this->field['name_suffix'] . '[height]' . '" rel="' . $this->field['id'] . '-height" value="' . $this->value['height'] . '">';
                echo '</div>';
            }

            if ($this->field['drop'] === true) {
                if (!empty($this->value['drop'])) {
                    $this->value['drop'] = filter_var($this->value['drop'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }
                echo '<div class="field-dimensions-input">';
                echo '<input type="checkbox" class="redux-dimensions-checkbox edux-dimensions-drop ' . $this->field['class'] . '" id="' . $this->field['id'] . '-drop" value="1" name="' . $this->field['name'] . $this->field['name_suffix'] . '[drop]' . '" ' . checked(1, absint($this->value['drop']), false) . '>';
                echo '<label for="' . $this->field['id'] . '-drop">' . esc_html('Hard drop?', 'omeo') . '</label>';
                echo '</div>';
            }

            echo "</fieldset>";
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
                'redux-field-dimensions-js',
                ReduxFramework::$_url . 'inc/fields/dimensions/field_dimensions' . Redux_Functions::isMin() . '.js',
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


