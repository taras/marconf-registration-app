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
        'name'        => 'new_registrant',
        'form_fields' => array(
          'attributes'      => array(
            'label'      => 'Check all that apply.',
            'type'       => 'checkbox',
            'options'    => array(
              'female'             => 'Female',
              'male'               => 'Male',
              'delegate'           => 'Delegate',
              'new-delegate'       => 'New Delegate',
              'visitor'            => 'Visitor',
              'ministry-personnel' => 'Ministry Personnel',
              'lay'                => 'Lay',
              'resource-person'    => 'Resource Person',
              '2012-ordinand'      => '2012 Ordinand / Commissionand',
              'ecumenical'         => 'Ecumenical Guest',
            ),
            'validation' => array( 'required' ),
          ),
          'salutation'      => array(
            'label'   => 'Salutation',
            'type'    => 'select',
            'options' => array(
              'ms.'    => 'Ms.',
              'mr.'    => 'Mr.',
              'mrs.'   => 'Mrs.',
              'rev'    => 'Rev.',
              'dr.'    => 'Dr.',
              'rev-dr' => 'Rev. Dr.',
            ),
          ),
          'first_name'      => array(
            'label'      => 'First name',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'last_name'       => array(
            'label'      => 'Last name',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'street_address'  => array(
            'label'      => 'Address',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'address_line2'   => array(
            'label' => 'Address Line 2',
            'type'  => 'text',
          ),
          'city'            => array(
            'label'      => 'City',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'province'        => array(
            'label'      => 'Province',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'postal_code'     => array(
            'label'      => 'Postal Code',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'country'         => array(
            'label'      => 'Country',
            'type'       => 'text',
            'validation' => array( 'required' ),
          ),
          'charge'          => array(
            'label'   => 'Presbytery & Pastoral Charge',
            'type'    => 'select',
            'options' => array( $this, 'get_charge_options' ),
          ),
          'email'           => array(
            'label'      => 'Email',
            'type'       => 'text',
            'validation' => array( 'email' ),
          ),
          'second_email'    => array(
            'label'      => 'CC Email',
            'type'       => 'text',
            'validation' => array( 'email' ),
          ),
          'photo'           => array(
            'label' => 'Photo for directory',
            'type'  => 'file',
          ),
          'work_phone'      => array(
            'label' => 'Work Phone',
            'type'  => 'text',
          ),
          'home_phone'      => array(
            'label' => 'Home Phone',
            'type'  => 'text',
          ),
          'mobile_phone'    => array(
            'label' => 'Mobile / Cell Phone',
            'type'  => 'text',
          ),
          'fax'             => array(
            'label' => 'Fax',
            'type'  => 'text',
          ),
          'ministry_status' => array(
            'label'   => 'Ministry Status',
            'type'    => 'select',
            'options' => array(
              'RT' => 'RT - Retired',
              'SP' => 'SP - Special Ministry',
              'RN' => 'RN - Retained on the Roll'
            ),
          ),
          'designation'     => array(
            'label'   => 'Designation',
            'type'    => 'select',
            'options' => array(
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
          ),
          'shuttle_pass'    => array(
            'label'      => 'I will be using the shuttle bus and require a pass.',
            'validation' => array( 'required' ),
            'type'       => 'radio',
            'options'    => array(
              '0' => 'No',
              '1' => 'Yes'
            ),
          ),
          'comments'        => array(
            'label' => 'Other Comments?',
            'type'  => 'textarea',
          ),
          'submit'          => array(
            'type'  => 'button',
            'value' => 'new_registrant',
            'text'  => 'Submit'
          )
        ),
      ) );

      /**
       * Register the existing user form
       */
      $this->register( 'form', array(
        'name'        => 'existing_registrant',
        'form_fields' => array(
          'person.id' => array(
            'type'       => 'select',
            'options'    => array( $this, 'get_people_options' ),
            'validation' => array( 'required', array( $this, 'is_person' ) )
          ),
          'submit'    => array(
            'type'  => 'button',
            'value' => 'existing_registrant',
            'text'  => 'Submit',
          )
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
          'registration_app_register' => array(
            'type' => 'script',
            'src'  => '/registration-app/templates/registration-app/register.js',
            'deps' => array( 'jquery' ),
          )
        ),
      ) );

      $this->register( 'template', array(
        'template' => '/graph/piechart.php',
        'path'     => dirname( __FILE__ ) . '/templates',
        'delay'    => true,
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

    }

    /**
     * Return array of Presbytery & Pastoral Charges used as callback for options for charge field.
     *
     * @return array
     */
    function get_charge_options() {
      $options = array( '' => 'not applicable' );

      if ( false === ( $options = get_transient( 'registration-app-charge-options' ) ) ) {

        $parents = get_terms( array( 'directory' ), array(
          'parent'    => 62,
        ));

        foreach ( $parents as $parent ) {
          $children = get_terms( array( 'directory' ), array(
            'parent'  => $parent->term_id,
          ));
          $options[ $parent->term_id ] = "{$parent->name}";
          foreach ( $children as $child ) {
            $options[ $child->term_id ] = "{$parent->name} - {$child->name}";
          }
        }

        set_transient( 'registration-app-charge-options', $options );

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

      switch ( $args[ 'form_name' ] ) :
        case 'new_registrant':
        case 'existing_registrant':
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
              'msg' => 'Your submission did not pass validation. Please, verify the required fields and resubmit.',
              'type' => 'warning'
            ) );
          }
          break;
        default:
          // we got a submission without from non existant form - something went borked, let's return a 404
          return false;
      endswitch;

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
    function ajax_people_search( $args ) {

      /**
       * @todo: implement code to find person by name
       */

      // return true causes ScaleUp to return HTML Status 200 and terminate further execution ( which we want )
      return true;
    }

  }

  new Marconf_Registration_App();

} );
