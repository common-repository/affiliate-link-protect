<?php

add_action('admin_menu', 'AffiliateLinkProtect_menu');
add_action('admin_init', 'AffiliateLinkProtect_settings' );
add_action('admin_init', 'AffiliateLinkProtect_ask_user_to_give_review');   

function AffiliateLinkProtect_ask_user_to_give_review()
   {   
   $install_date = get_option( 'AffiliateLinkProtect_activation_date' );
   if(empty($install_date))
      {
      update_option( 'AffiliateLinkProtect_activation_date' ,strtotime( "now" ));
   	  $install_date = get_option( 'AffiliateLinkProtect_activation_date' );
	  }
   $past_date = strtotime( '-1 days' );
   $optn = get_option('AffiliateLinkProtect_remove_notice');
   if ( $past_date >= $install_date && empty($optn) ) { 
      add_action( 'admin_notices', 'AffiliateLinkProtect_review_admin_notice' );
      }
   }
   
function AffiliateLinkProtect_review_admin_notice() {
    echo '<div class="updated">'; 
    $reviewurl = 'https://wordpress.org/support/plugin/affiliate-link-protect/reviews#new-post';
    $nobugurl = get_admin_url() . '?AffiliateLinkProtect_remove_notice=1';
    printf(__( "You have been using <span style='color:#cc0000;font-weight:bold;'>Affiliate Link Protect</span> for a while ... do you like it? If so, please <span style='color:#cc0000;font-weight:bold;'>leave us a review</span> with your feedback! <a href='%s' target='_blank'>Leave A Review</a> <I><a style='margin-left:5px' href='%s'>already Done</a></I>", 'affiliate-link-protect'), $reviewurl , $nobugurl ); 
    echo "</div>";
    }	  

function AffiliateLinkProtect_remove_review_notice() {
    $nobug = "";
    if (isset( $_GET['AffiliateLinkProtect_remove_notice'] ) ) {
       $nobug = esc_attr( $_GET['AffiliateLinkProtect_remove_notice'] );
       }
    if (1 == $nobug ) {
       update_option( 'AffiliateLinkProtect_remove_notice', "1" );
       }
}
add_action( 'admin_init', 'AffiliateLinkProtect_remove_review_notice', 5 );
	
	
// Admin Configuration Page
function AffiliateLinkProtectAdminPage(){

       update_option( 'AffiliateLinkProtect_remove_notice', "" );

echo '
<div class="wrap">
<h1>Affiliate Link Protect</h1>
<P>'.__( 'Hide your affiliate parameters from all links on your blog!', 'affiliate-link-protect').'</P>
<P>'.__( 'To become more specific you may use the following fields:', 'affiliate-link-protect').'</P>
<form method="post" action="options.php" novalidate="novalidate">
';
settings_fields( 'AffiliateLinkProtect' );
do_settings_sections( 'AffiliateLinkProtect' );
echo '<table class="form-table">
   <tr>
      <th scope="row"><label for="alp_param">'.__( 'Parameter for recognition', 'affiliate-link-protect').'</label></th>
	  <td><input name="alp_param" type="text" id="alp_param" value="'.esc_attr( get_option('alp_param') ).'" class="regular-text" placeholder="param1" />
      <p class="description" id="alp_param-description">'.__( 'Add this parameter (e.g. "&alp=1") to specific links that shall be protected.', 'affiliate-link-protect').'</p></td>
	  </td>
   </tr>
   <tr>
      <th scope="row"><label for="alp_elimi_paras">'.__( 'Parameters to hide', 'affiliate-link-protect').'</label></th>
      <td><input name="alp_elimi_paras" type="text" id="alp_elimi_paras" value="'.esc_attr( get_option('alp_elimi_paras') ).'" placeholder="param1, param2, param3" class="regular-text"/>
      <p class="description" id="alp_elimi_paras-description">'.__( 'comma separated list of parameters to hide - leave empty to hide all parameters', 'affiliate-link-protect').'</p></td>
   </tr>
</table>
';
submit_button();
echo '
</form>   
<P><strong>'.__( 'How it works', 'affiliate-link-protect').'</strong></P>
<P>'.__( 'When a blog page is displayed this plugin saves specific links in the page to memory and displays the urls on "mouse over" without parameters.', 'affiliate-link-protect').'</P>
<P>'.__( 'As soon as a link is clicked the user is directed to the internally saved link including all parameters', 'affiliate-link-protect').'.</P>
</div>
';
   }

function AffiliateLinkProtect_settings () {
  register_setting( 'AffiliateLinkProtect', 'alp_param' );
  register_setting( 'AffiliateLinkProtect', 'alp_elimi_paras' );
  register_setting( 'AffiliateLinkProtect', 'alp_count' );
  }

function AffiliateLinkProtect_menu(){
   add_options_page( 'Affiliate Link Protect', 'Affiliate Link Protect', 'manage_options', 'AffiliateLinkProtect', 'AffiliateLinkProtectAdminPage');
   }
?>