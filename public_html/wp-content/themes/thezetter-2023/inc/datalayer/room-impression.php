<script>
    /*
    * This is the code to record room impressions
    */
    dataLayer = [];
    dataLayer.push({
      'ecommerce': {
        'currencyCode': 'GBP',

        'detail': {
          'products': [
            {
                'id': '<?php echo $post->post_name; ?>',
                'name': '<?php the_title(); ?>',
                'destinationUrl': '<?php the_permalink(); ?>',
            }
            ]
        }
      }
    });
  </script>