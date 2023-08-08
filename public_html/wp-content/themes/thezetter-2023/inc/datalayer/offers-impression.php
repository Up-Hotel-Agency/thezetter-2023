<script>
    /*
    * This is the code to record offer impressions
    */
    dataLayer = [];
    dataLayer.push({
      'ecommerce': {
        'currencyCode': 'GBP',

        'promoView': {
          'promotions': [
            <?php
            $posts = array();
            $posts = get_posts(array(
                'post_type'         => 'offer',
                'posts_per_page'    => -1
            ));
            ?>
            <?php $count = 0; foreach($posts as $post): setup_postdata( $post ); ?>
            {
                'id': '<?php echo $post->post_name; ?>',
                'name': '<?php the_title(); ?> - <?php the_field('location_name','options'); ?>',
                'position': <?php echo $count; ?>,
                'destinationUrl': '<?php the_permalink(); ?>',
            },
            <?php $count++; endforeach; wp_reset_postdata(); ?>
            ]
        }
      }
    });
  </script>