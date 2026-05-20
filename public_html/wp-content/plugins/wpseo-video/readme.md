[![Coverage Status](https://coveralls.io/repos/github/Yoast/wpseo-video/badge.svg?branch=trunk&t=Vi74c9)](https://coveralls.io/github/Yoast/wpseo-video?branch=trunk)

Video SEO
=========
Requires at least: 6.8
Tested up to: 7.0
Stable tag: 13.9
Requires PHP: 7.4
Depends: Yoast SEO

Video SEO adds Video SEO capabilities to WordPress SEO.

Description
------------

This plugin adds Video XML Sitemaps as well as the necessary OpenGraph markup, Schema.org videoObject markup and mediaRSS for your videos.

This repository uses [the Yoast grunt tasks plugin](https://github.com/Yoast/plugin-grunt-tasks).

Installation
------------

1. Go to Plugins -> Add New.
2. Click "Upload" right underneath "Install Plugins".
3. Upload the zip file that this readme was contained in.
4. Activate the plugin.
5. Go to SEO -> Extensions and enter your license key.
6. Save settings, your license key will be validated. If all is well, you should now see the XML Video Sitemap settings.
7. Make sure to hit the "Re-index videos" button if you have videos in old posts.

Frequently Asked Questions
--------------------------

You can find the [Video SEO FAQ](https://yoast.com/help/video-seo-faq/) in our help center.

Changelog
=========

## 15.2

Release date: 2026-04-28

#### Other

* Modernizes how translations of the plugin work by removing the unneeded `load_plugin_textdomain()` calls.
* Sets the minimum supported WordPress version to 6.8.
* Sets the _WordPress tested up to_ version to 7.0.
* Updates the description copy of the XML Video Sitemap.

## 15.1

Release date: 2025-11-18

#### Enhancements

* Detect videos output by blocks.

#### Bugfixes

* Fixes a bug where a author post url containing an ampersand would cause invalid XML.
* Fixes a bug where a Wistia embed with an unknown `embedType` would not be picked up correctly.
* Fixes a bug where saving after re-indexation would cause settings to be lost.
* Fixes a bug where the saved video tags would not be used when reindexing videos.
* Fixes a bug where the video sitemap would include an invalid `player_loc` when using Wistia.

#### Other

* Bumps the minimum required Yoast SEO version to 26.4.
* Drops compatibility with PHP 7.2 and 7.3.
* Sets the minimum supported WordPress version to 6.7.
* Sets the _WordPress tested up to_ version to 6.8.

### Earlier versions
For the changelog of earlier versions, please refer to [the changelog on yoast.com](https://yoa.st/video-seo-changelog).
