<?php
/**
 * Functions
 */

/**
 * Included Files
 ***********************************************************************************************************************/

// Load custom WordPress nav walker.
require get_template_directory() . '/includes/core/bootstrap-navwalker.php';
// Load custom WordPress pagination.
require get_template_directory() . '/includes/core/bootstrap-pagination.php';
// Load ACF Functions
require get_template_directory() . '/includes/register-post.php';

require get_template_directory() . '/includes/acf/acf-functions.php';


add_theme_support( 'post-thumbnails' ); // для всех типов постов





function my_update_jquery () {
    if ( !is_admin() ) {
        wp_deregister_script('jquery');
        // wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, false, true);
        wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'my_update_jquery');

function my_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {
  $new_title = '<span>';
  $image = file_exists(get_template_directory() . '/assets/redesign/img/admin-acf/page_flex-'.$layout['name'].'.png');

  if($image) {
    $new_title = '<span class="acfe-layout-title__thumbnail"><img src="'.get_stylesheet_directory_uri().'/assets/redesign/img/admin-acf/page_flex-'.$layout['name'].'.png" />';
  }
  
  $new_title .= $title;
  $new_title .= '</span>';
  
  return $new_title;
}
add_filter('acf/fields/flexible_content/layout_title/name=page_flex', 'my_acf_fields_flexible_content_layout_title', 10, 4);

function enqueue_admin_custom_css(){
  wp_enqueue_style( 'admin-custom', get_stylesheet_directory_uri() . '/assets/redesign/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_custom_css' );


/**
 * Enqueue Scripts and Styles for Front-End
 ***********************************************************************************************************************/


function mythemename_all_scriptsandstyles() {
// Load JS and CSS files in here
  global $this_page_styles;
  global $this_page_scripts;
  
  if (!empty($this_page_scripts)) {
    foreach ($this_page_scripts as $handle => $src) {
        if(!strstr($src, 'http')) {
            $uri = get_theme_file_uri($src);
            $vsn = filemtime(get_theme_file_path($src));
        } else {
            $uri = $src;
            $vsn = '';
        }
      if($src) {
        wp_enqueue_script($handle, $uri, array(), $vsn, true);
      } else {
        wp_enqueue_script($handle);
      }
    }
  }
  if (!empty($this_page_styles)) {
    foreach ($this_page_styles as $handle => $src) {
        if(!strstr($src, 'http')) {
            $uri = get_theme_file_uri($src);
            $vsn = filemtime(get_theme_file_path($src));
        } else {
            $uri = $src;
            $vsn = '';
        }
      wp_enqueue_style($handle, $uri, array(), $vsn, 'all');
    }
  }
}

add_action( 'wp_enqueue_scripts', 'mythemename_all_scriptsandstyles' );

function bootstrap_scripts()
{
    wp_enqueue_script('jquery', esc_url(get_template_directory_uri()) . '/dist/query-3.6.0.min.js', '', '', false);
    wp_enqueue_script('jquery-migrate', esc_url(get_template_directory_uri()) . '/src/js/partials/jquery-migrate-3.3.2.min.js', '', '', true);
    wp_enqueue_script('jquery.mmenu.all.js', esc_url(get_template_directory_uri()) . '/dist/mmenu/jquery.mmenu.all.js', '', '', true);
  
    wp_enqueue_script('maskedinput', esc_url(get_template_directory_uri()) . '/dist/mask/jquery.maskedinput.min.js', '', '', true);
    
    wp_enqueue_script('nouislider-js', esc_url(get_template_directory_uri()) . '/dist/noUiSlider/dist/nouislider.min.js', '', '', true);
    wp_enqueue_script('wnumb-js', esc_url(get_template_directory_uri()) . '/dist/wnumb/wNumb.min.js', '', '', true);
    global $isRedesignPage;
    if($isRedesignPage || is_404()){
        return;
    }
    wp_enqueue_script('bootstrap.js', esc_url(get_template_directory_uri()) . '/js/bootstrap.js', '', '', true);

    wp_enqueue_script('carousel.js', esc_url(get_template_directory_uri()) . '/js/owl.carousel.min.js', '', '', true);

    wp_enqueue_script('popper', esc_url(get_template_directory_uri()) . '/dist/bootstrap/js/popper.min.js', '', '', true);

    wp_enqueue_script('fancybox', esc_url(get_template_directory_uri()) . '/js/fancybox.umd.js', '', '', true);

    wp_enqueue_script('mCustomScrollbar', esc_url(get_template_directory_uri()) . '/dist/crollbar-plugin/jquery.mCustomScrollbar.js', '', '', true);

    


    wp_enqueue_script('marquee', esc_url(get_template_directory_uri()) . '/js/jquery.marquee.min.js', '', '', true);



    wp_enqueue_script('AutoNumeric-js', esc_url(get_template_directory_uri()) . '/dist/autoNumeric.min.js', '', '', true);

/*    if (is_page_template('template/template-bank.php') || is_page_template('template/template-polzunok.php')) {
        wp_enqueue_script('nouislider-js', esc_url(get_template_directory_uri()) . '/dist/noUiSlider/dist/nouislider.min.js', '', '', true);
        wp_enqueue_script('wnumb-js', esc_url(get_template_directory_uri()) . '/dist/wnumb/wNumb.min.js', '', '', true);
        wp_enqueue_script('AutoNumeric-js', esc_url(get_template_directory_uri()) . '/dist/autoNumeric.min.js', '', '', true);
    }*/

     wp_enqueue_script('app-js', esc_url(get_template_directory_uri()) . '/js/app.js', '', '', true);
}
add_action('wp_enqueue_scripts', 'bootstrap_scripts');


function enqueue_custom_script() {
  global $isRedesignPage;
  if($isRedesignPage || is_404()){
    return;
  }
    if (is_page_template('template/template-bank.php')) {
        // Подключаем скрипт только для шаблона "custom-template.php"
        wp_enqueue_script('ajax-filters', esc_url(get_template_directory_uri()) . '/js/custom-ajax-filter.js', '', '', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');


add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
    global $isRedesignPage;
  
    wp_enqueue_style('mmenu', get_template_directory_uri() . '/dist/mmenu/jquery.mmenu.all.css', [], '', 'all');
    wp_enqueue_style('nouislider_css', get_template_directory_uri() . '/dist/noUiSlider/dist/nouislider.min.css', [], '', 'all');
    
    if($isRedesignPage || is_404()){
        return;
    }
    wp_enqueue_style('bank_compare', get_template_directory_uri() . '/static/css/modules/bank_compare/bank_compare.css', [], '', 'all');
    wp_enqueue_style('mCustomScrollbar.scss', get_template_directory_uri() . '/dist/crollbar-plugin/jquery.mCustomScrollbar.min.css', [], '', 'all');
    wp_enqueue_style('nice-select', get_template_directory_uri() . '/dist/jquery-nice-select/css/nice-select.css', [], '', 'all');
    wp_enqueue_style('jquery-nice-select', get_template_directory_uri() . '/dist/jquery-nice-select/css/style.css', [], '', 'all');
    wp_enqueue_style('icomoon', get_template_directory_uri() . '/static/fonts/icomoon/style.css', [], '', 'all');
    wp_enqueue_style('fontello', get_template_directory_uri() . '/static/fonts/fontello/css/fontello.css', [], '', 'all');
    wp_enqueue_style('fonts', get_template_directory_uri() . '/static/fonts/qanelas-cufonfonts-webfont/style.css', [], '', 'all');
    wp_enqueue_style('OwlCarousel', get_template_directory_uri() . '/dist/OwlCarousel/dist/assets/owl.carousel.min.css', [], '', 'all');
    wp_enqueue_style('OwlCarousel_default', get_template_directory_uri() . '/dist/OwlCarousel/dist/assets/owl.theme.default.min.css', [], '', 'all');
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/dist/fancybox/dist/fancybox.css', [], '', 'all');





    wp_enqueue_style('main', get_template_directory_uri() . '/static/css/main.min.css?v=1.1.1.15', [], '', 'all');

    wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css?v=1.1.1.8', [], '', 'all');
}


/************************************ PUT YOU FUNCTIONS BELOW **********************************************************/


// suproi_script
function suproi_script() {
    // Register the script
    wp_register_script('suproi-script', 'https://cdn.volsor.com/suproi-static/tracking.js', array(), null, true);

    // Enqueue the script
    wp_enqueue_script('suproi-script');
}

add_action('wp_enqueue_scripts', 'suproi_script');
// suproi_script


register_nav_menus(array(
    'header-menu'    => 'header-menu',    //Название месторасположения меню в шаблоне
));

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {
    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Add parent.
        $parent = acf_add_options_page(array(
            'page_title'  => __('Theme General Settings'),
            'menu_title'  => __('Theme Settings'),
            'redirect'    => false,
        ));



        $child = acf_add_options_page(array(
            'page_title'  => __('Insurance Post '),
            'menu_title'  => __('Insurance Post '),
            'parent_slug' => $parent['menu_slug'],
        ));

        $child = acf_add_options_page(array(
            'page_title'  => __('Footer Settings'),
            'menu_title'  => __('Footer'),
            'parent_slug' => $parent['menu_slug'],
        ));
    }
}

function wpb_custom_new_menu() {
    register_nav_menu('header-menu',__( 'Main menu' ));
    register_nav_menu('mobile-menu',__( 'Mobile menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
function my_wp_nav_menu_objects( $items, $args ) {
    // loop
    foreach( $items as &$item ) {
        // vars
        $icon = get_field('icon', $item);
        // append icon
        if( $icon ) {
            $item->title = '<span class="menu_iacon"><img src="'.$icon.'"alt="icon"> </span>' .$item->title;
        }
    }
    // return
    return $items;
}

/*  if (is_user_logged_in()) {
    show_admin_bar(false);
}*/

add_filter( 'facetwp_facet_dropdown_show_counts', '__return_false' );
add_filter( 'facetwp_result_count', function( $output, $params ) {
    $output =  ' &nbsp ' . $params['upper'] . ' z ' . $params['total'] . ' ';
    return $output;
}, 10, 2 );




add_action( 'wp_head', function() {
    ?>
    <script>
    </script>
    <?php
}, 100 );



// Добавляем скрипты и стили
function enqueue_custom_scripts() {
  global $isRedesignPage;
	

  if($isRedesignPage || is_404()){
    return;
  }
    // Подключаем библиотеку noUiSlider


    // Передаем URL для Ajax-запросов в скрипт
    wp_localize_script('custom-ajax-filter', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');






function custom_rewrite_rules() {
    add_rewrite_rule('^ajax-filter/page/([0-9]+)/?', 'index.php?pagename=ajax-filter&paged=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_rules');










function filter_banks() {
// Получаем значения минимальной и максимальной суммы из запроса и удаляем запятые
    $min_amount = str_replace(' ', '', $_POST['min_amount']);
    $max_amount = str_replace(' ', '', $_POST['max_amount']);

// Преобразуем их обратно в числа
    $min_amount = intval($min_amount);
    $max_amount = intval($max_amount);
    $selected_category = sanitize_text_field($_POST['selected_category']);



    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'bank',
        'posts_per_page' => 10, // Задайте количество постов на странице
        'paged' => $paged, // Устанавливаем текущую страницу
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'single_loan_amount_max',
                'value' => $min_amount,
                'type' => 'NUMERIC',
                'compare' => '>=',
            ),
            array(
                'key' => 'single_loan_amount_max',
                'value' => $max_amount,
                'type' => 'NUMERIC',
                'compare' => '<=',
            ),
        ),
    );

    if ($selected_category !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'bank_category',
                'field' => 'slug',
                'terms' => $selected_category,
            ),
        );
    }

    $query = new WP_Query($args);





    if ($query->have_posts()) {
        ob_start(); // Начинаем буферизацию вывода
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/ajax-template'); // Вставляем ваш шаблон
        }
        $posts = ob_get_clean(); // Получаем HTML постов
        $pagination = paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'prev_text' => __('Předchozí', 'textdomain'), // Текст для предыдущей страницы
            'next_text' => __('Další', 'textdomain'), // Текст для следующей страницы
        ));

        echo json_encode(array('posts' => $posts, 'pagination' => $pagination)); // Возвращаем JSON с постами и пагинацией
    } else {
        echo json_encode(array('posts' => 'Litujeme, vašim kritériím neodpovídají žádné příspěvky.', 'pagination' => '')); // Возвращаем JSON с сообщением об отсутствии банков
    }

    die();





}
add_action('wp_ajax_filter_banks', 'filter_banks');
add_action('wp_ajax_nopriv_filter_banks', 'filter_banks');
function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
    return '+420' . substr($phoneNumber, -9);;
}
function create_pipedrive_user($name, $phone, $email, $api_key) {
    $curl = curl_init();
    
    $data = [
        "name" => $name,
        "email" => [
            [
                "value"=> $email
            ]
        ],
        "phone"=> [
            [
                "value"=> $phone
            ]
        ]
    ];
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.pipedrive.com/v1/persons?api_token='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Cookie: __cf_bm=eHbpd.5OkVAyBw.a8ZbwYmSgK38MFvXKfUShGHCQLNs-1689103387-0-AeeK6C9ZVUnhpSBBqAexc85Y7jgQA/j8IttxWRY/AmUzgcoAYD8v4ljzN81xsvDtVLtalUUn5IMP3wPukZv8wOE='
        ),
    ));
    
    $response = curl_exec($curl);
    
    
    curl_close($curl);
    $response = json_decode($response);
    return $response->data->id;
    
}
function call_request(){
    $api_key = 'c337eaa624e07c72b3a296bb8b83f7e8be2bfa17';
    $pipeline_id = 21;
    $name = 'Callback person';
    $phone = formatPhoneNumber(sanitize_text_field($_POST['phone']));
    $email = '';
    if(!$phone){
        return;
    }
    
    
    $person_id = create_pipedrive_user($name,$phone,$email,$api_key);
    
    
    $pipedrive_field = [
        "title" => 'Callback request - ' . $phone,
        "person_id" => $person_id,
        "pipeline_id" => $pipeline_id,
    ];
    
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.pipedrive.com/v1/deals?api_token='.$api_key,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($pipedrive_field),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
        ),
    ));
    
    $response = curl_exec($curl);
    
    wp_send_json_success($response);
}
add_action('wp_ajax_call_request', 'call_request');
add_action('wp_ajax_nopriv_call_request', 'call_request');


function contact_request(){
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $tel = sanitize_text_field($_POST['tel']);
    $message = sanitize_text_field($_POST['message']);
    
    $required_text = 'Toto pole je povinné';
    $required = [
      [
        'name' => 'first_name',
        'value' => $first_name
      ],
      [
        'name' => 'last_name',
        'value' => $last_name
      ],
      [
        'name' => 'tel',
        'value' => $tel
      ],
    ];
    $errors = [];
    
    foreach ($required as $required_field){
      if(!$required_field['value']){
        $errors[$required_field['name']] = $required_text;
      }
    }
    
    if($errors){
      wp_send_json_error(['errors'=>$errors], 300);
      return;
    }
    
    $to = 'p.tuma@sjednej.cz';//get_option( 'admin_email' );
    $subject = 'Contact request';
    $headers = 'From: no_reply@sjednej.cz' . "\r\n";
    $email_message = 'Name: ' . $first_name . ' ' . $last_name . "\r\n";
    $email_message .= 'Phone: ' . $tel . "\r\n";
    $email_message .= 'Message: ' . "\r\n";
    $email_message .= $message;
    
    $sent = wp_mail($to, $subject, $email_message, $headers);
    
    
    wp_send_json_success(['success'=>$sent]);
}
add_action('wp_ajax_contact_request', 'contact_request');
add_action('wp_ajax_nopriv_contact_request', 'contact_request');



function careers_request(){
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_text_field($_POST['email']);
    $tel = sanitize_text_field($_POST['tel']);
    $position = sanitize_text_field($_POST['position']);
    
    $required_text = 'Toto pole je povinné';
    $required = [
      [
        'name' => 'first_name',
        'value' => $first_name
      ],
      [
        'name' => 'last_name',
        'value' => $last_name
      ],
      [
        'name' => 'email',
        'value' => $email
      ],
      [
        'name' => 'tel',
        'value' => $tel
      ],
      [
        'name' => 'position',
        'value' => $position
      ],
    ];
    $errors = [];
    $attachments = [];
    
    foreach ($required as $required_field){
      if(!$required_field['value']){
        $errors[$required_field['name']] = $required_text;
      }
    }
    if (isset($_FILES["file"])) {
      $uploadedfile = $_FILES['file'];
      $filepath = $uploadedfile['tmp_name'];
      $fileSize = filesize($filepath);
      $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
      $filetype = finfo_file($fileinfo, $filepath);
      $allowedTypes = [
        'text/plain' => 'txt',
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
      ];
  
      if ($fileSize === 0) {
        $errors['file'] = 'Toto pole je neplatné';
      }
      if ($fileSize > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
        $errors['file'] = 'Maximální velikost souboru je 3mb';
      }
      if (!in_array($filetype, array_keys($allowedTypes))) {
        $errors['file'] = 'Přípustné koncovky: .pdf, .docx, .doc, .txt';
      }
      
      $overrides = ['test_form' => false];
      $movefile = wp_handle_upload($uploadedfile, $overrides);
  
      if(!$movefile || isset($movefile['error'])){
        $errors['file'] = $movefile['error'];
      }
      
      $attachments = [$movefile['file']];
    }
    
    if($errors){
      wp_send_json_error(['errors'=>$errors], 300);
      return;
    }
    
    $to = 'p.tuma@sjednej.cz';//get_option( 'admin_email' );
    $subject = 'Careers request';
    $headers = 'From: no_reply@sjednej.cz' . "\r\n";
    $email_message = 'Name: ' . $first_name . ' ' . $last_name . "\r\n";
    $email_message .= 'Phone: ' . $tel . "\r\n";
    $email_message .= 'Email: ' . $email . "\r\n";
    $email_message .= 'Position: ' . $position . "\r\n";
    
    $sent = wp_mail($to, $subject, $email_message, $headers, $attachments);
    
    if($attachments) {
      unlink($attachments[0]);
    }
    wp_send_json_success(['success'=>$sent]);
}
add_action('wp_ajax_careers_request', 'careers_request');
add_action('wp_ajax_nopriv_careers_request', 'careers_request');


