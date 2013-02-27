<?php get_header(); ?>

  <div class="container">
    <div id="content-area" class="clearfix">
      <?php get_sidebar(); ?>
      <div id="left-area">
        <div class="entry post clearfix">
          <div class="header">
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
          <div id="accordion">
            <h4>New</h4>

            <?php scaleup_the_form( 'new_registrant' ); ?>
            <h4>Existing</h4>

            <?php scaleup_the_form( 'existing_registrant' ); ?>
          </div>
          <div class="footer">
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

<?php get_footer(); ?>