<?php

if (!class_exists('Yetithemes_YoutubeApi')) {
    class Yetithemes_YoutubeApi
    {
        private $_API = 'AIzaSyDa_oVbZr623ushe-OjzrYw8x4IMuU4yVs';

        private $_playlistID = 'PLHgheaJtNQ_SBVhhMJtXrojnoccSQA8We';

        public static $instance = null;

        public function __construct()
        {
            $this->_urls = array(
                'playlist' => "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=%d&playlistId={$this->_playlistID}&key={$this->_API}",
            );
        }

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        private function request($url, $args = array()) {
            $default = array(
                'timeout' => 20,
            );

            $args = wp_parse_args($args, $default);
            $response = wp_remote_get(esc_url_raw($url), $args);

            // Check the response code.
            $response_code = wp_remote_retrieve_response_code($response);
            $response_message = wp_remote_retrieve_response_message($response);

            if (200 !== $response_code && !empty($response_message)) {
                return false;
            } elseif (200 !== $response_code) {
                return false;
            } else {
                $return = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($return['error'])) return false;
                return $return;
            }
        }

        public function get_playList($limit = 9) {
            $url = sprintf($this->_urls['playlist'], $limit);
            $return = $this->request($url);
            return !empty($return) ? $return : array();
        }

    }

    function Yetithemes_YoutubeApi() {
        return Yetithemes_YoutubeApi::get_instance();
    }
}