function leave_review(){
    wp_send_json_success(['success'=>true]);
}
add_action('wp_ajax_leave_review', 'leave_review');
add_action('wp_ajax_nopriv_leave_review', 'leave_review');



add_filter('wpcf7_autop_or_not', '__return_false');









/** fixes values based on term slugs to be numberic by looking up term name **/
add_filter( 'facetwp_index_row', function( $params, $class ) {
    $term_id = (int) $params['term_id'];
    $value = $params['facet_value'];

    if ( 0 < $term_id && in_array( $class->facet['type'], [ 'number_range', 'slider' ] ) && !is_numeric( $value ) ) {
        // lookup term name
        $term = get_term( $term_id );
        if ( !empty( $term ) ) {
            $params['facet_value'] = $term->name;
        }
    }

    return $params;
}, 11, 2 );






function custom_phone_validation($result,$tag){

    $type = $tag->type;
    $name = $tag->name;

    if($type == 'tel' || $type == 'tel*'){

        $phoneNumber = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';

        $phoneNumber = preg_replace('/[() .+-]/', '', $phoneNumber);
        if (strlen((string)$phoneNumber) != 12) {
            $result->invalidate( $tag, 'Please enter a valid phone number.' );
        }
    }
    return $result;
}
add_filter('wpcf7_validate_tel','custom_phone_validation', 10, 2);
add_filter('wpcf7_validate_tel*', 'custom_phone_validation', 10, 2);



add_filter( 'facetwp_shortcode_html', function( $output, $atts) {
    if ( $atts['template'] = 'tag_post' ) { // replace 'example' with name of your template

        $output = str_replace( 'class="facetwp-template"', 'id="masonry-container" class="facetwp-template row"', $output );
    }
    return $output;
}, 10, 2 );


function misha_add_column( $columns ){
    $columns['misha_post_id_clmn'] = 'ID'; // $columns['Column ID'] = 'Column Title';
    return $columns;
}
add_filter('manage_posts_columns', 'misha_add_column', 5);
//add_filter('manage_pages_columns', 'misha_add_column', 5); // for Pages


/**
 * Fills the column content
 *
 * @param string $column ID of the column
 * @param integer $id Post ID
 */
function misha_column_content( $column, $id ){
    if( $column === 'misha_post_id_clmn')
        echo $id;
}
add_action('manage_posts_custom_column', 'misha_column_content', 5, 2);
//add_action('manage_pages_custom_column', 'misha_column_content', 5, 2); // for Pages



add_filter('site_transient_update_plugins', 'my_remove_update_nag');
function my_remove_update_nag($value) {
    unset($value->response[ 'advanced-custom-fields-pro/acf.php' ]);
    return $value;
}

function disable_search($query, $error = true) {
	if (is_search()) {
		$query->is_search = false;
		$query->query_vars['s'] = false;
		$query->query['s'] = false;

		// Přesměrovat na 404 stránku
		wp_redirect(home_url());
		exit;
	}
}

add_action('parse_query', 'disable_search');
add_filter('get_search_form', function($a) { return null; });


function custom_rank_math_breadcrumbs($crumbs) {

    if (is_home() || is_front_page() || is_404() || is_category()) {
        //return $crumbs;
		return [];
    }
	
	$post_type = get_post_type_object(get_post_type());
	$post_type_name = $post_type->labels->singular_name;
	$post_type_link = get_post_type_archive_link($post_type->name);

	if ($post_type_name != "Stránka" && $post_type_name != "Příspěvek") {
		$new_crumb = [
			[
				0 => $post_type_name,
				1 => $post_type_link,
				'hide_in_schema' => false
			]
		];

		array_splice($crumbs, 1, 0, $new_crumb);
	}


    return $crumbs;
}
add_filter('rank_math/frontend/breadcrumb/items', 'custom_rank_math_breadcrumbs');





if ( function_exists('register_sidebar') )

   register_sidebar(array(
        'name' => 'Имя сайтбара', // любое имя
        'id' => 'sidebar-1', // unikátní ID pro tento sidebar
        'before_widget' => '<div class="widget">', // то что стоит перед блоком виджета
        'after_widget' => '</div>', // то что стоит после блока виджета
        'before_title' => '<h3 class="title">', // стоит перед тайтлом
        'after_title' => '</h3>', // после тайтла
    ));




function create_slovnik_post_type() {
    $labels = array(
        'name'               => 'Slovník',
        'singular_name'      => 'Pojem',
        'menu_name'          => 'Slovník',
        'name_admin_bar'     => 'Slovník',
        'add_new'            => 'Přidat nový',
        'add_new_item'       => 'Přidat nový pojem',
        'new_item'           => 'Nový pojem',
        'edit_item'          => 'Upravit pojem',
        'view_item'          => 'Zobrazit pojem',
        'all_items'          => 'Všechny pojmy',
        'search_items'       => 'Hledat pojmy',
        'not_found'          => 'Žádné pojmy nenalezeny',
        'not_found_in_trash' => 'Žádné pojmy v koši',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'slovnik' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
		'menu_icon'          => 'dashicons-book',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'slovnik', $args );
}
add_action( 'init', 'create_slovnik_post_type' );

function create_kategorie_pojmu_taxonomy() {
    $labels = array(
        'name'              => 'Kategorie pojmů',
        'singular_name'     => 'Kategorie pojmu',
        'search_items'      => 'Hledat kategorie pojmů',
        'all_items'         => 'Všechny kategorie pojmů',
        'parent_item'       => 'Nadřazená kategorie pojmu',
        'parent_item_colon' => 'Nadřazená kategorie pojmu:',
        'edit_item'         => 'Upravit kategorii pojmu',
        'update_item'       => 'Aktualizovat kategorii pojmu',
        'add_new_item'      => 'Přidat novou kategorii pojmu',
        'new_item_name'     => 'Název nové kategorie pojmu',
        'menu_name'         => 'Kategorie pojmů',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'kategorie-pojmu' ),
    );

    register_taxonomy( 'kategorie_pojmu', array( 'slovnik' ), $args );
}
add_action( 'init', 'create_kategorie_pojmu_taxonomy' );


function create_produkty_post_type() {
    $labels = array(
        'name'               => 'Bannery',
        'singular_name'      => 'Banner',
        'menu_name'          => 'Bannery',
        'name_admin_bar'     => 'Banner',
        'add_new'            => 'Přidat nový',
        'add_new_item'       => 'Přidat nový banner',
        'new_item'           => 'Nový banner',
        'edit_item'          => 'Upravit banner',
        'view_item'          => 'Zobrazit banner',
        'all_items'          => 'Všechny bannery',
        'search_items'       => 'Hledat bannery',
        'not_found'          => 'Žádné bannery nenalezeny',
        'not_found_in_trash' => 'Žádné bannery v koši',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'produkty' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
		'menu_icon'          => 'dashicons-welcome-add-page',
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'produkty', $args );
}
add_action( 'init', 'create_produkty_post_type' );

function create_kategorie_produktu_taxonomy() {
    $labels = array(
        'name'              => 'Kategorie bannerů',
        'singular_name'     => 'Kategorie bannerů',
        'search_items'      => 'Hledat kategorie bannerů',
        'all_items'         => 'Všechny kategorie bannerů',
        'parent_item'       => 'Nadřazená kategorie bannerů',
        'parent_item_colon' => 'Nadřazená kategorie banneru:',
        'edit_item'         => 'Upravit kategorii banneru',
        'update_item'       => 'Aktualizovat kategorii banneru',
        'add_new_item'      => 'Přidat novou kategorii banneru',
        'new_item_name'     => 'Název nové kategorie banneru',
        'menu_name'         => 'Kategorie bannerů',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'kategorie-produktu' ),
    );

    register_taxonomy( 'kategorie_produktu', array( 'produkty' ), $args );
}
add_action( 'init', 'create_kategorie_produktu_taxonomy' );


function slovnik_definice_shortcode() {
   
	global $post;

    $definice = get_field('slovnik_definice', $post->ID);

    $output = '<div class="slovnik-definice">';
    $output .= '<div class="sharp"></div>';
    $output .= $definice;
    $output .= '</div>';

    return $output;
}
add_shortcode('slovnik_definice', 'slovnik_definice_shortcode');

function podobne_pojmy_shortcode($atts) {
    global $post;

    $podobne_pojmy = get_field('slovnik_podobne_pojmy', $post->ID);

	$output = '<div class="podobne-pojmy-container">';

    if (!$podobne_pojmy) {
        $output .= '<p>Nebyl nalezen žádný podobný pojem.</p>';
    } else {
		foreach ($podobne_pojmy as $pojem) {
			$output .= '<div class="podobny-pojem">';
			$output .= '<div class="pojem-content">';
			$output .= '<a href="'.get_permalink($pojem->ID).'">' . get_the_title($pojem->ID) . '</a>';
			$output .= '</div>';
			$output .= '</div>';
		}
	}
    
    $output .= '</div>';

    return $output;
}
add_shortcode('podobne_pojmy', 'podobne_pojmy_shortcode');

function produkt_box_shortcode($atts) {
	
    global $post;

    $produkt = get_field('slovnik_propojeni_s_produktem', $post->ID);
	
	if (!$produkt) {
		return;
	}
	
	$nadpis = get_field('slovnik_propojeni_s_produktem_nadpis', $post->ID);
	if (!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}
    $podnadpis = get_field('produkt_podnadpis', $produkt->ID);
    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);



    $output = '<div class="produkt-box">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
    if ($tlacitko1URL && $tlacitko1Text) {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
    if ($tlacitko2URL && $tlacitko2Text) {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('produkt_box', 'produkt_box_shortcode');

function banner_inside_shortcode($atts) {
   global $post;

    $produkt = get_field('slovnik_propojeni_s_produktem', $post->ID);
	
	if (!$produkt) {
		return;
	}
	
	$nadpis = get_field('slovnik_propojeni_s_produktem_nadpis', $post->ID);
	if (!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}
	
	$podnadpis = get_field('produkt_podnadpis', $produkt->ID);
	$tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
	$tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);

	$form_type_1 = get_field('banner_contact_form_type_1', $produkt->ID);
	$form_shortcode_1 = get_field('banner_contact_form_shortcode_1', $produkt->ID);

	$form_type_2 = get_field('banner_contact_form_type_2', $produkt->ID);
	$form_shortcode_2 = get_field('banner_contact_form_shortcode_2', $produkt->ID);

	$output = '<section class="produkt-box custom-form-wrapper banner-inside">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
	if ($tlacitko1URL && $tlacitko1Text && $form_type_1 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
	if ($tlacitko1Text && $form_type_1 == 'classic') {
        $output .= '<a class="produkt-button button button-primary" id="show-contact-form">' . esc_html($tlacitko1Text) . '</a>';
    }
	if ($form_shortcode_1 && $form_type_1 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_1);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }
	
	if ($tlacitko2URL && $tlacitko2Text && $form_type_2 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
	if ($tlacitko2Text && $form_type_2 == 'classic') {
        $output .= '<a class="produkt-button button button-secondary" id="show-contact-form">' . esc_html($tlacitko2Text) . '</a>';
    }
	if ($form_shortcode_2 && $form_type_2 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_2);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }
	
    $output .= '</div>';
    $output .= '</section>';

    return $output;
}
add_shortcode('banner_inside', 'banner_inside_shortcode');

function sticky_produkt_box_shortcode($atts) {
    global $post;

    // Získání propojeného produktu
    $produkt = get_field('slovnik_propojeni_s_produktem_sticky', $post->ID);

    if (!$produkt) {
        return '';
    }
	$nadpis = get_field('slovnik_propojeni_s_produktem_sticky_nadpis', $post->ID);
    $podnadpis = get_field('slovnik_propojeni_s_produktem_sticky_podnadpis', $post->ID);
   
	if (!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}
    if (!$podnadpis) {
		$podnadpis = get_field('produkt_podnadpis', $produkt->ID);
	}
    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);

    // HTML struktura pro výstup boxu
    $output = '<div class="sticky-produkt-box">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    if ($podnadpis) {
        $output .= $podnadpis;
    }
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
    if ($tlacitko1URL && $tlacitko1Text) {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
    if ($tlacitko2URL && $tlacitko2Text) {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('sticky_produkt_box', 'sticky_produkt_box_shortcode');


function custom_posts_shortcode($atts) {
 
    $atts = shortcode_atts(array(
        'posts_per_page' => -1,
    ), $atts);

    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => $atts['posts_per_page'],
    ));


    if (!$query->have_posts()) {
        return '';
    }


    $output = '<div class="custom-posts-container">';

    while ($query->have_posts()) {
        $query->the_post();
        $categories = get_the_category();
		$tags = get_the_tags();
        $category_list = '';
		$tag_list = '';
		/*
        foreach ($categories as $category) {
            $category_list .= '<span class="category-label">' . esc_html($category->name) . '</span> ';
        }
		*/
		if ($tags) {
            foreach ($tags as $tag) {
                $tag_list .= '<span class="tag-label">' . esc_html($tag->name) . '</span> ';
            }
        }
		
		 $formatted_date = get_the_date('j.n.Y');
		$excerpt = wp_trim_words(get_the_excerpt(), 24, '...');
		


        $output .= '<div class="custom-post">';
        if (has_post_thumbnail()) {
            $output .= '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
        }
        $output .= '<div class="post-content">';
        $output .= '<div class="post-date"><img src="'.home_url().'/wp-content/uploads/2024/07/Frame.svg"> ' . $formatted_date . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-title">' . get_the_title() . '</a>';
        $output .= '<div class="post-excerpt">' . $excerpt . '</div>';
        $output .= '<div class="post-categories">' . $tag_list . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-read-more"><span>Číst článek</span><img src="'.home_url().'/wp-content/uploads/2024/07/Icon.svg"></a>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';
	$output .= '<div class="buttons-bottom"><a href="/category/news">Další články</a><a>Hledat dle výrazu “úroková sazba”</a></div>';

    wp_reset_postdata();

    return $output;
}
add_shortcode('custom_posts', 'custom_posts_shortcode');




function custom_blog_posts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => 6, // 6
    ), $atts);

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : 'all';

    $offset = ($paged - 1) * $atts['posts_per_page'] + 1; // Adjust offset to skip the latest post

    $query_args = array(
        'post_type' => 'post',
        'posts_per_page' => $atts['posts_per_page'],
        'paged' => $paged,
        'offset' => $offset, // Add the offset to skip the latest post
    );

    if ($category != 'all') {
        $query_args['category_name'] = $category;
    }

    $query = new WP_Query($query_args);

    if (!$query->have_posts()) {
        return '<p>Žádné články nebyly nalezeny.</p>';
    }

    $output = '<div class="custom-posts-container">';

    while ($query->have_posts()) {
        $query->the_post();
        $categories = get_the_category();
        $tags = get_the_tags();
        $category_classes = '';

        if ($categories) {
            foreach ($categories as $category) {
                $category_classes .= ' ' . esc_attr($category->slug);
            }
        }

        $tag_list = '';
        if ($tags) {
            foreach ($tags as $tag) {
                $tag_list .= '<span class="tag-label">' . esc_html($tag->name) . '</span> ';
            }
        }

        $formatted_date = get_the_date('j.n.Y');
        $excerpt = wp_trim_words(get_the_excerpt(), 24, '...');

        $output .= '<div class="custom-post' . $category_classes . '">';
        if (has_post_thumbnail()) {
            $output .= '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
        }
        $output .= '<div class="post-content">';
        $output .= '<div class="post-date"><img src="' . home_url() . '/wp-content/uploads/2024/07/Frame.svg"> ' . $formatted_date . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-title">' . get_the_title() . '</a>';
        $output .= '<div class="post-excerpt">' . $excerpt . '</div>';
        $output .= '<div class="post-categories">' . $tag_list . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-read-more"><span>Číst článek</span><img src="' . home_url() . '/wp-content/uploads/2024/07/Icon.svg"></a>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';

    // Pagination
    $total_pages = $query->max_num_pages;
    if ($total_pages > 1) {
        $output .= '<div class="simple-buttons-bottom">';
        if ($paged > 1) {
            $prev_page = $paged - 1;
            $output .= '<a href="' . get_pagenum_link($prev_page) . '" class="prev-articles">Předchozí články</a>';
			$output .= '<a style="visibility: hidden;" class="next-articles">Další články</a>';
        }
        if ($paged < $total_pages) {
            $next_page = $paged + 1;
			$output .= '<a style="visibility: hidden;" class="prev-articles">Předchozí články</a>';
            $output .= '<a href="' . get_pagenum_link($next_page) . '" class="next-articles">Další články</a>';
        }
        $output .= '</div>';
    }

    wp_reset_postdata();

    return $output;
}
add_shortcode('custom_blog_posts', 'custom_blog_posts_shortcode');






