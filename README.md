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
* ~~CPT field for related CPT items (Advanced Detail Field)~~
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


# Tonik — WordPress Starter Theme

> The `develop` branch tracks starter development and it's not a stable code. If you want a stable version, use the [`master`](//github.com/tonik/theme/tree/master) branch or one of the latest [releases](//github.com/tonik/theme/releases).

[![Build Status](https://travis-ci.org/tonik/theme.svg?branch=develop)](https://travis-ci.org/tonik/theme) [![Packagist](https://img.shields.io/packagist/dt/tonik/theme.svg)](https://github.com/tonik/theme) [![license](https://img.shields.io/github/license/tonik/theme.svg)](https://github.com/tonik/theme)

### Tonik is a WordPress Starter Theme which aims to modernize, organize and enhance some aspects of WordPress theme development.

Take a look at what is waiting for you:

- [ES6](https://babeljs.io/learn-es2015/) for JavaScript
- [SASS](http://sass-lang.com/) preprocessor for CSS
- [Webpack](https://webpack.js.org/) for managing, compiling and optimizing theme's asset files
- Simple [CLI](https://github.com/tonik/cli) for quickly initializing a new project
- Ready to use front-end boilerplates for [Foundation](//foundation.zurb.com/sites.html), [Bootstrap](//getbootstrap.com/docs/3.3/), [Bulma](//bulma.io/) and [Vue](//vuejs.org/)
- Utilizes PHP [Namespaces](http://php.net/manual/pl/language.namespaces.php)
- Simple [Theme Service Container](http://symfony.com/doc/2.0/glossary.html#term-service-container)
- Child Theme friendly [Autoloader](https://en.wikipedia.org/wiki/Autoload) 
- Readable and centralized Theme Configs
- Oriented for building with [Actions](https://codex.wordpress.org/Glossary#Action) and [Filters](https://codex.wordpress.org/Glossary#Filter)
- Enhanced [Templating](https://en.wikibooks.org/wiki/PHP_Programming/Why_Templating) with support for passing data

### Requirements

Tonik Starter Theme follows [WordPress recommended requirements](https://wordpress.org/about/requirements/). Make sure you have all these dependences installed before moving on:

- WordPress >= 4.7
- PHP >= 7.0
- [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org)

## Documentation

Comprehensive documentation of the starter is available at http://labs.tonik.pl/theme/

## Contributing

Great that you are considering supporting the project. You have a lot of ways to help us grow. We appreciate all contributions, even the smallest.

- Report an issue
- Propose a feature
- Send a pull request
- Star project on the [GitHub](https://github.com/tonik/tonik)
- Tell about project around your community

## License

The Tonik Starter Theme is licensed under the [MIT license](http://opensource.org/licenses/MIT).

