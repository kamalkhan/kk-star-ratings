<?php

/*
Plugin Name: kk Star Ratings
Plugin URI: https://github.com/kamalkhan/kk-star-ratings
Description: Renewed from the ground up(as of v2.0), clean, animated and light weight ratings feature for your blog. With kk Star Ratings, you can <strong>allow your blog posts to be rated by your blog visitors</strong>. It also includes a <strong>widget</strong> which you can add to your sidebar to show the top rated post. Wait! There is more to it. Enjoy the extensive options you can set to customize this plugin.
Version: 2.6.1
Author: Kamal Khan
Author URI: http://bhittani.com
License: GPLv2 or later
*/

require_once 'bhittani-framework/plugin.php';

if(!class_exists('BhittaniPlugin_kkStarRatings')) :

    class BhittaniPlugin_kkStarRatings extends BhittaniPlugin
    {
        private $_Menus;

        public function __construct($id, $nick, $ver)
        {
            parent::__construct($id, $nick, $ver);
            $this->_Menus = array();
        }
        /**
          * File uri
          *
          * @since 1.0 Initially defined
          *
          * @param string $path Path to file.
          *
          * @return string full uri.
          */
        public static function file_uri($path)
        {
            return plugins_url($path, __FILE__);
        }
        /**
          * File path
          *
          * @since 1.0 Initially defined
          *
          * @param string $path Path to file.
          *
          * @return string full path.
          */
        public static function file_path($path)
        {
            return dirname(__FILE__).'/'.$path;
        }
        /** function/method
        * Usage: hook js frontend
        * Arg(0): null
        * Return: void
        */
        public function js()
        {
            $nonce = wp_create_nonce($this->id);
            $Params = array();
            $Params['nonce'] = $nonce; //for security
            $Params['grs'] = parent::get_options('kksr_grs') ? true : false;
            $Params['ajaxurl'] = admin_url('admin-ajax.php');
            $Params['func'] = 'kksr_ajax';
            $Params['msg'] = parent::get_options('kksr_init_msg');
            $Params['fuelspeed'] = (int) parent::get_options('kksr_js_fuelspeed');
            $Params['thankyou'] = parent::get_options('kksr_js_thankyou');
            $Params['error_msg'] = parent::get_options('kksr_js_error');
            $Params['tooltip'] = parent::get_options('kksr_tooltip');
            $Params['tooltips'] = parent::get_options('kksr_tooltips');
            $this->enqueue_js('js', self::file_uri('js.min.js'), $this->ver, array('jquery'), $Params, false, true);
        }
        /** function/method
        * Usage: hook js admin - helper
        * Arg(0): null
        * Return: void
        */
        public function js_admin()
        {
            $nonce = wp_create_nonce($this->id);
            $Params = array();
            $Params['nonce'] = $nonce;
            $Params['func_reset'] = 'kksr_admin_reset_ajax';
            $this->enqueue_js('js_admin', self::file_uri('js_admin.js'), $this->ver, array('jquery', 'bhittaniplugin_admin_script'), $Params);
        }
        /** function/method
        * Usage: hook admin scripts
        * Arg(0): null
        * Return: void
        */
        public function admin_scripts()
        {
            foreach($this->_Menus as $menu)
            {
                add_action('admin_print_scripts-'.$menu, array(&$this, 'js_admin'));
            }
        }
        /** function/method
        * Usage: hook css
        * Arg(0): null
        * Return: void
        */
        public function css()
        {
            $this->enqueue_css('', self::file_uri('css.css'));
        }
        /** function/method
        * Usage: hook custom css
        * Arg(0): null
        * Return: void
        */
        public function css_custom()
        {
            $stars = parent::get_options('kksr_stars') ? parent::get_options('kksr_stars') : 5;

            $star_w = parent::get_options('kksr_stars_w') ? parent::get_options('kksr_stars_w') : 24;
            $star_h = parent::get_options('kksr_stars_h') ? parent::get_options('kksr_stars_h') : 24;

            $star_gray = parent::get_options('kksr_stars_gray');
            $star_yellow = parent::get_options('kksr_stars_yellow');
            $star_orange = parent::get_options('kksr_stars_orange');

            echo '<style>';

            echo '.kk-star-ratings { width:'.($star_w*$stars).'px; }';
            echo '.kk-star-ratings .kksr-stars a { width:'.($star_w).'px; }';
            echo '.kk-star-ratings .kksr-stars, .kk-star-ratings .kksr-stars .kksr-fuel, .kk-star-ratings .kksr-stars a { height:'.($star_h).'px; }';

            echo $star_gray ? '.kk-star-ratings .kksr-star.gray { background-image: url('.$star_gray.'); }' : '';
            echo $star_yellow ? '.kk-star-ratings .kksr-star.yellow { background-image: url('.$star_yellow.'); }' : '';
            echo $star_orange ? '.kk-star-ratings .kksr-star.orange { background-image: url('.$star_orange.'); }' : '';

            echo '</style>';
        }
        /** function/method
        * Usage: Setting defaults and backwards compatibility
        * Arg(0): null
        * Return: void
        */
        public function activate()
        {
            $ver_current = $this->ver;
            $ver_previous = parent::get_options('kksr_ver') ? parent::get_options('kksr_ver') : false;
            $Old_plugin = parent::get_options('kk-ratings');

            $opt_enable = 1; // 1|0
            $opt_clear = 0; // 1|0
            $opt_show_in_home = 0; // 1|0
            $opt_show_in_archives = 0; // 1|0
            $opt_show_in_posts = 1; // 1|0
            $opt_show_in_pages = 0; // 1|0
            $opt_unique = 0; // 1|0
            $opt_position = 'top-left'; // 'top-left', 'top-right', 'bottom-left', 'bottom-right'
            $opt_legend = '[avg] ([per]) [total] vote[s]'; // [total]=total ratings, [avg]=average, [per]=percentage [s]=singular/plural
            $opt_init_msg = 'Rate this post'; // string
            $opt_column = 1; // 1|0

            $Options = array();
            $Options['kksr_enable'] = isset($Old_plugin['enable']) ? $Old_plugin['enable'] : $opt_enable;
            $Options['kksr_clear'] = isset($Old_plugin['clear']) ? $Old_plugin['clear'] : $opt_clear;
            $Options['kksr_show_in_home'] = isset($Old_plugin['show_in_home']) ? $Old_plugin['show_in_home'] : $opt_show_in_home;
            $Options['kksr_show_in_archives'] = isset($Old_plugin['show_in_archives']) ? $Old_plugin['show_in_archives'] : $opt_show_in_archives;
            $Options['kksr_show_in_posts'] = isset($Old_plugin['show_in_posts']) ? $Old_plugin['show_in_posts'] : $opt_show_in_posts;
            $Options['kksr_show_in_pages'] = isset($Old_plugin['show_in_pages']) ? $Old_plugin['show_in_pages'] : $opt_show_in_pages;
            $Options['kksr_unique'] = isset($Old_plugin['unique']) ? $Old_plugin['unique'] : $opt_unique;
            $Options['kksr_position'] = isset($Old_plugin['position']) ? $Old_plugin['position'] : $opt_position;
            $Options['kksr_legend'] = isset($Old_plugin['legend']) ? $Old_plugin['legend'] : $opt_legend;
            $Options['kksr_init_msg'] = isset($Old_plugin['init_msg']) ? $Old_plugin['init_msg'] : $opt_init_msg;
            $Options['kksr_column'] = isset($Old_plugin['column']) ? $Old_plugin['column'] : $opt_column;

            // Upgrade from old plugin(<2.0) to renewed plugin(>=2.0)
            if(!$ver_previous || version_compare($ver_previous, '2.0', '<'))
            {
                // Delete old options
                parent::delete_options('kk-ratings');

                // Update previous ratings
                global $wpdb;
                $table = $wpdb->prefix . 'postmeta';
                $Posts = $wpdb->get_results("SELECT a.ID, b.meta_key, b.meta_value
                                             FROM " . $wpdb->posts . " a, $table b
                                             WHERE a.ID=b.post_id AND
                                             (
                                                 b.meta_key='_kk_ratings_ratings' OR
                                                 b.meta_key='_kk_ratings_casts' OR
                                                 b.meta_key='_kk_ratings_ips'
                                             ) ORDER BY a.ID ASC");
                $Wrap = array();
                foreach ($Posts as $post)
                {
                    $Wrap[$post->ID]['id'] = $post->ID;
                    $Wrap[$post->ID][$post->meta_key] = $post->meta_value;
                }
                foreach($Wrap as $p)
                {
                    update_post_meta($p['id'], '_kksr_ratings', $p['_kk_ratings_ratings']);
                    update_post_meta($p['id'], '_kksr_casts', $p['_kk_ratings_casts']);
                    $Ips = array();
                    $Ips = explode('|', $p['_kk_ratings_ips']);
                    $ip = base64_encode(serialize($Ips));
                    update_post_meta($p['id'], '_kksr_ips', $ip);
                    update_post_meta($p['id'], '_kksr_avg', round($p['_kk_ratings_ratings']/$p['_kk_ratings_casts'],1));
                }
            }
            if(!parent::get_options('kksr_ver'))
            {
                $Options['kksr_ver'] = $ver_current;
                $Options['kksr_stars'] = 5;
                $Options['kksr_stars_w'] = 24;
                $Options['kksr_stars_h'] = 24;
                $Options['kksr_stars_gray'] = 0;
                $Options['kksr_stars_yellow'] = 0;
                $Options['kksr_stars_orange'] = 0;
                $Options['kksr_js_fuelspeed'] = 400;
                $Options['kksr_js_thankyou'] = 'Thank you for your vote';
                $Options['kksr_js_error'] = 'An error occurred';
                $Options['kksr_tooltip'] = 1;
                $Opt_tooltips = array();
                $Opt_tooltips[0]['color'] = 'red';
                $Opt_tooltips[0]['tip'] = 'Poor';
                $Opt_tooltips[1]['color'] = 'brown';
                $Opt_tooltips[1]['tip'] = 'Fair';
                $Opt_tooltips[2]['color'] = 'orange';
                $Opt_tooltips[2]['tip'] = 'Average';
                $Opt_tooltips[3]['color'] = 'blue';
                $Opt_tooltips[3]['tip'] = 'Good';
                $Opt_tooltips[4]['color'] = 'green';
                $Opt_tooltips[4]['tip'] = 'Excellent';
                $Options['kksr_tooltips'] = base64_encode(serialize($Opt_tooltips));
                parent::update_options($Options);
            }

            parent::update_options(array('kksr_ver'=>$ver_current));
        }
        /** function/method
        * Usage: helper for hooking (registering) the menu
        * Arg(0): null
        * Return: void
        */
        public function menu()
        {
            // Create main menu tab
            $this->_Menus[] = add_menu_page(
                $this->nick.' - Settings',
                $this->nick,
                'manage_options',
                $this->id.'_settings',
                array(&$this, 'options_general'),
                self::file_uri('icon.png')
            );
            // Create images menu tab
            $this->_Menus[] = add_submenu_page(
                $this->id.'_settings',
                $this->nick.' - Settings',
                'Settings',
                'manage_options',
                $this->id.'_settings',
                array(&$this, 'options_general')
            );
            // Create images menu tab
            $this->_Menus[] = add_submenu_page(
                $this->id.'_settings',
                $this->nick.' - Stars',
                'Stars',
                'manage_options',
                $this->id.'_settings_stars',
                array(&$this, 'options_stars')
            );
            // Create tooltips menu tab
            $this->_Menus[] = add_submenu_page(
                $this->id.'_settings',
                $this->nick.' - Tooltips',
                'Tooltips',
                'manage_options',
                $this->id.'_settings_tooltips',
                array(&$this, 'options_tooltips')
            );
            // Create reset menu tab
            $this->_Menus[] = add_submenu_page(
                $this->id.'_settings',
                $this->nick.' - Reset',
                'Reset',
                'manage_options',
                $this->id.'_settings_reset',
                array(&$this, 'options_reset')
            );
            // Create info menu tab
            $this->_Menus[] = add_submenu_page(
                $this->id.'_settings',
                $this->nick.' - Help',
                'Help',
                'manage_options',
                $this->id.'_settings_info',
                array(&$this, 'options_info')
            );
        }
        /** function/method
        * Usage: show options/settings form page
        * Arg(0): null
        * Return: void
        */
        public function options_page($opt)
        {
            if (!current_user_can('manage_options'))
            {
                wp_die( __('You do not have sufficient permissions to access this page.') );
            }
            $sidebar = true;
            $h3 = 'kk Star Ratings';
            $Url = array(
                // array(
                //     'title' => 'Github Repository',
                //     'link' => 'https://github.com/kamalkhan/kk-star-ratings'
                // ),
                // array(
                // 	'title' => 'Changelog',
                //     'link' => '#'
                // )
            );
            include self::file_path('admin.php');
        }
        /** function/method
        * Usage: show general options
        * Arg(0): null
        * Return: void
        */
        public function options_general()
        {
            $this->options_page('general');
        }
        /** function/method
        * Usage: show images options
        * Arg(0): null
        * Return: void
        */
        public function options_stars()
        {
            $this->options_page('stars');
        }
        /** function/method
        * Usage: show tooltips options
        * Arg(0): null
        * Return: void
        */
        public function options_tooltips()
        {
            $this->options_page('tooltips');
        }
        /** function/method
        * Usage: show reset options
        * Arg(0): null
        * Return: void
        */
        public function options_reset()
        {
            $this->options_page('reset');
        }
        /** function/method
        * Usage: show info options
        * Arg(0): null
        * Return: void
        */
        public function options_info()
        {
            $this->options_page('info');
        }
        public function kksr_admin_reset_ajax()
        {
            header('content-type: application/json; charset=utf-8');
            check_ajax_referer($this->id);

            $Reset = $_POST['kksr_reset'];
            if(is_array($Reset))
            {
                foreach($Reset as $id => $val)
                {
                    if($val=='1')
                    {
                        delete_post_meta($id, '_kksr_ratings');
                        delete_post_meta($id, '_kksr_casts');
                        delete_post_meta($id, '_kksr_ips');
                        delete_post_meta($id, '_kksr_avg');
                    }
                }
            }

            $Response = array();
            $Response['success'] = 'true';
            echo json_encode($Response);
            die();
        }
        public function extract_ratings($id)
        {
            $best = (int) parent::get_options('kksr_stars');
            $score = get_post_meta($id, '_kksr_ratings', true) ? ((int) get_post_meta($id, '_kksr_ratings', true)) : 0;
            $votes = get_post_meta($id, '_kksr_casts', true) ? ((int) get_post_meta($id, '_kksr_casts', true)) : 0;
            $avg = $score && $votes ? round((float)(($score/$votes)*($best/5)), 1) : 0;
            $per = $score && $votes ? round((float)((($score/$votes)/5)*100), 2) : 0;

            return compact('best', 'score', 'votes', 'avg', 'per');
        }
        public function ratings_as_legend($id, $ratings = null)
        {
            $ratings = $ratings ? $ratings : $this->extract_ratings($id);

            return apply_filters(
                'kksr_legend',
                parent::get_options('kksr_legend'),
                $id,
                $ratings['best'],
                $ratings['score'],
                $ratings['votes'],
                $ratings['avg'],
                $ratings['per']
            );
        }
        public function kksr_ajax()
        {
            header('Content-type: application/json; charset=utf-8');
            check_ajax_referer($this->id);

            $Response = array();

            $total_stars = is_numeric(parent::get_options('kksr_stars')) ? parent::get_options('kksr_stars') : 5;

            $stars = is_numeric($_POST['stars']) && ((int)$_POST['stars']>0) && ((int)$_POST['stars']<=$total_stars)
                    ? $_POST['stars']:
                    0;
            $ip = $_SERVER['REMOTE_ADDR'];

            $Ids = explode(',', $_POST['id']);

            foreach($Ids as $pid) :

            $ratings = get_post_meta($pid, '_kksr_ratings', true) ? get_post_meta($pid, '_kksr_ratings', true) : 0;
            $casts = get_post_meta($pid, '_kksr_casts', true) ? get_post_meta($pid, '_kksr_casts', true) : 0;

            if($stars==0 && $ratings==0)
            {
                $Response[$pid]['legend'] = parent::get_options('kksr_init_msg');
                $Response[$pid]['disable'] = 'false';
                $Response[$pid]['fuel'] = '0';
                do_action('kksr_init', $pid, false, false);
            }
            else
            {
                $nratings = $ratings + ($stars/($total_stars/5));
                $ncasts = $casts + ($stars>0);
                $avg = $nratings && $ncasts ? number_format((float)($nratings/$ncasts), 2, '.', '') : 0;
                $per = $nratings && $ncasts ? number_format((float)((($nratings/$ncasts)/5)*100), 2, '.', '') : 0;
                $Response[$pid]['disable'] = 'false';
                if($stars)
                {
                    $Ips = get_post_meta($pid, '_kksr_ips', true) ? unserialize(base64_decode(get_post_meta($pid, '_kksr_ips', true))) : array();
                    if(!in_array($ip, $Ips))
                    {
                        $Ips[] = $ip;
                    }
                    $ips = base64_encode(serialize($Ips));
                    update_post_meta($pid, '_kksr_ratings', $nratings);
                    update_post_meta($pid, '_kksr_casts', $ncasts);
                    update_post_meta($pid, '_kksr_ips', $ips);
                    update_post_meta($pid, '_kksr_avg', $avg);
                    $Response[$pid]['disable'] = parent::get_options('kksr_unique') ? 'true' : 'false';
                    do_action('kksr_rate', $pid, $stars, $ip);
                }
                else
                {
                    do_action('kksr_init', $pid, number_format((float)($avg*($total_stars/5)), 2, '.', '').'/'.$total_stars, $ncasts);
                }
                // $legend = parent::get_options('kksr_legend');
                // $legend = str_replace('[total]', $ncasts, $legend);
                // $legend = str_replace('[avg]', number_format((float)($avg*($total_stars/5)), 2, '.', '').'/'.$total_stars, $legend);
                // $legend = str_replace('[s]', $ncasts==1?'':'s', $legend);
                // $Response[$pid]['legend'] = str_replace('[per]',$per.'%', $legend);
                // $Response[$pid]['legend'] = apply_filters('kksr_legend', parent::get_options('kksr_legend'), $pid);
                $Response[$pid]['meta'] = $this->extract_ratings($pid);
                $Response[$pid]['legend'] = $this->ratings_as_legend($pid, $Response[$pid]['meta']);
                $Response[$pid]['fuel'] = (float) $per;
            }

            $Response[$pid]['success'] = true;

            endforeach;

            echo json_encode($Response);
            die();
        }
        protected function trim_csv_cb($value)
        {
            if(trim($value)!="")
                return true;
            return false;
        }
        protected function exclude_cat($id)
        {
            $excl_categories = parent::get_options('kksr_exclude_categories');
            $Cat_ids = $excl_categories ? array_filter(array_map('trim', explode(",", $excl_categories)), array(&$this, 'trim_csv_cb')) : array();
            $Post_cat_ids = wp_get_post_categories($id);
            $Intersection = array_intersect($Cat_ids, $Post_cat_ids);
            return count($Intersection);
        }
        public function markup($id=false)
        {
            $id = !$id ? get_the_ID() : $id;
            if($this->exclude_cat($id))
            {
                return '';
            }

            $disabled = false;
            if(get_post_meta($id, '_kksr_ips', true))
            {
                $Ips = unserialize(base64_decode(get_post_meta($id, '_kksr_ips', true)));
                $ip = $_SERVER['REMOTE_ADDR'];
                if(in_array($ip, $Ips))
                {
                    $disabled = parent::get_options('kksr_unique') ? true : false;
                }
            }
            $pos = parent::get_options('kksr_position');

            $markup = '
            <div class="kk-star-ratings '.($disabled || (is_archive() && parent::get_options('kksr_disable_in_archives')) ? 'disabled ' : ' ').$pos.($pos=='top-right'||$pos=='bottom-right' ? ' rgt' : ' lft').'" data-id="'.$id.'">
                <div class="kksr-stars kksr-star gray">
                    <div class="kksr-fuel kksr-star '.($disabled ? 'orange' : 'yellow').'" style="width:0%;"></div>
                    <!-- kksr-fuel -->';
            $total_stars = parent::get_options('kksr_stars');
            for($ts = 1; $ts <= $total_stars; $ts++)
            {
                $markup .= '<a href="#'.$ts.'"></a>';
            }
            $markup .='
                </div>
                <!-- kksr-stars -->
                <div class="kksr-legend">';

            $markup .= $this->ratings_as_legend($id);

            $markup .=
                '</div>
                <!-- kksr-legend -->
            </div>
            <!-- kk-star-ratings -->
            ';
            $markup .= parent::get_options('kksr_clear') ? '<br clear="both" />' : '';
            return $markup;
        }
        public function manual($atts)
        {
            extract(shortcode_atts(array('id' => false), $atts));
            if(!is_admin() && parent::get_options('kksr_enable'))
            {
                if(
                    ((parent::get_options('kksr_show_in_home')) && (is_front_page() || is_home()))
                    || ((parent::get_options('kksr_show_in_archives')) && (is_archive()))
                  )
                    return $this->markup($id);
                else if(is_single() || is_page())
                    return $this->markup($id);
            }
            else
            {
                remove_shortcode('kkratings');
                remove_shortcode('kkstarratings');
            }
            return '';
        }
        public function filter($content)
        {
            if(parent::get_options('kksr_enable')) :
            if(
                ((parent::get_options('kksr_show_in_home')) && (is_front_page() || is_home()))
                || ((parent::get_options('kksr_show_in_archives')) && (is_archive()))
                || ((parent::get_options('kksr_show_in_posts')) && (is_single()))
                || ((parent::get_options('kksr_show_in_pages')) && (is_page()))
              ) :
                remove_shortcode('kkratings');
                remove_shortcode('kkstarratings');
                $markup = $this->markup();
                if (strpos($content, '[kkratings]') !== false
                    || strpos($content, '[kkstarratings]') !== false
                ) {
                    $markup = '<div style="display: inline-block">' . $markup . '</div>';
                    $content = str_replace('[kkratings]', $markup, $content);
                    $content = str_replace('[kkstarratings]', $markup, $content);
                    return $content;
                }
                switch(parent::get_options('kksr_position'))
                {
                    case 'bottom-left' :
                    case 'bottom-right' : return $content . $markup;
                    default : return $markup . $content;
                }
            endif;
            endif;
            return $content;
        }
        public function kk_star_rating($pid=false)
        {
            if(parent::get_options('kksr_enable'))
                return $this->markup($pid);
            return '';
        }
        public function kk_star_ratings_get($total=5, $cat=false)
        {
            global $wpdb;
            $table = $wpdb->prefix . 'postmeta';
            $best = (int) parent::get_options('kksr_stars');
            $q = "SELECT a.ID, a.post_title, ROUND(b.meta_value * %f, 1) AS 'ratings' FROM " . $wpdb->posts . " a, $table b, ";
            if(!$cat) {
                $query = $wpdb->prepare("$q $table c WHERE a.post_status='publish' AND a.ID=b.post_id AND a.ID=c.post_id AND b.meta_key='_kksr_avg' AND c.meta_key='_kksr_casts' ORDER BY CAST(b.meta_value AS UNSIGNED) DESC, CAST(c.meta_value AS UNSIGNED) DESC LIMIT %d", $best / 5, $total);
                $rated_posts = $wpdb->get_results($query);
            } else
            {
                $table2 = $wpdb->prefix . 'term_taxonomy';
                $table3 = $wpdb->prefix . 'term_relationships';
                $query = $wpdb->prepare("$q $table2 c, $table3 d, $table e WHERE c.term_taxonomy_id=d.term_taxonomy_id AND c.term_id=$cat AND d.object_id=a.ID AND a.post_status='publish' AND a.ID=b.post_id AND a.ID=e.post_id AND b.meta_key='_kksr_avg' AND e.meta_key='_kksr_casts' ORDER BY CAST(b.meta_value AS UNSIGNED) DESC, CAST(e.meta_value AS UNSIGNED) DESC LIMIT %d", $best / 5, $total);
                $rated_posts = $wpdb->get_results($query);
            }

            return $rated_posts;
        }
        public function add_column($Columns)
        {
            if(parent::get_options('kksr_column'))
                $Columns['kk_star_ratings'] = 'Ratings';
            return $Columns;
        }
        public function add_row($Columns, $id)
        {
            if(! parent::get_options('kksr_column'))
            {
                return;
            }

            $row = 'No ratings';

            $ratings = $this->extract_ratings($id);
            if ($ratings['score']) {
                $row = $this->sanitize_legend(
                    parent::get_options('kksr_legend'),
                    $id,
                    $ratings['best'],
                    $ratings['score'],
                    $ratings['votes'],
                    $ratings['avg'],
                    $ratings['per']
                );
            }

            switch($Columns)
            {
                case 'kk_star_ratings' : echo $row; break;
            }
        }
        /** function/method
        * Usage: Allow sorting of columns
        * Arg(1): $Args (array)
        * Return: (array)
        */
        public function sort_columns($Args)
        {
            $Args = array_merge($Args,
                array('kk_star_ratings' => 'kk_star_ratings')
            );
            return wp_parse_args($Args);
        }
        /** function/method
        * Usage: Allow sorting of columns - helper
        * Arg(1): $Query (array)
        * Return: null
        */
        public function sort_columns_helper($Query)
        {
            if(!is_admin())
            {
                return;
            }
            $orderby = $Query->get( 'orderby');
            if($orderby=='kk_star_ratings')
            {
                $Query->set('meta_key','_kksr_avg');
                $Query->set('orderby','meta_value_num');
            }
        }
        public function sanitize_legend($legend, $id, $best, $score, $votes, $avg, $per)
        {
            if(!$score)
            {
                return parent::get_options('kksr_init_msg');
            }

            $leg = str_replace('[total]', '<span itemprop="ratingCount">'.$votes.'</span>', $legend);
            $leg = str_replace('[avg]', '<span itemprop="ratingValue">'.$avg.'</span>', $leg);
            $leg = str_replace('[per]',  $per .'%', $leg);
            $leg = str_replace('[s]', $votes == 1 ? '' : 's', $leg);
            $leg = str_replace('[best]', $best, $leg);

            return $leg;
        }
        public function grs_legend($legend, $id, $best, $score, $votes, $avg, $per)
        {
            if(!parent::get_options('kksr_grs'))
            {
                return $legend;
            }

            $title = get_the_title($id);

            $snippet = '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
            $snippet .= '    <div itemprop="name" class="kksr-title">' . $title . '</div>';
            $snippet .=      $legend;
            $snippet .= '    <meta itemprop="bestRating" content="'. $best . '"/>';
            $snippet .= '    <meta itemprop="worstRating" content="1"/>';
            $snippet .= '    <div itemprop="itemReviewed" itemscope itemtype="http://schema.org/CreativeWork">';
            $snippet .= '    <!-- Product properties -->';
            $snippet .= '    </div>';
            $snippet .= '</div>';

            return $snippet;
        }
    }

    $kkStarRatings_obj = new BhittaniPlugin_kkStarRatings('bhittani_plugin_kksr', 'kk Star Ratings', '2.6.1');

    // Setup
    register_activation_hook(__FILE__, array($kkStarRatings_obj, 'activate'));

    // Scripts
    add_action('wp_enqueue_scripts', array($kkStarRatings_obj, 'js'));
    add_action('wp_enqueue_scripts', array($kkStarRatings_obj, 'css'));
    add_action('wp_head', array($kkStarRatings_obj, 'css_custom'));
    add_action('admin_init', array($kkStarRatings_obj, 'admin_scripts'));

    // Menu
    add_action('admin_menu', array($kkStarRatings_obj, 'menu'));

    // AJAX
    add_action('wp_ajax_kksr_admin_reset_ajax', array($kkStarRatings_obj, 'kksr_admin_reset_ajax'));
    add_action('wp_ajax_kksr_ajax', array($kkStarRatings_obj, 'kksr_ajax'));
    add_action('wp_ajax_nopriv_kksr_ajax', array($kkStarRatings_obj, 'kksr_ajax'));

    // Main Hooks
    add_filter('the_content', array($kkStarRatings_obj, 'filter'));
    add_shortcode('kkratings', array($kkStarRatings_obj, 'manual'));
    add_shortcode('kkstarratings', array($kkStarRatings_obj, 'manual'));

    // Google Rich Snippets
    add_filter('kksr_legend', array($kkStarRatings_obj, 'sanitize_legend'), 10, 7);
    add_filter('kksr_legend', array($kkStarRatings_obj, 'grs_legend'), 10, 7);

    // Posts/Pages Column
    add_filter( 'manage_posts_columns', array($kkStarRatings_obj, 'add_column') );
    add_filter( 'manage_pages_columns', array($kkStarRatings_obj, 'add_column') );
    add_filter( 'manage_posts_custom_column', array($kkStarRatings_obj, 'add_row'), 10, 2 );
    add_filter( 'manage_pages_custom_column', array($kkStarRatings_obj, 'add_row'), 10, 2 );
    add_filter( 'manage_edit-post_sortable_columns', array($kkStarRatings_obj, 'sort_columns') );
    add_filter( 'pre_get_posts', array($kkStarRatings_obj, 'sort_columns_helper') );

    // For use in themes
    if(!function_exists('kk_star_ratings'))
    {
        function kk_star_ratings($pid=false)
        {
            global $kkStarRatings_obj;
            return $kkStarRatings_obj->kk_star_rating($pid);
        }
    }
    if(!function_exists('kk_star_ratings_get'))
    {
        function kk_star_ratings_get($lim=5, $cat=false)
        {
            global $kkStarRatings_obj;
            return $kkStarRatings_obj->kk_star_ratings_get($lim, $cat);
        }
    }

    require_once 'shortcode/shortcode.php';
    require_once 'widget.php';

endif;