function custom_breadcrumb() {
    // Získání URL domovské stránky
    $home_url = home_url();
    // Ikona domovské stránky (můžete použít jakoukoliv SVG nebo ikonu podle svého výběru)
    $home_icon = '<img src="' . esc_url($home_url. '/wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;">';

    // HTML struktura pro breadcrumb
    $breadcrumb = '<div class="custom-breadcrumb">';
    $breadcrumb .= '<a href="' . $home_url . '">' . $home_icon . '</a> &gt; ';
    $breadcrumb .= '<a href="' . $home_url . '/category/news">Blog</a> &gt; ';
    $breadcrumb .= '<a href="' . $home_url . '/slovnik">Slovník pojmů</a> &gt; ';
    $breadcrumb .= '<span>' . get_the_title() . '</span>';
    $breadcrumb .= '</div>';

    return $breadcrumb;
}
add_shortcode('custom_breadcrumb', 'custom_breadcrumb');

function custom_breadcrumb_dict() {
    // Získání URL domovské stránky
    $home_url = home_url();
    // Ikona domovské stránky (můžete použít jakoukoliv SVG nebo ikonu podle svého výběru)
    $home_icon = '<img src="' . esc_url($home_url. '/wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;">';

    // HTML struktura pro breadcrumb
    $breadcrumb = '<div class="custom-breadcrumb">';
    $breadcrumb .= '<a href="' . $home_url . '">' . $home_icon . '</a> &gt; ';
    $breadcrumb .= '<a href="' . $home_url . '/category/news">Blog</a> &gt; ';
    $breadcrumb .= '<a href="' . $home_url . '/slovnik">Slovník pojmů</a>';
    $breadcrumb .= '</div>';

    return $breadcrumb;
}
add_shortcode('custom_breadcrumb_dict', 'custom_breadcrumb_dict');

function custom_filter_search_shortcode() {
    $alphabet = range('A', 'Z');
    $output = '<div id="custom-filter-search">';
    $output .= '<div class="filter-tabs">';
    $output .= '<span class="filter-tab active" data-filter="alphabet">Abecedně</span>';
    $output .= '<span class="filter-tab" data-filter="search">Vyhledávat</span>';
    $output .= '</div>';
    $output .= '<div class="alphabet-filter">';
    foreach ($alphabet as $letter) {
        $output .= '<span class="alphabet-letter" data-letter="' . $letter . '">' . $letter . '</span>';
    }
    $output .= '</div>';
    $output .= '<div class="search-filter" style="display: none;">';
    $output .= '<input type="text" id="search-input" placeholder="Vyhledávat...">';
    $output .= '</div>';
    $output .= '<div id="filter-results">' . do_shortcode('[alphabetical_terms]') . '</div>';
    $output .= '<div id="no-results-message" style="display:none;">Žádné výsledky nenalezeny.</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('custom_filter_search', 'custom_filter_search_shortcode');


/*
function alphabetical_terms_shortcode() {
    // Fetch terms from the custom post type 'slovnik'
    $args = array(
        'post_type' => 'slovnik',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );

    $query = new WP_Query($args);

    // Begin output buffering
    ob_start();

    $terms = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title();
            $normalized_title = remove_diacritics($title);
            $first_letter = strtoupper(mb_substr($normalized_title, 0, 1));
            if (!isset($terms[$first_letter])) {
                $terms[$first_letter] = [];
            }
            $terms[$first_letter][] = array('title' => $title, 'link' => get_permalink());
        }
    }

    // Restore original post data
    wp_reset_postdata();

    // Generate the output
    $alphabet = range('A', 'Z');
    foreach ($alphabet as $letter) {
        echo '<div class="terms-section">';
        echo '<div class="section-header">' . $letter . '</div>';
        echo '<div class="terms-columns">';

        if (!empty($terms[$letter])) {
            $chunks = array_chunk($terms[$letter], ceil(count($terms[$letter]) / 4));
            foreach ($chunks as $chunk) {
                echo '<div class="terms-column">';
                foreach ($chunk as $term) {
                    echo '<a href="' . esc_url($term['link']) . '" class="term-item">' . esc_html($term['title']) . '</a>';
                }
                echo '</div>';
            }
        } else {
            echo '<div class="terms-column"><div class="term-item">Žádné termíny</div></div>';
        }

        echo '</div>';
        echo '</div>';
    }

    // Return the buffered content
    return ob_get_clean();
}

// Function to remove diacritics from a string
function remove_diacritics($string) {
    return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
}

// Register the shortcode
add_shortcode('alphabetical_terms', 'alphabetical_terms_shortcode');
*/

function alphabetical_terms_shortcode() {
    // Načti termíny z vlastního typu příspěvku 'slovnik'
    $args = array(
        'post_type' => 'slovnik', // Definice vlastního typu příspěvku
        'posts_per_page' => -1, // Načti všechny příspěvky
    );

    $query = new WP_Query($args); // Vytvoř nový dotaz

    // Začni output buffering
    ob_start();

    $terms = []; // Inicializace pole pro termíny

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $title = get_the_title(); // Získej název příspěvku
            $normalized_title = remove_diacritics($title); // Normalizuj název bez diakritiky pro určení prvního písmeno
            $first_letter = strtoupper(mb_substr($normalized_title, 0, 1)); // Získej první písmeno názvu
            if (!isset($terms[$first_letter])) {
                $terms[$first_letter] = []; // Inicializace pole pro první písmeno
            }
            $terms[$first_letter][] = array('title' => $title, 'link' => get_permalink()); // Přidej termín do pole
        }
    }

    // Obnov původní data příspěvků
    wp_reset_postdata();

    // Seřadit termíny uvnitř každého písmene
    foreach ($terms as $letter => &$terms_array) {
        usort($terms_array, function($a, $b) {
            $collator = collator_create('cs_CZ'); // Nastavení české lokalizace pro řazení
            return $collator->compare($a['title'], $b['title']);
        });
    }

    // Generuj výstup
    $alphabet = range('A', 'Z'); // Vytvoř pole s písmeny abecedy
    foreach ($alphabet as $letter) {
        echo '<div class="terms-section">';
        echo '<div class="section-header">' . $letter . '</div>'; // Záhlaví sekce s písmenem
        echo '<div class="terms-columns">';

        if (!empty($terms[$letter])) {
            $chunks = array_chunk($terms[$letter], ceil(count($terms[$letter]) / 4)); // Rozděl termíny do 4 sloupců
            foreach ($chunks as $chunk) {
                echo '<div class="terms-column">';
                foreach ($chunk as $term) {
                    echo '<a href="' . esc_url($term['link']) . '" class="term-item">' . esc_html($term['title']) . '</a>'; // Vypiš každý termín jako odkaz
                }
                echo '</div>';
            }
        } else {
            echo '<div class="terms-column"><p>Žádné termíny</p></div>'; // Pokud nejsou termíny, vypiš zprávu
        }

        echo '</div>';
        echo '</div>';
    }

    // Vrátí obsah bufferu
    return ob_get_clean();
}

// Funkce pro odstranění diakritiky
function remove_diacritics($string) {
    $normalizeChars = array(
        'á'=>'a', 'č'=>'c', 'ď'=>'d', 'é'=>'e', 'ě'=>'e', 'í'=>'i', 'ň'=>'n', 'ó'=>'o', 'ř'=>'r', 'š'=>'s', 'ť'=>'t', 'ú'=>'u', 'ů'=>'u', 'ý'=>'y', 'ž'=>'z',
        'Á'=>'A', 'Č'=>'C', 'Ď'=>'D', 'É'=>'E', 'Ě'=>'E', 'Í'=>'I', 'Ň'=>'N', 'Ó'=>'O', 'Ř'=>'R', 'Š'=>'S', 'Ť'=>'T', 'Ú'=>'U', 'Ů'=>'U', 'Ý'=>'Y', 'Ž'=>'Z'
    );
    return strtr($string, $normalizeChars);
}

// Registrace krátkého kódu
add_shortcode('alphabetical_terms', 'alphabetical_terms_shortcode');






function set_custom_post_title($post_id) {
    // Zabránit nekonečné smyčce
    remove_action('save_post', 'set_custom_post_title');
    
    // Získejte hodnotu pole ACF
    $custom_title = get_field('slovnik_nadpis', $post_id);
    
    // Zkontrolujte, zda má pole hodnotu
    if ($custom_title) {
        // Aktualizujte název příspěvku a URL (slug)
        $post_data = array(
            'ID' => $post_id,
            'post_title' => $custom_title,
            'post_name' => sanitize_title($custom_title) // Nastavení URL (slug)
        );
        wp_update_post($post_data);
    }
    
    // Obnovte akci
    add_action('save_post', 'set_custom_post_title');
}
add_action('save_post', 'set_custom_post_title');


function custom_admin_js() {
    $screen = get_current_screen();
    if ($screen->post_type == 'slovnik' && $screen->base == 'post') {
        ?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Skrýt pole pro název a obsah příspěvku
                var titleDiv = document.getElementById('titlediv');
                var postDivRich = document.getElementById('postdivrich');
                if (titleDiv) titleDiv.style.display = 'none';
                if (postDivRich) postDivRich.style.display = 'none';
            });
        </script>
        <?php
    }
}
add_action('admin_head', 'custom_admin_js');


function custom_menu_shortcode() {
    $categories = get_categories(array(
        'orderby' => 'name',
        'order'   => 'ASC',
		'hide_empty' => false
    ));

    // Determine the active category
    $current_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : 'all';

    $html = '<div class="menu-container">';
    $html .= '<a href="' . esc_url(add_query_arg('category', 'all', 'https://sjednej.cz/category/news/')) . '" class="menu-item' . ($current_category == 'all' ? ' active' : '') . '">Všechny články</a>';

    foreach ($categories as $category) {
		if ($category->slug != 'news') {
			$active_class = ($current_category == $category->slug) ? ' active' : '';
        $html .= '<a href="' . esc_url(add_query_arg('category', $category->slug, 'https://sjednej.cz/category/news/')) . '" class="menu-item' . $active_class . '">' . esc_html($category->name) . '</a>';	
		}
    }

    $html .= '</div>';

    return $html;
}
add_shortcode('custom_menu', 'custom_menu_shortcode');



function custom_article_block_shortcode() {
    // Získání kategorie z URL parametru
    $category_name = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

    // Nastavení základních dotazových argumentů
    $query_args = array(
        'post_type' => 'post',
        'posts_per_page' => 1,
    );

    // Pokud je zvolena kategorie, přidání do dotazu
    if (!empty($category_name)) {
        $category = get_category_by_slug($category_name);
        if ($category) {
            $query_args['cat'] = $category->term_id;
        }
    }

    // Provedení dotazu
    $query = new WP_Query($query_args);

    // Pokud nejsou nalezeny žádné příspěvky v zvolené kategorii, dotázat se na nejnovější příspěvek
    if (!$query->have_posts()) {
        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 1,
        ));
    }

    // Pokud stále nejsou nalezeny žádné příspěvky, zobrazit zprávu
    if (!$query->have_posts()) {
        return '<p>No articles found.</p>';
    }

    $query->the_post(); // Získat data příspěvku
    $post_id = get_the_ID();
    $post_title = get_the_title();
    $post_excerpt = get_the_excerpt();
	$trim_excerpt = wp_trim_words(get_the_excerpt(), 24, '...');
    $post_permalink = get_permalink();
    $post_date = get_the_date('j.n.Y');
    $post_thumbnail = get_the_post_thumbnail($post_id, 'full', array('class' => 'article-image'));

    // Získat kategorie
	$categories = get_the_category();
	
    $category_links = '';
    foreach ($categories as $category) {
        $category_links .= '<a class="tag-label" href="' . get_category_link($category->term_id) . '">' . esc_html($category->name) . '</a> ';
    }
	
	// Získat tagy
	$post_tags = get_the_tags();
	$tag_links = '';
	if ($post_tags) {
		foreach ($post_tags as $post_tag) {
			$tag_links .= '<a class="tag-label" href="' . get_tag_link($post_tag->term_id) . '">' . esc_html($post_tag->name) . '</a> ';
		}
	}

    // Sestavit HTML
    $html = '<div class="custom-article-block">';
	$html .= '<div class="gradient-overlay"></div>';
    if ($post_thumbnail) {
        $html .= $post_thumbnail;
    } else {
        $html .= '<img src="https://sjednej.cz/wp-content/uploads/2024/04/promo-page-error.png" alt="Article Image" class="article-image">';
    }
    $html .= '<div class="article-content">';
    $html .= '<div class="post-date"><img decoding="async" src="https://sjednej.cz/wp-content/uploads/2024/07/Group.svg">' . $post_date . '</div>';
    $html .= '<a href="'.$post_permalink.'" class="article-title">' . esc_html($post_title) . '</a>';
    $html .= '<p>' . esc_html($trim_excerpt) . '</p>';
    $html .= '<div class="post-categories">' . $tag_links . '</div>';
    $html .= '<a href="' . esc_url($post_permalink) . '" class="post-read-more"><span>Číst článek</span><img decoding="async" src="https://sjednej.cz/wp-content/uploads/2024/07/Icon-1.svg"></a>';
    $html .= '</div>';
    $html .= '</div>';

    wp_reset_postdata(); // Resetovat globální objekt příspěvku

    return $html;
}
add_shortcode('custom_article_block', 'custom_article_block_shortcode');




function custom_articles_list_shortcode() {
   
	$args = array(
		'order'	=> 'desc',
		'post_type' => 'post',
		'posts_per_page' => 3,
		'suppress_filters' => false,
		'orderby' => 'post_views',
		'fields' => ''
	);
    
    $most_viewed = get_posts($args);

    $html = '<h5 class="article-head-title">Nejčtenější články</h5>';
    $html .= '<div class="custom-articles-list">';

    if (!empty($most_viewed)) {
        foreach ($most_viewed as $post) {
            setup_postdata($post);

            $formatted_date = get_the_date('j.n.Y', $post->ID);
            $tags = get_the_tags($post->ID);
            $tag_list = '';
            if ($tags) {
                foreach ($tags as $tag) {
                    $tag_list .= '<a href="' . get_tag_link($tag->term_id) . '" class="tag">' . $tag->name . '</a> ';
                }
            }

            $excerpt = wp_trim_words(get_the_excerpt($post->ID), 24, '...');
           
            $html .= '<div class="article-item">';
            $html .= '<span class="article-date">' . $formatted_date . '</span>';
            $html .= '<br>';
            $html .= '<a href="' . get_permalink($post->ID) . '" class="article-title">' . get_the_title($post->ID) . '</a>';
            $html .= '<p>' . $excerpt . '</p>';
            $html .= '<div class="article-tags">' . $tag_list . '</div>';
            $html .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $html .= '<p>No articles found.</p>';
    }

    $html .= '</div>';

    return $html;
}
add_shortcode('custom_articles_list', 'custom_articles_list_shortcode');





function custom_tags_list_shortcode() {

    $tags = get_tags(array(
        'hide_empty' => true,
        'number' => 0
    ));

    $html = '<div class="custom-tags-list">';
    $html .= '<h5 class="article-head-title">Podle tagů</h5>';
    $html .= '<div class="custom-tags">';

    $count = 0; 
    foreach ($tags as $tag) {
        if ($count < 8) {
            $html .= '<a href="' . get_tag_link($tag->term_id) . '" class="tag">' . $tag->name . '</a>';
        } else {
            $html .= '<a href="' . get_tag_link($tag->term_id) . '" class="tag hidden">' . $tag->name . '</a>';
        }
        $count++;
    }

    $html .= '</div>';

    if (count($tags) > 8) {
        $more_count = count($tags) - 8;
        $html .= '<a id="show-more-tags" class="tag-more">Zobrazit více témat (+' . $more_count . ')</a>';
    }

    $html .= '</div>';

    return $html;
}
add_shortcode('custom_tags_list', 'custom_tags_list_shortcode');


function custom_article_info_shortcode() {
    global $post;
    $published = get_the_date('j.n.Y H:i', $post);
    $updated = get_the_modified_date('j.n.Y H:i', $post);
    $content = apply_filters('the_content', get_the_content());
    $tags = get_the_tags($post->ID);
    $tag_links = '';
	$pojmyTrue = true;

    if ($tags) {
        foreach ($tags as $tag) {
            $tag_links .= '<a href="' . get_tag_link($tag->term_id) . '" class="tag">' . $tag->name . '</a> ';
        }
    }

    // Přidání předchozího a následujícího článku
    $next_post = get_previous_post();
    $prev_post = get_next_post();
    $navigation_html = '';

    if (!empty($prev_post)) {
        $navigation_html .= '<div class="previous-article"><a href="' . get_permalink($prev_post->ID) . '">Předchozí článek</a></div>';
    } else {
		$navigation_html .= '<div style="visibility: hidden;" class="next-article"></div>';
	}
    
    if (!empty($next_post)) {
        $navigation_html .= '<div class="next-article"><a href="' . get_permalink($next_post->ID) . '">Následující článek</a></div>';
    } else {
		$navigation_html .= '<div style="visibility: hidden;" class="previous-article"></div>';
	}

    // Vyhledání pojmů v obsahu
    preg_match_all('/<a[^>]+class="pojem"[^>]*href="([^"]+)"[^>]*data-id="([^"]+)"[^>]*data-title="([^"]+)"[^>]*>(.*?)<\/a>/', $content, $matches);

    $used_terms = array();
    if (!empty($matches[0])) {
        foreach ($matches[0] as $key => $match) {
            $term_title = $matches[3][$key];
            if (!array_key_exists($term_title, $used_terms)) {
                $used_terms[$term_title] = array(
                    'url' => $matches[1][$key],
                    'title' => $term_title
                );
            }
        }
    }

    // Generování HTML pro použité termíny
    $used_terms_html = '<div class="terms-columns">';
    $columns = [[], [], []];
    if (!empty($used_terms)) {
        $index = 0;
        foreach ($used_terms as $term) {
            $columns[$index % 3][] = '<a class="term-item" href="' . $term['url'] . '">' . $term['title'] . '</a>';
            $index++;
        }
        $used_terms_html .= '<div class="terms-column">' . implode('', $columns[0]) . '</div>';
        $used_terms_html .= '<div class="terms-column">' . implode('', $columns[1]) . '</div>';
        $used_terms_html .= '<div class="terms-column">' . implode('', $columns[2]) . '</div>';
    } else {
        $used_terms_html .= '<p>Žádné pojmy nejsou obsaženy v tomto článku.</p>';
		$pojmyTrue = false;
    }
    $used_terms_html .= '</div>';

    $html = '<div class="custom-article-details">';
    $html .= '<div class="article-info">';
    $html .= '<div class="date-info">';
    $html .= '<div class="published"><img src="https://sjednej.cz/wp-content/uploads/2024/07/Group-1.svg" class="calendar-check"><div class="date-info-section"><p class="date-info-title">Zveřejněno</p><p class="date-info-date">' . $published . '</p></div></div>';
    $html .= '<div class="updated"><img src="https://sjednej.cz/wp-content/uploads/2024/07/Group-2.svg" class="calendar-check"><div class="date-info-section"><p class="date-info-title">Aktualizováno</p><p class="date-info-date">' . $updated . '</p></div></div>';
    $html .= '</div>';
    $html .= '<div class="custom-tags">';
    $html .= $tag_links;
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="article-content">' . $content . '</div>';
	if ($pojmyTrue == true) {
		$html .= '<div class="terms-used">';
		$html .= '<p>Použité termíny:</p>';
		$html .= $used_terms_html;
		$html .= '</div>';
	}
    $html .= '</div>';
    $html .= '<div class="article-menu">'. $navigation_html. '</div>';

    return $html;
}
add_shortcode('custom_article_info', 'custom_article_info_shortcode');




function related_posts_shortcode($atts) {
    // Načtení globálního postu pro získání ID aktuálního článku
    global $post;
    $current_post_id = $post->ID;

    // Načtení kategorií a štítků pro aktuální příspěvek
    $categories = get_the_category($current_post_id);

    // Příprava seznamů ID kategorií a štítků
    $category_ids = array();

    if ($categories) {
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
    }

    // Vytvoření dotazu WP_Query
    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => array($current_post_id),
        'category__in' => $category_ids,
        'orderby' => 'date',
        'order' => 'DESC'
    ));
	
    if (!$query->have_posts()) {
		$output = '<div class="related-posts-container">';
        $output .= '<p>Nejsou k dispozici žádné další články.</p>';
		$output .= '<div class="related-posts-container">';
		return $output;
    }

	$output = '<div class="related-posts-container">';

    while ($query->have_posts()) {
        $query->the_post();
        $categories = get_the_category();
		$tags = get_the_tags();
        $category_list = '';
		$tag_list = '';

		if ($tags) {
            foreach ($tags as $tag) {
                $tag_list .= '<a href="/tag/'.$tag->slug.'" class="tag-label">' . esc_html($tag->name) . '</a> ';
            }
        }

		$excerpt = wp_trim_words(get_the_excerpt(), 24, '...');
		$formatted_date = get_the_date('j.n.Y');


        $output .= '<div class="custom-post">';
        if (has_post_thumbnail()) {
            $output .= '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
        }
        $output .= '<div class="post-content">';
        $output .= '<div class="post-date"><img src="'.home_url().'/wp-content/uploads/2024/07/Frame.svg"> ' . $formatted_date . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-title">' . get_the_title() . '</a>';
        $output .= '<div class="post-excerpt">' . $excerpt . '</div>';
        $output .= '<div class="post-categories">' . $tag_list . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-read-more"><span>Číst článek</span><img src="'.home_url().'/wp-content/uploads/2024/07/Icon.svg"></a>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';

    wp_reset_postdata();

    return $output;
}
add_shortcode('related_posts', 'related_posts_shortcode');



