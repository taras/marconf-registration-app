<?php
global $post;

$thisPerson = get_person_metadata( get_the_ID() );

$infoToDisplay = array(
  'personFormalName',
  'ministrystatus',
  'designation',
  'streetaddress',
  'addressline2',
  'cityProvince',
  'postalcode',
  'personEmail',
  'personPhone',
  'personWebsite'
);
?>
<div id="personalInformation">
  <div class="post entry">
    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) ) ?>
    <?php foreach ( $infoToDisplay as $displayOrder => $infoName ) : ?>
      <?php if ( trim( $thisPerson[ $infoName ] ) != "" ) : echo $thisPerson[ $infoName ] . '<br />'; endif; ?>
    <?php endforeach; ?>
      <?php echo $thisPerson[ 'personDirectoryOrgs-single' ]; ?>
  </div>
  <a class="btn btn-warning btn-small" href="<?php echo get_bloginfo( 'home' ) . '/people/' . $post->post_name; ?>">Correct this record</a>
</div>
