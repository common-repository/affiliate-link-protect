<?php
/*
Plugin Name: Affiliate Link Protect
Plugin URI: http://virelin.com/AffiliateLinkProtect
Description: Affiliate Link Protect hides all or specific URL parameters in any link of any Wordpress website. Displays all affiliate links like normal links without cloaking them!
Version: 1.05
Author: Virelin Inc.
Author URI: http://virelin.com
Text Domain: affiliate-link-protect
Domain Path: /languages
License: GPLv2 only
License URI: http://www.gnu.org/licenses/gpl-2.0.html

    Copyright 2017  Virelin Inc.  (email : info@virelin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if(empty(get_option('alp_param'))) update_option('alp_param','alp');

if ( is_admin() ) // admin page
   {
   require_once( dirname( __FILE__ ) . '/includes/AffiliateLinkProtect-admin.php' );
   add_action('plugins_loaded', 'AffiliateLinkProtect_load_textdomain');
   }

else  // public pages   
   {

   // set javascript params for public page
   $alp_elimi_paras = get_option("alp_elimi_paras");
   $alp_elimi_paras = str_replace(" ","",$alp_elimi_paras);
   if(!empty($alp_elimi_paras))
      {
	  $alp_elimi_paras = "'".$alp_elimi_paras."'";
	  $alp_elimi_paras = str_replace(",","','",$alp_elimi_paras);
	  }


   add_action('wp_head', 'AffiliateLinkProtect_inlinescript');
   add_action('wp_loaded', 'AffiliateLinkProtect_loadscript');
   }

   
function AffiliateLinkProtect_load_textdomain() {
	$result = load_plugin_textdomain( 'affiliate-link-protect', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
//	if($result) echo "<script>alert('loaded');</script>"; else echo "<script>alert('not loaded');</script>";
   }
   
function AffiliateLinkProtect_inlinescript() {
   global $alp_elimi_paras;
   echo '<script>var alp_param = "'.get_option("alp_param").'";var alp_elimi_paras = ['.$alp_elimi_paras.'];</script>';
   }

function AffiliateLinkProtect_loadscript() {
   wp_register_script( 'AffiliateLinkProtect', plugin_dir_url( __FILE__ ).'js/AffiliateLinkProtect.js', array("jquery"), filemtime(plugin_dir_path( __FILE__ ).'js/AffiliateLinkProtect.js'));
   wp_enqueue_script ( 'AffiliateLinkProtect' );
   }
   
function AffiliateLinkProtect_install() {}
register_activation_hook( __FILE__, 'AffiliateLinkProtect_install' );

function AffiliateLinkProtect_deactivation() {
   update_option( 'AffiliateLinkProtect_activation_date', "");
   update_option( 'AffiliateLinkProtect_remove_notice', "" );
   }
register_deactivation_hook( __FILE__, 'AffiliateLinkProtect_deactivation' );

function AffiliateLinkProtect_uninstall() {}
register_uninstall_hook(__FILE__, 'AffiliateLinkProtect_uninstall');
	
?>