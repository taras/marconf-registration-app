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
        'notify'      => array(
          array(
            'method'  => 'email',
            'to'      => array( $this, '_get_email' ),
            'subject' => 'You are registered to the 2013 Annual Meeting',
            'message' => 'We look forward to seeing you.',
          ),
        ),
        'store'       => array(
          'schemas' => array( 'person' )
        ),
        'form_fields' => array(
          'attributes'                => array(
            'label'   => 'Check all that apply.',
            'type'    => 'checkbox',
            'options' => array(
              'Delegate'                      => 'Delegate',
              'New Delegate'                  => 'New Delegate',
              'Visitor'                       => 'Visitor',
              'Resource Person'               => 'Resource Person',
              '2012 Ordinand / Commissionand' => '2012 Ordinand / Commissionand',
              'Ecumenical Guest'              => 'Ecumenical Guest',
            ),
          ),
          'delegate'                  => array(
            'label'   => 'What type of delegate are you?',
            'type'    => 'radio',
            'options' => array(
              '711' => 'Ministry Personnel',
              '382' => 'Lay',
            ),
          ),
          'shuttle_pass'              => array(
            'label'      => 'I will be using the shuttle bus and require a pass.',
            'validation' => array( 'required' ),
            'type'       => 'radio',
            'options'    => array(
              '0' => 'No',
              '1' => 'Yes'
            ),
          ),
          'info'                      => array(
            'type'    => 'html',
            'content' => '<p class="alert alert-info">If you attended Annual Conference in 2011 or 2012 then your information should already be on file in our website Directory.</p>'
          ),
          'id'                        => array(
            'type'        => 'text',
            'label'       => 'Enter your "Last Name, First Name" to find your record',
            'placeholder' => 'Search by last name',
            'options'     => array( '' => '' ),
            'class'       => 'wide-field',
            'before'      => '<p class="small">or choose "Not in directory" if you are not in the directory or your record cannot be found.</p>',
            'after'       => '<button id="not-in-directory" class="btn btn-small btn-info">Not In Directory</button>',
          ),
          'fieldset_new_person_open'  => array(
            'type'    => 'html',
            'content' => '<fieldset id="new-person"><legend>Create a new record</legend>'
          ),
          'salutation'                => array(
            'label'    => 'Salutation',
            'type'     => 'select',
            'options'  => array(
              ''         => '',
              'Ms.'      => 'Ms.',
              'Mr.'      => 'Mr.',
              'Mrs.'     => 'Mrs.',
              'Rev.'     => 'Rev.',
              'Dr.'      => 'Dr.',
              'Rev. Dr.' => 'Rev. Dr.',
            ),
            'template' => 'select2',
          ),
          'first_name'                => array(
            'label'      => 'First name',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'last_name'                 => array(
            'label'      => 'Last name',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'street_address'            => array(
            'label'      => 'Address',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'address_line2'             => array(
            'label' => 'Address Line 2',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'city'                      => array(
            'label'      => 'City',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'province'                  => array(
            'label'      => 'Province',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'postal_code'               => array(
            'label'      => 'Postal Code',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'country'                   => array(
            'label'      => 'Country',
            'type'       => 'text',
            'validation' => array( 'required' ),
            'class'      => 'input-large',
          ),
          'charge'                    => array(
            'label'    => 'Presbytery & Pastoral Charge',
            'type'     => 'select',
            'options'  => array( $this, 'get_charge_options' ),
            'template' => 'select2',
            'class'    => 'wide-field',
            'params'   => array(
              'placeholder' => 'Select your Presbytery & Pastoral Charge',
            ),
          ),
          'email'                     => array(
            'label'      => 'Email',
            'type'       => 'text',
            'validation' => array( 'email' ),
            'class'      => 'input-large',
          ),
          'second_email'              => array(
            'label'      => 'Second Email',
            'type'       => 'text',
            'validation' => array( 'email' ),
            'class'      => 'input-large',
          ),
          'photo'                     => array(
            'label' => 'Photo for directory',
            'type'  => 'file',
            'class' => 'input-large',
          ),
          'work_phone'                => array(
            'label' => 'Work Phone',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'home_phone'                => array(
            'label' => 'Home Phone',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'mobile_phone'              => array(
            'label' => 'Mobile / Cell Phone',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'fax'                       => array(
            'label' => 'Fax',
            'type'  => 'text',
            'class' => 'input-large',
          ),
          'ministry_status'           => array(
            'label'    => 'Ministry Status',
            'type'     => 'select',
            'options'  => array(
              ''                          => '',
              'RT - Retired'              => 'RT - Retired',
              'SP - Special Ministry'     => 'SP - Special Ministry',
              'RN - Retained on the Roll' => 'Retained on the Roll',
            ),
            'template' => 'select2',
            'params'   => array(
              'placeholder' => 'Select your Ministry Status',
            ),
          ),
          'designation'               => array(
            'label'    => 'Designation',
            'type'     => 'select',
            'options'  => array(
              ''                                           => '',
              'OM - Ordained Minister'                     => 'OM - Ordained Minister',
              'DM - Diaconal Minister'                     => 'DM - Diaconal Minister',
              'IM - Interim Minister'                      => 'IM - Interim Minister',
              'DLM - Designated Lay Minister'              => 'DLM - Designated Lay Minister',
              'DLM-RT - Designated Lay Minister (retired)' => 'DLM-RT - Designated Lay Minister (retired)',
              'CDM - Congregationally Designated Ministry' => 'CDM - Congregationally Designated Ministry',
              'US - United [Ordained] Supply'              => 'US - United [Ordained] Supply',
              'DS - Diaconal Supply'                       => 'DS - Diaconal Supply',
              'RS - Retired Supply'                        => 'RS - Retired Supply',
              'TM - Team Minister'                         => 'TM - Team Minister',
              'CS - Candidate Supply'                      => 'CS - Candidate Supply',
              'SS - Student Supply'                        => 'SS - Student Supply',
              'IS - Intern Supply'                         => 'IS - Intern Supply',
              'OS - Ordained Supply (other denomination)'  => 'OS - Ordained Supply (other denomination)',
            ),
            'template' => 'select2',
            'class'    => 'wide-field',
            'params'   => array(
              'placeholder' => 'Select your Designation',
            ),
          ),
          'gender'                    => array(
            'label'   => 'Gender',
            'type'    => 'radio',
            'options' => array( 'Male' => 'Male', 'Female' => 'Female' ),
          ),
          'comments'                  => array(
            'label' => 'Other Comments?',
            'type'  => 'textarea',
            'class' => 'input-large',
          ),
          'fieldset_new_person_close' => array(
            'type'    => 'html',
            'content' => '</fieldset> <!-- close #new-person ( open_fieldset ) -->',
          ),
          'conferences'               => array(
            'type'   => 'hidden',
            'value'  => 'name=2013',
            'format' => 'args_string',
          ),
          'submit'                    => array(
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
      register_schema( 'people', array(
        'post_type'       => 'people',
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
        ),
        'delegate'        => array(
          'type'     => 'taxonomy',
          'taxonomy' => 'directory',
        ),
        'conferences'     => array(
          'type'     => 'taxonomy',
          'taxonomy' => 'conferences',
        ),
        'gender'          => array(
          'meta_key' => 'gender',
        )
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
        'name' => 'people',
        'url'  => '/people/{id}'
      ) );

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

      $item = new_item( 'people' );

      /** @var $form ScaleUp_Form */
      $form = $this->get_feature( 'form', 'registration' );

      /**
       * Callback function that removes required from new person registration form fields
       *
       * @param $form ScaleUp_Form
       * @param $args
       */
      $form->make_optional = function ( $form, $args ) {
        $fields = array( 'first_name', 'last_name', 'street_address', 'city', 'province', 'postal_code', 'country' );
        foreach ( $fields as $field_name ) {
          /** @var $field ScaleUp_Form_Field */
          $field = $form->get_feature( 'form_field', $field_name );
          $field->remove_validation( 'required' );
        }

        return $args;
      };

      if ( isset( $args[ 'id' ] ) && $args[ 'id' ] > 0 ) {
        /**
         * If a person was selected then make "new person" fields optional and remove values from args
         */
        $form->add_filter( 'process', array( $form, 'make_optional' ), 25 );
        $form->add_filter( 'process', function ( $args ) {
          $fields = array( 'salutation', 'first_name', 'last_name', 'street_address', 'address_line2', 'city', 'province',
            'postal_code', 'country', 'charge', 'email', 'second_email', 'photo', 'work_phone', 'home_phone', 'mobile_phone',
            'fax', 'ministry_status', 'designation', 'gender', 'comments', );
          foreach ( $fields as $field ) {
            unset( $args[ $field ] );
          }
          return $args;
        }, 35 );
      } else {
        /**
         * If a new person is being created then create a post title from Last name, First name
         * To add the post title we hook a function into form "process" filter
         */
        $form->add_filter( 'process', function ( $args ) {
          $args[ 'post_title' ] = "{$args[ 'last_name' ]}, {$args[ 'first_name' ]}";
          unset( $args[ 'id' ] );
          return $args;
        }, 35 );
      }

      /**
       * Store item after form is validated
       */
      $form->add_action( 'store', array( $item, 'store' ) );

      /**
       * process the from from $args
       */
      $form->process( $args );
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

      $p       = new stdClass();
      $p->id   = 0;
      $p->text = 'Not In Directory';

      $results    = array();
      $results[ ] = $p;
      $query      = new WP_Query( $query_args );
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

    /**
     * Return email of the registrant
     *
     * @param $form ScaleUp_Form
     * @return string
     */
    function _get_email( $form ) {
      $form  = $this->get_feature( 'form', 'registration' );
      $field = $form->get_feature( 'form_field', 'email' );

      return $field->get( 'value' );
    }

  }

  new Marconf_Registration_App();

} );
