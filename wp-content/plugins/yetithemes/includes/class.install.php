<?php

if (!defined('ABSPATH')) exit;

class Yetithemes_Installations
{

    public static function install()
    {
        flush_rewrite_rules();

    }

}