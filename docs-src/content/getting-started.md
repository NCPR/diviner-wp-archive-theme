---
title: "Getting Started"
draft: false
---

## Define Your Project 

We recommend potential users define their project as much as they can before they get started. It will help immeasurably in the overall installation and configuration of DIVINER. 

- **NAME** What will you call your DIVINER archive? Decide on a title.
- **CONTENT** What is going IN your DIVINER archive? Decide now what you want to put into the archive, because you will design your search mechanisms by which you want to sort through your materials before you upload your materials, not after. 
- **SEARCHABILITY** Think about your materials and how you want your audience to be able to search them. For example, if you have 1000 dog portraits, you may want to filter them by breed, age of the dog, date taken, size of the dog, etcetera. Perhaps you have 5,000 audio clips of folk songs. You may want to search by date recorded, by subject, by singer/group, and by the location from which they originated. We suggest choosing between five and ten criteria you’d like to be able to search by, though you can certainly do less or more than that! Write them down. Each of these will become a field you have to fill out for each archive item as you enter it. 

## Hosting Recommendations

To get started with Diviner, you will need a hosting solution capable of running Wordpress (https://codex.wordpress.org/Template:Server_requirements), for which the base requirements are:

* PHP version 5.6.20 or greater, PHP 7 is highly recommended
* MySQL version 5.0.15 or greater or any version of MariaDB

We recommend you choose a managed wordpress environment with 

* 1 gig of minimum RAM
* Daily backups of media files and database
* Regular updates to wordpress core 


## Additional Plugins

Although not required, we also recommend that Diviner be used in tandem with ElasticPress and an Elasticsearch server account, such as Searchly. Elasticsearch will cache search returns in the browse page and improve performance in the real-time multifacet search. 

Other plugins may be used with this theme. We recommend a social media plugin to add social media buttons to each article in either the Sidebar or After Single Title widget area. If your managed hosting service does not already provide daily updates, we recommend a plugin to manage scheduled backups.



## Installation of Diviner

Install Wordpress by follow the installation instructions of your managed hosting service. Refer to the Wordpress documentation directly for further information: https://wordpress.org/support/article/how-to-install-wordpress/

Set up an admin account for managing your site

Login as your new admin user. Navigate to the Appearance/Themes section and install Diviner Archive Theme. This may be done either directly in the interface via the theme Wordpress theme marketplace (once the theme is available) or as a direct download. Please contact us directly if you do not already have a ZIP of the theme.
 
Activate the theme and verify that you now see the Diviner and Archive Items menus in the admin interface. 

**Activate additional optional plugins**

Plugins may be installed from the wordpress.org plugin marketplace via the admin tool.

* ElasticPress
  * Install plugin and activate it
  * Set up an Elasticsearch service such as searchly
  * Enter the Elasticsearch host URL in the elasticpress settings
  * Click the sync button in the ElasticPress seetings to rebuild the search index. Because syncing happens in batches, this may take time if you already have a number of archive items.
  * Verify in your Elastcsearch service account that the indexing was successful
* Google Analytics
* Any other plugins you might prefer to use (Social Media plugin, etc)