function intro_blog_posts_shortcode($atts) {

    global $post;

    // Získání atributů z shortcodu, s výchozí hodnotou prázdného řetězce pro category
    $atts = shortcode_atts(array(
        'category' => '',
		'title' => '',
    ), $atts, 'intro_blog_posts');

    // Vytvoření WP_Query s filtrem podle kategorie nebo bez filtru, pokud je kategorie prázdná
    $query_args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    if (!empty($atts['category'])) {
        $query_args['category_name'] = $atts['category']; // Filtruje příspěvky podle zadané kategorie
    }

    $query = new WP_Query($query_args);
    
    $output = '<div class="intro-blog-posts">';
    
    $output .= '<h3>' . ($atts['title'] ? $atts['title'] : "Přečtěte si náš blog") . '</h3>';
    
    // Menu položky
    $menu_items = array(
		'news' => 'Všechny články',
        'energie' => 'Energie',
        'pojisteni' => 'Pojištění',
        'finance' => 'Finance',
        'aktuality' => 'Aktuality'
    );

    $output .= '<div class="menu-container">';
    foreach ($menu_items as $slug => $label) {
        $active_class = ($atts['category'] == $slug) ? ' active' : '';
        $output .= '<a href="https://sjednej.cz/category/' . ($slug ? $slug : 'news') . '/" class="menu-item' . $active_class . '">' . $label . '</a>';
    }
    $output .= '</div>';

    $output .= '<div class="related-posts-container">';

    while ($query->have_posts()) {
        $query->the_post();
        $categories = get_the_category();
        $tags = get_the_tags();
        $tag_list = '';

        if ($tags) {
            foreach ($tags as $tag) {
                $tag_list .= '<a href="/tag/'.esc_html($tag->slug).'" class="tag-label">' . esc_html($tag->name) . '</a> ';
            }
        }

        $excerpt = wp_trim_words(get_the_excerpt(), 24, '...');
        $formatted_date = get_the_date('j.n.Y');

        $output .= '<div class="custom-post">';
        if (has_post_thumbnail()) {
            $output .= '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
        }
        $output .= '<div class="post-content">';
        $output .= '<div class="post-date">' . $formatted_date . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-title">' . get_the_title() . '</a>';
        $output .= '<div class="post-excerpt">' . $excerpt . '</div>';
        $output .= '<div class="post-categories">' . $tag_list . '</div>';
        $output .= '<a href="' . get_the_permalink() . '" class="post-read-more"><span>Číst článek</span><img src="' . home_url() . '/wp-content/uploads/2024/07/Icon-1.svg"></a>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';
    $output .= '</div>';

    wp_reset_postdata();

    return $output;
}
add_shortcode('intro_blog_posts', 'intro_blog_posts_shortcode');





function new_custom_breadcrumb() {

    if (!is_single()) {
        return '';
    }

    $home_url = esc_url(home_url('/'));
    $home_icon = '<a href="' . $home_url . '"><img src="' . esc_url($home_url . 'wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;"></a>';
    $blog_url = esc_url(home_url() . '/category/news');
    $post_title = get_the_title();
    $categories = get_the_category();
    $category_links = '';

    if (!empty($categories)) {
        foreach ($categories as $category) {
            if ($category->name != 'Blog') {
                $category_links .= '<a href="' . get_category_link($category->term_id) . '">' . esc_html($category->name) . '</a> | ';
            }
        }
        $category_links = rtrim($category_links, ' | ');
    }

    $breadcrumb = $home_icon . ' &gt; <a href="' . $blog_url . '">Blog</a> &gt; ' . $category_links . ' &gt; ' . $post_title;

    return '<div class="custom-breadcrumb">' . $breadcrumb . '</div>';
}
add_shortcode('new_custom_breadcrumb', 'new_custom_breadcrumb');






function tag_custom_breadcrumb() {
    // Get the home URL
    $home_url = home_url();
    // Home icon (use any SVG or icon of your choice)
    $home_icon = '<img src="' . esc_url($home_url . '/wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;">';

    // Initialize breadcrumb HTML structure
    $breadcrumb = '<div class="custom-breadcrumb">';
    $breadcrumb .= '<a href="' . $home_url . '">' . $home_icon . '</a> &gt; ';

    // Add blog link
    $blog_page_id = get_option('page_for_posts');
    if ($blog_page_id) {
        $blog_url = get_permalink($blog_page_id);
    } else {
        $blog_url = $home_url . '/category/news';
    }
    $breadcrumb .= '<a href="' . $blog_url . '">Blog</a> &gt; '; //Štítek &gt; 

    // Special case for tag pages
    if (is_tag()) {
        $tag = get_queried_object();
        $breadcrumb .= '<span>' . esc_html($tag->name) . '</span>';
    }

    $breadcrumb .= '</div>';

    return $breadcrumb;
}
add_shortcode('tag_custom_breadcrumb', 'tag_custom_breadcrumb');




function add_custom_tinymce_plugin($plugin_array) {
    $plugin_array['my_mce_button'] = get_template_directory_uri() . '/js/tinymce-custom-button.js';
    return $plugin_array;
}
add_filter('mce_external_plugins', 'add_custom_tinymce_plugin');

function register_my_custom_button($buttons) {
    array_push($buttons, 'my_mce_button');
    return $buttons;
}
add_filter('mce_buttons', 'register_my_custom_button');

function get_slovnik_terms() {
    $args = array(
        'post_type' => 'slovnik',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );
    $query = new WP_Query($args);
    $terms = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $terms[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink()
            );
        }
    }
    wp_reset_postdata();

    echo json_encode($terms);
    wp_die();
}
add_action('wp_ajax_get_slovnik_terms', 'get_slovnik_terms');


/*
function propojeni_clanek_produkt_obsah_shortcode($atts) {
	global $post;

    $produkt = get_field('clanek_propojeni_s_produktem', $post->ID);
	
	if (!$produkt) {
		return;
	}
	
	$nadpis = get_field('clanek_propojeni_s_produktem_text', $post->ID);
	
	if(!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}

    $podnadpis = get_field('produkt_podnadpis', $produkt->ID);
    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);


    $output = '<div class="produkt-box">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
    if ($tlacitko1URL && $tlacitko1Text) {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
    if ($tlacitko2URL && $tlacitko2Text) {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('propojeni_clanek_produkt_obsah', 'propojeni_clanek_produkt_obsah_shortcode');
*/
	
function propojeni_clanek_produkt_obsah_shortcode($atts) {
	global $post;

    $produkt = get_field('clanek_propojeni_s_produktem', $post->ID);
	
	if (!$produkt) {
		return;
	}
	
	$nadpis = get_field('clanek_propojeni_s_produktem_text', $post->ID);
	
	if(!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}

    $podnadpis = get_field('produkt_podnadpis', $produkt->ID);
    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);
	
	$form_type_1 = get_field('banner_contact_form_type_1', $produkt->ID);
	$form_shortcode_1 = get_field('banner_contact_form_shortcode_1', $produkt->ID);

	$form_type_2 = get_field('banner_contact_form_type_2', $produkt->ID);
	$form_shortcode_2 = get_field('banner_contact_form_shortcode_2', $produkt->ID);


	$output = '<section class="produkt-box custom-form-wrapper">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
	if ($tlacitko1URL && $tlacitko1Text && $form_type_1 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
	if ($tlacitko1Text && $form_type_1 == 'classic') {
        $output .= '<a class="produkt-button button button-primary" id="show-contact-form">' . esc_html($tlacitko1Text) . '</a>';
    }
	if ($form_shortcode_1 && $form_type_1 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_1);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }
	
	if ($tlacitko2URL && $tlacitko2Text && $form_type_2 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
	if ($tlacitko2Text && $form_type_2 == 'classic') {
        $output .= '<a class="produkt-button button button-secondary" id="show-contact-form">' . esc_html($tlacitko2Text) . '</a>';
    }
	if ($form_shortcode_2 && $form_type_2 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_2);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }
	
    $output .= '</div>';
    $output .= '</section>';

    return $output;
}
add_shortcode('propojeni_clanek_produkt_obsah', 'propojeni_clanek_produkt_obsah_shortcode');
	
/*
function propojeni_clanek_produkt_side($atts) {
    global $post;

    // Získání propojeného produktu
    $produkt = get_field('clanek_propojeni_s_produktem_sidebar', $post->ID);

    if (!$produkt) {
        return '';
    }
	
	$nadpis = get_field('clanek_propojeni_s_produktem_sidebar_nadpis', $post->ID);
	$podnadpis = get_field('clanek_propojeni_s_produktem_sidebar_podnadpis', $post->ID);
	
	if (!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}

	if (!$podnadpis) {
		$podnadpis = get_field('produkt_podnadpis', $produkt->ID);
	}

    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);

    // HTML struktura pro výstup boxu
    $output = '<div class="sticky-produkt-box">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    if ($podnadpis) {
        $output .= $podnadpis;
    }
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
    if ($tlacitko1URL && $tlacitko1Text) {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
    if ($tlacitko2URL && $tlacitko2Text) {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}
add_shortcode('propojeni_clanek_produkt_side', 'propojeni_clanek_produkt_side');
*/
function propojeni_clanek_produkt_side($atts) {
   global $post;

    // Získání propojeného produktu
    $produkt = get_field('clanek_propojeni_s_produktem_sidebar', $post->ID);

    if (!$produkt) {
        return '';
    }
	
	$nadpis = get_field('clanek_propojeni_s_produktem_sidebar_nadpis', $post->ID);
	$podnadpis = get_field('clanek_propojeni_s_produktem_sidebar_podnadpis', $post->ID);
	
	if (!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}

	if (!$podnadpis) {
		$podnadpis = get_field('produkt_podnadpis', $produkt->ID);
	}

    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);
	
	$form_type_1 = get_field('banner_contact_form_type_1', $produkt->ID);
	$form_shortcode_1 = get_field('banner_contact_form_shortcode_1', $produkt->ID);

	$form_type_2 = get_field('banner_contact_form_type_2', $produkt->ID);
	$form_shortcode_2 = get_field('banner_contact_form_shortcode_2', $produkt->ID);

    // HTML struktura pro výstup boxu
    $output = '<section class="sticky-produkt-box custom-form-wrapper">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    if ($podnadpis) {
        $output .= '<p>' . esc_html($podnadpis) . '</p>';
    }
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
    if ($tlacitko1URL && $tlacitko1Text && $form_type_1 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
	if ($tlacitko1Text && $form_type_1 == 'classic') {
        $output .= '<a class="produkt-button button button-primary" id="show-contact-form">' . esc_html($tlacitko1Text) . '</a>';
    }
	if ($form_shortcode_1 && $form_type_1 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_1);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }
	
    if ($tlacitko2URL && $tlacitko2Text && $form_type_2 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
	if ($tlacitko2Text && $form_type_2 == 'classic') {
        $output .= '<a class="produkt-button button button-secondary" id="show-contact-form">' . esc_html($tlacitko2Text) . '</a>';
    }
	$output .= '</div>';
	
	if ($form_shortcode_2 && $form_type_2 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_2);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }

	$output .= '</section>';

	return $output;
}
add_shortcode('propojeni_clanek_produkt_side', 'propojeni_clanek_produkt_side');

function banner_side_pojem($atts) {
   global $post;

    // Získání propojeného produktu
    $produkt = get_field('slovnik_propojeni_s_produktem_sticky', $post->ID);

    if (!$produkt) {
        return '';
    }
	
	$nadpis = get_field('slovnik_propojeni_s_produktem_sticky_nadpis', $post->ID);
	$podnadpis = get_field('slovnik_propojeni_s_produktem_sticky_podnadpis', $post->ID);

	$podnadpis_pojem = "";
	
	if (!$nadpis) {
		$nadpis = get_field('produkt_nadpis', $produkt->ID);
	}

	if (!$podnadpis) {
		$podnadpis_pojem = get_field('produkt_podnadpis', $produkt->ID);
	}

    $tlacitko1URL = get_field('produkt_tlacitko_1_url', $produkt->ID);
	$tlacitko1Text = get_field('produkt_tlacitko_1_text', $produkt->ID);
    $tlacitko2URL = get_field('produkt_tlacitko_2_url', $produkt->ID);
	$tlacitko2Text = get_field('produkt_tlacitko_2_text', $produkt->ID);
	
	$form_type_1 = get_field('banner_contact_form_type_1', $produkt->ID);
	$form_shortcode_1 = get_field('banner_contact_form_shortcode_1', $produkt->ID);

	$form_type_2 = get_field('banner_contact_form_type_2', $produkt->ID);
	$form_shortcode_2 = get_field('banner_contact_form_shortcode_2', $produkt->ID);

    // HTML struktura pro výstup boxu
    $output = '<section class="sticky-produkt-box custom-form-wrapper">';
    $output .= '<div class="produkt-text">';
    $output .= '<h2>' . esc_html($nadpis) . '</h2>';
    if ($podnadpis_pojem) {
        $output .= $podnadpis_pojem;
    }
	 if ($podnadpis) {
        $output .= "<p>" . esc_html($podnadpis) . "</p>";
    }
    $output .= '</div>';
    $output .= '<div class="produkt-buttons">';
    if ($tlacitko1URL && $tlacitko1Text && $form_type_1 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko1URL) . '" class="button button-primary">'.esc_html($tlacitko1Text).'</a>';
    }
	if ($tlacitko1Text && $form_type_1 == 'classic') {
        $output .= '<a class="produkt-button button button-primary" id="show-contact-form">' . esc_html($tlacitko1Text) . '</a>';
    }
	if ($form_shortcode_1 && $form_type_1 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_1);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }
	
    if ($tlacitko2URL && $tlacitko2Text && $form_type_2 == 'url') {
        $output .= '<a href="' . esc_url($tlacitko2URL) . '" class="button button-secondary">'.esc_html($tlacitko2Text).'</a>';
    }
	if ($tlacitko2Text && $form_type_2 == 'classic') {
        $output .= '<a class="produkt-button button button-secondary" id="show-contact-form">' . esc_html($tlacitko2Text) . '</a>';
    }
	$output .= '</div>';
	
	if ($form_shortcode_2 && $form_type_2 == 'classic') {
			$output .= '<div id="contact-form">';
				$output .= '<div class="popup-form">';
					$output .= '<div class="popup-close">';
						$output .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
						$output .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
						$output .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
						$output .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
						$output .= '</svg>';
						$output .= '</button>';
					$output .= '</div>';
					$output .= '<div class="popup-inner">';
						$output .= '<div class="popup-contact-wrapper">';
							$output .= do_shortcode($form_shortcode_2);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
        $output .= '</div>';
    }

	$output .= '</section>';

	return $output;
}
add_shortcode('banner_side_pojem', 'banner_side_pojem');


function main_category_description_shortcode() {

	$category_name = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
	
	$output = "";

	if (!empty($category_name)) {
		$category = get_category_by_slug($category_name);

		if ($category->category_description) {
			$output .= '<div class="category-description">';
			$output .= '<p>'.$category->category_description.'</p>';
			$output .= '</div>';
		}
	}

	return $output;
}
add_shortcode('main_category_description', 'main_category_description_shortcode');




