<?php


class Yetithemes_Instagram
{
    /**
     * The API OAuth URL.
     */
    private $get_user_url = 'https://api.instagram.com/v1/users/self/?access_token=';

    private $get_user_media_url = 'https://api.instagram.com/v1/users/%1$s/media/recent/?access_token=%2$s&count=%3$s';
    private $get_tags_media_url = 'https://api.instagram.com/v1/tags/%1$s/media/recent?access_token=%2$s&count=%3$s';
    private $get_search_user_url = 'https://api.instagram.com/v1/users/search?q=%1$s&access_token=%2$s';

    /**
     * The Instagram API Key.
     *
     * @var string
     */
    private $_token;

    /**
     * The Instagram OAuth API secret.
     *
     * @var string
     */
    private $_apisecret;

    /**
     * The callback URL.
     *
     * @var string
     */
    private $_callbackurl;

    /**
     * The user access token.
     *
     * @var string
     */
    private $_accesstoken;

    /**
     * Whether a signed header should be used.
     *
     * @var bool
     */
    private $_signedheader = false;

    /**
     * Available scopes.
     *
     * @var string[]
     */

    private $_cache_key_prefix = 'instagram-media_';


    public static $instance;

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init() {
        add_action('wp_ajax_instagram_validate_token', array($this, 'instagram_validate_token'));
        //add_action( 'wp_ajax_nopriv_instagram_validate_token', array( $this, 'instagram_validate_token' ) );

        add_action('wp_ajax_yeti_instagram_get_media', array($this, 'instagram_get_media'));
        add_action('wp_ajax_nopriv_yeti_instagram_get_media', array($this, 'instagram_get_media'));
    }

    private function _makecall($api_url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $jsonData = curl_exec($ch);
        list($headerContent, $jsonData) = explode("\r\n\r\n", $jsonData, 2);
        curl_close($ch);

        return $jsonData;
    }


    public function instagram_validate_token($token = '', $echo = true)
    {
        if (empty($token)) $token = $_REQUEST['token'];

        $content = $this->_makecall($this->get_user_url . $token);

        if ($echo) {
            echo $content;
            wp_die();
        } else {
            return $content;
        }
    }

    public function getInstagramMedia($user_id, $access_token, $limit, $is_hash = false)
    {
        if (empty($user_id) || empty($access_token)) return array();

        $request_url = ($is_hash)? $this->get_tags_media_url : $this->get_user_media_url;

        if(!$is_hash && !is_numeric($user_id)) {
            $_url = sprintf($this->get_search_user_url, esc_attr($user_id), esc_attr($access_token));
            try {
                $content = $this->_makecall($_url);
                $user = json_decode($content, true);
                if(!empty($user) && count($user['data']) > 0) {
                    $user_id = $user['data'][0]['id'];
                } else return array();
            } catch (Exception $e) {
                return array();
            }
        }

        try {
            $_url = sprintf($request_url, esc_attr($user_id), esc_attr($access_token), absint($limit));
            $content = $this->_makecall($_url);

            return json_decode($content, true);
        } catch (Exception $e) {
            return array();
        }
    }

