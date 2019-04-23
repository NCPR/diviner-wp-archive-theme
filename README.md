# Diviner Archiving Theme

A wordpress theme that allows small institutions and media organizations to create a public-facing, custom archive interface for a themed collection of media.

The main goals of this project are

* Wordpress based small scale archiving tools for a wide array of media materials (audio, video, documents, articles)
* Customizable multi-faceted search mechanism 
* Based on open source technologies
* Dublin Core like meta data fields 
* Easy to use by smaller organizations
* Customizable theme templates and experience
* Follow wordpress standards during development
* Ensure security of data
* Write clear support documentation for new and existing users
* Generate interest in the open source developer community and encourage participation.

The project is managed by the excellent people at [North Country Public Radio](http://northcountrypublicradio.org) and supported by a digital humanities grant from the [National Endowment for Humanities](https://www.neh.gov/)

## Technology overview

This project is based on the excellent [Tonik Starter Theme](/README_Tonik.md) because of all the excellent workflow and build mechanism that Tonik created in order to help developers organize their code.

* NPM and webpack for build system
* Composer for dependencies
* SASS for styling
* ECMA 6 for JS development
* React for the multifacet live updating front end experience
* Standard wordpress templating and customizer for theme variations.
* Carbon Fields for field management
* ( Optional ) Elastic search for improved performance

## Development

There are two parts to this development stack. 

1. General theme with JS, CSS and templates
2. The ReactJS based browse application which appears in the browse template. Located in /browse-app

Each has it's own yarn/npm webpack build system. Eventually, the build systems may be combined with separate entry points and resource chunking.

### General Theme

Run `nvm use` at top level. Run `yarn install` to set up dependencies. `yarn run dev` for development and `yarn run prod` for production. 

JS and SASS files are located in /resources/assets.


### Browse App

Run `nvm use` at top level. Run `yarn install` to set up dependencies. `yarn run dev` for development and `yarn run dist` for production. 

To develop this app, you must ensure that the dev JS version is used instead of the production version. 

To do this, set `SCRIPT_DEBUG` to true in the wp-config.php

```
define( 'SCRIPT_DEBUG', true );
```
and then add a MU plugin to set a `browse_js_dev_path`

```
<?php 
// mu-plugins/somefile.php
add_filter( 'browse_js_dev_path', function () {
	return 'http://localhost:3000/dist/master.js';
} );
```

Then you can view the browse page with the dev version. 

## Roadmap

### Summer and early Fall of 2018

* ~~Development of Alpha Version based on existing [North Country at Work](http://www.northcountryatwork.org/) code base~~
* Elastic search enabled multi facet react front end (in testing)
* ~~Admin experience allowing user to activate/deactivate a set of core fields~~
* ~~Date field with multi front end display options (year decade or century slider or date range selector)~~
* ~~Text field for basic text data~~
* ~~Taxonomy fields for any number of things (location, keywords etc)~~
* ~~CPT field for related CPT items~~
* ~~Select Field~~

### Late fall 2018

* ~~Collections Feature (optional)~~
* QA work with NCPR team (ongoing)
* Refinements and improvements (ongoing)
* ~~Theme Buildout~~
* ~~Gutenberg Compatible~~

### Winter 2019 and beyond

* Submission to Wordpress.org as a theme
* Documentation (ongoing)
* Release in the wild
* User testing session 
* Support adopters
* Upgrade to webpack 4
* Add modal window system to the collections display. Set up chunking for the react library

