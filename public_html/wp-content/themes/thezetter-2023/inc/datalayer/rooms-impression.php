<script>
    /*
    * This is the code to record room impressions
    */
    dataLayer = [];
    dataLayer.push({
      'ecommerce': {
        'currencyCode': 'GBP',
        'impressions': [
            <?php
            $posts = array();
            $posts = get_posts(array(
                'post_type'         => 'room',
                'posts_per_page'    => -1
            ));
            ?>
            <?php $count = 0; foreach($posts as $post): setup_postdata( $post ); ?>
            {
                'name': '<?php the_title(); ?>',
                <?php if( get_field('room_type') ): ?>'id': '<?php the_field('room_type'); ?>',<?php endif; ?>
                <?php if( get_field('from_price') ): ?>'price': '<?php the_field('from_price'); ?>',<?php endif; ?>
                'brand': 'SafeStay',
                'category': 'Rooms',
                'variant': '<?php the_title(); ?>',
                'list': 'Rooms Page <?php the_field('location_name', 'options'); ?>',
                'position': <?php echo $count; ?>,
                'url': '<?php the_permalink(); ?>'
            },
            <?php $count++; endforeach; wp_reset_postdata(); ?>
        ]
      }
    });
  </script>