    public function instagram_get_media()
    {
        global $elextron_datas;

        $_tokan = isset($elextron_datas['instagram-tokan']) ? esc_attr($elextron_datas['instagram-tokan']) : '';
        $limit = isset($_REQUEST['limit']) ? absint($_REQUEST['limit']) : 6;
        $thumbnail = isset($_REQUEST['image_size']) ? esc_attr($_REQUEST['image_size']) : 'low_resolution';
        $result = array();

        $validate_token = $this->instagram_validate_token($_tokan, false);
        $validate_token = json_decode($validate_token);

        if (isset($validate_token->meta) && $validate_token->meta->code == '200') {
            $result = $this->getInstagramMedia($validate_token->data->id, $_tokan, $limit);
        }

        if (!empty($result) && count($result['data'])) {
            if(!empty($_REQUEST['title'])) echo '<h3 class="heading-title">'.esc_html($_REQUEST['title']).'</h3>';
            $options = array(
                "items" => $_REQUEST['columns'],
            );
            $options = YetiThemes_Extra()->get_owlResponsive($options);
            ?>
            <div class="yeti-owlCarousel yeti-loading light" data-options="<?php echo esc_attr(wp_json_encode($options))?>" data-base="1">

                <?php YetiThemes_Extra()->get_yetiLoadingIcon();?>

                <div class="yeti-owl-slider">

                    <?php foreach ($result['data'] as $item): ?>

                        <div class="instagram-item">

                            <a target="_blank" class="effect_color" href="<?php echo esc_url($item['link'])?>">

                                <img src="<?php echo esc_url($item['images'][$thumbnail]['url'])?>" alt="instag image" />

                            </a>

                        </div>

                    <?php endforeach;?>

                </div>

            </div>
            <?php
        }

        wp_die();
    }

    public function get_media($key='', $limit = 6, $time = 2)
    {
        global $yesshop_datas;

        $_tokan = isset($yesshop_datas['instagram-tokan']) ? esc_attr($yesshop_datas['instagram-tokan']) : '';
        $result = array();

        if(empty($key)) {
            $_cache_key = $this->_cache_key_prefix . 'l'.absint($limit);
            $action = 'self';
        } else {
            $key = strtolower($key);
            $is_hash = (substr( $key, 0, 1) === '#');
            if($is_hash) {
                $action = 'tags';
                $key = substr( $key, 1);
                $_cache_key = $this->_cache_key_prefix.'tag_'.$key.'_l'.absint($limit);
            } else {
                $action = 'user';
                $_cache_key = $this->_cache_key_prefix.'user_'.$key.'_l'.absint($limit);
            }

        }

        if(!$instagram = get_transient( esc_attr($_cache_key))) {
            switch ($action) {
                case 'self':
                    $validate_token = $this->instagram_validate_token($_tokan, false);
                    $validate_token = json_decode($validate_token);
                    if (isset($validate_token->meta) && $validate_token->meta->code == '200') {
                        $result = $this->getInstagramMedia($validate_token->data->id, $_tokan, $limit);
                    }
                    break;
                case 'tags':
                case 'user':
                    $result = $this->getInstagramMedia($key, $_tokan, $limit, $is_hash);
                    break;

            }

            $instagram = array();
            if(!empty($result) && count($result['data'])) {
                foreach ($result['data'] as $data) {
                    if(!empty($data['images']['thumbnail']))
                        $data['images']['thumbnail']['url'] = preg_replace( "/^http:/i", "", esc_url($data['images']['thumbnail']['url']) );
                    if(!empty($data['images']['standard_resolution']))
                        $data['images']['standard_resolution']['url'] = preg_replace( "/^http:/i", "", esc_url($data['images']['standard_resolution']['url']) );
                    if(!empty($data['images']['low_resolution']))
                        $data['images']['low_resolution']['url'] = preg_replace( "/^http:/i", "", esc_url($data['images']['low_resolution']['url']) );

                    $instagram[] = array(
                        'description'   => $data['caption']['text'],
                        'link'		  	=> preg_replace( "/^http:/i", "", esc_url($data['link']) ),
                        'time'		  	=> esc_attr($data['created_time']),
                        'comments'	  	=> esc_attr($data['comments']['count']),
                        'likes'		 	=> esc_attr($data['likes']['count']),
                        'thumbnail'	 	=> $data['images']['thumbnail'],
                        'large'		 	=> $data['images']['standard_resolution'],
                        'small'		 	=> $data['images']['low_resolution'],
                        'type'		  	=> $data['type']
                    );
                }
            }

            if(!empty($instagram)) {
                set_transient(esc_attr($_cache_key), maybe_serialize($instagram), HOUR_IN_SECONDS*absint($time));
                return $instagram;
            }
        }

        $instagram = maybe_unserialize($instagram);

        return $instagram;
    }

