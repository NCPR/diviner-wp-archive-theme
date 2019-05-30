---
title: "Documentation"
draft: false
---


The following instructions provide a how to in setting up your new archiving site with the DIVINER theme. If you have any questions please refer to the wordpress.org forum.

\
\

### Diviner Lexicon

\
\

*   **Kitchen Sink:** the rendering of all gutenberg elements, called blocks, in the main content area of pages and posts. Previously, this editor experience was a WYSIWYG.
*   **Breakpoint: **describes the different stylings of elements based on width and device characteristics. This theme has breakpoints for smartphone, tablet and desktop
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

\
\


### Configure **DIVINER** for your project

\
\

**BROWSE HELP AND SEARCH PAGE**

(Optional) Let’s start with creating an optional Browse Help Page. This page appears at the top of the Browse experience and serves to help visitors get to know the multifacet search experience. 

- Navigate to Pages on the left navigation menu, and choose All Pages. You should see a **DIVINER** Home and **DIVINER** Browse page - we’ll come back to those later. At the top of the page, choose Add New.

- Title your Help Page and add text if you already know what you wish it to say (you can always come back and change it later). Publish the Page (controls found in upper right). 

A search page is generated automatically when you activate the theme. This page is different than your archive browse experience; it is simply a page where a little search bar that searches through your entire site (excluding the archive browse experience) will live. It will be helpful to visitors trying to find information.

Add another new page, and title your search page (ex: Search) 

\
\

**GENERAL SETTINGS:**

Now we can move on to configuring your site! On the left navigation menu, find the **DIVINER** tab (there’s a star next to it) and choose General Diviner Settings. Starting from the top: 


**Add a Permissions/Rights Note**, which will appear on all Archive items, and verify that it gets updated in the popup and archive item single page. 

Example: _North Country Public Radio is not the owner or holder of copyright for any images within the North Country at Work archive. For uses of a photo (other than educational or non-commercial purposes), contact the photo’s institution of origin._

**Title your Browse Page Title** and verify that the new text appears at the top of the browse experience, which you can view by clicking on View Diviner Browse Page on the top navigation bar. 

Choose whether or not you want to **“Activate Modal in browse page on click”, **which causes a pop-up (with a small thumbnail of the archive item plus a few pieces of meta-data) to display in the browse experience when you click on an individual archive item. If _no_t selected, the visitor will be taken directly to the Archive Item single. The point of the pop-up is to allow visitors to look through many archive items without having to leave the browse experience.     2. 

\
{{< figure width="500" src="../img/image2.png" alt="Modal Window" caption="Modal Window in Browse Experience" captionClass="figure-caption text-left" >}}

\
\

**Set your Help Page.** (Move on if you chose not to create a Help Page). From the drop-down menu, select it. This links that page (which you can fill with whatever information you believe will be helpful to your visitors) with a little link at the top of the  **DIVINER** browse experience.  

**Set your Nav Search Page.** In the menu of your site is a small search icon. Here is where you choose what page a visitor is taken to when they click on that search icon. Choose the search page you made earlier!  

Choose whether or not you want to **Activate Related Items Field on Archive Items**, which activates the Related Items function on all archive items. This will add a function to all your archive items, which gives you the ability to connect each archive item to other archive items of your choosing. 

Example: _you add a photo of a certain factory to your archive, and you already have other factory-related archive items uploaded - such as an interview with a former worker, and a scan of old advertising. Related items will allow you to link the photo of the factory to the interview and the ad._

**Display blog listing as cards.** Check this box if you want your posts/stories to be displayed as cards instead of in the traditional stacked WordPress manner.

\

{{< figure width="500" src="../img/image1.png" alt="Stacked Wordpress Layout" caption="Stacked Wordpress Layout" captionClass="figure-caption text-left" >}}

\
\

{{< figure width="500" src="../img/image4.png" alt="Card Layout" caption="Card Layout" captionClass="figure-caption text-left" >}}


\
\

