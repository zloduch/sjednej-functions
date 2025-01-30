<?php
/* uložení DEALu do CPF */
add_action( 'wpcf7_before_send_mail', 'cf_store_lead_data' );

function cf_store_lead_data( $contact_form ) {
  // Zkontrolujte, jestli formulář obsahuje pole "api_key"
  $submission = WPCF7_Submission::get_instance();
  if ( $submission ) {
    $data = $submission->get_posted_data();

    // Debug - logování celého formuláře
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
      error_log( 'Celá data formuláře: ' . print_r( $data, true ) );
    }

    if ( isset( $data[ 'id_pipedrive' ] ) ) {

      // Debug - logování dat
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Formulářová data: ' . print_r( $data, true ) );
      }

      // Namapujte data na ACF hodnoty
      $first_name = sanitize_text_field( $data[ 'p_first_name' ] ?? '' );
      $last_name = sanitize_text_field( $data[ 'p_last_name' ] ?? '' );
      $email = sanitize_email( $data[ 'p_email' ] ?? '' );
      $phone = sanitize_text_field( $data[ 'p_phone' ] ?? '' );

      $id_pipedrive = absint( $data[ 'id_pipedrive' ] ?? 0 );
      $id_pipeline = absint( $data[ 'id_pipeline' ] ?? 0 );
      $id_product = absint( $data[ 'id_product' ] ?? 0 );
      $id_stage = absint( $data[ 'id_stage' ] ?? 0 );

      // Inicializace proměnných pro data person a deal
      $person_data = [];
      $deal_data = [];

      // Ošetření souhlasu - seznam checkboxů
      $checkbox_names = array(
        '336ed8442de2a64be959508fd5d67f6783129dbb',
        'cf0292b488c9aacb8d5df5ddd1b8d746098f8e92',
        'ed219bfaf0562553fb4f84ccf22410d06f3235cb',
        'c90fd641cb48088d2657475772fb868e5842a201',
        '6fce3e668619f1af0a8bed1e6f0138a675a043fe',
        '877633914bc62abc7a51d274ed7ca73117c4af58'
      );

      // Najděte a zpracujte pole s klíčem odpovídajícím regexu (40 hexadecimálních znaků)
      foreach ( $data as $key => $value ) {
        if ( preg_match( '/^p_[a-f0-9]{40}$/', $key ) ) {
          // Zpracování person dat
          $clean_key = substr( $key, 2 );
          if ( in_array( $clean_key, $checkbox_names ) ) {
            $person_data[ $clean_key ] = empty( $value ) ? 'NE' : 'ANO';
          } else {
            $person_data[ $clean_key ] = sanitize_text_field( $value );
          }
        } elseif ( preg_match( '/^d_[a-f0-9]{40}$/', $key ) ) {
          // Zpracování deal dat
          $clean_key = substr( $key, 2 );
          if ( in_array( $clean_key, $checkbox_names ) ) {
            $deal_data[ $clean_key ] = empty( $value ) ? 'NE' : 'ANO';
          } else {
            $deal_data[ $clean_key ] = sanitize_text_field( $value );
          }
        }
      }

      // JSON encode pro person a deal data
      $data_json_person = wp_json_encode( $person_data );
      $data_json_deal = wp_json_encode( $deal_data );

      // Debug - logování JSON dat
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'JSON data person: ' . $data_json_person );
        error_log( 'JSON data deal: ' . $data_json_deal );
      }

      // Získejte aktuální datum a čas v CZ formátu
      $date_received = date( 'd.m.Y H:i:s' );

      // Debug - logování datumu přijetí
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Datum přijetí: ' . $date_received );
      }

      // Vytvořte nový custom post typu "pipedrive-data"
      $post_id = wp_insert_post( [
        'post_type' => 'pipedrive-data',
        'post_status' => 'publish',
        'post_title' => 'Lead - ' . $first_name . ' ' . $last_name,
        'meta_input' => [
          'id_pipedrive' => $id_pipedrive,
          'id_pipeline' => $id_pipeline,
          'id_product' => $id_product,
          'id_stage' => $id_stage,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'email' => $email,
          'phone' => $phone,
          'data_json_person' => $data_json_person,
          'data_json_deal' => $data_json_deal,
          'date_received' => $date_received,
          'number_of_attempts' => 0,
          'status' => "awaiting dispatch",
          'data_send' => "no",
          'debug_person' => "nothing",
          'debug_deal' => "nothing"
        ]
      ] );

      // Debug - logování ID nového příspěvku
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'ID nového příspěvku: ' . $post_id );
      }
    }
  }
}


