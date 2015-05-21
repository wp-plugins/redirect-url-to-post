=== Redirect URL to Post ===
Contributors: camthor
Donate link: http://www.burma-center.org/donate/
Tags: url, redirect, latest post, random, query, link
Requires at least: 3.0
Tested up to: 4.2
Stable tag: 0.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Display your currently latest, oldest, most-commented or other post with a permanent link.

== Description ==

This plugin provides an URL that takes you directly to a post in single-post view. The post is determined by the query parameter **redirect_to=** and optional others. All matching posts are sorted and the first according to the chosen order will be displayed.

You can use URLs such as

http://www.example.com/?redirect_to=latest - **redirects to the latest post**

or

http://www.example.com/?redirect_to=random - **redirects to a random post**

or

http://www.example.com/?redirect_to=custom&orderby=comment_count&order=DESC - **redirects to the post with the most comments**

There is no menu or plugin page. You use it entirely through the query parameters in the URL.

Please find more information [here](http://www.christoph-amthor.de/software/redirect-url-post/ "plugin website").

== Installation ==

1. Find the plugin in the list at the admin backend and click to install it. Or, upload the ZIP file through the admin backend. Or, upload the unzipped redirect-url-to-post folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the ‘Plugins’ menu in WordPress.


== Frequently Asked Questions ==

= 1. What if more than one post match the criteria (e.g. two have the same comment_count)? =

There can be only *one* winner. The post that would be first in the list (as determined by WP) beats all others.



== Screenshots ==

none (all done via URL)


== Changelog ==

= 0.1 =

* initial release


== Upgrade Notice ==

Nothing yet.


== Other Notes ==
