<?php

/*
 * Creates the section, settings and the controls for the customizer
 */
function shoestrap_typography_customizer( $wp_customize ){
  
  $sections   = array();
  $sections[] = array( 'slug' => 'shoestrap_typography',        'title' => __( 'Typography', 'shoestrap' ),       'priority' => 7 );

  foreach( $sections as $section ){
    $wp_customize->add_section( $section['slug'], array( 'title' => $section['title'], 'priority' => $section['priority'] ) );
  }

  $settings   = array();
  
  // Color Settings
  $settings[] = array( 'slug' => 'shoestrap_text_color',                'default' => '' );
  $settings[] = array( 'slug' => 'shoestrap_link_color',                'default' => '#0088cc' );
  $settings[] = array( 'slug' => 'shoestrap_google_webfonts',           'default' => '' );
  $settings[] = array( 'slug' => 'shoestrap_webfonts_weight',           'default' => '400' );
  $settings[] = array( 'slug' => 'shoestrap_webfonts_character_set',    'default' => 'latin' );
  $settings[] = array( 'slug' => 'shoestrap_webfonts_assign',           'default' => 'all' );
  
  foreach( $settings as $setting ){
    $wp_customize->add_setting( $setting['slug'], array( 'default' => $setting['default'], 'type' => 'theme_mod', 'capability' => 'edit_theme_options' ) );
  }

  // Determine if the user is using the advanced builder or not
  $advanced_builder = get_option('shoestrap_advanced_compiler');
  // Turn off the advanced builder on multisite
  if ( is_multisite() && !is_super_admin() ) {
    $advanced_builder == '';
  }
  
  /*
   * Color Controls
   */
  $color_controls   = array();
  
  // Display the following controls only when user is NOT using the advanced controls
  if ( $advanced_builder != 1 ) {
    // Links Color
    $color_controls[] = array( 'setting' => 'shoestrap_link_color',             'label' => 'Links Color',                     'section' => 'colors',            'priority' => 3 );
    // Text Color
    $color_controls[] = array( 'setting' => 'shoestrap_text_color',             'label' => 'Text Color',                      'section' => 'colors',            'priority' => 2 );
  }
  
  /*
   * Dropdown (Select) Controls
   */
  $select_controls = array();
  // Assign Webfonts weight
  $select_controls[] = array( 'setting' => 'shoestrap_webfonts_weight',         'label' => 'Webfont weight:',                 'section' => 'shoestrap_typography',  'priority' => 2, 'choises' => array( '200' => __( '200', 'shoestrap' ), '300' => __( '300', 'shoestrap' ), '400' => __( '400', 'shoestrap' ), '600' => __( '600', 'shoestrap' ), '700' => __( '700', 'shoestrap' ), '800' => __( '800', 'shoestrap' ), '900' => __( '900', 'shoestrap' ) ) );
  // Assign Webfonts character set
  $select_controls[] = array( 'setting' => 'shoestrap_webfonts_character_set',  'label' => 'Webfont character set:',          'section' => 'shoestrap_typography',  'priority' => 3, 'choises' => array( 'cyrillic' => __( 'Cyrillic', 'shoestrap' ), 'cyrillic-ext' => __( 'Cyrillic Extended', 'shoestrap' ), 'greek' => __( 'Greek', 'shoestrap' ), 'greek-ext' => __( 'Greek Extended', 'shoestrap' ), 'latin' => __( 'Latin', 'shoestrap' ), 'latin-ext' => __( 'Latin Extended', 'shoestrap' ), 'vietnamese' => __( 'Vietnamese', 'shoestrap' ) ) ); 
  // Assign Webfonts to specific page elements
  $select_controls[] = array( 'setting' => 'shoestrap_webfonts_assign',         'label' => 'Apply Webfont to:',               'section' => 'shoestrap_typography',  'priority' => 4, 'choises' => array( 'sitename' => __( 'Site Name', 'shoestrap' ), 'headers' => __( 'Headers', 'shoestrap' ), 'all' => __( 'Everywhere', 'shoestrap' ) ) );
  
  // Text Controls
  $text_controls = array();
  // Google Webfonts (text, name of the webfont)
  $text_controls[]  = array( 'setting' => 'shoestrap_google_webfonts',    'label' => 'Google Webfont Name',         'section' => 'shoestrap_typography',  'priority' => 1 );

  foreach( $color_controls as $control ){
    $wp_customize->add_control( new WP_Customize_Color_Control(
      $wp_customize,
      $control['setting'],
      array(
        'label'     => __( $control['label'], 'shoestrap' ),
        'section'   => $control['section'],
        'settings'  => $control['setting'],
        'priority'  => $control['priority'],
      )
    ));
  }

  foreach ( $select_controls as $control ) {
    $wp_customize->add_control( $control['setting'], array(
      'label'       => __( $control['label'], 'shoestrap' ),
      'section'     => $control['section'],
      'settings'    => $control['setting'],
      'type'        => 'select',
      'priority'    => $control['priority'],
      'choices'     => $control['choises']
    ));
  }

  foreach ( $text_controls as $control) {
    $wp_customize->add_control( $control['setting'], array(
      'label'       => __( $control['label'], 'shoestrap' ),
      'section'     => $control['section'],
      'settings'    => $control['setting'],
      'type'        => 'text',
      'priority'    => $control['priority']
    ));
  }
}
add_action( 'customize_register', 'shoestrap_typography_customizer' );
