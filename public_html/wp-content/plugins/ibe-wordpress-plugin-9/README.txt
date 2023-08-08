=== Plugin Name ===
Contributors: Luke Clifton (UP Hotel Agency)
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a WordPress shortcode for adding the UP Booking Engine widget into your site

== Installation ==

= Download =

Download the [Download](https://ibe-wordpress-plugin-bucket.s3-eu-west-1.amazonaws.com/ibe-wordpress-plugin.zip "WordPress Plugin")

= Setup =

Enable the plugin and then add the following shortcode in your page:

```
[up-booking-engine ibe_key="YOUR-IBE-KEY" language="en"]
```

Just change the `ibe_key` attribute to your ibe-key given to you in the UP Booking Engine admin area.
The `language` attribute can also be changed to change the IBE language.

When using this plugin, you do not need to add the JS & CSS file, as the plugin will include this for you.

== Booking Mask Redirect Path ==

You can also pass a redirect path as an attribute to redirect users when they complete a search to your main IBE page.

```
[up-booking-engine ibe_key="YOUR-IBE-KEY" language="en" mask-redirect-path="YOUR-MAIN-IBE-PAGE"]
```

This is a relative path i.e. `/main-page.html`

== Default Property ==

Specifies the default property to be selected when the IBE is first launched.
It can be found in the admin page under PMS ID.

```
[up-booking-engine ibe_key="YOUR-IBE-KEY" language="en" default-property-id="PROPERTY-ID"]
```

== Environment ==

You can also pass an extra environment attribute like this: `environment="sandbox"` to specify which environment you want to use. The options are `development`, `staging`, `sandbox`, `production`. If no environment attribute is passed then it will default to production.

== FAQs ==

Here is our FAQ section:

https://uphotel.zendesk.com/hc/en-us/sections/360000812414-FAQs