    public function scrape_instagram($key) {
        $key = strtolower($key);
        $is_hash = (substr( $key, 0, 1) === '#');
        if($is_hash) $key = substr( $key, 1);

        $_cache_key = $this->_cache_key_prefix . ($is_hash? 'tag_': '') . $key;
        if(true||!$instagram = get_transient( esc_attr($_cache_key))) {
            $request_url = 'http://instagram.com/' . (($is_hash)? 'explore/tags/' . esc_attr($key): esc_attr($key));
            $remote = wp_remote_get( $request_url );
            if ( is_wp_error( $remote ) ) return 'site_down';
            echo '<pre>';
            print_r($request_url);
            echo '</pre>';
            if ( 200 != wp_remote_retrieve_response_code( $remote ) ) return 'invalid_response';

            $shards = explode( 'window._sharedData = ', $remote['body'] );
            $_json = explode( ';</script>', $shards[1] );
            $_array = json_decode( $_json[0], TRUE );

            if ( !is_array($_array) ) return 'bad_json';

            if($is_hash && isset($_array['entry_data']['TagPage'][0]['tag']['media']['nodes'])) {
                $media = $_array['entry_data']['TagPage'][0]['tag']['media']['nodes'];
                $_old = false;
            } elseif(isset( $_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'])) {
                $media = $_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
                $_old = false;
            } elseif(isset( $_array['entry_data']['UserProfile'][0]['userMedia'] )) {
                $media = $_array['entry_data']['UserProfile'][0]['userMedia'];
                $_old = true;
            } else {
                return 'resulf_empty';
            }

            if(empty($media)) return 'resulf_empty';
            $instagram = array();

            if($_old) {
                foreach ( $media as $image ) {
                    if ( $image['user']['username'] == $key ) {
                        $instagram[] = array(
                            'description'   => $image['caption']['text'],
                            'link'		  	=> preg_replace( "/^http:/i", "", esc_url($image['link']) ),
                            'time'		  	=> esc_attr($image['created_time']),
                            'comments'	  	=> esc_attr($image['comments']['count']),
                            'likes'		 	=> esc_attr($image['likes']['count']),
                            'thumbnail'	 	=> preg_replace( "/^http:/i", "", esc_url($image['images']['thumbnail']) ),
                            'large'		 	=> preg_replace( "/^http:/i", "", esc_url($image['images']['standard_resolution']) ),
                            'small'		 	=> preg_replace( "/^http:/i", "", esc_url($image['images']['low_resolution'] )),
                            'type'		  	=> $image['type']
                        );
                    }
                }
            } else {
                foreach ( $media as $image ) {
                    $image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );

                    $instagram[] = array(
                        'description'   => empty( $image['caption'])? esc_attr__( 'Instagram Image', 'yetithemes' ): $image['caption'],
                        'link'		  	=> '//instagram.com/p/' . $image['code'],
                        'time'		  	=> $image['date'],
                        'comments'	  	=> $image['comments']['count'],
                        'likes'		 	=> $image['likes']['count'],
                        'thumbnail'	 	=> str_replace( 's640x640', 's160x160', $image['thumbnail_src'] ),
                        'medium'		=> str_replace( 's640x640', 's320x320', $image['thumbnail_src'] ),
                        'large'			=> $image['thumbnail_src'],
                        'original'		=> preg_replace( "/^https:/i", "", $image['display_src'] ),
                        'type'		  	=> ($image['is_video'] == true)? 'video': 'image'
                    );
                }
            }

            if(!empty($instagram)) {
                set_transient(esc_attr($_cache_key), maybe_serialize($instagram), HOUR_IN_SECONDS*2);
            }

        }

        if(!empty($instagram)) {
            return maybe_unserialize($instagram);
        }
    }

}

function Yetithemes_Instagram() {
    return Yetithemes_Instagram::get_instance();
}

