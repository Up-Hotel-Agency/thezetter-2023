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
            {
                'id': '<?php echo $post->post_name; ?>',
                'name': '<?php the_title(); ?> - <?php the_field('location_name','options'); ?>',
                'destinationUrl': '<?php the_permalink(); ?>',
            }
            ]
        }
      }
    });
  </script>