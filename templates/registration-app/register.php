<?php get_header(); ?>

  <div class="container">
    <div id="content-area" class="clearfix">
      <?php get_sidebar(); ?>
      <div id="left-area">
        <div class="entry post registration-app clearfix">
          <div class="header well">
            <h2>“What’s Left?”</h2>

            <h3>2013 Annual Meeting</h3>

            <p>Maritime Conference, The United Church of Canada<br>
              Thursday, May 31 (7:00 pm) - Sunday, June 3 (12:00 pm)<br>
              Sackville, New Brunswick</p>

            <h3>Time and Location for Registration</h3>

            <p><strong>*** Attendance must be confirmed at the registration desk upon arrival. ***</strong><br>
              Registration is located at Tantramar Veterans Memorial Civic Centre<br>
              May 31, Thursday, from 11:00 am to 8:30 pm and June 1, Friday, starting at 8:30 am</p>
          </div>
          <?php scaleup_the_form( 'registration' ); ?>
          <div class="footer well">
            <p>Following the action of the Conference Sub Executive, March 2011, we continue to work towards reducing
              the cost of printing and mailing of Conference materials. Please note:</p>
            <ul>
              <li>Reports to Conference will be available on the Conference website. Permission is given to download
                Conference materials to electronic devices. DO NOT RELY ON THE WIRELESS INTERNET SERVICE AT THE ARENA.
                Necessary print materials will be provided upon arrival to the meeting. One print copy of all materials
                will be provided to each table group.
              </li>
              <li>Minutes of Conference, when available, will be posted to the Conference website.</li>
              <li>Directory of Conference is available on the Conference website and is constantly updated.</li>
              <li>Members of Conference without personal access to the internet are urged to develop relationships that
                would provide them with access and to work on how to make internet resources more accessible in their
                Pastoral Charges.
              </li>
            </ul>
          </div>
        </div>
        <!-- end .entry -->
      </div>
      <!-- end #left-area -->
    </div>
    <!-- end #content-area -->
  </div> <!-- end .container -->

  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      $( "#new-person").hide();
      $( "#field_person_id" ).select2({
        placeholder: 'Search by "Last Name, First Name"',
        minimumInputLength: 3,
        ajax: {
          url: "people/search",
          dataType: 'json',
          quietMillis: 300,
          data: function (term, paged) { // page is the one-based page number tracked by Select2
            return {
              s: term, //search term
            };
          },
          results: function (data, paged) {
            var more = (paged * 10) < data.total; // whether or not there are more results available

            // notice we return the value of more so Select2 knows if more results can be loaded
            return data;
          }
        }
      });
      $( "#field_person_id").change( function(){
        if ( 0 == $(this).attr( 'value' ) ) {
          $( "#new-person").show();
        } else {
          $( "#new-person").hide();
          var person_id = $(this).attr( 'value' );
          $.ajax( 'people/'+person_id).done(function(data){
            console.log( data );
          });
        }
      })
    });

  </script>

<?php get_footer(); ?>