function custom_posts_connected_shortcode($atts) {
    global $post;
	
    $pojem = $post;

    if (!$pojem || !isset($pojem->ID)) {
        return 'Pojem není definován.';
    }

    $pojem_id = $pojem->ID;

    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    ));

    if (!$query->have_posts()) {
        return '';
    }

    $output = '<h2 class="similar-posts-title">Články s termínem "' . $pojem->post_title . '"</h2>';
    $output .= '<div class="custom-posts-container">';
    $found_posts = false;

    while ($query->have_posts()) {
        $query->the_post();
        $post_content = get_the_content();

        // Kontrola, zda obsahuje daný pojem pomocí data-id
        if (strpos($post_content, 'data-id="' . $pojem_id . '"') !== false) {
            $found_posts = true;
            $categories = get_the_category();
            $tags = get_the_tags();
            $tag_list = '';
            if ($tags) {
                foreach ($tags as $tag) {
                    $tag_list .= '<a href="' . get_tag_link($tag->term_id) . '" class="tag-label">' . esc_html($tag->name) . '</a> ';
                }
            }

            $formatted_date = get_the_date('j.n.Y');
            $excerpt = wp_trim_words(get_the_excerpt(), 24, '...');

            $output .= '<div class="custom-post">';
            if (has_post_thumbnail()) {
                $output .= '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
            }
            $output .= '<div class="post-content">';
            $output .= '<div class="post-date"><img src="' . home_url() . '/wp-content/uploads/2024/07/Frame.svg"> ' . $formatted_date . '</div>';
            $output .= '<a href="' . get_the_permalink() . '" class="post-title">' . get_the_title() . '</a>';
            $output .= '<div class="post-excerpt">' . $excerpt . '</div>';
            $output .= '<div class="post-categories">' . $tag_list . '</div>';
            $output .= '<a href="' . get_the_permalink() . '" class="post-read-more"><span>Číst článek</span><img src="' . home_url() . '/wp-content/uploads/2024/07/Icon.svg"></a>';
            $output .= '</div>';
            $output .= '</div>';
        }
    }

    if (!$found_posts) {
        $output .= '<p>Žádné články s termínem "' . esc_html($pojem->post_title) . '" nebyly nalezeny.</p>';
		$output = '';
		$output .= '<div class="buttons-bottom"><a href="/category/news">Další články</a><a>Hledat dle výrazu “' . esc_html($pojem->post_title) . '”</a></div>';
    } else {
		$output .= '</div>';
    	$output .= '<div class="buttons-bottom"><a href="/category/news">Další články</a><a>Hledat dle výrazu “' . esc_html($pojem->post_title) . '”</a></div>';
	}

    wp_reset_postdata();

    return $output;
}

add_shortcode('custom_posts_connected', 'custom_posts_connected_shortcode');


/* custom_rewrite_rules - START */
/*
// Přidání vlastních přepisovacích pravidel
function custom_pojisteni_rewrite_rules() {
    add_rewrite_rule(
        '^pojisteni/([^/]+)/?$',
        'index.php?custom_pojisteni_nazev=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_pojisteni_rewrite_rules', 15); // Priorita 15 zajistí, že se spustí po registraci CPT UI

// Registrace vlastních query variables
function custom_query_vars($vars) {
    $vars[] = 'custom_pojisteni_nazev';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');

// Úprava hlavního dotazu
function custom_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query() && get_query_var('custom_pojisteni_nazev')) {
        $nazev = get_query_var('custom_pojisteni_nazev');

        // Kontrola existence v CPT 'pojištění'
        $pojisteni_post = get_posts([
            'name'        => $nazev,
            'post_type'   => 'pojisteni',
            'post_status' => 'publish',
            'numberposts' => 1,
            'fields'      => 'ids',
        ]);

        if (!empty($pojisteni_post)) {
            // Nastavení dotazu pro CPT 'pojištění'
            $query->set('post_type', 'pojisteni');
            $query->set('p', $pojisteni_post[0]);

            // Nastavení správných flagů
            $query->is_single = true;
            $query->is_singular = true;
            $query->is_page = false;
            $query->is_home = false;
            $query->is_archive = false;
        } else {
            // Kontrola existence v CPT 'nabidka'
            $nabidka_post = get_posts([
                'name'        => $nazev,
                'post_type'   => 'nabidka',
                'post_status' => 'publish',
                'numberposts' => 1,
                'fields'      => 'ids',
            ]);

            if (!empty($nabidka_post)) {
                // Nastavení dotazu pro CPT 'nabidka'
                $query->set('post_type', 'nabidka');
                $query->set('p', $nabidka_post[0]);

                // Nastavení správných flagů
                $query->is_single = true;
                $query->is_singular = true;
                $query->is_page = false;
                $query->is_home = false;
                $query->is_archive = false;
            } else {
                // Žádný příspěvek nenalezen, nastavení 404
                $query->set_404();
                status_header(404);
                nocache_headers();
            }
        }
    }
}
add_action('pre_get_posts', 'custom_pre_get_posts', 15); // Priorita 15 zajistí správné pořadí

// Změna url v příspěvku produktech CPT nabidka
function custom_nabidka_permalink($post_link, $post) {	
    if ($post->post_type == 'nabidka' && $post->post_status == 'publish') {
        // Získání termínů z taxonomie 'kategorie-sluzba'
        $terms = wp_get_post_terms($post->ID, 'kategorie-sluzba');

        if (!is_wp_error($terms) && !empty($terms)) {
            // Použití slugu prvního termínu
            $term_slug = $terms[0]->slug;
            $post_link = home_url('/' . $term_slug . '/' . $post->post_name . '/');
        } else {
            // Pokud není termín přiřazen, ponechá jen název
            $post_link = home_url('/' . $post->post_name . '/');
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'custom_nabidka_permalink', 10, 2);
*/
/* custom_rewrite_rules - END */



/*=============================
 * custom_rewrite_rules
 *============================*/
/* custom_rewrite_rules - START */

// Přidání vlastních přepisovacích pravidel
function custom_pojisteni_rewrite_rules() {
    add_rewrite_rule(
        '^pojisteni/([^/]+)/?$',
        'index.php?custom_pojisteni_nazev=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_pojisteni_rewrite_rules', 15); // Priorita 15 zajistí, že se spustí po registraci CPT UI

// Registrace vlastních query variables
function custom_query_vars($vars) {
    $vars[] = 'custom_pojisteni_nazev';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');

// Úprava hlavního dotazu
function custom_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query() && get_query_var('custom_pojisteni_nazev')) {
        $nazev = get_query_var('custom_pojisteni_nazev');
        

        // Kontrola existence v CPT 'pojištění'
        $pojisteni_post = get_posts([
            'name'        => $nazev,
            'post_type'   => 'pojisteni',
            'post_status' => 'publish',
            'numberposts' => 1,
            'fields'      => 'ids',
        ]);

        if (!empty($pojisteni_post)) {
            // Nastavení dotazu pro CPT 'pojištění'
            $query->set('post_type', 'pojisteni');
            $query->set('p', $pojisteni_post[0]);

            // Nastavení správných flagů
            $query->is_single = true;
            $query->is_singular = true;
            $query->is_page = false;
            $query->is_home = false;
            $query->is_archive = false;
        } else {
          // Kontrola existence v CPT 'nabidka'
            $nabidka_post = get_posts([
                'name'        => $nazev,
                'post_type'   => 'nabidka',
                'post_status' => 'publish',
                'numberposts' => 1,
                'fields'      => 'ids',
            ]);

            if (!empty($nabidka_post)) {
                // Nastavení dotazu pro CPT 'nabidka'
                $query->set('post_type', 'nabidka');
                $query->set('p', $nabidka_post[0]);

                // Nastavení správných flagů
                $query->is_single = true;
                $query->is_singular = true;
                $query->is_page = false;
                $query->is_home = false;
                $query->is_archive = false;
            } else {
                // Žádný příspěvek nenalezen, nastavení 404
                $query->set_404();
                status_header(404);
                nocache_headers();
            }
        }
    }
}
add_action('pre_get_posts', 'custom_pre_get_posts', 15); // Priorita 15 zajistí správné pořadí


// Přesměrování nabidka URL na vlastni URL
function custom_redirect_standard_urls() {
    if ( is_singular( 'pojisteni' ) && !get_query_var( 'custom_pojisteni_nazev' ) ) {
        global $post;
        $custom_url = home_url( '/pojisteni/' . $post->post_name . '/' );
        wp_redirect( $custom_url, 301 ); // proedení 301 přesměrování
        exit;
    }
}
add_action( 'template_redirect', 'custom_redirect_standard_urls' );

// Změna url v příspěvku produktech CPT nabidka + Administrace WP
function custom_nabidka_permalink($post_link, $post) {	
    if ($post->post_type == 'nabidka' && $post->post_status == 'publish') {

        $terms = wp_get_post_terms($post->ID, 'kategorie-sluzba');
      //  var_dump($post->ID);
        if (!is_wp_error($terms) && !empty($terms)) {
            // Použití slugu prvního termínu => pokud vybere uživatel více, bere pouze první
            $term_slug = $terms[0]->slug;
        //    var_dump($term_slug);
            $post_link = home_url('/' . $term_slug . '/' . $post->post_name . '/');
        }
		//else {
            // Pokud není termín přiřazen, ponechá jen název
            //$post_link = home_url('/nezarazeno/' . $post->post_name . '/');
        //}
		
    }
    return $post_link;
}
add_filter('post_type_link', 'custom_nabidka_permalink', 20, 2);
/*
function custom_nabidka_rewrite_rules()
{
    // Přidání pravidla pro URL se strukturou /kategorie-sluzba/post-name/
    add_rewrite_rule(
        '^(?!category/|tag/|slovnik/)([^/]+)/([^/]+)/?$',
        'index.php?post_type=nabidka&name=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_nabidka_rewrite_rules', 100);

function exclude_pages_from_custom_rewrite($query)
{
    if (!is_admin() && $query->is_main_query() && isset($query->query['name'])) {
        // Zkontrolujeme, jestli příspěvek není typu 'page'
        $page = get_page_by_path($query->query['name'], OBJECT, 'page');
        if ($page) {
            $query->set('post_type', 'page');
        }
    }
}
add_action('pre_get_posts', 'exclude_pages_from_custom_rewrite');
*/

function custom_nabidka_rewrite_rules()
{
    // pravidlo pro slovník
    add_rewrite_rule(
        'slovnik/([^/]+)/?$',
        'index.php?post_type=slovnik&name=$matches[1]',
        'top'
    );
    // Přidání pravidla pro URL se strukturou /kategorie-sluzba/post-name/
    add_rewrite_rule(
        '^(?!category/|tag/|slovnik/)([^/]+)/([^/]+)/?$',
        'index.php?post_type=nabidka&name=$matches[2]',
        'top'
    );

}
add_action('init', 'custom_nabidka_rewrite_rules', 100);

function exclude_pages_from_custom_rewrite($query)
{
    if (!is_admin() && $query->is_main_query() && isset($query->query['name'])) {
        // Nejdřív zkontrolujeme, jestli nejsme na URL slovníku
        if (strpos($_SERVER['REQUEST_URI'], '/slovnik/') !== false) {
            $query->set('post_type', 'slovnik');
            return;
        }

        // Pokud nejsme na URL slovníku, pokračujeme v původní logice
        $page = get_page_by_path($query->query['name'], OBJECT, 'page');
        if ($page) {
            $query->set('post_type', 'page');
        }
    }
}
add_action('pre_get_posts', 'exclude_pages_from_custom_rewrite');

//add_action('template_redirect', 'debug_current_post_rewrite_rules');
function debug_current_post_rewrite_rules()
{
    if (current_user_can('administrator')) { // Pouze pro administrátory
        global $wp, $wp_query, $wp_rewrite, $post;

        if (is_singular() && $post) {
            echo '<pre>';

            // Vypiš všechny query vars a rewrite rules, které aktuálně platí
            echo "Aktuální permalink: " . get_permalink($post->ID) . "\n";
            echo "WP Query Vars:\n";
            var_dump($wp->query_vars);

            echo "WP Rewrite Rules (related to current request):\n";
            var_dump($wp_rewrite->wp_rewrite_rules());

            // Vypiš informace o konkrétním příspěvku
            echo "\nInformace o příspěvku (post object):\n";
            var_dump($post);

            echo '</pre>';
            exit; // Zastaví načítání stránky, aby se výstup lépe četl
        }
    }
}