**Customize your Footer** This is not time-sensitive, and can be done later in set-up if you so choose. This section allows you to customize the footer that appears at the bottom of all pages on your **DIVINER** site. You can add text, copyright statements, etc. in the box called ‘Footer Copy’ and connect up your social media accounts (facebook, instagram, and twitter), which will appear as icons that take you directly to those social media accounts when clicked on. 

**Customize your Collections** This is not time-sensitive, and can be done later in set-up if you so choose. Collections are automatically activated, but you can choose to de-activate them. Collections are also automatically displayed in card-format, but if you un-check this box, they will be displayed in the traditional stacked WordPress manner. Customize the title of your Collections page, and add a collection description if you want one. 

Example: _Title: North Country at Work photo collections. Description: Collected here are our curated work photo collections. Some have been created around industries, others around specific time periods or from certain families. Enjoy perusing!_

\
\

**CUSTOMIZE YOUR BROWSE AND HOME PAGES**

This is not time-sensitive, and can be done later in set-up if you so choose. _Navigate to Pages on the left navigation menu. You will see a list of all your pages, which right now, should include Help, Search, Diviner Browse, and Diviner Home. 

Choose to edit Diviner Browse and add a description of what visitors can find in your archive if you want to. (This is optional! You may or may not want a descriptive paragraph). 

Choose to edit Diviner Home. 

\

{{< figure width="500" src="../img/image3.png" alt="Home Page" caption="Home Page" captionClass="figure-caption text-left" >}}