/* Odeslání LEADU */
// Nastav CRON akci
// Přidání minutového intervalu
function cf_pipedrive_form_custom_cron_intervals( $schedules ) {
  $schedules[ 'every_minute' ] = array(
    'interval' => 60, // 60 sekund
    'display' => esc_html__( 'Každou minutu' ),
  );
  return $schedules;
}
add_filter( 'cron_schedules', 'cf_pipedrive_form_custom_cron_intervals' );

// Naplánování úlohy
function cf_schedule_pipedrive_form_cron_job() {
  if ( !wp_next_scheduled( 'cf_send_leads_to_pipedrive_form_cron_hook' ) ) {
    wp_schedule_event( time(), 'every_minute', 'cf_send_leads_to_pipedrive_form_cron_hook' );
  }
}
add_action( 'wp', 'cf_schedule_pipedrive_form_cron_job' );

// Přidání funkce do cron hooku
add_action( 'cf_send_leads_to_pipedrive_form_cron_hook', 'cf_send_leads_to_pipedrive_function' );


function cf_send_leads_to_pipedrive_function() {
  error_log( "START CRON" );
  $args = array(
    'post_type' => 'pipedrive-data',
    'meta_query' => array(
      array(
        'key' => 'data_send',
        'value' => 'no',
        'compare' => '=',
        'type' => 'CHAR'
      ),
      array(
        'key' => 'number_of_attempts',
        'value' => 2, //TODO
        'compare' => '<',
        'type' => 'NUMERIC'
      )
    ),
    'posts_per_page' => 10
  );


  $query = new WP_Query( $args );
  error_log( "Počet: " . $query->found_posts );
  if ( $query->have_posts() ) {
    $query->the_post();
    $post_id = get_the_ID();

    // Zvýšení počtu pokusů
    $attempts = get_post_meta( $post_id, 'number_of_attempts', true );
    $new_attempts = ( int )$attempts + 1;
    update_post_meta( $post_id, 'number_of_attempts', $new_attempts );


    // Získej data leadu
    $first_name = get_post_meta( $post_id, 'first_name', true );
    $last_name = get_post_meta( $post_id, 'last_name', true );
    $email = get_post_meta( $post_id, 'email', true );
    $phone = get_post_meta( $post_id, 'phone', true );
    $id_pipeline = get_post_meta( $post_id, 'id_pipeline', true );
    $id_stage = get_post_meta( $post_id, 'id_stage', true );
    $id_pipedrive = get_post_meta( $post_id, 'id_pipedrive', true );
    $title = "DEMO - " . get_the_title( $post_id );
    $data_json_person = json_decode( get_post_meta( $post_id, 'data_json_person', true ), true );
    $data_json_deal = json_decode( get_post_meta( $post_id, 'data_json_deal', true ), true );
    $full_name = $first_name . " " . $last_name;

    // Dynamicky sestav API klíč a URL
    $api_key = constant( 'PIPEDRIVE_API_KEY_' . $id_pipedrive );
    $api_url = constant( 'PIPEDRIVE_API_URL_' . $id_pipedrive );

    // Odeslání do Pipedrive
    // Vytvoření nebo aktualizace persony v Pipedrive
    $person_id = cf_get_pipedrive_person_id( $email, $phone, $full_name, $api_key, $api_url, $post_id );

    if ( !$person_id ) {
      // Vytvoření nové persony
      $lead_data_person = array(
        'email' => $email,
        'phone' => $phone,
        'name' => $full_name
      );

      //přidání JSON dat
      if ( is_array( $data_json_person ) ) {
        $lead_data_person = array_merge( $lead_data_person, $data_json_person );
      }

      $person_id = cf_update_or_create_pipedrive_person( $lead_data_person, $api_key, $api_url, $post_id, $person_id );
      error_log( "Created new person ID: $person_id" );
    } else {
      // Aktualizace existující persony
      error_log( "Updated person ID: $person_id" );
    }

    // Vytvoření LEAD DATA
    $lead_data = array(
      'title' => $title,
      'person_id' => $person_id,
      'value' => 0, // Hodnota leadu
      'currency' => 'CZK', // Měna
      'pipeline_id' => $id_pipeline,
      'stage_id' => $id_stage
    );

    //přidání JSON dat
    if ( is_array( $data_json_deal ) ) {
      $lead_data = array_merge( $lead_data, $data_json_deal );
    }


    $deal_response = cf_create_pipedrive_deal( $lead_data, $api_key, $api_url, $post_id );

    if ( isset( $deal_response[ 'data' ][ 'id' ] ) ) {
      // Lead úspěšně odeslán
      update_post_meta( $post_id, 'data_send', 'yes' );
      update_post_meta( $post_id, 'status', 'send' );
    } else {

      // Debugování
      error_log( "Lead ID: $post_id - Pokus o odeslání neúspěšný, počet pokusů: $new_attempts" );

      // Pokud počet pokusů překročí 3, nastav data_send a status na 'error'
      if ( $new_attempts > 3 ) {
        error_log( "Lead ID: $post_id - Počet pokusů překročen, nastavuji status 'error'" );
        if ( $new_attempts > 3 ) {
          update_post_meta( $post_id, 'data_send', 'error' );
          update_post_meta( $post_id, 'status', 'error' );
        }
      }
    }
  }
  wp_reset_postdata();
  error_log( "END CRON" );
}


