=== Plugin Name ===
Contributors: tj2point0
Tags: Permalink, Taxonomy, SEO, rewrite, url
Requires at least: 3.0.1
Tested up to: 3.2.1
Stable tag: tsp-0.3.1
Donate link: http://rakesh.tembhurne.com/

This plugin helps you to set your permalinks by using custom taxonomies just like you use %category% or %postname% in your permalink structure. 

== Description ==

Taxonomic SEO Permalinks is a simple plugin that allows you to create SEO urls based on custom taxonomies in WordPress. I personally wanted to use custom taxonomies in URLs just like built-in taxonomies like category. WordPress does support some options that helps in 'rewrite' of permalinks, while creating custom taxonomies. However, I found this thing is not actually working, as I tried and tested.

So I have created this plugin to fix this issue. This plugin does two major works. First, it modifies links to posts at all the places in blog and second, it helps in parsing the URLs. If you did not understand what I just said, leave it and read below.

Let me explain you with the help of an example, what we are trying to achieve with this plugin.

Consider a university website want to build a website for announcing results. The results are announced every six months (summer 2010, winter 2010, ...) for various courses (BSc, BTech, ...) and for various semesters (final year, second semester, ...).

So we can create three custom taxonomies viz. Season, Course and Semester. What we want is SEO url with the help of custom WordPress taxonomies that will look like:

<code>http://example.com/winter-2010/bsc/final-year/list-of-passed-candidates</code>

Which you can set in your regular permalink structure options just like 

<code>/%season%/%course%/%semester%/%postname%/</code>

NOTE: Currently this plugin do not help you to create custom taxonomies. You will need to use another plugin to create custom taxonomies.

== Installation ==

= Installation from zip file =

1. Go to Admin > Plugins > Add News  and click on upload link.
2. Browse the zip file and click upload
3. Activate the plugin

= Manual Installation =

1. Download the latest copy of Taxonomic SEO Permalink in .zip format
2. Extract the zip file and Upload to the '/wp-content/plugins/' directory
3. Activate the plugin through the 'Plugins' menu in WordPress

= After Installation =

Go to Admin Menu >> Settings >> Permalink and change the permalink structure having your custom taxonomy. For example:
/%season%/%course%/%semester%/%postname%/

== Frequently Asked Questions ==

= How does it work =

1. It changes the URLs of all the links of posts generated by wordpress, according to your permalink structure.
1. It helps in parsing the URLs according to your permalink structure

= How it works with sub-taxonomy =

I was requested to support sub-taxonomy just like Wordpress supports sub-category in URLs. For example if you use %category% in permalink structure and a post has sub-category, %category% will be replaced with 'parent-category-slug/child-category-slug'. In order to do similar things with custom taxonomies I tried many things but the solutions was getting complicated just because of forward slash (/) character as separator. So in order to keep things as simple as possible I used plus (+) character to separate child and parent custom taxonomies. I know this is not what most of us want but still it solves sub-taxonomy problem. I will fix this as soon as possible.
Also I used a limit of three parts per replacement. So a custom taxonomy structure tag can be replaced with 'grandparent-slug+parent-slug+child-slug' at the max and won't show 'great-grandparent-slug' even if present.

== Changelog ==

= 0.3.1 =
Now supports sub-taxonomy (read FAQ for details)

= 0.2.1 =
Uploaded the missing code.

= 0.2.0 =
Did some major changes to the code.
No need to manage sequence of taxonomy.
Should work on Network blog, but not tested yet.

= 0.1.3 =
Works on WP Network Site.

= 0.1.2 =
Solved minor bugs

= 0.1.1 =
Solved url parsing problem

= 0.1.0 Beta =
* Need to edit taxonomies in php file of plugin