\
\
 

 * Once you’re in the editing experience, click on Preview on the upper right.  This will show you what your current homepage looks like in a new tab, and this is how you can check to see how your choices on the back-end are affecting the look of your home page.
 * Now head on back to the Diviner Home edit page, and get to customizing! You can keep elements you like, get rid of elements you don’t, and add additional elements. The basis of this homepage building experience is WordPress’s 5.0, which includes the Gutenberg Editor experience. For more on the basics of Gutenberg and how to leverage Gutenberg to its full potential, [use this manual](https://wordpress.org/gutenberg/).       
 * What exists out-of-the-box on your home page are a number of **DIVINER** elements - you can keep or discard them. 
 * Photo subheader with overlaid text - this will appear at the top of your homepage. Add a photo by adding a featured image (on lower right) and by adding subheader text (at very bottom of homepage edit screen). 
 * Link Boxes - three appear automatically; you can add more or remove link boxes at will. You can use these link boxes to direct visitors to other destinations on your site, such as your Browse Page, Collections, or an About the Project page. You can customize the fonts and colors of the boxes, add photos, etc. 
   * A note on visual contrast and accessibility - if you make your overlaid text light, make sure to make you background color dark, and vice versa. 
 * Featured Story - this appears underneath your link boxes, and you activate it by choosing a post in the drop-down menu. 
 * Recent Additions - this feature appears at the bottom of your homepage, above the footer. It pulls from your recently added Archive Items in your Browse page.  

\
\

#### **Create Fields & Configure Fields**

\

**DIVINER** fields are the basis for all the information associated with your archive items - they are the building blocks of your entire archive! Before you start entering data in any significant way, you should set up these fields. 


1. Navigate to **DIVINER** on the left navigation, choose Manage **DIVINER** Meta Fields . This is where you will simultaneously: 
    1. Choose what information will be assigned to each archive item 
    2. Determine the search facets appearing on the browse page of your archive.
2. Before you begin adding fields, you should take a moment to brainstorm what you want your fields to be. Think about your materials and how you want your audience to be able to search them. For example, if you have 1000 dog portraits, you may want to filter them by _breed, age of the dog, date taken, size of the dog_, etcetera. Perhaps you have 5,000 audio clips of folk songs. You may want to search by _date recorded, by subject, by singer/group, and by the location from which they originated_. We suggest choosing between five and ten criteria you’d like to be able to search by, though you can certainly do less or more than that! Write them down. Each of these will become a field you have to fill out for each archive item as you enter it. 
3. Now that you have your search criteria chosen, it’s time to figure out what kind of field each one represents. There are five types of fields: _Text, Date, Taxonomy, Advanced Detail Field, _and_ Select. _Read through the descriptions of the types of fields, and decide what kind of field each of yours is. 
    3. Text Field: for information you wish to assign to each archive item, but which might vary for each item. Example: serial number, catalog number, internal title, secondary description etc.
    4. Date Field: for your audience to be able to filter by a date range, by year, decade, or by century. Example: if you want to sort a collection of a thousand photos from the 20th century into decades. Or to sort a collection of 500 oral histories by decade recorded. 
    5. Taxonomy (Category/Tags/Keywords): Add a taxonomy field for categories you want to sort your materials by (ex: by location, such as by county, by neighborhood, or by room in a museum). You will have to create each of the choices in this category (ex: by county; Clinton, Essex, Warren, and Jefferson). Taxonomy fields are best suited to categories which do not need further explanation to a viewer. Each category also has a related canonical URL (for example /work-types/ballooning/).
    6. Advanced Detail Field: For related content with many choices (20+) and which you would like to be able to elaborate on and attach auxiliary information, use the Advanced Detail Field. A good example would be if you wished to sort your materials by their creator (photographer, author, etc.) – for each creator, this type of field allows you to create an “entry” for that creator. Other examples: donor, institution. Advanced Detail Fields have their own pages at unique URLs such as /photographers/cindy-sherman. Under the hood, these fields control wordpress custom post types ([https://codex.wordpress.org/Post_Types](https://codex.wordpress.org/Post_Types)).
    7. Select Field: Add a select field to assign a piece of information that comes from a very small list of pre-set choices to each of your archive item. Examples: Art Format, with the choices being Painting, Sculpture, or Digital. Th
4. Now that you have your fields, you can start adding them! In Manage Diviner Meta Fields, click on the Create a New Meta Field Button, and go in order; add a text field (if you have one). 
    8.  From the top: 
        1. Title
        2. Choose whether or not (by checking or unchecking the box) this “Field Active and Should it be Added to each Archive Item?” This is automatically checked because if you’re adding a field, you probably want it to be activated! However, if in the future you want to de-activate the field for a period of time, this is where you’d do it.  
        3. Add Browse Page Filter Helper Text (optional) 
        4. Select your Browse Page Placement
        5. Choose whether or not (by checking or unchecking the box) this “appear in the popup overlay.” Check this if you believe this field will be on most archive items. 
        6. Choose whether or not (by checking or unchecking the box) this ‘Is this field sortable in the browse experience’. Check if you want this field to show up on the browse page. 
        7. Admin Experience Helper Text: this is not for your visitors - it’s for yourself and other site admin/uploaders in your organization or group. This will show up when you are adding archive items, and (if you add text here) will help clarify the field. _Example: You add a text field called catalog number. Your Admin Experience Helper Text might be: Starts with P, can be found in X folder. _
        8. Description: (optional) add a description of the field if you feel it is necessary
    9. Add the rest of your fields! You can see all of your fields (as you add them) on the Manage Diviner Meta Fields Page. If you want to see how your fields look on your Diviner Browse page as you go, click on View Diviner Browse Page (which can be found on the top navigation bar).   

\
\

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

\
\

#### **Make collections out of your Archive Items**

So you’ve uploaded somewhere between fifty and thousands of archive items, and your archive is starting to look pretty robust! Another **DIVINER** tool available to you is Collections, which allows you to curate groups of archive items you find thematically relevant. 

**DIVINER’s** first project, North Country at Work, uses Collections to create collections of historic work photos (examples: Tending Bar in the North Country, The Photography of Seneca Ray Stoddard, Treating Tuberculosis in Saranac Lake, 1990s Construction Work in Wanakena. You can see all of them here for ideas: [http://www.northcountryatwork.org/collections/](http://www.northcountryatwork.org/collections/))

To create your own collections, navigate to Collections on the left navigation bar, and choose Add New. 


1. Title your collection
2. Write an introductory text (or more!)
3. Create a subheader (optional) 
    1. Set a featured image (this will express as a long thin bar across the top of the collection page
    2. Add subheader text if you wish it to appear
4. Add relevant archive items by searching for them by title and adding them using the drop-down box titled Archive Items. 

Your collections will express on a Collections Page that is automatically generated when you have added at least one collection. The title and description of that page are controlled under Diviner General Settings, under Customize Your Collections.  

\
\

#### **Create content**

This site uses the standard WordPress blogging system; you may decide to add stories or news items to the blog.  

\
\

#### **Customize the Look and Feel of your Site **

Personalizing your site involves customizing your theme. Go to Appearance/Customizer/Theme Customization first to start designing the look and feel of your site. You’ll be able to test the appearance of different colors in the preview on the screen to your right. None of these changes will appear on your site until you hit “publish” at the very end.

Here are the main theme customization options 


1. **Header background color**

    The header will be visible at the top of every page on your site.  

2. **Header Text Color**

    This will be the color used for the title of your site if you didn’t include a logo. If you chose to use a logo and do not have a tagline, skip to the next step! 

3. **Header Menu Button Color**

    This is the color for all your page titles on the header. You can simply make this the same color as the Header Text Color, or choose something else that fits with your color scheme. Note: The text will be clearest if you choose a light/neutral text color on a darker header color, or vice versa. 

4. **Header Menu Button Hover Color**

    When you hover your mouse over the page titles on the header, they will change to this color to show people it’s something they can click on. 

5. **Footer Background Color**

    You may want to make this the same color as your header, or choose something else that fits into your color scheme. The footer will be visible at the bottom of every page on your site. 

6. **Footer Text Color**

    Use for the footer copy block that is editable in the Diviner General Settings page

7. **Footer Menu Button Color**
8. **Footer Menu Button Hover Color**
9. **Button and Link Color**

    This is for different buttons and links throughout your site: for example, the “go” and “reset search filter” buttons on the browse page, and links attached to your individual archive items.

10. **Accent Color**

    Additional color for highlights throughout the theme.

11. **Header Font**

    Choose the font for your page titles on the header, and the title that will appear at the top of each individual page. 

12. **Body Font**

    Choose the text that will appear within each page. For example, this will affect the text on each archive item, and the names of each search field on the browse page. 

\
\

Make sure to hit Publish before exiting the theme customization! It’s the blue button on the top of the tool banner on the left. If you do not hit this, none of your color or font customizations will save. 

At this point, you may decide to customize the content that appears in your footer. For example, you may want to put a mission statement or copyright in the footer or include your organization’s social media links.

Go back to the main menu. On the left navigation menu, find the **DIVINER** tab at the bottom (there’s a star next to it) and choose General Diviner Settings. In the “Footer Copy”, you may include text or images. Editing the social media links, Facebook, Instagram, and Twitter, allows you to control what social media links appear in your footer. 

Please note that these social media links are for links to social media accounts only. Share links which encourage users to post pages in social media streams will need to handled by third party plugins. Read in the related plugins sections.

\
\

#### **General suggestions for customizing your font and colors**: 

*   Very bright and vibrant colors can come across as too strong on the screen. Think about choosing colors that are engaging but will be easy on the eyes for people who are browsing your archive for a period of time!
*   Consider choosing a basic color scheme of two or three colors and sticking to those to create a cohesive look for your site. 
*   Complementary (opposing) colors can work well together to create an appealing color scheme so your site doesn’t come across as monochromatic. For instance, the North Country at Work site uses a dark purple, burnt orange, and dark teal color scheme. Think about colors on opposite sides of the color wheel that will play well together (while keeping the first tip in mind!)
*   With fonts, the same as with colors, think about making a choice that will be easy to read for people who are browsing your archive for a period of time. 

\
\

#### **Content Strategy Concerns**

**DIVINER** is no replacement for a backup tool. It is a public-facing archive that helps both the creators and visitors to the site search through their content (photos, documents, videos, audio) in exciting ways. It is NOT a master repository or master cataloguing tool. For the sake of server space and copyright concerns, uploading master images is not advised, and all content should be stored and backed-up in other ways (ex: on hard drives, cloud solutions, etc.)  

To the degree that Wordpress has been used for years by sites large and small and because the open-source Wordpress community is so vibrant, there are many plugins which may help to backup data already within the site.