function redirect_old_nabidka_urls() {
    if ( is_singular( 'nabidka' ) ) {
        global $post;

        $requested_url = untrailingslashit( home_url( $_SERVER['REQUEST_URI'] ) );
        $correct_url = untrailingslashit( get_permalink( $post->ID ) );

        if ( $requested_url !== $correct_url ) {
            wp_redirect( $correct_url, 301 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'redirect_old_nabidka_urls' );


function disable_nabidka_sitemap($value, $public_post_type) {
    if ($public_post_type === 'nabidka') {
        return false;
    }
    return $value;
}
add_filter('rank_math/sitemap/post_type_archive_link', 'disable_nabidka_sitemap', 10, 2);
/* ========================== */
/* custom_rewrite_rules - END */
/* ========================== */

function hide_breadcrumbs_on_specific_pages() {
    // Získá aktuální URL
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	$custom_post_type = 'post';


    if (is_singular($custom_post_type)) {
        echo '<style>.rank-math-breadcrumb { display: none !important; }</style>';
    }

    if (strpos($current_url, 'https://sjednej.cz/prispevek') === 0 ||  // Pro příspěvky
        strpos($current_url, 'https://sjednej.cz/tag/') === 0 ||      // Pro tagy (štítky)
        strpos($current_url, 'https://sjednej.cz/category/news/') === 0 || // Pro rubriky (blog)
        strpos($current_url, 'https://sjednej.cz/slovnik/') === 0) {  // Pro slovník (CPT)
        // Skryje breadcrumbs
        echo '<style>.rank-math-breadcrumb { display: none !important; }</style>';
    }
}

add_action('wp_head', 'hide_breadcrumbs_on_specific_pages');


function add_custom_schema_json_ld() {
	$custom_post_type = 'post';
    if (is_single($custom_post_type)) {
        global $post;
        $schema_data = array(
            "@context" => "https://schema.org",
            "@type" => "Article",
            "mainEntityOfPage" => array(
                "@type" => "WebPage",
                "@id" => get_permalink($post->ID)
            ),
            "headline" => get_the_title($post->ID),
            "image" => get_the_post_thumbnail_url($post->ID),
            "datePublished" => get_the_date('c', $post->ID),
            "dateModified" => get_the_modified_date('c', $post->ID),
            "author" => array(
                "@type" => "Person",
                "name" => get_the_author_meta('display_name', $post->post_author)
            ),
            "publisher" => array(
                "@type" => "Organization",
                "name" => "Sjednej.cz",
                "logo" => array(
                    "@type" => "ImageObject",
                    "url" => 'https://sjednej.cz/wp-content/uploads/2024/03/Sjednej_logo_final.png'
                )
            )
        );
        echo '<script type="application/ld+json">' . json_encode($schema_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}
add_action('wp_head', 'add_custom_schema_json_ld');

function add_custom_meta_description() {
    if (is_post_type_archive('slovnik')) {
        echo '<meta name="description" content="Praktický slovník pojmů vám pomůže zorientovat se v odborných termínech z oblasti pojištění, půjček a energií." />';
    }
}
add_action('wp_head', 'add_custom_meta_description');

function get_pojem_content() {
    if (isset($_POST['pojem_id'])) {
        $pojem_id = intval($_POST['pojem_id']);
        $pojem = get_post($pojem_id);
		
		$nadpis = get_field('slovnik_nadpis', $pojem_id);
		$popisek = get_field('slovnik_definice', $pojem_id);

        if ($pojem) {
			$response = '<img src="https://sjednej.cz/wp-content/uploads/2024/07/Frame-3.svg">';
            $response .= '<h2>' . $nadpis . '</h2>';
            $response .= '<p>' . $popisek . '</p>';
			$response .= '<a href="'.esc_url(get_permalink($pojem_id)).'" class="pojem-read-more"><span>Otevřít slovník termínů</span><img src="https://sjednej.cz/wp-content/uploads/2024/07/Icon-2.svg"></a>';
        } else {
            $response = '<p>Pojem nenalezen.</p>';
        }

        echo $response;
    }
    wp_die();
}
add_action('wp_ajax_get_pojem_content', 'get_pojem_content');
add_action('wp_ajax_nopriv_get_pojem_content', 'get_pojem_content');


function slovnik_popup_shortcode() {
    $content = '';
    $content .= '<div id="popup-slovnik" style="display:none;">';
    $content .= '<div class="popup-content">';
    $content .= '<span class="close-button">&times;</span>';
    $content .= '<div id="popup-content"></div>';
    $content .= '</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('slovnik_popup', 'slovnik_popup_shortcode');
/*
function add_canonical_to_pagination() {
    if (is_category() && (get_query_var('paged') > 1 || get_query_var('page') > 1)) {
        $canonical_url = get_category_link(get_queried_object_id());
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">';
		echo '<meta name="robots" content="index, follow">';
    }
	if (is_tag() && (get_query_var('paged') > 1 || get_query_var('page') > 1)) {
		$canonical_url = get_tag_link(get_queried_object_id());
		echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">';
		echo '<meta name="robots" content="index, follow">';
	}
}
add_action('wp_head', 'add_canonical_to_pagination');
*/

function add_canonical_to_pagination() {
    if (is_category() && (get_query_var('paged') > 1 || get_query_var('page') > 1)) {
        $paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
        $canonical_url = trailingslashit(get_category_link(get_queried_object_id())) . 'page/' . $paged . '/';
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">';
        echo '<meta name="robots" content="index, follow">';
    }
    if (is_tag() && (get_query_var('paged') > 1 || get_query_var('page') > 1)) {
        $paged = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
        $canonical_url = trailingslashit(get_tag_link(get_queried_object_id())) . 'page/' . $paged . '/';
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">';
        echo '<meta name="robots" content="index, follow">';
    }
}
add_action('wp_head', 'add_canonical_to_pagination');



// Funkce pro zobrazení nového pole
function pridat_stitek_nazev_field($term) {
    $stitek_nazev = get_term_meta($term->term_id, 'stitek_nazev', true); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="stitek_nazev"><?php _e('Název Štítku'); ?></label></th>
        <td>
            <input type="text" name="stitek_nazev" id="stitek_nazev" value="<?php echo esc_attr($stitek_nazev) ? esc_attr($stitek_nazev) : ''; ?>">
            <p class="description"><?php _e('Vložte název štítku, který se zobrazí na stránce štítků.'); ?></p>
        </td>
    </tr>
<?php
}
add_action('edit_tag_form_fields', 'pridat_stitek_nazev_field');

// Funkce pro uložení hodnoty nového pole
function ulozit_stitek_nazev_field($term_id) {
    if (isset($_POST['stitek_nazev'])) {
        update_term_meta($term_id, 'stitek_nazev', sanitize_text_field($_POST['stitek_nazev']));
    }
}
add_action('edited_post_tag', 'ulozit_stitek_nazev_field');
add_action('create_post_tag', 'ulozit_stitek_nazev_field');

// Funkce pro zobrazení hodnoty nového pole na frontend
function zobrazit_stitek_nazev($term_id) {
    $stitek_nazev = get_term_meta($term_id, 'stitek_nazev', true);
    if ($stitek_nazev) {
        echo '<p>' . esc_html($stitek_nazev) . '</p>';
    }
}
add_action('wp_head', 'zobrazit_stitek_nazev');



function search_cpt_slovnik_terms() {
    if (isset($_GET['term'])) {
        global $wpdb;

        $search_term = sanitize_text_field($_GET['term']);
        $results = $wpdb->get_results($wpdb->prepare("
            SELECT post_title as title, guid as url, ID as id 
            FROM $wpdb->posts 
            WHERE post_type = 'slovnik' 
            AND post_status = 'publish' 
            AND post_title LIKE %s
        ", '%' . $wpdb->esc_like($search_term) . '%'));

        echo json_encode($results);
    }
    wp_die(); // WordPress function to properly end AJAX requests
}
add_action('wp_ajax_search_cpt_slovnik_terms', 'search_cpt_slovnik_terms');
add_action('wp_ajax_nopriv_search_cpt_slovnik_terms', 'search_cpt_slovnik_terms');


/*Kalkulačka - Elektrika */
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/submit_form_electricity_create', array(
        'methods' => 'POST',
        'callback' => 'submit_form_electricity_create',
    ));
});

function submit_form_electricity_create(WP_REST_Request $request) {
    // Start session if not already started
    if (!session_id()) {
        session_start();
    }

    // Retrieve parameters from the request
    $params = $request->get_params();
    //error_log('Received Params: ' . print_r($params, true));

    // Check or create session ID
    if (!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = session_id();
    }
    $session_id = $_SESSION['session_id'];
    //error_log('Session ID: ' . $session_id);

    // Sanitize and log input data
    $current_supplier = sanitize_text_field($params['currentSupplier']);
    $circuit_breaker = sanitize_text_field($params['circuitBreaker']);
    $distribution_rate = sanitize_text_field($params['distributionRate']);
    $consumption_vt = intval($params['consumptionVT']);
    $consumption_nt = intval($params['consumptionNT']);
    $property_type = sanitize_text_field($params['propertyType']);
    $person_count = sanitize_text_field($params['personCount']);
    $usage = isset($params['usage']) && is_array($params['usage']) ? array_map('sanitize_text_field', $params['usage']) : array();
	$full_name = sanitize_text_field($params['full_name']);
    $region = sanitize_text_field($params['region']);
    $phone = sanitize_text_field($params['phone']);
    $email = sanitize_email($params['email']);
    $marketing_consent = isset($params['marketing_consent']) ? 1 : 0;
    $data_processing_consent = isset($params['data_processing_consent']) ? 1 : 0;
    $last_update = current_time('timestamp');
    $deal_sent = 0;
    $lead_type = 'soft';

    /*
    error_log("Current Supplier: " . $current_supplier);
    error_log("Circuit Breaker: " . $circuit_breaker);
    error_log("Distribution Rate: " . $distribution_rate);
    error_log("Consumption VT: " . $consumption_vt);
    error_log("Consumption NT: " . $consumption_nt);
    error_log("Property Type: " . $property_type);
    error_log("Person Count: " . $person_count);
    error_log("Usage: " . print_r($usage, true));
    error_log("Region: " . $region);
    error_log("Phone: " . $phone);
    error_log("Email: " . $email);
    error_log("Marketing Consent: " . $marketing_consent);
    error_log("Data Processing Consent: " . $data_processing_consent);
    error_log("Last Update: " . $last_update);
    error_log("Deal Sent: " . $deal_sent);
    error_log("Lead Type: " . $lead_type);
    */

    // Check if lead with the current session ID already exists
    $args = array(
        'post_type' => 'electricity_deal',
        'meta_query' => array(
            array(
                'key' => 'session_id',
                'value' => $session_id,
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    //error_log('WP_Query Arguments: ' . print_r($args, true));
    //error_log('WP_Query Found Posts: ' . $query->found_posts);

    if ($query->have_posts()) {
        // Update existing lead
        $query->the_post();
        $post_id = get_the_ID();
        error_log('Updating Post ID: ' . $post_id);
        update_post_meta($post_id, 'current_supplier', $current_supplier);
        update_post_meta($post_id, 'circuit_breaker', $circuit_breaker);
        update_post_meta($post_id, 'distribution_rate', $distribution_rate);
        update_post_meta($post_id, 'consumption_vt', $consumption_vt);
        update_post_meta($post_id, 'consumption_nt', $consumption_nt);
        update_post_meta($post_id, 'property_type', $property_type);
        update_post_meta($post_id, 'person_count', $person_count);
        update_post_meta($post_id, 'usage', $usage);
		update_post_meta($post_id, 'full_name', $full_name);
        update_post_meta($post_id, 'region', $region);
        update_post_meta($post_id, 'phone', $phone);
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'marketing_consent', $marketing_consent);
        update_post_meta($post_id, 'data_processing_consent', $data_processing_consent);
        update_post_meta($post_id, 'last_update', $last_update);
        update_post_meta($post_id, 'deal_sent', $deal_sent);
        update_post_meta($post_id, 'lead_type', $lead_type);
        //error_log('Updated Post Meta for Post ID: ' . $post_id);
    } else {
        // Insert new lead
        $post_id = wp_insert_post(array(
            'post_type' => 'electricity_deal',
            'post_title' => 'Electricity Deal - ' . $phone. " - ".$full_name,
            'post_status' => 'publish',
            'meta_input' => array(
                'session_id' => $session_id,
                'current_supplier' => $current_supplier,
                'circuit_breaker' => $circuit_breaker,
                'distribution_rate' => $distribution_rate,
                'consumption_vt' => $consumption_vt,
                'consumption_nt' => $consumption_nt,
                'property_type' => $property_type,
                'person_count' => $person_count,
                'usage' => $usage,
				'full_name' => $full_name,
                'region' => $region,
                'phone' => $phone,
                'email' => $email,
                'marketing_consent' => $marketing_consent,
                'data_processing_consent' => $data_processing_consent,
                'last_update' => $last_update,
                'deal_sent' => $deal_sent,
                'lead_type' => $lead_type
            ),
        ));
        //error_log('Inserted New Post ID: ' . $post_id);
    }
    wp_reset_postdata();
    
    // Redirect to target URL
    $redirect_url = 'https://sjednej.cz/sjednavac-elektriny-analyza/';
    //error_log('Redirecting to: ' . $redirect_url . '?' . http_build_query($params));
    return rest_ensure_response(array('redirect_url' => $redirect_url . '?' . http_build_query($params)));
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/submit_form_electricity_update', array(
        'methods' => 'POST',
        'callback' => 'submit_form_electricity_update',
    ));
});

function submit_form_electricity_update(WP_REST_Request $request) {
    if (!session_id()) {
        session_start();
    }

    $params = $request->get_params();
    //error_log('Received Params: ' . print_r($params, true));

    if (!isset($_SESSION['session_id'])) {
        return new WP_Error('no_session', 'No session ID found', array('status' => 400));
    }
    $session_id = $_SESSION['session_id'];
    //error_log('Session ID: ' . $session_id);

    $pricing_name = sanitize_text_field($params['pricing_name']);
    $last_update = current_time('timestamp');
    $lead_type = 'hard';
    $value =  sanitize_text_field($params['value']);

    //error_log("Pricing Name: " . $pricing_name);
    //error_log("Last Update: " . $last_update);
    //error_log("Lead Type: " . $lead_type);

    $args = array(
        'post_type' => 'electricity_deal',
        'meta_query' => array(
            array(
                'key' => 'session_id',
                'value' => $session_id,
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    //error_log('WP_Query Arguments: ' . print_r($args, true));
    //error_log('WP_Query Found Posts: ' . $query->found_posts);

    if ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        //error_log('Updating Post ID: ' . $post_id);

        update_post_meta($post_id, 'pricing_name', $pricing_name);
        //error_log('Updated pricing_name: ' . get_post_meta($post_id, 'pricing_name', true));

        update_post_meta($post_id, 'last_update', $last_update);
        //error_log('Updated last_update: ' . get_post_meta($post_id, 'last_update', true));

        update_post_meta($post_id, 'lead_type', $lead_type);
        //error_log('Updated lead_type: ' . get_post_meta($post_id, 'lead_type', true));
        
         update_post_meta($post_id, 'value', $value);
        //error_log('Updated lead_type: ' . get_post_meta($post_id, 'lead_type', true));
    } else {
        return new WP_Error('no_post', 'No post found for session ID', array('status' => 404));
    }
    wp_reset_postdata();

    $redirect_url = 'https://sjednej.cz/sjednavac-elektriny-podekovani/';
    //error_log('Redirecting to: ' . $redirect_url);
    return rest_ensure_response(array('redirect_url' => $redirect_url));
}


/*Kalkulačka - plyn*/
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/submit_form_gas_create', array(
        'methods' => 'POST',
        'callback' => 'submit_form_gas_create',
    ));
});

function submit_form_gas_create(WP_REST_Request $request) {
    // Start session if not already started
    if (!session_id()) {
        session_start();
    }

    // Retrieve parameters from the request
    $params = $request->get_params();
    //error_log('Received Params: ' . print_r($params, true));

    // Check or create session ID
    if (!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = session_id();
    }
    $session_id = $_SESSION['session_id'];
    //error_log('Session ID: ' . $session_id);

    // Sanitize and log input data
    $current_supplier = sanitize_text_field($params['currentSupplier']);
    $consumption = intval($params['consumption']);
    $property_type = sanitize_text_field($params['propertyType']);
    $person_count = sanitize_text_field($params['personCount']);
    $usage = isset($params['usage']) && is_array($params['usage']) ? array_map('sanitize_text_field', $params['usage']) : array();
	$full_name = sanitize_text_field($params['full_name']);
    $region = sanitize_text_field($params['region']);
    $phone = sanitize_text_field($params['phone']);
    $email = sanitize_email($params['email']);
    $marketing_consent = isset($params['marketing_consent']) ? 1 : 0;
    $data_processing_consent = isset($params['data_processing_consent']) ? 1 : 0;
    $last_update = current_time('timestamp');
    $deal_sent = 0;
    $lead_type = 'soft';

    /*
    error_log("Current Supplier: " . $current_supplier);
    error_log("Circuit Breaker: " . $circuit_breaker);
    error_log("Distribution Rate: " . $distribution_rate);
    error_log("Consumption VT: " . $consumption_vt);
    error_log("Consumption NT: " . $consumption_nt);
    error_log("Property Type: " . $property_type);
    error_log("Person Count: " . $person_count);
    error_log("Usage: " . print_r($usage, true));
    error_log("Region: " . $region);
    error_log("Phone: " . $phone);
    error_log("Email: " . $email);
    error_log("Marketing Consent: " . $marketing_consent);
    error_log("Data Processing Consent: " . $data_processing_consent);
    error_log("Last Update: " . $last_update);
    error_log("Deal Sent: " . $deal_sent);
    error_log("Lead Type: " . $lead_type);
    */

    // Check if lead with the current session ID already exists
    $args = array(
        'post_type' => 'gas_deal',
        'meta_query' => array(
            array(
                'key' => 'session_id',
                'value' => $session_id,
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    //error_log('WP_Query Arguments: ' . print_r($args, true));
    //error_log('WP_Query Found Posts: ' . $query->found_posts);

    if ($query->have_posts()) {
        // Update existing lead
        $query->the_post();
        $post_id = get_the_ID();
        //error_log('Updating Post ID: ' . $post_id);
        update_post_meta($post_id, 'current_supplier', $current_supplier);
        update_post_meta($post_id, 'consumption', $consumption);
        update_post_meta($post_id, 'property_type', $property_type);
        update_post_meta($post_id, 'person_count', $person_count);
        update_post_meta($post_id, 'usage', $usage);
		update_post_meta($post_id, 'full_name', $full_name);
        update_post_meta($post_id, 'region', $region);
        update_post_meta($post_id, 'phone', $phone);
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'marketing_consent', $marketing_consent);
        update_post_meta($post_id, 'data_processing_consent', $data_processing_consent);
        update_post_meta($post_id, 'last_update', $last_update);
        update_post_meta($post_id, 'deal_sent', $deal_sent);
        update_post_meta($post_id, 'lead_type', $lead_type);
        //error_log('Updated Post Meta for Post ID: ' . $post_id);
    } else {
        // Insert new lead
        $post_id = wp_insert_post(array(
            'post_type' => 'gas_deal',
            'post_title' => 'Gas Deal - ' . $phone. " - ".$full_name,
            'post_status' => 'publish',
            'meta_input' => array(
                'session_id' => $session_id,
                'current_supplier' => $current_supplier,
                'consumption' => $consumption,
                'property_type' => $property_type,
                'person_count' => $person_count,
                'usage' => $usage,
				'full_name' => $full_name,
                'region' => $region,
                'phone' => $phone,
                'email' => $email,
                'marketing_consent' => $marketing_consent,
                'data_processing_consent' => $data_processing_consent,
                'last_update' => $last_update,
                'deal_sent' => $deal_sent,
                'lead_type' => $lead_type
            ),
        ));
        //error_log('Inserted New Post ID: ' . $post_id);
    }
    wp_reset_postdata();
    
    // Redirect to target URL
    $redirect_url = 'https://sjednej.cz/sjednavac-plyn-analyza/';
    //error_log('Redirecting to: ' . $redirect_url . '?' . http_build_query($params));
    return rest_ensure_response(array('redirect_url' => $redirect_url . '?' . http_build_query($params)));
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/submit_form_gas_update', array(
        'methods' => 'POST',
        'callback' => 'submit_form_gas_update',
    ));
});

function submit_form_gas_update(WP_REST_Request $request) {
    if (!session_id()) {
        session_start();
    }

    $params = $request->get_params();
    //error_log('Received Params: ' . print_r($params, true));

    if (!isset($_SESSION['session_id'])) {
        return new WP_Error('no_session', 'No session ID found', array('status' => 400));
    }
    $session_id = $_SESSION['session_id'];
    //error_log('Session ID: ' . $session_id);

    $pricing_name = sanitize_text_field($params['pricing_name']);
    $last_update = current_time('timestamp');
    $lead_type = 'hard';
    $value =  sanitize_text_field($params['value']);

    //error_log("Pricing Name: " . $pricing_name);
    //error_log("Last Update: " . $last_update);
    //error_log("Lead Type: " . $lead_type);

    $args = array(
        'post_type' => 'gas_deal',
        'meta_query' => array(
            array(
                'key' => 'session_id',
                'value' => $session_id,
                'compare' => '='
            )
        )
    );
    $query = new WP_Query($args);
    //error_log('WP_Query Arguments: ' . print_r($args, true));
    //error_log('WP_Query Found Posts: ' . $query->found_posts);

    if ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        //error_log('Updating Post ID: ' . $post_id);

        update_post_meta($post_id, 'pricing_name', $pricing_name);
        //error_log('Updated pricing_name: ' . get_post_meta($post_id, 'pricing_name', true));

        update_post_meta($post_id, 'last_update', $last_update);
        //error_log('Updated last_update: ' . get_post_meta($post_id, 'last_update', true));

        update_post_meta($post_id, 'lead_type', $lead_type);
        //error_log('Updated lead_type: ' . get_post_meta($post_id, 'lead_type', true));
        update_post_meta($post_id, 'value', $value);
        //error_log('Updated lead_type: ' . get_post_meta($post_id, 'lead_type', true));
    } else {
        return new WP_Error('no_post', 'No post found for session ID', array('status' => 404));
    }
    wp_reset_postdata();

    $redirect_url = 'https://sjednej.cz/sjednavac-plyn-podekovani/';
    //error_log('Redirecting to: ' . $redirect_url);
    return rest_ensure_response(array('redirect_url' => $redirect_url));
}

/*=================================
********** ENERGY - PAGE **********
=================================*/
function energy_repeater_shortcode() {
    if( have_rows('energy_s_2_repeater') ):
        $output = '<div class="energy-repeater">';
        $first = true; // Kontrola pro první položku
        while ( have_rows('energy_s_2_repeater') ) : the_row();
            if (!$first) {
                // Přidání obrázku mezi kroky
                $output .= '<div class="energy-repeater-divider"><img src="' . esc_url('http://matej.webotvurci.cz/wp-content/uploads/2024/07/Vector-8.svg') . '" alt="energie"></div>';
            }
            $first = false;
            
            $icon = get_sub_field('energy_s_2_repeater_icon');
            $title = get_sub_field('energy_s_2_repeater_title');
            $text = get_sub_field('energy_s_2_repeater_text');

            $output .= '<div class="energy-repeater-item">';
            if ($icon) {
                $output .= '<div class="energy-repeater-icon"><img src="' . esc_url($icon['url']) . '" alt="' . esc_attr($icon['alt']) . '"></div>';
            }
            if ($title) {
                $output .= '<h3 class="energy-repeater-title">' . esc_html($title) . '</h3>';
            }
            if ($text) {
                $output .= '<div class="energy-repeater-text">' . wp_kses_post($text) . '</div>';
            }
            $output .= '</div>';
        endwhile;
        $output .= '</div>';

        return $output;
    else :
        return '<p>No content found</p>';
    endif;
}
add_shortcode('energy_repeater', 'energy_repeater_shortcode');

