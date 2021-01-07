<?php
function corporate_blue_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
                  
                  $form['search_block_form']['#attributes']['placeholder'] = t('Search');
                  $form['actions']['submit']['#value'] = ''; // Change the text on the submit button
                  $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search_icon.png');
                  /*$form['search_block_form']['#value'] = t('Search');
                  $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search';this.style.color='#9F9F9F'}";
                  $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search') {this.value = '';this.style.color='black'}";*/
  
  }
}


function corporate_blue_preprocess_comment(&$vars) {
	$theme_path = drupal_get_path('theme', variable_get('theme_default', NULL));
  $vars['submitted'] = $vars['created'] ;
   $vars['default_photo'] = '<img src="' . base_path( ) . $theme_path . '/images/default.png" />';
}
function corporate_blue_preprocess_page(&$vars) {
  // Useful for devel default banners, remove before commit
  //   variable_del('theme_marinelli_first_install');
  // Chcek if is first setup of marinelli and install banners.
  if (variable_get('theme_corporate_blue_first_install', TRUE)) {
    include_once('theme-settings.php');
    _corporate_blue_install();
  }

  //to print the banners
  $banners = corporate_blue_show_banners();
  $vars['banner'] = $banners;
  if(drupal_is_front_page()){
    drupal_add_js(path_to_theme() .'/js/slide.js', 'file');
    
  }
}

/**
 *
 * @return <array>
 *    html markup to show banners
 */
function corporate_blue_show_banners() {
  $banners = corporate_blue_get_banners(FALSE);
  $output = ' <div id="orbitDemo">';
  for($i=0;$i<count($banners);$i++){
  /*  $output .= '<a href="' . $banners[$i]['image_url'] . '" >';
    $output .= '<img src="' . file_create_url($banners[$i]['image_path']) . '" >';
    $output .= '</a>'; */ 
    $output .= l('<img class="img-sl" src="' . file_create_url($banners[$i]['image_path']) . '" alt="slider image' . $i . '" />', $banners[$i]['image_url'],array('html' => TRUE));
  }  
  $output .= '</div>';
  return $output;
}


/**
 * Get banner settings.
 *
 * @param <bool> $all
 *    Return all banners or only active.
 *
 * @return <array>
 *    Settings information
 */
function corporate_blue_get_banners($all = TRUE) {
  // Get all banners
  $banners = variable_get('theme_corporate_blue_banner_settings', array());
  // Create list of banner to return
  $banners_value = array();
  foreach ($banners as $banner) {     
      $banners_value[] = $banner;   
  }
  // Sort image by weight
  //usort($banners_value, 'drupal_sort_weight');
  return $banners_value;
}

/**
 * Set banner settings.
 *
 * @param <array> $value
 *    Settings to save
 */
function corporate_blue_set_banners($value) {
  variable_set('theme_corporate_blue_banner_settings', $value);
}

