=== amr breadcrumb navigation ===
Contributors: anmari
Tags: breadcrumb, breadtrail, navigation, menu, pages
Tested up to: 5.5
Version: 1.6
Stable tag: trunk

Produces a breadcrumb trail through the page tree - a single page from each level of the page hierarchy (no nesting, no indenting).  

== Description ==

The widget produces a breadcrumb trail through the page tree - a single page from each level of the page hierarchy (no nesting, no indenting).  This widget is useful for website that may  have fairly deep menu`s and a risk of the user getting "lost".  
A Default CSS styling is provided, however this can be switched off.  It is also possible to add a separator in the HTML markup (instead of just using CSS to style the menu).

Features:

*	Uses listed items with minimal markup. The markup is compatible with twentyseventeentheme html markup and wordpress delivered markup. 
*	Provides default css styling (no spans for separators), with the option to switch the default styling off to use your own. Depending on your existing theme, you may need to adjust your theme`s css. See below.
*	Allows specification of a separator if you really wish one. This will be inserted into a span within the link text, so the whole area is clickable. If there is no separator (default) then no span html is issued.


== Installation ==

1. Install and activate plugin
2. Add the widget to the chosen sidebar. 
4. That`s it - customise the css and background image to taste.

== Changelog ==
= Version 1.6 =
* replaced deprecated php widget coding
* will now show in archives and single posts with home (or the text you have specified) as the top 

= Version 1.5 =
*   Tested on 4.0, and will show on home page now to avoid confusion

= Version 1.4 =
*   Cleaned up deprecated function calls etc, and fixed stylesheet call 

= Version 1.3 =
*   Reworked code to use wordpress multi-widget API
*   Added option to include the top level with own naming.  Blank will exclude top level.
*   Changed css to be included files with regsiter style and enqueue style instead of directly included text
*   Changed background image for slightly cleaner look 
*   Added Russian translation provided by Marcis G. of [pc.de](http://pc.de/)

= Version 1.2 =
*   Added html classes so that successive levels can be styled by the depth of the page.  First lvl li will have a css class of lvl1, then lvl2 etc.

= Version 1.1 =
*   Fixed some minor css errors
*   Added option to not have the background image, while still having the plugin style - this helps if using the default theme on Safari - somehow it is hard in safari to get rid of the li:before content that the default theme uses to style the bullets.  So in that case, one could just work with it.


== Screenshots ==

1. Screenshot of a breadcrumb navigation with minimal styling in the default wordpress theme.
2. Widget configuration menu 
3. A vertical use of the breadcrumb widget
4. html generated in version 1.2 - with css tags for levels
5. Screenshot of another variation
6. Widget with separator with spaces
7. In the default theme sidebar with separators
8. With background-image
9. No background image and no separator in default theme in safari
10. Best configuration for default theme in Safari - no background image, some styling
