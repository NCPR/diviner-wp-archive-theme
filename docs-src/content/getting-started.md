---
title: "Getting Started"
draft: false
---

## Define Your Project 

We recommend potential users define their project as much as they can before they get started. It will help immeasurably in the overall installation and configuration of **DIVINER**. 


1. NAME. What will you call your **DIVINER** archive? Decide on a title.
2. CONTENT. What is going IN your **DIVINER** archive? Decide now what you want to put into the archive, because you will design your search mechanisms by which you want to sort through your materials before you upload your materials, not after. 
3. SEARCHABILITY Think about your materials and how you want your audience to be able to search them. For example, if you have 1000 dog portraits, you may want to filter them by _breed, age of the dog, date taken, size of the dog_, etcetera. Perhaps you have 5,000 audio clips of folk songs. You may want to search by _date recorded, by subject, by singer/group, and by the location from which they originated_. We suggest choosing between five and ten criteria you’d like to be able to search by, though you can certainly do less or more than that! Write them down. Each of these will become a field you have to fill out for each archive item as you enter it. 

&nbsp;

## Hosting Recommendations

To get started with Diviner, you will need a hosting service running the latest version of Wordpress, for which here are the requirements: [https://wordpress.org/about/requirements/](https://wordpress.org/about/requirements/)

We recommend that your hosting service be a managed Wordpress environment with


*   At least 1 Gig of minimum RAM
*   Regular backups of media files and database
*   Periodic security updates to wordpress core 
*   At least 10 gigs of hard drive space
*   At least 50 gigs bandwidth a month
*   Max upload filesize of 64M

Some of these requirements depend on the needs of your individual project such as the number of archive items and the type of archive items you are managing. Whatever hosting service you choose should have a clear upgrade path if ever the needs of your project change.

If you are embedding Oembed video files, you will need transcoding service such as Vimeo for stocking those media files. For audio files, **DIVINER** supports either direct uploads to the Wordpres media library or OEmbed from services such as SoundCloud.

&nbsp;

## Additional Plugins

Although not required, we also recommend that **DIVINER** be used in tandem with ElasticPress and an Elasticsearch server account, such as Searchly. Elasticsearch will cache search returns in the browse page and improve performance in the real-time multifacet search. 

Other plugins may be used with **DIVINER**. We recommend a social media plugin to add social media buttons to each article in either the Sidebar or After Single Title widget area. If your managed hosting service does not already provide daily updates, we recommend a plugin to manage scheduled backups.

&nbsp;

## Installation


1. Install Wordpress by follow the installation instructions of your managed hosting service. Refer to the Wordpress documentation directly for further information: [https://wordpress.org/support/article/how-to-install-wordpress/](https://wordpress.org/support/article/how-to-install-wordpress/)
2. Set up an admin account for managing your site
3. Login as your new admin user. Navigate to the Appearance/Themes section and install **DIVINER** Archive Plugin. 
4. Activate the plugin and verify that you now see the **DIVINER** and Archive Items menus in the admin interface. You may not start adding fields to your archive items and set up a browse page using the `diviner_browse_page` shortcode.
5. Optionally you also also decide to install the **DIVINER** Archive Theme. 
6. Activate additional optional plugins
    1. ElasticPress
        1. Install plugin and activate it
        2. Set up an Elasticsearch service such as searchly
        3. Enter the Elasticsearch host URL in the elasticpress settings
        4. Click the sync button in the ElasticPress seetings to rebuild the search index. Because syncing happens in batches, this may take time if you already have a number of archive items.
        5. Verify in your Elastcsearch service account that the indexing was successful
    2. Google Analytics
    3. Social Media plugin
    4. Any other plugins
