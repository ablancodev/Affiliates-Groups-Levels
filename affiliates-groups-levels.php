<?php
/**
* affiliates-groups-levels.php
*
* Copyright (c) 2011,2012 Antonio Blanco http://www.blancoleon.com
*
* This code is released under the GNU General Public License.
* See COPYRIGHT.txt and LICENSE.txt.
*
* This code is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This header and all notices must be kept intact.
*
* @author Antonio Blanco
* @package affiliates-groups-levels
* @since affiliates-groups-levels 1.0
*
* Plugin Name: Affiliates Groups Levels
* Plugin URI: http://itthinx.com
* Description: Assign multi-tier levels according to the affiliate's group.
* Author: eggemplo
* Version: 1.0
* Author URI: http://www.eggemplo.com
**/
class Affiliates_Groups_Level_Plugin {
public static function init() {
  add_action( 'init', array( __CLASS__, 'wp_init' ) );
}
public static function wp_init() {
  add_filter('option_aff_ent_n_tiers', array(__CLASS__, 'option_aff_ent_n_tiers'));
}
public static function option_ ( $value ) {
  $levels = array();
  $levels['Premium'] = 2;
  $levels['VIP'] = 3;

  $new_level = $value;
  if ( ! is_admin() ) {
    if (!class_exists("Affiliates_Service"))
      include_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' );
    $aff_id = Affiliates_Service::get_referrer_id();

    $user_id = affiliates_get_affiliate_user($aff_id);
    if ( $user_id ) {
      $user_groups = self::get_user_groups ( $user_id );
      if ( sizeof( $user_groups ) > 0 ) {
        $first_group = $user_groups[0];
        if ( isset( $levels[$first_group->name] ) ) {
          $new_level = $levels[$first_group->name];
        }
      }
    }
  }
  
  return $new_level;
}

}
Affiliates_Groups_Level::init();
?>
