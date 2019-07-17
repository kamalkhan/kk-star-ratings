<!-- only:wp>
=== kk Star Ratings ===
Contributors: bhittani
Donate link: https://github.com/kamalkhan/kk-star-ratings
Tags: star ratings, votings, rate posts, ajax ratings, infinite stars, unlimited stars, google rich snippets, structured data, SEO, SERP
Requires at least: 4.5
Requires PHP: 5.5.9
Tested up to: 5.2.2
Stable tag: 2.6.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
</only:wp -->

<!-- only:github/ -->
kk Star Ratings - A WordPress Plugin
======

![icon-plugin-installs]
![icon-plugin-downloads-per-day]
![icon-plugin-downloads]
![icon-wp-rating]

![icon-plugin-version]
![icon-wp-version]
![icon-wp-tested]

![icon-php-version]
[![Travis Build Status][icon-travis-status]][link-travis-status]

[![License][icon-license]](LICENSE.txt)
<!-- /only:github -->

kk Star Ratings allows blog visitors to involve and interact more effectively with your website by rating posts.

This plugin has been renewed from the ground up as of v3 covered by unit tests.

<!-- only:github/ -->
**Table of contents**
---
  - [Features](#features)
  - [Installation](#installation)
    - [Auto](#auto)
    - [Manual](#manual)
  - [FAQs](#faqs)
  - [Changelog](#changelog)
  - [i18n](#i18n)
  - [Testing](#testing)
  - [Contributing](#contributing)
  - [Security](#security)
  - [Credits](#credits)
  - [Attribution](#attribution)
  - [License](#license)
<!-- /only:github -->

<!-- only:wp>
== Description ==
</only:wp -->

<!-- only:github/ -->
## Features
<!-- /only:github -->

kk Star Ratings is a widely used star rating plugin for wordpress. Here are some highlighted features:

- User defined amount of star ratings (5 as default) in your **posts**, **pages** and publicly accesible **custom post types**.

- Structured data supporting **google rich snippets** showing the star ratings in search results which has the potential to drive more traffic to your website.

- Widespread coverage of custom hooks.

- Full control via options page. You can,

  - Enable or disable globally.
  
  - Disable star ratings in posts that belong to certain categories.

  - Choose where to show the star ratings. It can be on the **homepage**, in **archives**, in **posts**, in **pages** and/or in **custom post types**.

  - Control the structured data schema and type.

  - Restrict votings per unique ip.

  - Allow voting in archives.

  - Allow guests to vote.

  - Customize position within the post content.

  - Adjust the number of stars.

  - Adjust the amount of stars.

  - Adjust the colors of the stars.
  
- And much more...

<!-- only:wp>
== Installation ==
</only:wp -->

<!-- only:github/ -->
## Installation
<!-- /only:github -->

<!-- only:github/ -->
### Auto
1. Navigate to your wordpress plugins dashboard page.
2. Upload the plugin zip file.
3. Activate the plugin via the wordpress plugins dashboard page.
4. Adjust the plugin options under the kk Star Ratings menu in wp-admin.
<!-- /only:github -->

<!-- only:github/ -->
### Manual
<!-- /only:github -->
1. Extract the plugin zip file.
1. Upload/move the folder `kk-star-ratings` to the `wp-content/plugins` directory.
1. Activate the plugin via the wordpress plugins dashboard page.
1. Adjust the plugin options under the kk Star Ratings menu in wp-admin.

<!-- only:wp>
== Frequently Asked Questions ==
</only:wp -->

<!-- only:github/ -->
## FAQs
<!-- /only:github -->

<!-- only:wp>
= What should I do if structured data do not show in search result pages. =
</only:wp -->
<!-- only:github/ -->
> What should I do if the structured data is not picked by search result pages? 
<!-- /only:github -->

Please have patience as we have no control over how google or any search engine indexes your pages. It might take some days or even weeks for the robots to crawl the ratings.

<!-- only:wp>
= I have been using a verion of this plugin prior to v3. Is it safe for me to update? =
</only:wp -->
<!-- only:github/ -->
> I have been using a verion of this plugin prior to v3. Is it safe for me to update?
<!-- /only:github -->

The source of this plugin is located at [Github](https://github.com/kamalkhan/kk-star-ratings). Feel free to post an issue or submit a pull request.

<!-- only:wp>
= I found a bug or want to contribute. =
</only:wp -->
<!-- only:github/ -->
> I found a bug or want to contribute.
<!-- /only:github -->

All previous ratings and options will be preserved. However, since v3 has been renewed from scratch, we do not support downgrading to v2 after moving from v2 to v3.

<!-- only:wp>
== Screenshots ==

1. Screenshot label 1
2. Screenshot label 2
3. ...
</only:wp -->

<!-- only:wp>
== Changelog ==

= 3.0.0 =
- Describe the changes!

= 2.x =
[Archived](.github/CHANGELOG-v2.md)

= 1.x =
[Archived](.github/CHANGELOG-v1.md)
</only:wp -->

<!-- only:wp>
== Upgrade Notice ==

= 3.0.0 =
All previous ratings and options will be preserved. However, since v3 has been renewed from scratch, we do not support downgrading to v2 after moving from v2 to v3.
</only:wp -->

<!-- only:github/ -->
## Changelog

Please see the [CHANGELOG](CHANGELOG.md) for more information on what has changed.

[Version 2.x](.github/CHANGELOG-v2.md) has been *archived* as of July 2019.

[Version 1.x](.github/CHANGELOG-v1.md) has been *archived* as of March 2016.

## i18n

```bash
npm install
npm run i18n
```

or

```bash
yarn
yarn i18n
```

## Testing

You may clone this repository for development and test purposes.

```bash
git clone https://github.com/kamalkhan/kk-star-ratings

cd kk-star-ratings

composer install

composer install-test-suite

composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details.

## Security

If you discover any security related issues, please email `shout@bhittani.com` instead of using the issue tracker.

## Credits

- [Kamal Khan](https://github.com/kamalkhan)
- [All Contributors][link-contributors]

## Attribution

The [pull request template](.github/PR_TEMPLATE) and [issue template](.github/ISSUE_TEMPLATE) have been adapted from the [thephpleague's skeleton package](https://github.com/thephpleague/skeleton).

## License

The GPLv2 or later license. Please see the [License File](LICENSE.txt) for more information.

<!-- WordPress -->
[icon-wp-version]: https://img.shields.io/wordpress/plugin/wp-version/kk-star-ratings.svg?style=for-the-badge
[icon-wp-tested]: https://img.shields.io/wordpress/plugin/tested/kk-star-ratings.svg?style=for-the-badge
[icon-wp-rating]: https://img.shields.io/wordpress/plugin/rating/kk-star-ratings.svg?style=for-the-badge

<!-- Plugin -->
[icon-plugin-downloads-per-day]: https://img.shields.io/wordpress/plugin/dd/kk-star-ratings.svg?style=for-the-badge
[icon-plugin-downloads]: https://img.shields.io/wordpress/plugin/dt/kk-star-ratings.svg?style=for-the-badge
[icon-plugin-installs]: https://img.shields.io/wordpress/plugin/installs/kk-star-ratings.svg?style=for-the-badge
[icon-plugin-version]: https://img.shields.io/wordpress/plugin/v/kk-star-ratings.svg?style=for-the-badge

<!-- PHP version -->
[icon-php-version]: https://img.shields.io/travis/php-v/kamalkhan/kk-star-ratings/master.svg?style=for-the-badge

<!-- Travis Status -->
[icon-travis-status]: https://img.shields.io/travis/kamalkhan/kk-star-ratings.svg?style=for-the-badge
[link-travis-status]: https://travis-ci.org/kamalkhan/kk-star-ratings

<!-- Packagist Downloads -->
[icon-packagist-downloads]: https://img.shields.io/packagist/dt/bhittani/kk-star-ratings.svg?style=for-the-badge
[link-packagist-downloads]: https://packagist.org/packages/bhittani/kk-star-ratings

<!-- License -->
[icon-license]: https://img.shields.io/badge/License-GPL%20v2-blue.svg?style=for-the-badge

<!-- Composer -->
[link-composer]: https://getcomposer.org

<!-- Contributors -->
[link-contributors]: https://github.com/kamalkhan/kk-star-ratings/contributors
<!-- /only:github -->