function energy_section_shortcode($atts) {
    $content = '';

    if (have_rows('energy_s_3_repeater')) {
        while (have_rows('energy_s_3_repeater')) {
            the_row();
            
            // Get sub fields
            $background_image = get_sub_field('energy_s_3_repeater_background');
            $image = get_sub_field('energy_s_3_repeater_image');
            $title = get_sub_field('energy_s_3_repeater_title');
            $text = get_sub_field('energy_s_3_repeater_text');
            $button_text = get_sub_field('energy_s_3_repeater_button_text');
            $button_link = get_sub_field('energy_s_3_repeater_button_link');
			$button_type = get_sub_field('energy_s_3_repeater_button_type');
			
			$section_side = get_sub_field('energy_s_3_repeater_side');

			if ($section_side == 'left') {
				$content .= '<div class="energy-section left">';
			}
			if ($section_side == 'right') {
				$content .= '<div class="energy-section right">';
			}
			
            $content .= '<div class="energy-section-inner">';
            $content .= '<div class="energy-section-image" style="background-image: url(' . esc_url($background_image['url']) . ');">';
            $content .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';
            $content .= '</div>';
            $content .= '<div class="energy-section-content">';
			$content .= '<div class="energy-section-content-tiny">';
            $content .= $title;
            $content .= '<div class="energy-section-text">' . wp_kses_post($text) . '</div>';
			if ($button_type == 'energy') {
				 $content .= '<a href="' . esc_url($button_link) . '" class="energy-button energy"><span class="elementor-button-text">' . esc_html($button_text) . '</span></a>';
			}
			if ($button_type == 'fire') {
				 $content .= '<a href="' . esc_url($button_link) . '" class="energy-button fire"><span class="elementor-button-text">' . esc_html($button_text) . '</span></a>';
			}
            $content .= '</div>';
            $content .= '</div>';
			$content .= '</div>';
            $content .= '</div>';
        }
    }

    return $content;
}
add_shortcode('energy_section', 'energy_section_shortcode');

function energy_notification_box_shortcode($atts) {
    $content = '';

	$image = get_field('energy_s_4_notification_image');
	$text = get_field('energy_s_4_notification_text_bubble');
	$background_url = "https://sjednej.cz/wp-content/uploads/2024/08/textarea-blue.png";
	

	$content .= '<div class="energy-notification">';
	$content .= '<div class="energy-notification-box" style="background-image: url(' . esc_url($background_url) . ');">';
	$content .= $text;
	$content .= '</div>';
	$content .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';
	$content .= '</div>';


    return $content;
}
add_shortcode('energy_notification_box', 'energy_notification_box_shortcode');

function energy_provider_logos_shortcode($atts) {

	$content = '<div class="energy-provider-logos">';
	if (have_rows('energy_s_5_provider_logo_repeater')) {
		while (have_rows('energy_s_5_provider_logo_repeater')) {
			the_row();

			$logo = get_sub_field('energy_s_5_provider_logo_repeater_image');


			$content .= '<div class="energy-provider-logo">';
				$content .= '<img src="' . esc_url($logo['url']) . '" alt="' . esc_attr($logo['alt']) . '">';
			$content .= '</div>';
		}
	}
	$content .= '</div>';
	return $content;
}
add_shortcode('energy_provider_logos', 'energy_provider_logos_shortcode');


function energy_hp_section_shortcode($atts) {

	$content = '<div class="energy-hp-section">';
		$content .= '<div class="energy-hp-section-column energy-hp-image">';
			$content .= '<img src="https://sjednej.cz/wp-content/uploads/2024/08/Jezek-energy-page.png" alt="enerie">';
		$content .= '</div>';
		$content .= '<div class="energy-hp-section-column energy-hp-text">';
	
			$content .= '<h2>Lepší ceny elektřiny&nbsp;a&nbsp;plynu</h2>';
			$content .= '<h3>Nepřeplácíte za energie? </h3>';
			$content .= '<ul>
							<li>Kalkulačka cen elektřiny a plynu na <strong>1 místě</strong></li>
							<li>Výhodnější cenu vám sjednáme do <strong>15 minut</strong></li>
							<li>Ušetřete až <strong>9 500 Kč</strong> ročně</li>
							<li>Akční ceny energií od ověřených dodavatelů</li>
						</ul>';
			$content .= '<div class="energy-hp-buttons">';
				$content .= '<a href="https://sjednej.cz/sjednavac-elektriny/" class="energy-button energy"><span class="elementor-button-text">SPOČÍTAT elektřinu</span></a>';
				$content .= '<a href="https://sjednej.cz/sjednavac-plyn/" class="energy-button fire"><span class="elementor-button-text">SPOČÍTAT plyn</span></a>';
		$content .= '</div>';
	$content .= '</div>';
	return $content;
}
add_shortcode('energy_hp_section', 'energy_hp_section_shortcode');



/***************************
 *      SVG PODPORA
 * ************************/
// Povolit SVG soubory v mediální knihovně
function povolit_svg($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'povolit_svg');

// Zabezpečení při nahrávání SVG
function kontrola_svg($data, $file, $filename, $mimes) {
  $filetype = wp_check_filetype($filename, $mimes);
  if ($filetype['ext'] === 'svg') {
    $data['ext'] = 'svg';
    $data['type'] = 'image/svg+xml';
  }
  return $data;
}
add_filter('wp_check_filetype_and_ext', 'kontrola_svg', 10, 4);


/***************************
 *      PIPEDRIVE
 * ************************/
// Registrace vlastního intervalu pro cron
add_filter('cron_schedules', 'custom_cron_schedules');
function custom_cron_schedules($schedules) {
    $schedules['every_minute'] = array(
        'interval' => 60,
        'display' => __('Every Minute')
    );
    return $schedules;
}

// Plánování cron úlohy, pokud není naplánovaná
add_action('wp', 'schedule_custom_cron');
function schedule_custom_cron() {
    if (!wp_next_scheduled('process_leads_cron_job')) {
        wp_schedule_event(time(), 'every_minute', 'process_leads_cron_job');
    }
}

// Odebrání naplánované cron úlohy při deaktivaci pluginu nebo tématu
register_deactivation_hook(__FILE__, 'remove_custom_cron');
function remove_custom_cron() {
    $timestamp = wp_next_scheduled('process_leads_cron_job');
    wp_unschedule_event($timestamp, 'process_leads_cron_job');
}

// Přidání akce pro cron úlohu
add_action('process_leads_cron_job', 'process_leads');

// Funkce pro zpracování leadů
function process_leads() {
    // Získání aktuálního času
    $current_time = current_time('timestamp');
    error_log('Processing leads ENERGY at: ' . date('Y-m-d H:i:s', $current_time));

    // Argumenty pro WP_Query
    $args = array(
        'post_type' => 'electricity_deal',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'deal_sent',
                'value' => 0,
                'compare' => '='
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'lead_type',
                    'value' => 'hard',
                    'compare' => '='
                ),
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'lead_type',
                        'value' => 'soft',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'last_update',
                        'value' => $current_time - (15 * 60),
                        'compare' => '<'
                    )
                )
            )
        )
    );

    // Dotaz na leady
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Získání dat z leadu
            $phone = get_post_meta($post_id, 'phone', true);
            $email = get_post_meta($post_id, 'email', true);
            $full_name = get_post_meta($post_id, 'full_name', true);
            $current_supplier = get_post_meta($post_id, 'current_supplier', true);
            $circuit_breaker = get_post_meta($post_id, 'circuit_breaker', true);
            $distribution_rate = get_post_meta($post_id, 'distribution_rate', true);
            $consumption_vt = get_post_meta($post_id, 'consumption_vt', true);
            $consumption_nt = get_post_meta($post_id, 'consumption_nt', true);
            $property_type = get_post_meta($post_id, 'property_type', true);
            $person_count = get_post_meta($post_id, 'person_count', true);
            $usage = get_post_meta($post_id, 'usage', true);
            $region = get_post_meta($post_id, 'region', true);
            $marketing_consent = get_post_meta($post_id, 'marketing_consent', true);
            $data_processing_consent = get_post_meta($post_id, 'data_processing_consent', true);
            $pricing_name = get_post_meta($post_id, 'pricing_name', true);
            $last_update = get_post_meta($post_id, 'last_update', true);
            $lead_type = get_post_meta($post_id, 'lead_type', true);
            $value = get_post_meta($post_id, 'value', true);
            // Kontrola, zda je $value prázdné, null, nebo prázdný řetězec
            if (empty($value)) {
                $value = 0;
            }
            // Rozdělení jména a příjmení
            $name_parts = explode(' ', $full_name, 2);
            $first_name = $name_parts[0];
            $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

            // Úprava telefonního čísla
            $phone = str_replace(' ', '', $phone); // Odstranění mezer
            $phone = preg_replace('/^\+420/', '', $phone); // Odstranění +420

            error_log("Processing lead ID: $post_id, Email: $email, Phone: $phone");

            // Vytvoření nebo aktualizace persony v Pipedrive
            $person_id = get_pipedrive_person_id($email, $phone);

            if (!$person_id) {
                // Vytvoření nové persony
                $person_id = create_pipedrive_person(array(
                    'email' => $email,
                    'phone' => $phone,
                    'name' =>  $full_name //TEST
                ));
                error_log("Created new person ID: $person_id");
            } else {
                // Aktualizace existující persony
                error_log("Updated person ID: $person_id");
            }

            $marketing_consent = ($marketing_consent == 1 || $marketing_consent == 'on') ? 'ANO' : 'NE';
            // Vytvoření leadu v Pipedrive
            $lead_result = create_pipedrive_deal_electricity(array(
                'title' => "Elektro sjednávačka - ".$lead_type ." .".$full_name, 
                'person_id' => $person_id,
                'value' => $value , //TEST
                'custom_fields' => array(
                    'current_supplier' => $current_supplier,
                    'circuit_breaker' => $circuit_breaker,
                    'distribution_rate' => $distribution_rate,
                    'consumption_vt' => $consumption_vt,
                    'consumption_nt' => $consumption_nt,
                    'property_type' => $property_type,
                    'person_count' => $person_count,
                    'usage' => $usage,
                    'region' => $region,
                    'marketing_consent' => $marketing_consent,
                    'data_processing_consent' => $data_processing_consent,
                    'last_update' => $last_update,
                    'lead_type' => $lead_type,
                    'phone' => $phone,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email
                )
            ));
            error_log("Created electricty deal for person ID: $person_id, Result: " . print_r($lead_result, true));

            // Aktualizace deal_sent na 1
            update_post_meta($post_id, 'deal_sent', 1);
        }
    } else {
        error_log('No electricity leads to process.');
    }

    wp_reset_postdata();
    
    //GAS
    // Získání aktuálního času
    $current_time = current_time('timestamp');
    error_log('Processing leads GAS at: ' . date('Y-m-d H:i:s', $current_time));

    // Argumenty pro WP_Query
    $args = array(
        'post_type' => 'gas_deal',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'deal_sent',
                'value' => 0,
                'compare' => '='
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'lead_type',
                    'value' => 'hard',
                    'compare' => '='
                ),
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'lead_type',
                        'value' => 'soft',
                        'compare' => '='
                    ),
                    array(
                        'key' => 'last_update',
                        'value' => $current_time - (15 * 60),
                        'compare' => '<'
                    )
                )
            )
        )
    );

    // Dotaz na leady
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();

            // Získání dat z leadu
            $phone = get_post_meta($post_id, 'phone', true);
            $email = get_post_meta($post_id, 'email', true);
            $full_name = get_post_meta($post_id, 'full_name', true); // TEST
            $current_supplier = get_post_meta($post_id, 'current_supplier', true);
            $consumption = get_post_meta($post_id, 'consumption', true);
            $property_type = get_post_meta($post_id, 'property_type', true);
            $person_count = get_post_meta($post_id, 'person_count', true);
            $usage = get_post_meta($post_id, 'usage', true);
            $region = get_post_meta($post_id, 'region', true);
            $marketing_consent = get_post_meta($post_id, 'marketing_consent', true);
            $data_processing_consent = get_post_meta($post_id, 'data_processing_consent', true);
            $pricing_name = get_post_meta($post_id, 'pricing_name', true);
            $last_update = get_post_meta($post_id, 'last_update', true);
            $lead_type = get_post_meta($post_id, 'lead_type', true);
            $value = get_post_meta($post_id, 'value', true);
            // Kontrola, zda je $value prázdné, null, nebo prázdný řetězec
            if (empty($value)) {
                $value = 0;
            }

             // Rozdělení jména a příjmení
            $name_parts = explode(' ', $full_name, 2);
            $first_name = $name_parts[0];
            $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

            // Úprava telefonního čísla
            $phone = str_replace(' ', '', $phone); // Odstranění mezer
            $phone = preg_replace('/^\+420/', '', $phone); // Odstranění +420
            
            error_log("Processing GAS deal ID: $post_id, Email: $email, Phone: $phone");

            // Vytvoření nebo aktualizace persony v Pipedrive
            $person_id = get_pipedrive_person_id($email, $phone);

            if (!$person_id) {
                // Vytvoření nové persony
                $person_id = create_pipedrive_person(array(
                    'email' => $email,
                    'phone' => $phone,
                    'name' => $full_name //TEST
                ));
                error_log("Created new person ID: $person_id");
            } else {
                // Aktualizace existující persony
                error_log("Updated person ID: $person_id");
            }

            $marketing_consent = ($marketing_consent == 1 || $marketing_consent == 'on') ? 'ANO' : 'NE';
            // Vytvoření dealu v Pipedrive
            $lead_result = create_pipedrive_deal_gas(array(
                'title' => "Plyno sjednávačka - ".$lead_type ." .".$full_name, 
                'person_id' => $person_id,
                'value' => $value, //TODO
                'custom_fields' => array(
                    'current_supplier' => $current_supplier,
                    'consumption' => $consumption,
                    'property_type' => $property_type,
                    'person_count' => $person_count,
                    'usage' => $usage,
                    'region' => $region,
                    'marketing_consent' => $marketing_consent,
                    'data_processing_consent' => $data_processing_consent,
                    'last_update' => $last_update,
                    'lead_type' => $lead_type,
                    'phone' => $phone,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email
                )
            ));
            error_log("Created lead for person ID: $person_id, Result: " . print_r($lead_result, true));

            // Aktualizace deal_sent na 1
            update_post_meta($post_id, 'deal_sent', 1);
        }
    } else {
        error_log('No gas leads to process.');
    }

    wp_reset_postdata();
}

// Funkce pro komunikaci s Pipedrive

function get_pipedrive_person_id($email, $phone) {
    $api_key = PIPEDRIVE_API_KEY;
    $url = 'https://energo.pipedrive.com/api/v1/persons/search?api_token=' . $api_key . '&term=' . urlencode($email) . '&fields=email,phone';

    $response = wp_remote_get($url);
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);

    error_log("Pipedrive get_pipedrive_person_id response: " . print_r($result, true));

    if (!empty($result['data']['items'])) {
        return $result['data']['items'][0]['item']['id'];
    }

    return false;
}

function create_pipedrive_person($data) {
    $api_key = PIPEDRIVE_API_KEY;
    $url = 'https://energo.pipedrive.com/api/v1/persons?api_token=' . $api_key;

    $args = array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($data)
    );

    $response = wp_remote_post($url, $args);
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);

    error_log("Pipedrive create_pipedrive_person response: " . print_r($result, true));

    return $result['data']['id'];
}

function create_pipedrive_deal_electricity($data) {
    $api_key = PIPEDRIVE_API_KEY;
    $url = 'https://energo.pipedrive.com/api/v1/deals?api_token=' . $api_key;

   $lead_data = array(
    'title' => $data[ 'title' ],
    'person_id' => $data[ 'person_id' ],
    'value' => $data[ 'value' ], // Hodnota leadu
    'currency' => 'CZK', // Měna
    'pipeline_id' => 2,
    'stage_id' => 6,

    // Přidání vlastních polí s použitím správných ID
    '3360b9b76e1beafb7e919c22ca2abe6f4e8d6a63' => $data[ 'custom_fields' ][ 'current_supplier' ], // Aktuální dodavatel
    'd7d9c431e3164b6486c800d9aea0f29c960f2781' => $data[ 'custom_fields' ][ 'circuit_breaker' ], // Jistič
    '2a0dd3a0042455e0b08fac7f7107dbc8257495de' => $data[ 'custom_fields' ][ 'distribution_rate' ], // Distribuční sazba
    '2102f7a2b118fe569ce3c36ca3c799d6710e2552' => $data[ 'custom_fields' ][ 'consumption_vt' ], // Přesná spotřeba VT
    'b6793db31043f650e9aac45cf86d98977f46ae2b' => $data[ 'custom_fields' ][ 'consumption_nt' ], // Přesná spotřeba NT
    '7280d4522026ca6a513af002c0960b76e7a6a77c' => $data[ 'custom_fields' ][ 'property_type' ], // Druh nemovitosti
    '7d20c177496431cf510a65165b33890bf35503ec' => $data[ 'custom_fields' ][ 'person_count' ], // Počet osob
    '278761539535c229e99eebb98e9633a5acb2953d' => $data[ 'custom_fields' ][ 'usage' ], // Charakter odběru
    '3cb6ead12b1210a6e336d2b293491c7d0d493da1' => $data[ 'custom_fields' ][ 'region' ], // Kraj
    '336ed8442de2a64be959508fd5d67f6783129dbb' => $data[ 'custom_fields' ][ 'marketing_consent' ], // Marketingový souhlas
    'ed219bfaf0562553fb4f84ccf22410d06f3235cb' => "ANO", // Zpracovaní os. údajů
    'dd59b8a22613ba5d456fb0deb821d2bd1484e033' => $data[ 'custom_fields' ][ 'lead_type' ], // Lead_typ
    '84f73a2a9d9cb2f7b3abe4bf8a82037ac21cb4f5' => $data[ 'custom_fields' ][ 'usage' ], // Může mít více voleb (Pokud je 
    '148b3e066d8d60b5fa0dfaaac207aa1a5fed8a86' => $data[ 'custom_fields' ][ 'phone' ],
    'b44607cceb5d0888b234ca2384d702c01c9c8314' => $data[ 'custom_fields' ][ 'first_name' ],
    'd342ffedd0492052c5cb183ef3e5da3108ec395f' => $data[ 'custom_fields' ][ 'last_name' ],
    '9db1af1ef98e077817dd9b1ca5084e406d01b9a3' => $data[ 'custom_fields' ][ 'email' ]
       
  );

    $args = array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($lead_data)
    );

    $response = wp_remote_post($url, $args);
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);

    error_log("Pipedrive create_pipedrive_deal_electricity response: " . print_r($result, true));

    return $result;
}


