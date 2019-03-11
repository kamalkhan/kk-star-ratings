=== kk Star Ratings ===
Contributors: bhittani
Donate link: https://github.com/kamalkhan/kk-star-ratings
Tags: star ratings, votings, rate posts, ajax ratings, infinite stars, unlimited stars, google rich snippets
Requires at least: 3.0
Requires PHP: 5.2.4
Tested up to: 5.1
Stable tag: 2.6.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

kk Star Ratings allows blog visitors to involve and interact more effectively with your website by rating posts.

== Description ==
kk Star Ratings has been renewed from the ground up in version 2.0.

This plugin displays a user defined amount of star ratings in your posts/pages.

It has cool mouse over effects and animations such as fueling of stars.

Supports Google Rich Snippets. Now the ratings will be indexed in google search :)

Inludes a widget so you can show top rated posts in your sidebar as well. Can also be filtered by category.

Custom template tag/function available

Enhanced settings page where you can adjust quite anything you may need to. You can:

1. Select where to show the ratings. It can be on homepage, archives, posts, pages or manually.

1. A visual button in your editor to easily display the ratings manually in your posts/pages. No more typing a shortcode :)

1. Google rich snippets. Ratings will be shown in google search results :)

1. Have a thousand of ratings on a single page? No worries, all will be fetched in a single request (as of v2.4).

1. Revamped the entire frontend js (normal: 6.03KB, minified: 4.29KB)

1. Ratings column in your admin posts/pages screen so you can view the statistics at comfort.

1. Restrict votings per unique ip.

1. Choose placement. Top left, top right, bottom left or bottom right.

1. Adjust frequent messages and strings.

1. Choose your own images.

1. Attach tooltips when mouse is hovered while rating with colors.

1. Change amount of stars anytime you want. Default is 5.

1. Reset the ratings for individual posts or the entire site.

== Installation ==

1. Upload the folder 'kk-star-ratings' found inside the zip to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Adjust the settings under kk Star Ratings tab in wp-admin.

== Frequently Asked Questions ==
=

Google rich snippets are not being displayed when I updated to v2.5.1

=

The snippet code vocabulary has been updated. Have some patience and let google crawl your posts/pages again for some days.

=

I found a bug or want to contribute.

=

The source of this plugin is located at https://github.com/kamalkhan/kk-star-ratings (as of v2.5+). Feel free to post an issue or submit a pull request.

=

I have been using an older verion of the plugin. Is it safe for me to update?

=

Version 2.0+ has been re-coded from the ground up preserving backwards compatibility. Feel free to upgrade safely.

=

I need some help or have some issues?

=

Visit the help tab in the settings to find out what you can do.

== Screenshots ==

1. The general settings page


2. The stars settings page


3. The tooltips settings page


4. The reset settings page


5. The menu tab


6. The widget


7. Five stars with custom image


8. Eight stars with custom image


9. Five stars with default image


10. Single star with default image


== Changelog ==

= 2.6.3 =
* Fix previous commit 2.6.2

