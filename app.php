<?php
/**
 * Marconf Registration app allows visitors to register for an upcoming conference.
 *
 * Class Marconf_Registration_App
 */
class Marconf_Registration_App extends ScaleUp_App {

  function initization() {

    $this->set( 'url', '/annual-meeting/delegate-visitor-registration' );

    $header_content = <<<HTML
<h3>“What’s Left?”</h3>
<h4>2013 Annual Meeting</h4>
<p>Maritime Conference, The United Church of Canada<br>
Thursday, May 31 (7:00 pm) - Sunday, June 3 (12:00 pm)<br>
Sackville, New Brunswick</p>
<h4>Time and Location for Registration</h4>
<p><strong>*** Attendance must be confirmed at the registration desk upon arrival. ***</strong><br>
Registration is located at Tantramar Veterans Memorial Civic Centre<br>
May 31, Thursday, from 11:00 am to 8:30 pm and June 1, Friday, starting at 8:30 am</p>
HTML;

    $footer_content = <<<HTML
<p>Following the action of the Conference Sub Executive, March 2011, we continue to work towards reducing the cost of printing and mailing of Conference materials. Please note:</p>
<ul>
    <li>Reports to Conference will be available on the Conference website. Permission is given to download Conference materials to electronic devices. DO NOT RELY ON THE WIRELESS INTERNET SERVICE AT THE ARENA. Necessary print materials will be provided upon arrival to the meeting. One print copy of all materials will be provided to each table group.</li>
    <li>Minutes of Conference, when available, will be posted to the Conference website.</li>
    <li>Directory of Conference is available on the Conference website and is constantly updated.</li>
    <li>Members of Conference without personal access to the internet are urged to develop relationships that would provide them with access and to work on how to make internet resources more accessible in their Pastoral Charges.</li>
</ul>
HTML;

    $this->register( 'form', array(
      'name'      => 'new',
      'fields'    => array(
        'header'    => array(
          'type'      => 'html',
          'content'   => $header_content
        ),
        'attributes' => array(
          'type'      => 'checkbox',
          'options'   => array(
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
          'validation'  => array( 'required' ),
        ),
        'salutation'    => array(
          'type'    => 'select',
          'options' => array(
            'ms.'      => 'Ms.',
            'mr.'      => 'Mr.',
            'mrs.'     => 'Mrs.',
            'rev'      => 'Rev.',
            'dr.'      => 'Dr.',
            'rev-dr'   => 'Rev. Dr.',
          ),
        ),
        'givenName' => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'familyName'  => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'address1'    => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'address2'    => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'city'    => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'province'    => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'post_code'    => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'country'    => array(
          'type'        => 'text',
          'validation'  => array( 'required' ),
        ),
        'charge'     => array(
          'type'        => 'select',
          'options'     => array( $this, 'get_charge_options' ),
        ),
        'email'        => array(
          'type'        => 'text',
          'validation'  => array( 'email' ),
        ),
        'email2'       => array(
          'type'        => 'text',
          'validation'  => array( 'email' ),
        ),
        'photo'        => array(
          'type'        => 'file',
        ),
        'work_phone'   => array(
          'type'        => 'text',
        ),
        'home_phone'   => array(
          'type'        => 'text',
        ),
        'mobile_phone'   => array(
          'type'        => 'text',
        ),
        'fax'   => array(
          'type'        => 'text',
        ),
        'ministry_status'   => array(
          'type'        => 'select',
          'options'     => array(
            'RT' => 'RT - Retired',
            'SP' => 'SP - Special Ministry',
            'RN' => 'RN - Retained on the Roll'
          ),
        ),
        'designation' => array(
          'label'   => 'Designation',
          'type'    => 'select',
          'options' => array(
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
        'shuttle_pass'  => array(
          'label'         => 'I will be using the shuttle bus and require a pass.',
          'validation'    => array( 'required' ),
          'type'          => 'checkbox',
          'options'       => array(
            '0' => 'No',
            '1' => 'Yes'
          ),
        ),
        'comments'  => array(
          'label' => 'Other Comments?',
          'type'  => 'textarea',
        ),
        'footer'    => array(
          'type'      => 'html',
          'content'   => $footer_content
        ),
        'submit'    => array(
          'type'      => 'button',
        )
      ),
    ));

    $this->register( 'form', array(
      'name'      => 'existing',
      'fields'    => array(
        'person.id'    => array(
          'type'        => 'select',
          'options'     => array( $this, 'get_people_options' ),
          'validation'  => array( 'required', array( $this, 'is_person' ) )
        ),
        'submit'    => array(
          'type'      => 'button',
        )
      ),
    ));

    $this->register( 'template', array(
      'name'      => 'registration_app_register',
      'path'      => dirname( __FILE__ . '/templates' ),
      'template'  => '/registration-app/register.php',
    ));

    $this->register( 'view', array(
      'name'  => 'registration',
      'url'   => '',
    ) );

    /**
     * @todo: add person schema
     */

  }

  /**
   * Return array of Presbytery & Pastoral Charges used as callback for options for charge field.
   *
   * @return array
   */
  function get_charge_options() {
    $options = array();

    /**
     * @todo: implement this function
     */

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
    get_template_part( '/registration-app/register.php' );

    if ( isset( $args[ 'submit' ] ) ) {

      $form_name = $args[ 'submit' ];

      switch ( $form_name ) :
        case 'new':
        case 'existing':
          $form = get_form( $form_name );
          $form->load( $args );
          if ( $form->validates() ) {
            $person = get_item( 'person' );
            $person->load( $args );
            $result = $person->save();
            if ( is_wp_error( $result ) ) {
              $this->register( 'message', array(
                'text'   => $result->get_error_message(),
                'type' => 'error'
              ));
            }
          } else {
            $this->register( 'message', array(
              'text' => 'Your submission did not pass validation. Please, verify the required fields and resubmit.',
              'type' => 'alert'
            ));
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


  }

  /**
   * Callback to AJAX request to registration view
   *
   * @param $args
   * @return bool
   */
  function ajax_registration( $args ) {
    get_template_part( '/registration-app/register.php' );

    switch ( $args[ 'action' ] ) {
      case 'find_person':
        /**
         * @todo: implement code to find person by name
         */
        break;
      default:
        /**
         * return failed status
         */
        return false;
    }

    // return true causes ScaleUp to return HTML Status 200 and terminate further execution ( which we want )
    return true;
  }

}
new Marconf_Registration_App();