function create_pipedrive_deal_gas( $data ) {
  $api_key = PIPEDRIVE_API_KEY;
  $url = 'https://energo.pipedrive.com/api/v1/deals?api_token=' . $api_key;

  $lead_data = array(
    'title' => $data[ 'title' ],
    'person_id' => $data[ 'person_id' ],
    'value' => $data[ 'value' ], // Hodnota leadu
    'currency' => 'CZK', // Měna
    'pipeline_id' => 2,
    'stage_id' => 6,

    // Přidání vlastních polí s použitím správných ID
    '3360b9b76e1beafb7e919c22ca2abe6f4e8d6a63' => $data[ 'custom_fields' ][ 'current_supplier' ], // Aktuální dodavatel
    '127534050c3472fcfe05453d4c1b0b1547829410' => $data[ 'custom_fields' ][ 'consumption' ], // Přesná spotřeba NT
    '7280d4522026ca6a513af002c0960b76e7a6a77c' => $data[ 'custom_fields' ][ 'property_type' ], // Druh nemovitosti
    '7d20c177496431cf510a65165b33890bf35503ec' => $data[ 'custom_fields' ][ 'person_count' ], // Počet osob
    '278761539535c229e99eebb98e9633a5acb2953d' => $data[ 'custom_fields' ][ 'usage' ], // Charakter odběru
    '3cb6ead12b1210a6e336d2b293491c7d0d493da1' => $data[ 'custom_fields' ][ 'region' ], // Kraj
    '336ed8442de2a64be959508fd5d67f6783129dbb' => $data[ 'custom_fields' ][ 'marketing_consent' ], // Marketingový souhlas
    'ed219bfaf0562553fb4f84ccf22410d06f3235cb' => "ANO", // Zpracovaní os. údajů
    'dd59b8a22613ba5d456fb0deb821d2bd1484e033' => $data[ 'custom_fields' ][ 'lead_type' ], // Lead_typ
    '84f73a2a9d9cb2f7b3abe4bf8a82037ac21cb4f5' => $data[ 'custom_fields' ][ 'usage' ], // Může mít více voleb (Pokud je 
    '148b3e066d8d60b5fa0dfaaac207aa1a5fed8a86' => $data[ 'custom_fields' ][ 'phone' ],
    'b44607cceb5d0888b234ca2384d702c01c9c8314' => $data[ 'custom_fields' ][ 'first_name' ],
    'd342ffedd0492052c5cb183ef3e5da3108ec395f' => $data[ 'custom_fields' ][ 'last_name' ],
    '9db1af1ef98e077817dd9b1ca5084e406d01b9a3' => $data[ 'custom_fields' ][ 'email' ]
  );

    $args = array(
        'method' => 'POST',
        'timeout' => 45,
        'headers' => array(
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($lead_data)
    );

    $response = wp_remote_post($url, $args);
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);

    error_log("Pipedrive create_pipedrive_deal_gas response: " . print_r($result, true));

    return $result;
}


/*****************
 * forms
 ****************/
function custom_popup_form_shortcode() {
	
	$content = '';

	$content .= '<div id="contact-form">';
	$content .= '<div class="popup-form">';
	$content .= '<div class="popup-close">';
	$content .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
	$content .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
	$content .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
	$content .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
	$content .= '</svg>';
	$content .= '</button>';
	$content .= '</div>';
	$content .= '<div class="popup-inner">';
	$content .= '<div class="popup-contact-wrapper">';
	// Zde bude ACF, kde uživatel vloží [popup_form form_id="id formuláře" form_type="pojisteni/pujcka"]
	$content .= do_shortcode('[contact-form-7 id="4654bde" title="test - product form - pojištění"]');
	$content .= '</div>';
	$content .= '</div>';
	$content .= '<button data-fancybox-close="" class="f-button is-close-btn" title="Close" tabindex="-1">';
	$content .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"></path></svg>';
	$content .= '</button>';
	$content .= '</div>';
	$content .= '</div>';

	return $content;
}
add_shortcode('popup_form', 'custom_popup_form_shortcode');


function popup_slider_form_shortcode() {
    // Start constructing the content with clean HTML5 slider
    $content = '<div class="custom-slider-container">';
    $content .= '<div class="custom-slider-header">';
    $content .= '<span class="slider-title">Vyberte výši půjčky</span>';
    $content .= '</div>';
    $content .= '<div class="slider-wrapper">';
	$content .= '<span class="slider-amount" id="sliderAmount">10 000 Kč</span>';
    $content .= '<input type="range" id="custom-slider" min="10000" max="1000000" value="10000" step="10000" />';
    $content .= '</div>';
    $content .= '<div class="custom-slider-values">';
    $content .= '<span>od 10 000 Kč</span><br>';
    $content .= '<span>do 1 000 000 Kč</span>';
    $content .= '</div>';
    $content .= '<p><input id="custom-requested-amount" name="requested_amount" type="hidden" value="10000"></p>';
    $content .= '<div class="custom-button-container">';
    $content .= '<a class="custom-btn" id="show-contact-form">Chci si půjčit</a>';
    $content .= '</div>';
    $content .= '</div>';
	
	$content .= '<div id="contact-form">';
	$content .= '<div class="popup-form">';
	$content .= '<div class="popup-close">';
	$content .= '<button type="button" data-fancybox-close="" aria-label="close popup">';
	$content .= '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">';
	$content .= '<path opacity="0.4" d="M22.5 41.25C32.8553 41.25 41.25 32.8553 41.25 22.5C41.25 12.1447 32.8553 3.75 22.5 3.75C12.1447 3.75 3.75 12.1447 3.75 22.5C3.75 32.8553 12.1447 41.25 22.5 41.25Z" fill="#009EE2"></path>';
	$content .= '<path d="M24.4883 22.4998L28.8008 18.1873C29.3445 17.6436 29.3445 16.7436 28.8008 16.1998C28.257 15.6561 27.357 15.6561 26.8133 16.1998L22.5008 20.5123L18.1883 16.1998C17.6445 15.6561 16.7445 15.6561 16.2008 16.1998C15.657 16.7436 15.657 17.6436 16.2008 18.1873L20.5133 22.4998L16.2008 26.8123C15.657 27.3561 15.657 28.2561 16.2008 28.7998C16.482 29.0811 16.8383 29.2123 17.1945 29.2123C17.5508 29.2123 17.907 29.0811 18.1883 28.7998L22.5008 24.4873L26.8133 28.7998C27.0945 29.0811 27.4508 29.2123 27.807 29.2123C28.1633 29.2123 28.5195 29.0811 28.8008 28.7998C29.3445 28.2561 29.3445 27.3561 28.8008 26.8123L24.4883 22.4998Z" fill="#009EE2"></path>';
	$content .= '</svg>';
	$content .= '</button>';
	$content .= '</div>';
	$content .= '<div class="popup-inner">';
	$content .= '<div class="popup-contact-wrapper">';
	// Zde bude ACF, kde uživatel vloží [popup_form form_id="id formuláře" form_type="pojisteni/pujcka"]
	$content .= do_shortcode('[contact-form-7 id="259aa79" title="test - product form - půjčka"]');
	$content .= '</div>';
	$content .= '</div>';
	$content .= '<button data-fancybox-close="" class="f-button is-close-btn" title="Close" tabindex="-1">';
	$content .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"></path></svg>';
	$content .= '</button>';
	$content .= '</div>';
	$content .= '</div>';

    // Return the constructed content
    return $content;
}
add_shortcode('popup_slider_form', 'popup_slider_form_shortcode');


/*============================================================
 * Rozcestníky/Služby - breadcrumbs
 *===========================================================*/
function sluzby_breadcrumb() {

    if (!is_single()) {
        return '';
    }

    $home_url = esc_url(home_url('/'));
    $home_icon = '<a href="' . $home_url . '"><img src="' . esc_url($home_url . 'wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;"></a>';
    $post_title = get_the_title();

    $breadcrumb = $home_icon . ' &gt; <b>' . $post_title . '</b>';

    return '<div class="custom-breadcrumb">' . $breadcrumb . '</div>';
}
add_shortcode('sluzby_breadcrumb', 'sluzby_breadcrumb');
/*
function produkty_breadcrumb() {

    if (!is_single()) {
        return '';
    }

    $home_url = esc_url(home_url('/'));
    $home_icon = '<a href="' . $home_url . '"><img src="' . esc_url($home_url . 'wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;"></a>';
    $post_title = get_the_title();

    $breadcrumb = $home_icon . ' &gt; Produkty &gt; <b>' . $post_title . '</b>';

    return '<div class="custom-breadcrumb">' . $breadcrumb . '</div>';
}
add_shortcode('produkty_breadcrumb', 'produkty_breadcrumb');
*/
function produkty_breadcrumb() {

    if (!is_single()) {
        return '';
    }

    $home_url = esc_url(home_url('/'));
    $home_icon = '<a href="' . $home_url . '"><img src="' . esc_url($home_url . 'wp-content/uploads/2024/07/Vector.svg') . '" alt="Home" style="width: 16px; height: 16px; vertical-align: middle;"></a>';
    $post_title = get_the_title();

    // Získání termínu z taxonomie 'kategorie-sluzba'
    $terms = wp_get_post_terms(get_the_ID(), 'kategorie-sluzba');
	$terms_subproduct = wp_get_post_terms(get_the_ID(), 'subprodukt');
    $category_name = '';
	$subproduct_name = '';
	
	if (!empty($terms) && !is_wp_error($terms) && !empty($terms_subproduct) && !is_wp_error($terms_subproduct)) {
		$category_name = $terms[0]->name; // Získá jméno prvního termínu
		$category_slug = $terms[0]->slug; // Získá odkaz na termín
		$subproduct_name = $terms_subproduct[0]->name;

		$posts = get_posts([
			'post_type' 	=> 'nabidka',
			'post_status' 	=> 'publish',
			'numberposts' 	=> -1,
			'title'       	=> $subproduct_name
		]);

		$subproduct_url = '';
		foreach ($posts as $post) {
			if ($post->post_title == $subproduct_name) {
				$subproduct_url = get_permalink($post->ID);
				break; // Když najdeme správný příspěvek, ukončíme smyčku
			}
		}
		
		if ($subproduct_name !== '' && $subproduct_url !== '') {
			$breadcrumb = $home_icon . ' &gt; <a href="/' . $category_slug . '">' . esc_html($category_name) . '</a> &gt; <a href="'.$subproduct_url.'">' . esc_html($subproduct_name)  . '</a>  &gt; <b>' . esc_html($post_title) . '</b>';
		} else {
			$breadcrumb = $home_icon . ' &gt; <a href="/' . $category_slug . '">' . esc_html($category_name) . '</a> &gt; <b>' . esc_html($post_title) . '</b>';
		}
		
	} elseif (!empty($terms) && !is_wp_error($terms)) {
        $category_name = $terms[0]->name; // Získá jméno prvního termínu
        $category_slug = $terms[0]->slug; // Získá odkaz na termín
		
		$breadcrumb = $home_icon . ' &gt; <a href="/' . $category_slug . '">' . esc_html($category_name) . '</a> &gt; <b>' . esc_html($post_title) . '</b>';
	
    } else {
        $breadcrumb = $home_icon . ' &gt; <b>' . esc_html($post_title) . '</b>';
    }

    return '<div class="custom-breadcrumb">' . $breadcrumb . '</div>';
}
add_shortcode('produkty_breadcrumb', 'produkty_breadcrumb');



/*============================================================
 * Rozcestníky/Služby - Přepis /sluzby/nazev => /nazev
 *===========================================================*/
function remove_sluzby_slug($post_link, $post) {
    if ('sluzby' === $post->post_type) {
        $post_link = home_url( '/' . $post->post_name . '/' );
    }
    return $post_link;
}
add_filter('post_type_link', 'remove_sluzby_slug', 10, 2);

function add_sluzby_rewrite_rules() {
    // Získat všechny příspěvky typu 'sluzby', včetně těch nepublikovaných
    $sluzby_posts = get_posts(array(
        'post_type' => 'sluzby',
        'post_status' => 'any',  // Zde změněno na 'any' pro zahrnutí všech stavů
        'numberposts' => -1
    ));

    // Pro každý příspěvek vytvořit specifické přepisovací pravidlo
    foreach ($sluzby_posts as $post) {
        add_rewrite_rule(
            '^' . $post->post_name . '/?$',
            'index.php?post_type=sluzby&name=' . $post->post_name,
            'top'
        );
    }
}
add_action('init', 'add_sluzby_rewrite_rules');


//PipeDrive form
require_once("functions/function-pipe-drive-form.php");

/* První varianta -> z měna URLs (pouze kategorie-služby) */
/*
// Funkce pro úpravu URL struktury Produkty - slug nabidka
function upravit_url_nabidky($post_link, $post) {
    if ($post->post_type === 'nabidka') {
        $terms = wp_get_object_terms($post->ID, 'kategorie-sluzba');
        if ($terms) {
            $kategorie_slug = $terms[0]->slug;
            return home_url($kategorie_slug . '/' . $post->post_name . '/');
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'upravit_url_nabidky', 10, 2);

// Přidání nového pravidla přesměrování
function pridat_rewrite_rules_nabidka() {
    add_rewrite_rule(
        '^([^/]+)/([^/]+)/?$',
        'index.php?post_type=nabidka&kategorie-sluzba=$matches[1]&nabidka=$matches[2]',
        'top'
    );
}
add_action('init', 'pridat_rewrite_rules_nabidka');

// Přidání nových pravidel přesměrování pro taxonomii `kategorie-sluzba`
function pridat_rewrite_rules_pro_kategorie_sluzba() {
    add_rewrite_rule(
        '^([^/]+)/?$',
        'index.php?kategorie-sluzba=$matches[1]',
        'top'
    );
    
    // Pravidlo pro stránkování
    add_rewrite_rule(
        '^([^/]+)/page/?([0-9]{1,})/?$',
        'index.php?kategorie-sluzba=$matches[1]&paged=$matches[2]',
        'top'
    );
}
add_action('init', 'pridat_rewrite_rules_pro_kategorie_sluzba');

// Upravte odkazy taxonomie
function upravit_kategorie_sluzba_link($link, $term, $taxonomy) {
    if ($taxonomy === 'kategorie-sluzba') {
        return home_url($term->slug);
    }
    return $link;
}
add_filter('term_link', 'upravit_kategorie_sluzba_link', 10, 3);
*/


/* Druhá varianta -> z měna URLs (kategorie + podprodukt) */
/*
// Funkce pro úpravu permalinku na základě taxonomií
function custom_nabidka_permalink($permalink, $post) {
    // Zkontrolujeme, zda se jedná o příspěvek typu 'nabidka'
    if ($post->post_type == 'nabidka') {
        // Získáme termíny taxonomií
        $kategorie_sluzba_terms = get_the_terms($post->ID, 'kategorie-sluzba');
        $subprodukt_terms = get_the_terms($post->ID, 'subprodukt');

        // Pokud je kategorie-sluzba nastavena, použijeme ji
        if ($kategorie_sluzba_terms && !is_wp_error($kategorie_sluzba_terms)) {
            $kategorie_sluzba_slug = $kategorie_sluzba_terms[0]->slug;

            // Pokud je subprodukt nastaven, přidáme ho do URL
            if ($subprodukt_terms && !is_wp_error($subprodukt_terms)) {
                $subprodukt_slug = $subprodukt_terms[0]->slug;
                $permalink = home_url('/' . $kategorie_sluzba_slug . '/' . $subprodukt_slug . '/' . $post->post_name);
            } else {
                // Pokud subprodukt není nastaven, vytvoříme URL jen s kategorií-sluzba
                $permalink = home_url('/' . $kategorie_sluzba_slug . '/' . $post->post_name);
            }
        }
    }

    return $permalink;
}
add_filter('post_type_link', 'custom_nabidka_permalink', 10, 2);

// Přepisovací pravidla pro zajištění správného routingu URL
function custom_nabidka_rewrite_rules() {
    // Pravidlo pro URL ve formátu /kategorie-sluzba/subprodukt/nazev
    add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?nabidka=$matches[3]', 'top');

    // Pravidlo pro URL ve formátu /kategorie-sluzba/nazev
    add_rewrite_rule('^([^/]+)/([^/]+)/?$', 'index.php?nabidka=$matches[2]', 'top');
}
add_action('init', 'custom_nabidka_rewrite_rules');
*/




/*
// 1. Upravit přepisovací pravidla pro CPT 'nabidka'
function modify_nabidka_cpt_args( $args, $post_type ) {
    if ( 'nabidka' === $post_type ) {
        $args['rewrite'] = array(
            'slug'       => '%kategorie-sluzba%',
            'with_front' => false,
        );
    }
    return $args;
}
add_filter( 'register_post_type_args', 'modify_nabidka_cpt_args', 10, 2 );

// 2. Upravit permalinky pro příspěvky 'nabidka'
function custom_nabidka_permalink( $post_link, $post ) {
    if ( 'nabidka' === $post->post_type ) {
        $terms = wp_get_post_terms( $post->ID, 'kategorie-sluzba' );
        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            $term_slug = $terms[0]->slug;
        } else {
            $term_slug = 'nabidka';
        }
        return str_replace( '%kategorie-sluzba%', $term_slug, $post_link );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'custom_nabidka_permalink', 10, 2 );

// 3. Přesměrovat staré URL 'nabidka' na nové
function redirect_old_nabidka_urls() {
    if ( is_singular( 'nabidka' ) ) {
        global $post;
        $requested_url  = untrailingslashit( home_url( $_SERVER['REQUEST_URI'] ) );
        $correct_url    = untrailingslashit( get_permalink( $post->ID ) );

        if ( $requested_url !== $correct_url ) {
            wp_redirect( $correct_url, 301 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'redirect_old_nabidka_urls' );
*/
