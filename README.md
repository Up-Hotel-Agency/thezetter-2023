# Base WP Template

  Use this to create most excellent WordPress sites.

# local setup
These are the prerequisites you need:

  1. Node version 14 LTS: https://nodejs.org/en/download/

  2. Requires Docker for Mac (if setting up locally on a Mac):

      bash start

To access your new WordPress site, visit <http://localhost>
  Trouble loading the site? Check that the ports defined in docker-compose.yml are the same as above.

# Logging in to Wordpress:

  A user is set up automatically – you will be able to find the correct login details on Lastpass (search for 'localhost')

# To export the database:

    bash export /tmp/dump.sql
      Tip: You can change this path to anything you like ('tmp' is used as an example)

# To import a database and install local WP:

    Add as a .sql dump into /db
    Run the following - the second parameter is what the URL will be the remote url (e.g. www.my-hotel-site.com)
    ./import localhost:4444

# To expose your wordpress site on the local network:

  1. Get your local network IP address     `ifconfig | grep 192 | awk '{print $2}'`

  2. Run this to update your local copy:     `docker-compose run --rm "wordpress" wp search-replace 'localhost' '<your ip address>'`

  3. Now you can access this from other devices on the same network with <your ip address>:4000 - useful for testing on other devices or web browser types

# Use the checklist

  follow the checklist to get up and running with your project. You can duplicate this template to your project and work on it there.
  https://app.asana.com/0/1199630890885629/list

# Gitlab Repo Setup

  Follow these steps for when the new repo for your site has been created:

  1. Go into your new repo and hit `Settings -> CI/CD` in the sidebar

  2. Expand the `Variables` section

  3. Create a new variable called `DEPLOY_TARGET`, and set it to where your site will be deployed (`ukservers` or `wpengine`)

  -------------------------------

  If `DEPLOY_TARGET` = `ukservers`

  4. Create 3 new variables in the same section:
    - `SERVER_ADDRESS` (the IP address of the server the site will be hosted on)
    - `WHM_ACCOUNT_NAME` (the username of the account in WHM/cPanel)
    - `SSH_PASSWORD` (the password used to log into the server the site will be hosted on)

    Fill these in with their respective values
    
    a. If you're getting a permission denied error when SSHing, you may need to append any $ in the SSH_PASSWORD with another $ so that Gitlab ignores it and doesn't try to expand it as a variable.

  5. Hit `CI/CD -> Pipelines` on the sidebar, and hit `Run Pipeline` to run the pipeline for the first time. Your site now has continuous deployment!

  If `DEPLOY_TARGET` = `wpengine`

  4. Create 6 new variables in the same section:
  
    - `STAGING_SFTP_URL` (The SFTP URL of the Staging site on WPEngine)
    - `STAGING_SFTP_USER` (The name of the SFTP User for the Staging site on WPEngine)
    - `STAGING_SFTP_PASS` (The password of the SFTP User for the Staging site on WPEngine)
    - `PROD_SFTP_URL` (The SFTP URL of the Production site on WPEngine)
    - `PROD_SFTP_USER` (The name of the SFTP User for the Production site on WPEngine)
    - `PROD_SFTP_PASS` (The password of the SFTP User for the Production site on WPEngine)

    Fill these in with their respective values

  5. Hit `CI/CD -> Pipelines` on the sidebar, and hit `Run Pipeline` to run the pipeline for the first time. Your site now has continuous deployment! Note: to deploy to production, the deploy job needs manual approval/activation

  -------------------------------
  
# before initial upload of theme folder

  1. change theme folder name from thezetter-2023 to a relevant name for the client
  2. edit names / labels in style.css
  3. edit author META tag in header.php
  4. update screenshot.png - needs to be 880 x 660 and a .png, designers should provide
  5. do a find and replace of "thezetter-2023" to your new theme folder name to update all assets / paths
  6. overwrite favicon set (provided by designers)
  7. overwrite google map pins (if required, provided by designers)

# install

  1. Install gulp & deps
      `cd public_html/wp-content/themes/thezetter-2023`
      `npm install`
  2. Modify `inc/cpts/cpts.php` to match what's required for your site, delete blocks not required
      - select which single templates you want to use in the cpt files
  3. Remove any Gutenberg blocks not required (delete the folder itself)
  4. Select your desired header and footer in setup-header.php and setup-footer.php
      - also select the relevant scss for both in abovethefold.scss and global.scss

# initial wp-admin changes to activate UP Core

  The order is important.
  1. Go to `/wp-admin/plugins.php` and enable ACF *first* - otherwise when you activate the theme you'll get an error fest
  2. Go to `/wp-admin/themes.php` and enable the renamed UP Core

