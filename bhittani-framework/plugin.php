<?php

if(!class_exists('BhittaniPlugin')) :

	class BhittaniPlugin
	{
		public $id;
		public $nick;
		public $ver;
		public $wpver;

		public function __construct($id, $nick, $ver)
		{
			$this->id = $id;
			$this->nick = $nick;
			$this->ver = $ver;
			global $wp_version;
			$this->wpver = $wp_version;
		}
		/** function/method
		* Usage: return file uri
		* Arg(1): string
		* Return: string
		*/
		public static function file_uri($path)
		{
			return plugins_url($path, dirname(__FILE__));
		}
		/** function/method
		* Usage: return absoulte file path
		* Arg(1): string
		* Return: string
		*/
		public static function file_path($path)
		{
			return dirname(dirname(__FILE__)).'/'.$path;
		}
		/** function/method
		* Usage: get options
		* Arg(1): key (string)
		* Return: string
		*/
		public static function get_options($key)
		{
			return get_option($key);
		}
		/** function/method
		* Usage: update/save options
		* Arg(1): array
		* Return: void
		*/
		public static function update_options($Options)
		{
			if(is_array($Options))
			{
				foreach($Options as $key => $value)
				{
					update_option($key, $value);
				}
			}
		}
		/** function/method
		* Usage: delete options
		* Arg(1): key (string)
		* Return: void
		*/
		public static function delete_options($key)
		{
			delete_option($key);
		}

		/**
		 * Encode a variable into JSON.
		 *
		 * @param mixed $data    Variable (usually an array or object) to encode as JSON.
		 * @param int   $options Optional. Default 0.
		 * @param int   $depth   Optional. Default 512.
		 *
		 * @return string|false The JSON encoded string, or false if it cannot be encoded.
		 */
		protected function json_encode( $data, $options = 0, $depth = 512 ) {
			return function_exists( 'wp_json_encode' )
				? wp_json_encode( $data, $options, $depth )
				: json_encode( $data, $options, $depth );
		}

		/**
		 * Adds extra code to a registered script.
		 *
		 * @param string $handle   Name of the script to add the inline script to.
		 * @param string $data     String containing the javascript to be added.
		 *
		 * @return bool True on success, false on failure.
		 */
		protected function add_inline_script( $handle, $data ) {
			if ( ! function_exists( 'wp_add_inline_script' ) ) {
				echo '<script type="text/javascript">' . $data . '</script>';
				return true;
			}

			return wp_add_inline_script( $handle, $data, 'before' );
		}

		/** function/method
		* Usage: helper for hooking js scripts
		* Arg(6): slug (string), file (string), version (string)[optional, default: '0.1'], prerequisite (bool|array)[optional, default: false], parameters (bool|array)[optional, default: array('ajax')]
		* Return: void
		*/
		protected function enqueue_js($slug, $file, $ver = false, $prerequisite=false, $params=false, $footer = false, $json = false)
		{
			$handle = $this->id.($slug?('_'.$slug):'');
			wp_register_script($handle, $file, is_array($prerequisite)?$prerequisite:array('jquery'), $ver ? $ver : $this->ver, $footer);

			if(is_array($params) && $json)
			{
				$this->add_inline_script(
					$handle,
					sprintf( "\tvar %s = %s;", str_replace('-','_',$handle), $this->json_encode( $params ) )
				);
			}	
			wp_enqueue_script( $handle );
			
			if(is_array($params) && !$json) 
				wp_localize_script($handle, str_replace('-','_',$handle), $params);
		}
		/** function/method
		* Usage: helper for hooking css scripts
		* Arg(3): slug (string), file (string), ver (string)[optional, default: '0.1']
		* Return: void
		*/
		protected function enqueue_css($slug, $file, $ver = false)
		{
			wp_register_style( $this->id.($slug?('_'.$slug):''), $file, false, $ver ? $ver : $this->ver );
			wp_enqueue_style( $this->id.($slug?('_'.$slug):''));
		}
	}
	
	if(is_admin())
	{
		require_once 'admin/markup.class.php';
		require_once 'admin/admin.class.php';
	}

endif;
?>