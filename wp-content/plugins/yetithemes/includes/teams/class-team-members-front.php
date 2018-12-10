<?php
/**
 * @package yeti-portfolios
 */

if (!class_exists('Yetithemes_TeamMembers_Front')) {

    class Yetithemes_TeamMembers_Front extends Yetithemes_TeamMembers
    {

        function __construct()
        {
            parent::__construct();

        }

        public function getByIds($ids = array())
        {
            if (count($ids) == 0) return '';

            $team = new WP_Query(array('post_type' => $this->post_type, 'post__in' => $ids, 'posts_per_page' => -1));

            return $team;
        }

    }

}
