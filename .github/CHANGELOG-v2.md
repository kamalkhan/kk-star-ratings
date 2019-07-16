= 2.6.4 =
* Fix legend string calculation (Github PR #68 and #72)
* Fix Github star widget
* Add patreon link

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
