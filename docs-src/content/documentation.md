---
title: "Documentation"
draft: false
---


The following instructions provide a how-to in setting up your new archiving site with the DIVINER plugin and (optional) theme. Before proceeding, please make sure DIVINER is a good fit for your project (See: IS DIVINER RIGHT FOR YOU?) and that you've already installed the plug-in or theme (SEE: GETTING STARTED). 
What you'll find below is a step-by-step guide to getting set up.  

&nbsp;

### Diviner Lexicon

&nbsp;

*   **Kitchen Sink:** the rendering of all gutenberg elements, called blocks, in the main content area of pages and posts. Previously, this editor experience was a WYSIWYG.
*   **Breakpoint:** describes the different stylings of elements based on width and device characteristics. This theme has breakpoints for smartphone, tablet and desktop
*   **Diviner**: this digital platform, which takes the form of a WordPress theme.
*   **Hosted Project**: the project that **DIVINER** supports. For example: User = small historical museum uses Diviner to host their collection of World War II photographs. 
*   **Archive Item:** The items that populate your Diviner archive - they can be photos, documents, audio files, or videos. 
*   **Browse Page**: Page on the front end where the user can search for archive items. This page will allow the user to search with a query string or facets in real time. The browse page includes an input field, search facets, a sorting selector, a grid of archive item thumbnails matching the search criteria, and a pagination
*   **Archive Item Field**: Fields describe meta data related to your archive items. They also translate to facet search items in browse page
*   **Modal**: refers to a pop-up window that appears when you have clicked on an archive item within the browse experience
*   **Types of Fields** (that can be configured): 
    *   Taxonomy
    *   Advanced Detail
    *   Date
    *   Text
    *   Select

&nbsp;


### Configure **DIVINER PLUG-IN** for your project

&nbsp;

You've installed the DIVINER plug-in into your WordPress environment - now it's time to make it yours! That starts with logging into your WordPress site.  Do that now, and you should arrive in the back-end navigation system. 

&nbsp;

**MAKE A PAGE TO HOUSE YOUR DIVINER ARCHIVE**

First up, you'll want to make a simple WordPress page where your archive will live and can be visited by users. Do this by navigating to Pages -> Add New. Title this page to describe your archive (example: 18th Century Portraits, Popular Cars of the 1950s,  Photo Archive) and don't get too hung up, you can always change it. 
Next, you're going to add the DIVINER shortcode so that your archive shows up on this page. Click on the + underneath the title. You have the option to 'Search for a block'. Type in shortcode, and a widget called shortcode should appear. Add it, and then copy and paste (or type) this shortcode into the box: `[diviner_browse_page]`. 

Save the page, and you're finished! 

&nbsp;


**CONFIGURE GENERAL SETTINGS:**

You'll notice that your dashboard (on left) looks a little different - there are two new Headings, 'Archive Items' and 'Diviner', both marked by a star icon. 'Archive Items' is where you will create the items that will populate your archive. Before you get there, however, you'll need to do some set-up, all which will happen under 'Diviner'. 

Navigate to the Diviner heading, hover over it, and choose Diviner General Settings. You have two things to do here: 

1. **Add a Permissions/Rights Note**, which will appear on all Archive items, and verify that it gets updated in the popup and archive item single page. 

    Example: _North Country Public Radio is not the owner or holder of copyright for any images within the North Country at Work archive. For uses of a photo (other than educational or non-commercial purposes), contact the photo’s institution of origin._

2. Choose whether or not you want to **“Activate Modal in browse page on click”**, which causes a pop-up (with a small thumbnail of the archive item plus a few pieces of meta-data) to display in the browse experience when you click on an individual archive item. If _no_t selected, the visitor will be taken directly to the Archive Item single. The point of the pop-up is to allow visitors to look through many archive items without having to leave the browse experience. 

&nbsp;

{{< figure width="500" src="../img/image-general-settings.png" alt="General Settings" caption="General Settings" captionClass="figure-caption text-left" >}}


&nbsp;

#### **Create Fields & Configure Fields**

**DIVINER** fields are the basis for all the information associated with your archive items - they are the building blocks of your entire archive! Before you start entering data in any significant way, you should set up these fields. 

1. Navigate to **DIVINER** on the left navigation, choose Manage Diviner Meta Fields . This is where you will simultaneously: 
    1. Choose what information will be assigned to each archive item 
    2. Determine the search facets appearing on the browse page of your archive.