= 2.6.2 =
* Update: Bump wp version compatibility to 5.1.
* Fix: See [PR #65](https://github.com/kamalkhan/kk-star-ratings/pull/65)
* Fix: See [PR #65](https://github.com/kamalkhan/kk-star-ratings/pull/66)
* Fix: See [PR #65](https://github.com/kamalkhan/kk-star-ratings/pull/67)

= 2.6.1 =
* Fix: Possible division by zero.
* Update: Bump wp version compatibility to 4.9.5.

= 2.6 =
* Fix: Parse legend correctly when not using google rich snippets.
* Fix: Admin screen colum notice bug.
* Fix: Show ratings at correct location when shortcode is used.
* Fix: Widget average values to reflect amount of stars being used.
* Update: Use one decimal point in average.
* Update: Use a single source of truth for parsing the legend.
* Update: Optimize images.
* Add: Allow [best] value in legend to show the total possible stars.

= 2.5.2 =
* Fix: See [PR #6](https://github.com/kamalkhan/kk-star-ratings/pull/6)
* Fix: See [PR #24](https://github.com/kamalkhan/kk-star-ratings/pull/24)
* Fix: See [PR #25](https://github.com/kamalkhan/kk-star-ratings/pull/25)
* Fix: See [PR #28](https://github.com/kamalkhan/kk-star-ratings/pull/28)

= 2.5.1 =
* Fix: Google rich snippets with new vocabulary code.
* Fix: Average calculation when x amount of stars used and changed dynamically.
* Fix: Shortcode.
* Fix: Styling.

= 2.5 =
* Fix: Deprecate WP_Widget for __construct. Required for wp 4.3+.
* Fix google rich snippets by using #Ratings as the vocabulary.
* Update: social and sponsored links in admin.
* Add: Css reset for star anchors.
* Use github for managing the plugin source at https://github.com/kamalkhan/kk-star-ratings.

= 2.4 =
* Fix: Upper and Lower boundary limits for rating. Oops, had not noticed this before.
* Fix: Fuelspeed. Strange! no one ever complained about it.
* Update: Revamped the entire javascript (normal: 6.03KB, minified: 4.29KB).
* Update: Two fixed decimal points for average and percentage instead of one.
* Update: Icon star color from grey to yellow.
* Added: Efficient fetching of ratings. No matter how many ratings you may have on a page, they will all be fetched in a single go :)
* Added: Rating column can now be sorted in the admin screen.

= 2.3.1 =
* Update: Framework updated for no conflict mode with other kk plugins.

= 2.3 =
* Added: Ability to exclude specific category(s).

= 2.2.1 =
* Update: Restricted admin scripts to render in its own page scope.

= 2.2 =
* Fix: jquery ui causing problems in wordpress 3.5. It is removed because no longer required.
* Update: Shortcode can contain optional 'id' argument to display ratings for a specific post intentionally. e.g. [kkstarratings id="192"]

= 2.1 =
* Fix: Google rich snippets is now stable and safe to use.
* Fix: Grammers in admin settings.
* Update: Control whether to allow users to rate in archives or not.
* Update: Reordered directory tree structure.
* Added: Useful hooks and filters for advanced developers.

= 2.0 =
* Update: Re-coded the plugin from the ground up, adding rich settings page and more features.
* Update: Transparent stars and availability of custom stars as per needs.
* Update: Ajax based settings page. No refreshes what so ever.
* Update: Seperate settings tab.
* Update: Visual flushing of ratings. No need to remember post ids.
* Update: [s] added as a variable for use in the legend (description). Will display the s only if there are 0 or more than 1 ratings.
* Added: kk Star Ratings now supports Google Rich Snippets. So the ratings will now be indexed in google search.
* Added: Visual shortcode button. No need to type in a shortcode manually in your posts/pages when in manual mode.
* Added: User specific amount of stars. Forget the fixed 5 stars.
* Added: Choose your own images instead of the default ones.
* Added: Tooltips. Now you can set tooltips for each star when mouse is hovered on each. You can also set colors.
* Added: Adjustment of fueling speed of stars when being loaded or refilling.
* Added: Set error message if anything goes unexpectidly.
* Added: Set thank you message.

= 1.7.2 =
* Fix: This is a fix for the previous version (1.7.1). The plugin was not tagged with the latest files. Now it is fixed.

= 1.7.1 =
* Security Fix: Fixed a security issue in the ajax request for the file inclusion risk. This is a recommended update for all users.

= 1.7 =
* Update: The top rated posts now considers the vote count as well. This is a recommended update for all users.

= 1.6 =
* Added: Now you can see a column in the admin screen of posts and pages stating the ratings of each.

= 1.5 =
* Fixed: Some users complained about a fault: "An error occured" being displayed when someone rates a post. This was due to the charset of the returned response via ajax (Mentioned by jamk). Has been fixed as the ajax response is now retrieved as an xml dom instead of plain text.
* Fixed: Regardless of unique voting set or not, a user could click on a star multiple times simultaneously and the post would be rated that much time. Has been fixed.
* Added: Filter by category in the widget as well as the custom template tag/function.

= 1.4.1 =
* Fixed: Settings are now able to be saved. Was not being saved in v1.4.

= 1.4 =
* Added: ability to retrieve top rated posts in the template/theme.

= 1.3.1 =
* Fixed: flushing/removing of ratings for widget included. Thanks to feedback from glyn.

= 1.3 =
* Added a widget. Now you can show top rated posts in your sidebar :).

= 1.2 =
* Added possibility to show ratings of any post anywhere in your theme files.

= 1.1 =
* Fixed the [avg] error, so now it will display average ratings properly.

== Upgrade Notice ==