// Funkce pro ověření Persony v Pipedrive
function cf_get_pipedrive_person_id( $email, $phone, $full_name, $api_key, $api_url, $post_id ) {
  $url = $api_url . '/api/v1/persons/search?api_token=' . $api_key . '&term=' . urlencode( $email ) . ',' . urlencode( $phone ) . ',' . urlencode( $full_name ) . '&fields=email,phone,name';

  $response = wp_remote_get( $url );
  $body = wp_remote_retrieve_body( $response );
  $result = json_decode( $body, true );

  error_log( "Pipedrive get_pipedrive_person_id response: " . print_r( $result, true ) );
  $sanitized_data = htmlspecialchars( json_encode( $result, JSON_PRETTY_PRINT ), ENT_QUOTES, 'UTF-8' );
  update_post_meta( $post_id, 'debug_person', $sanitized_data );

  if ( !empty( $result[ 'data' ][ 'items' ] ) ) {
    foreach ( $result[ 'data' ][ 'items' ] as $item ) {
      if ( isset( $item[ 'result_score' ] ) && $item[ 'result_score' ] >= 0.50 ) {
        if ( isset( $item[ 'item' ][ 'name' ] ) && stripos( $item[ 'item' ][ 'name' ], $first_name ) !== false && stripos( $item[ 'item' ][ 'name' ], $last_name ) !== false ) {
          return $item[ 'item' ][ 'id' ];
        }
      }
    }
  }

  return false;
}

// Funkce pro aktualizaci nebo vytvoření persony v Pipedrive
function cf_update_or_create_pipedrive_person( $data, $api_key, $api_url, $post_id, $person_id = null ) {
  if ( $person_id ) {
    // Update person
    $url = $api_url . '/api/v1/persons/' . $person_id . '?api_token=' . $api_key;
    $args = array(
      'method' => 'PUT',
      'timeout' => 45,
      'headers' => array(
        'Content-Type' => 'application/json'
      ),
      'body' => json_encode( $data )
    );
    $action = 'Updated';
  } else {
    // Create new person
    $url = $api_url . '/api/v1/persons?api_token=' . $api_key;
    $args = array(
      'method' => 'POST',
      'timeout' => 45,
      'headers' => array(
        'Content-Type' => 'application/json'
      ),
      'body' => json_encode( $data )
    );
    $action = 'Created new';
  }

  $response = wp_remote_post( $url, $args );
  $body = wp_remote_retrieve_body( $response );
  $result = json_decode( $body, true );

  error_log( "Pipedrive {$action}_pipedrive_person response: " . print_r( $result, true ) );
  $sanitized_data = htmlspecialchars( json_encode( $result, JSON_PRETTY_PRINT ), ENT_QUOTES, 'UTF-8' );

  update_post_meta( $post_id, 'debug_person', $sanitized_data );

  return $result[ 'data' ][ 'id' ];
}

// Funkce pro vytvoření leadu v Pipedrive
function cf_create_pipedrive_deal( $data, $api_key, $api_url, $post_id ) {
  error_log( 'Vytvářím deal v Pipedrive: ' . print_r( $data, true ) );
  $url = $api_url . '/api/v1/deals?api_token=' . $api_key;

  $args = array(
    'method' => 'POST',
    'timeout' => 45,
    'headers' => array(
      'Content-Type' => 'application/json'
    ),
    'body' => json_encode( $data )
  );

  $response = wp_remote_post( $url, $args );
  $body = wp_remote_retrieve_body( $response );
  $result = json_decode( $body, true );
  error_log( "Pipedrive create_pipedrive_deal response: " . print_r( $result, true ) );
  $sanitized_data = htmlspecialchars( json_encode( $result, JSON_PRETTY_PRINT ), ENT_QUOTES, 'UTF-8' );

  update_post_meta( $post_id, 'debug_deal', $sanitized_data );

  return $result;
}
?>