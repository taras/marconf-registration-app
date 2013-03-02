<?php
/**
 * Plugin Name: Registration App
 */

add_action( 'scaleup_app_init', function () {
  /**
   * Marconf Registration app allows visitors to register for an upcoming conference.
   *
   * Class Marconf_Registration_App
   */
  class Marconf_Registration_App extends ScaleUp_App {

    function init() {

      $this->set( 'name', 'marconf_registration' );

      $this->set( 'url', '/annual-meeting/delegate-visitor-registration-new' );

      /**
       * New User Form
       */
      $this->register( 'form', array(
        'name'        => 'registration',
        'form_fields' => array(
          'attributes'       => array(
            'label'   => 'Check all that apply.',
            'type'    => 'checkbox',
            'options' => array(
              'delegate'        => 'Delegate',
              'new-delegate'    => 'New Delegate',
              'visitor'         => 'Visitor',
              'resource-person' => 'Resource Person',
              '2012-ordinand'   => '2012 Ordinand / Commissionand',
              'ecumenical'      => 'Ecumenical Guest',
            ),
          ),
          'type_of_delegate' => array(
            'label'   => 'What type of delegate are you?',
            'type'    => 'radio',
            'options' => array(
              '711' => 'Ministry Personnel',
              '382' => 'Lay',
              ''    => 'Other',
            ),
          ),
          'shuttle_pass'     => array(
            'label'      => 'I will be using the shuttle bus and require a pass.',
            'validation' => array( 'required' ),
            'type'       => 'radio',
            'options'    => array(
              '0' => 'No',
              '1' => 'Yes'
            ),
          ),
          'info'    => array(
            'type'    => 'html',
            'content' => '<p class="alert alert-info">If you attended Annual Conference in 2011 or 2012 then your information should already be on file in our website Directory.</p>'
          ),
          'person_id' => array(
            'type'        => 'text',
            'label'       => 'Enter your "Last Name, First Name" to find your record',
            'placeholder' => 'Search by last name',
            'options'     => array( '' => '' ),
            'validation'  => array( array( $this, 'is_person' ) ),
            'class'       => 'wide-field',
            'before'      => '<p class="small">or choose "Not in directory" if you are not in the directory or your record cannot be found.</p>',
            'after'       => '<button id="not-in-directory" class="btn btn-small btn-info">Not In Directory</button>',
          ),
          'fieldset_new_person_open'    => array(
            'type'    => 'html',
            'content' => '<fieldset id="new-person"><legend>Create a new record</legend>'
          ),
          'salutation'       => array(
            'label'    => 'Salutation',
            'type'     => 'select',
            'options'  => array(
              ''       => '',
              'ms.'    => 'Ms.',
              'mr.'    => 'Mr.',
              'mrs.'   => 'Mrs.',
              'rev'    => 'Rev.',
              'dr.'    => 'Dr.',
              'rev-dr' => 'Rev. Dr.',
            ),
            'template' => 'select2',
          ),
          'first_name'       => array(
            'label'      => 'First name',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'last_name'        => array(
            'label'      => 'Last name',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'street_address'   => array(
            'label'      => 'Address',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'address_line2'    => array(
            'label' => 'Address Line 2',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'city'             => array(
            'label'      => 'City',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'province'         => array(
            'label'      => 'Province',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'postal_code'      => array(
            'label'      => 'Postal Code',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'country'          => array(
            'label'      => 'Country',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'charge'           => array(
            'label'    => 'Presbytery & Pastoral Charge',
            'type'     => 'select',
            'options'  => array( $this, 'get_charge_options' ),
            'template' => 'select2',
            'class'    => 'wide-field',
            'params'   => array(
              'placeholder' => 'Select your Presbytery & Pastoral Charge',
            ),
          ),
          'email'            => array(
            'label'      => 'Email',
            'type'       => 'text',
            'validation' => array( 'email' ),
            'class'      => 'input-large',
          ),
          'second_email'     => array(
            'label'      => 'Second Email',
            'type'       => 'text',
            'validation' => array( 'email' ),
            'class'      => 'input-large',
          ),
          'photo'            => array(
            'label' => 'Photo for directory',
            'type'  => 'file',
            'class' => 'input-large',
          ),
          'work_phone'       => array(
            'label' => 'Work Phone',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'home_phone'       => array(
            'label' => 'Home Phone',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'mobile_phone'     => array(
            'label' => 'Mobile / Cell Phone',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'fax'              => array(
            'label' => 'Fax',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'ministry_status'  => array(
            'label'    => 'Ministry Status',
            'type'     => 'select',
            'options'  => array(
              ''   => '',
              'RT' => 'Retired',
              'SP' => 'Special Ministry',
              'RN' => 'Retained on the Roll',
            ),
            'template' => 'select2',
            'params'   => array(
              'placeholder' => 'Select your Ministry Status',
            ),
          ),
          'designation'      => array(
            'label'    => 'Designation',
            'type'     => 'select',
            'options'  => array(
              ''       => '',
              'OM'     => 'Ordained Minister',
              'DM'     => 'Diaconal Minister',
              'IM'     => 'Interim Minister',
              'DLM'    => 'Designated Lay Minister',
              'DLM-RT' => 'Designated Lay Minister (retired)',
              'CDM'    => 'Congregationally Designated Ministry',
              'US'     => 'United [Ordained] Supply',
              'DS'     => 'Diaconal Supply',
              'RS'     => 'Retired Supply',
              'TM'     => 'Team Minister',
              'CS'     => 'Candidate Supply',
              'SS'     => 'Student Supply',
              'IS'     => 'Intern Supply',
              'OS'     => 'Ordained Supply (other denomination)',
            ),
            'template' => 'select2',
            'class'    => 'wide-field',
            'params'   => array(
              'placeholder' => 'Select your Designation',
            ),
          ),
          'comments'         => array(
            'label' => 'Other Comments?',
            'type'  => 'textarea',
            'class' => 'input-large',
          ),
          'fieldset_new_person_close'    => array(
            'type'    => 'html',
            'content' => '</fieldset> <!-- close #new-person ( open_fieldset ) -->',
          ),
          'submit'           => array(
            'type'  => 'button',
            'value' => 'new_registrant',
            'text'  => 'Register',
            'class' => 'btn btn-primary'
          ),
        ),
      ) );

      /**
       * Registration template
       */
      $this->register( 'template', array(
        'name'     => 'registration_app_register',
        'path'     => dirname( __FILE__ ) . '/templates',
        'template' => '/registration-app/register.php',
        'assets'   => array(
          'registration_app_bootstrap_css' => array(
            'type' => 'style',
            'src'  => '/registration-app/templates/registration-app/bootstrap.css',
          ),
          'registration_app_register_css'  => array(
            'type' => 'style',
            'src'  => '/registration-app/templates/registration-app/register.css',
          )
        ),
      ) );

      $this->register( 'template', array(
        'name'     => 'registration_app_register_person',
        'path'     => dirname( __FILE__ ) . '/templates',
        'template' => '/registration-app/person.php',
      ) );


      /**
       * Main Registration view
       */
      $this->register( 'view', array(
        'name' => 'registration',
        'url'  => '',
      ) );

      /**
       * Person Schema
       */
      $this->register( 'schema', array(
        'post_type'  => 'people',
        'properties' => array(
          'first_name'      => array(
            'meta_key' => 'ecpt_first-name'
          ),
          'last_name'       => array(
            'meta_key' => 'ecpt_last-name'
          ),
          'salutation'      => array(
            'meta_key' => 'ecpt_salutation'
          ),
          'designation'     => array(
            'meta_key' => 'ecpt_designation',
          ),
          'ministry_status' => array(
            'meta_key' => 'ecpt_ministry'
          ),
          'street_address'  => array(
            'meta_key' => 'ecpt_street-address'
          ),
          'address_line2'   => array(
            'meta_key' => 'ecpt_address-line2'
          ),
          'city'            => array(
            'meta_key' => 'ecpt_city'
          ),
          'province'        => array(
            'meta_key' => 'ecpt_province',
          ),
          'postal_code'     => array(
            'meta_key' => 'ecpt_postal-code',
          ),
          'work_phone'      => array(
            'meta_key' => 'ecpt_work-phone'
          ),
          'home_phone'      => array(
            'meta_key' => 'ecpt_home-phone',
          ),
          'mobile_phone'    => array(
            'meta_key' => 'ecpt_mobile-phone'
          ),
          'fax'             => array(
            'meta_key' => 'ecpt_fax',
          ),
          'email'           => array(
            'meta_key' => 'ecpt_email'
          ),
          'second_email'    => array(
            'meta_key' => 'ecpt_second-email'
          ),
          'website'         => array(
            'meta_key' => 'ecpt_website'
          ),
          'existingvalues'  => array(
            'meta_key' => '_existingvalues',
          )
        ),
      ) );

      /**
       * Register people search view
       */
      $this->register( 'view', array(
        'name' => 'people_search',
        'url'  => '/people/search',
      ) );

      /**
       * Register people view
       */
      $this->register( 'view', array(
        'name'  => 'people',
        'url'   => '/people/{id}'
      ));

    }

    /**
     * Return array of Presbytery & Pastoral Charges used as callback for options for charge field.
     *
     * @return array
     */
    function get_charge_options() {

      if ( false === ( $options = get_transient( 'registration-app-charge-options' ) ) ) {

        $options = array( '' => '' );

        $parents = get_terms( array( 'directory' ), array(
          'parent' => 62,
        ) );

        foreach ( $parents as $parent ) {
          $children                    = get_terms( array( 'directory' ), array(
            'parent' => $parent->term_id,
          ) );
          $options[ $parent->term_id ] = "{$parent->name}";
          foreach ( $children as $child ) {
            $options[ $child->term_id ] = "{$parent->name} - {$child->name}";
          }
        }

        set_transient( 'registration-app-charge-options', $options, 60 * 60 * 12 );

      }

      return $options;
    }

    /**
     * Check provided value is an actual person.
     *
     * Callback for person field validation.
     *
     * @param $field ScaleUp_Form_Field
     * @return bool
     */
    function is_person( $field ) {

      /**
       * @todo: implement is_person validation filter callback
       */

      return $field;
    }

    /**
     * Return associative array of people.
     * Key is person id and value is person's name.
     *
     * Callback function for people field
     *
     * @return array
     */
    function get_people_options() {

      $people = array();

      /**
       * @todo: implement get_people_options callback function
       */

      return $people;
    }

    /**
     * Callback for GET request to registration view
     *
     * @param $args
     * @return bool
     */
    function get_registration( $args ) {

      get_template_part( '/registration-app/register.php' );

      // return true causes ScaleUp to return HTML Status 200 and terminate further execution ( which we want )
      return true;
    }

    /**
     * Callback to POST request to registration view
     *
     * @param $args
     * @return bool
     */
    function post_registration( $args ) {

      /**
       * sanity check, cause the only thing that's happening here is related to registration form
       */
      if ( 'registration' != $args[ 'form_name' ] ) {
        return false;
      }

      /** @var $form ScaleUp_Form */
      $form = $this->get_feature( 'form', $args[ 'form_name' ] );
      $form->load( $args );
      if ( $form->validates() ) {
        $person = get_item( 'person' );
        $person->load( $args );
        $result = $person->save();
        if ( is_wp_error( $result ) ) {
          $this->register( 'message', array(
            'text' => $result->get_error_message(),
            'type' => 'error'
          ) );
        }
      } else {
        $this->register( 'alert', array(
          'msg'  => 'Your submission did not pass validation. Please, verify the required fields and resubmit.',
          'type' => 'warning'
        ) );
      }

      get_template_part( '/registration-app/register.php' );

      // return true causes ScaleUp to return HTML Status 200 and terminate further execution ( which we want )
      return true;

    }

    /**
     * Callback to AJAX request to people search
     *
     * @param $args
     * @return bool
     */
    function get_people_search( $args ) {

      $query_args = array(
        'post_type'      => 'people',
        'post_status'    => 'publish',
        'meta_query'     => array(
          array(
            'key'     => 'ecpt_last-name',
            'compare' => 'LIKE',
          ),
        ),
        'posts_per_page' => -1,
      );
      if ( isset( $args[ 's' ] ) ) {
        $query_args[ 'meta_query' ][ 0 ][ 'value' ] = esc_sql( $args[ 's' ] );
      }

      $p          = new stdClass();
      $p->id      = -1;
      $p->text    = 'Not In Directory';

      $results = array();
      $results[] =  $p;
      $query   = new WP_Query( $query_args );
      if ( $query->post_count > 0 ) {
        $posts = $query->get_posts();
        foreach ( $posts as $post ) {
          $p          = new stdClass();
          $p->id      = $post->ID;
          $p->text    = $post->post_title;
          $results[ ] = $p;
        }
      }

      $wrapper          = new stdClass();
      $wrapper->results = $results;
      header( 'Content-Type: application/json' );
      echo json_encode( $wrapper );

      // return true causes ScaleUp to return HTML Status 200 and terminate further execution ( which we want )
      return true;
    }

    /**
     * Callback function for /people/{id} ajax call
     * @param $args
     * @return bool
     */
    function get_people( $args ) {

      if ( isset( $args[ 'id' ] ) && 0 < $args[ 'id' ] ) {
        global $post;
        $post = get_post( $args[ 'id' ] );
        setup_postdata( $post );
        get_template_part( '/registration-app/person.php' );
      }

      return true;
    }

  }

  new Marconf_Registration_App();

} );