2. Before you begin adding fields, you should take a moment to brainstorm what you want your fields to be. Think about your materials and how you want your audience to be able to search them. For example, if you have 1000 dog portraits, you may want to filter them by _breed, age of the dog, date taken, size of the dog_, etcetera. Perhaps you have 5,000 audio clips of folk songs. You may want to search by _date recorded, by subject, by singer/group, and by the location from which they originated_. We suggest choosing between five and ten criteria you’d like to be able to search by, though you can certainly do less or more than that! Write them down. Each of these will become a field you have to fill out for each archive item as you enter it. 
3. Now that you have your search criteria chosen, it’s time to figure out what kind of field each one represents. There are five types of fields: _Text, Date, Taxonomy, Advanced Detail Field, _and_ Select. Read through the descriptions of the types of fields, and decide what kind of field each of yours is. 
    1. Text Field: for information you wish to assign to each archive item, but which might vary for each item. Example: serial number, catalog number, internal title, secondary description etc.
    2. Date Field: for your audience to be able to filter by a date range, by year, decade, or by century. Example: if you want to sort a collection of a thousand photos from the 20th century into decades. Or to sort a collection of 500 oral histories by decade recorded. 
    3. Taxonomy (Category/Tags/Keywords): Add a taxonomy field for categories you want to sort your materials by (ex: by location, such as by county, by neighborhood, or by room in a museum). You will have to create each of the choices in this category (ex: by county; Clinton, Essex, Warren, and Jefferson). Taxonomy fields are best suited to categories which do not need further explanation to a viewer. Each category also has a related canonical URL (for example /work-types/ballooning/).
    4. Advanced Detail Field: For related content with many choices (20+) and which you would like to be able to elaborate on and attach auxiliary information, use the Advanced Detail Field. A good example would be if you wished to sort your materials by their creator (photographer, author, etc.) – for each creator, this type of field allows you to create an “entry” for that creator. Other examples: donor, institution. Advanced Detail Fields have their own pages at unique URLs such as /photographers/cindy-sherman. Under the hood, these fields control wordpress custom post types ([https://codex.wordpress.org/Post_Types](https://codex.wordpress.org/Post_Types)).
    5. Select Field: Add a select field to assign a piece of information that comes from a very small list of pre-set choices to each of your archive item. Examples: Art Format, with the choices being Painting, Sculpture, or Digital. Th
4. Now that you have your fields, you can start adding them! In Manage Diviner Meta Fields, click on the Create a New Meta Field Button, and go in order; add a text field (if you have one). 
    1.  From the top: 
        1. Title
        2. Choose whether or not (by checking or unchecking the box) this “Field Active and Should it be Added to each Archive Item?” This is automatically checked because if you’re adding a field, you probably want it to be activated! However, if in the future you want to de-activate the field for a period of time, this is where you’d do it.  
        3. Add Browse Page Filter Helper Text (optional) 
        4. Select your Browse Page Placement
        5. Choose whether or not (by checking or unchecking the box) this “appear in the popup overlay.” Check this if you believe this field will be on most archive items. 
        6. Choose whether or not (by checking or unchecking the box) this ‘Is this field sortable in the browse experience’. Check if you want this field to show up on the browse page. 
        7. Admin Experience Helper Text: this is not for your visitors - it’s for yourself and other site admin/uploaders in your organization or group. This will show up when you are adding archive items, and (if you add text here) will help clarify the field. _Example: You add a text field called catalog number. Your Admin Experience Helper Text might be: Starts with P, can be found in X folder. _
        8. Description: (optional) add a description of the field if you feel it is necessary
    2. Add the rest of your fields! You can see all of your fields (as you add them) on the Manage Diviner Meta Fields Page. If you want to see how your fields look on your Diviner Browse page as you go, click on View Diviner Browse Page (which can be found on the top navigation bar).   

&nbsp;

{{< figure width="500" src="../img/image-fields.png" alt="Field Management" caption="Field Management" captionClass="figure-caption text-left" >}}

&nbsp;

#### **Add Archive Items**

Archive items are the core content of your archive. They can be Photo, Video, Audio, Document, or Mixed, and can take on the shape that you give them. For instance, an archive item can be as simple as a photo with a short caption, OR a mixed-media entry with a featured photo, videos, linked text documents, links to different social media, etcetera. This is up to how much work and content you put in to each archive item. 

** To view your archive as you populate it, click on the View Diviner Browse Page on the top navigation bar; this will show you how visitors will see your archive.     


1. Now that you’ve configured your General Settings, and added and customized your fields, you can start to populate your archive with archive items! 
    1. Navigate to Archive Items on the left navigation bar, then depending on what kind of item you’re adding, add a New Archive Item (Photo, Video, Audio, Document, or Mixed).
    2. Enter title and text content. 
    3. Enter data for all the fields you have previously created. 
    4. Add a featured image (if you choose to - it is required for photo archive items, but optional everywhere else.) 
        1. This image will appear in several different places, first in the browse page grid as a cropped square, and secondly it will also appear in the canonical archive item single pages uncropped in a larger format. SCREENSHOT
        2. Note that if you add a featured image to an archive item, it will be the first thing displayed in the archive item. If you would like a thumbnail image that does NOT appear on the archive item single, elect to add a thumbnail image and no featured image.)  

&nbsp;

#### **Content Strategy Concerns**

**DIVINER** is no replacement for a backup tool. It is a public-facing archive that helps both the creators and visitors to the site search through their content (photos, documents, videos, audio) in exciting ways. It is NOT a master repository or master cataloguing tool. For the sake of server space and copyright concerns, uploading master images is not advised, and all content should be stored and backed-up in other ways (ex: on hard drives, cloud solutions, etc.)  

To the degree that Wordpress has been used for years by sites large and small and because the open-source Wordpress community is so vibrant, there are many plugins which may help to backup data already within the site.

**DIVINER** is more than just a theme in that it sets up the data type for your archive items adn collections. In this way, the data you enter for your archive items is only for use only with the Diviner theme. If ever you deactivate this theme, you will no longer have access to the browse experience or your Archive Items. 
