=== Redirect URL to Post ===
Contributors: camthor
Donate link: http://www.burma-center.org/donate/
Tags: url, redirect, latest post, random, random post, single post, query, link
Requires at least: 3.0
Tested up to: 4.3
Stable tag: 0.3.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Automatically redirect to your latest, oldest, random, or other post through a custom URL

== Description ==

This plugin provides an URL that takes you directly to a post in *single-post view*. The post is determined by the query parameter **?redirect_to=** and optional others. The URL will redirect to the first of all matching posts according to the chosen order.

Possible values for **redirect_to** are:

* **last** or **latest** – The URL will redirect to the last (latest) post.
* **first** or **oldest** – The URL will redirect to the first (oldest) post.
* **random** – The URL will redirect to a random post.
* **custom** – The post will be determined according to the mandatory parameter orderby and the optional parameter order.

You can also limit the scope of considered posts by additional parameters, such as **&s=searchaword** or **&cat=2**.

= Examples for URLs =

http://www.example.com/?redirect_to=latest - **redirects to the latest post**

http://www.example.com/?redirect_to=random - **redirects to a random post**

http://www.example.com/?redirect_to=custom&orderby=comment_count&order=DESC - **redirects to the post with the most comments**

http://www.example.com/?redirect_to=latest&s=iaido&default_redirect_to=12 - **redirects to the latest post that contains the word 'iaido' or, if nothing can be found, to the page or post with the id 12**

There is no settings page in the backend. You configure the plugin entirely through the query parameters in the URL.

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

= 0.3.2 =

BUG FIXES

* parameters with upper-case values not working

= 0.3.1 =

BUG FIXES

* fixed warnings on plugins page

= 0.3 =

FEATURES

* added option 'default_redirect_to'
* enabled criteria 'has_password' and 'tag_id'
* added a "Help" link on the plugins page

BUG FIXES

* improved compatibility with other plugins

= 0.2.1 =

BUG FIXES

* collision with other plugins using the same query parameter


= 0.2 =

BUG FIXES

* incorrect processing of *orderby* and *order* for *redirect_to=custom*

NOTE

* sorry, inconsistent version numbering...


= 0.1 =

* initial release


== Upgrade Notice ==

Nothing yet.


== Other Notes ==