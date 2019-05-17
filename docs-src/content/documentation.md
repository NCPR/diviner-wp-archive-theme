---
title: "Documentation"
draft: false
---


The following instructions provide a how to in setting up your new archiving site with the DIVINER theme. If you have any questions please refer to the wordpress.org forum.

## Vocab/Lexicon

- **Kitchen Sink**: the rendering of all gutenberg elements, called blocks, in the main content area of pages and posts. Previously, this editor experience was a WYSIWYG.
- **Breakpoint**: describes the different stylings of elements based on width and device characteristics. This theme has breakpoints for smartphone, tablet and desktop
- **Elastic Search**: Technlogy used by Diviner to speed up performance. See plugins for more info
- **Diviner**: this digital platform, which takes the form of a WordPress theme.
- **Hosted Project**: the project that Diviner supports. For example: User = small historical museum uses Diviner to host their collection of World War II photographs. 
- **Hosted Project**: the project that Diviner supports. For example: User = small historical museum uses Diviner to host their collection of World War II photographs. 
- **Browse Page**: Page on the front end where the user can search for archive items. This page will allow the user to search with a query string or facets in real time. The browse page includes an input field, search facets, a sorting selector, a grid of archive item thumbnails matching the search criteria, and a pagination
- **Archive Item Field**: Fields describe meta data related to your archive items. They also translate to facet search items in browse page
- **Modal**: refers to a pop-up window that appears when you have clicked on an archive item within the browse experience
- **Types of Fields (that can be configured)**: 
   - Taxonomy: 
   - Advanced Detail: manages a discrete kind of wordpress content 
   - Date: 
   - Text: 
   - Select


## Configure DIVINER for your project

#### BROWSE HELP AND SEARCH PAGE

(Optional) Let’s start with creating an optional Browse Help Page. This page appears at the top of the Browse experience and serves to help visitors get to know the multifacet search experience. 

Navigate to Pages on the left navigation menu, and choose All Pages. You should see a Diviner Home and Diviner Browse page - we’ll come back to those later. At the top of the page, choose Add New.

Title your Help Page and add text if you already know what you wish it to say (you can always come back and change it later). Publish the Page (controls found in upper right). 

A search page is generated automatically when you activate the theme. This page is different than your archive browse experience; it is simply a page where a little search bar that searches through your entire site (excluding the archive browse experience) will live. It will be helpful to visitors trying to find information. 

Add another new page, and title your search page (ex: Search) 


#### GENERAL SETTINGS: 

Now we can move on to configuring your general settings! On the left navigation menu, find the Diviner tab (there’s a star next to it) and choose General Settings. Starting from the top: 
     
1. Add a Permissions/Rights Note, which will appear on all Archive items, and verify that it gets updated in the popup and archive item single page. 
   1. Example: North Country Public Radio is not the owner or holder of copyright for any images within the North Country at Work archive. For uses of a photo (other than educational or non-commercial purposes), contact the photo’s institution of origin.
1. Title your Browse Page Title and verify that the new text appears at the top of the browse experience, which you can view by clicking on View Diviner Browse Page on the top navigation bar. 
1. Choose whether or not you want to “Activate Modal in browse page on click”, which causes a pop-up (with a small thumbnail of the archive item plus a few pieces of meta-data) to display in the browse experience when you click on an individual archive item. If not selected, the visitor will be taken directly to the Archive Item single. The point of the pop-up is to allow visitors to look through many archive items without having to leave the browse experience.  ADD SCREENSHOT 
1. Set your Help Page. (Move on if you chose not to create a Help Page). From the drop-down menu, select it. This links that page (which you can fill with whatever information you believe will be helpful to your visitors) with a little link at the top of the  DIVINER browse experience.  
1. Set your Nav Search Page. In the menu of your site is a small search icon. Here is where you choose what page a visitor is taken to when they click on that search icon. Choose the search page you made earlier!  
1. Choose whether or not you want to “Activate Related Items Field on Archive Items”, which activates the Related Items function on all archive items. This will add a function to all your archive items, which gives you the ability to connect each archive item to other archive items of your choosing. 
   1. Example: you add a photo of a certain factory to your archive, and you already have other factory-related archive items uploaded - such as an interview with a former worker, and a scan of old advertising. Related items will allow you to link the photo of the factory to the interview and the ad. 
1. Display blog loop as cards. Check this box if you want your posts/stories to be displayed as cards instead of in the traditional stacked WordPress manner. ADD SCREENSHOT with cards and stacked. 
1. Customize your Footer. This is not time-sensitive, and can be done later in set-up if you so choose. This section allows you to customize the footer that appears at the bottom of all pages on your DIVINER site. You can add text, copyright statements, etc. in the box called ‘Footer Copy’ and connect up your social media accounts (facebook, instagram, and twitter), which will appear as icons that take you directly to those social media accounts when clicked on. 
1. Customize your Collections. This is not time-sensitive, and can be done later in set-up if you so choose. Collections are automatically activated, but you can choose to de-activate them. Collections are also automatically displayed in card-format, but if you un-check this box, they will be displayed in the traditional stacked WordPress manner. Customize the title of your Collections page, and add a collection description if you want one. 
   1. Ex: Title: North Country at Work photo collections. Description: Collected here are our curated work photo collections. Some have been created around industries, others around specific time periods or from certain families. Enjoy perusing! 
     

####Customize Your Browse and Homepages
    
This is not time-sensitive, and can be done later in set-up if you so choose. Navigate to Pages on the left navigation menu. You will see a list of all your pages, which right now, should include Help, Search, Diviner Browse, and Diviner Home. 

1. Choose to edit Diviner Browse and add a description of what visitors can find in your archive if you want to. (This is optional! You may or may not want a descriptive paragraph). 
1. Choose to edit Diviner Home. 
   1. Once you’re in the editing experience, click on Preview on the upper right.  This will show you what your current homepage looks like in a new tab, and this is how you can check to see how your choices on the back-end are affecting the look of your home page.
   1. Now head on back to the Diviner Home edit page, and get to customizing! You can keep elements you like, get rid of elements you don’t, and add additional elements. The basis of this homepage building experience is WordPress’s 5.0, which includes the Gutenberg Editor experience. For more on the basics of Gutenberg and how to leverage Gutenberg to its full potential, use this manual.       
   1. What exists out-of-the-box on your home page are a number of DIVINER elements - you can keep or discard them. They are: (Make screenshot of homepage edit screen and label all these) 
      1. Photo subheader with overlaid text - this will appear at the top of your homepage. Add a photo by adding a featured image (on lower right) and by adding subheader text (at very bottom of homepage edit screen). 
      1. Link Boxes - three appear automatically; you can add more or remove link boxes at will. You can use these link boxes to direct visitors to other destinations on your site, such as your Browse Page, Collections, or an About the Project page. You can customize the fonts and colors of the boxes, add photos, etc. 
      1. Featured Story - this appears underneath your link boxes, and you activate it by choosing a post in the drop-down menu. 
      1. Recent Additions - this feature appears at the bottom of your homepage, above the footer. It pulls from your recently added Archive Items in your Browse page.  
