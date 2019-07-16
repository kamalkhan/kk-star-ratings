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