# prep your WP install

  1. Delete hello world post
  2. Settings > Permalinks: post name
  3. Edit sample page - delete content and rename to home page, and alter slug. Save.
  4. Settings > General: change site title / tagline
  5. Settings > Reading: front page displays a static page: home page
  6. Settings > Discussion: untick all default article settings
  7. If you have a sitemap, create all pages with no content in to create the structure of the site
  8. Create menus and assign them to their locations
  9. Add pages into menus
  10. Sync ACF (see below)
  11. Users > Your Profile > Untick "Show Toolbar when viewing site"
  12. Go forth and style!

# ACF

  we have the /acf-json/ folder in the theme folder, which is automatically updated when you modify the fields in the WP dashboard.

  initially, you'll need to go into custom fields > sync and sync all groups

# watching for SASS changes etc

  cd to theme dir eg: `cd public_html/wp-content/themes/thezetter-2023`
  then run `npx gulp watch`

  Please note we have the following generated stylesheets:
  1. abovethefold.css
  2. global.css
  3. a separate css file for each gutenberg block

  abovethefold.css is manually outputted within a style tag in the <head> for page speed optimisation
    this should only include base and grid styles, header and banner

  each gutenberg block's css file is enqueued when the block is registered. this is to stop unnecessary css being loaded in each page

  global.css is the rest of the styles and is also loaded in the footer to avoid being render blocking

# JS

  rather than enqueuing JS in functions.php, we include them in footer.js

  `npx gulp watch` will automatically concatonate the files (unmified)

  we have the following JS files:
  1. libs.min.js - this concatenates all the REQUIRED JS libraries files added to the src/js/libs/ folder (minified). Please note the order is random, so if you have a library dependent on another, combine them both in the same js file in the required order
  2. main.js - anything else goes in here
  3. a separate JS file for each gutenberg block

  we use Autoptimize to concatonate and minify *all* CSS and JS together into 1 file each (as plugins usually addd a load in too)

# using images

  We use sourceset as well as lazy loading if appropriate (don't use lazy loading on *the first* image above the fold)
  In the function options you can specify the default image size (using the add_image_size set in functions) as well as lazyload true / false
  The following examples use the template found in templates/img_sizes.tpl.php
  Example using an ACF image field (return value must be ID): `<?php echo img_sizes(get_field('image_field'), ['default' => 'img_1024', 'lazy_load' => false]); ?>`
  Example using the posts thumbnail: `<?php echo img_sizes(get_post_thumbnail_id(), ['default' => 'img_1024', 'lazy_load' => false]); ?>`
  These images use object-fit (notice the polyfill JS for IE - ofi.browser.js)
  Additional options are available, check out `srcset.php` to see

# CPTs and base templates

  we have simple CPTs, listing Gutenberg blocks, and singles already setup as a basis to start. Simply modify or remove.

# Headers and footers

  we have 3 different types of headers and footers to use pre-built.

  to select a header:
  1. go to setup-header.php and set the header type
  2. go to abovethefold.scss and comment in the relevant scss file for the header

  to select a footer:
  1. go to setup-footer.php and set the footer type
  2. go to global.scss and comment in the relevant scss file for the footer

    these are just starting points, so ideally you should delete all the other header / footer styles and html, as well as copy and paste the contents of the template into the WP header.php and footer.php

# other templates

  # blog
  select a blog listing and single style in setup-blog.php

  # offers
  In inc/cpt/offers.php select your offers listing / single type

  # rooms
  In inc/cpt/rooms.php select your rooms listing / single type

  # event
  In inc/cpt/events.php select your event listing / single type

# carousel / sliders

  We use slick carousel http://kenwheeler.github.io/slick/
  Examples are already within main.js

# button shortcodes

  We have a shortcode set up in functions.php to be used in the editor. The most basic usage is:
  [button link="https://google.com"]Click me[/button] which will create `<a href="https://google.com" class="button">Click me</a>`
  But you can add extra settings such as:
  target="target type"
  type="extra classes go here"

# datepickers

  We use flatpickr for the booking mask datepicker
  If datepickers are required please go to global.scss make sure the following styles are included (yes by default):
  @import "utilities/flatpickr";
  javascript code can be found in booking_mask.js

# modals

  We use fancybox v3 for modals, this is already activated in main.js http://fancyapps.com/fancybox/3/
  Just add data tag to element to use: data-fancybox

# contact forms

  Install Contact Form 7 plugin for contact forms

# google maps API embed

  Example can be found in the google_map and neighbourhood gutenberg block JS

# instagram feeds

  we use an API-free Instagram feed, examples can be found on a number of our sites (just ask)

# multi-lingual

  We use WPML for multi-lingual sites https://wpml.org/
  use <?php languages_list(); ?> where you want to display the language switcher

# post launch optimisation

  Please visit the wiki to see the latest optimisation techniques: https://adao.co.uk/wiki/post-launch-optimisation/
