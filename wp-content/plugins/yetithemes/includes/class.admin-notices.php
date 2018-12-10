<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Admin_Notices
{

    private $msg;

    protected static $instance = null;

    private $type, $class = array();

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new Yetithemes_Admin_Notices();
        }

        return self::$instance;
    }

    public function create($msg, $type = 'updated')
    {
        $this->msg = $msg;
        $this->type = $type;
        switch ($type) {
            case "updated":
                $this->class[] = $type;
                break;
            case "warning":
                $this->class[] = "updated";
                $this->class[] = $type;
                break;
            default:
                $this->class = $type;
        }
        add_action('admin_notices', array($this, 'notices_call'));
    }

    public function notices_call()
    {
        $this->class[] = 'yeti-notices';
        ?>
        <div class="<?php echo esc_attr(implode(' ', $this->class)); ?>">
            <p><?php echo $this->msg ?></p>
        </div>
        <?php
    }

}

if (!function_exists('Yetithemes_Admin_Notices')) {
    function Yetithemes_Admin_Notices()
    {
        return Yetithemes_Admin_Notices::get_instance();
    }
}