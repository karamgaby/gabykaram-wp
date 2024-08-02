=== Lighthouse ===
Contributors: butterflymedia
Tags: performance, speed, pagespeed, optimization, security
Requires at least: 4.9
Requires PHP: 7.0
Tested up to: 6.6
Stable tag: 4.2.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

Lighthouse is a performance tuning plugin, removing lots of default WordPress behaviour.

== Description ==

Lighthouse is a performance tuning plugin, removing lots of default WordPress behaviour, such as filters, actions, injected code, native code and third-party actions.

== Installation ==

1. Copy the `/lighthouse/` folder into your `/wp-content/plugins/` directory
2. Activate the plugin
3. Go to Settings -> Lighthouse and start optimizing

== Changelog ==

= 4.2.0 =
* FIX: Remove db_server_info() method for WordPress 4.9+ and ClassicPress compatibility
* FEATURE: Add automatic background updater

= 4.1.2 =
* FIX: Remove old, deprecated code
* FIX: Fix typos and contextual help wording
* FIX: Fix footer message to work with non-block editor websites
* UPDATE: Add jQuery Migrate removal option
* UPDATE: Update WordPress recommendations
* UPDATE: Update WordPress compatibility

= 4.1.1 =
* FIX: Exclude mailto and tel links from prefetching
* FIX: Sanitize query string parameter for SQL injection check
* FIX: Remove unused variable
* UPDATE: Update PHP recommendations
* UPDATE: Update WordPress recommendations
* UPDATE: Update WordPress compatibility
* FEATURE: Add page caching (browser caching)
* FEATURE: Add support for Cloudflare page caching headers

= 4.1.0 =
* FIX: Fix various Beacon issues
* FIX: Fix missing class in the Firewall section
* UPDATE: Refactor the Dashboard section
* UPDATE: Update PHP recommendations
* FEATURE: Implement dark mode
* FEATURE: Join Performance and Speed Metrics sections
* PERFORMANCE: Remove minification options, it's better if this is done at build time or server level via Cloudflare
* PERFORMANCE: Remove unused, empty front-end CSS file
* PERFORMANCE: Remove obsolete tag

= 4.0.4 =
* FIX: Update User Agent check to prevent PHP 8+ warnings
* UPDATE: Update ClassicPress recommendations
* UPDATE: Remove all "Beta" labels
* UPDATE: Refactor code (WPCS)

= 4.0.3 =
* FIX: Fix wrong user email variable not triggering the period pattern check
* FIX: Fix sorting by date in the login history table
* FEATURE: Delete old login history entries (keep most recent 10,000 records)
* UPDATE: Remove Cascadia Code font

= 4.0.2 =
* FEATURE: Add user email registration pattern detection
* FEATURE: Add spam registration counter for all methods
* UPDATE: Refactor bot detection
* UPDATE: Refactor the ban system
* UPDATE: Remove all ban types except for IP and IP ranges
* UPDATE: Add tooltip styling
* UPDATE: Change option help wording
* FIX: Remove a fake SQL injection positive

= 4.0.1 =
* UPDATE: Update firewall module

= 4.0.0 =
* UPDATE: Update firewall module

= 3.10.0 =
* FEATURE: Add firewall module

= 3.9.10 =
* FEATURE: Add CAPTCHA module
* FEATURE: Add Akismet integration for the registration form
* UPDATE: Update WordPress and ClassicPress recommendations
* UPDATE: Update minimum WordPress version requirement
* FIX: Replace print_emoji_styles, deprecated in WordPress 6.4.0

= 3.9.9 =
* FEATURE: Implement IsSpammy (beta)
* FEATURE: Implement SegmentJS library for server timing measurements
* UPDATE: Only load ChartJS on Lighthouse pages to prevent conflicts with other getButterfly plugins
* UPDATE: Update WordPress and ClassicPress recommendations
* UPDATE: Refactor plugin dashboard to show better information

= 3.9.8 =
* FIX: Removed conflicting box sizing CSS declaration
* FIX: Removed unused blacklist log
* FIX: Properly enqueued ChartJS library
* UPDATE: Removed NEW badges from settings tabs
* UPDATE: Updated WordPress recommendations

= 3.9.7 =
* UPDATE: Updated Thin UI to latest version (2.1.1)

= 3.9.6 =
* FIX: Fixed missing asset chart if any of the following are missing (IMG, JS, CSS)
* UPDATE: Updated ChartJS to latest version (4.3.2)
* UPDATE: Updated Thin UI to latest version (2.1.0)
* UPDATE: Updated PHP and WordPress recommendations
* PERFORMANCE: Moved CRON job clearing to its own module

= 3.9.5 =
* UPDATE: Removed Core Web Vitals and CrUX
* UPDATE: Added option to delete old settings, tables, files and logs on-demand
* UPDATE: Added option to remove the Custom Fields metabox from the post editor because it uses a very slow meta_key sort query

= 3.9.4 =
* FIX: Fixed update checker loop
* UPDATE: Removed CrUX report

= 3.9.3 =
* UPDATE: Refactored registration spam prevention to shortcircuit the `register_post` hook
* UPDATE: Refactored the blacklist log into an option counter
* UPDATE: Deprecated Core Web Vitals and CrUX
* UPDATE: Updated WordPress recommendation
* UPDATE: Updated ClassicPress recommendation

= 3.9.2 =
* FEATURE: Added registration spam prevention feature
* FEATURE: Added option to disable the REST API for non-authenticated users
* FEATURE: Added option to disable user enumeration
* UPDATE: Added new "Security" tab
* UPDATE: Updated ChartJS to latest version (4.3.0)

= 3.9.1 =
* UPDATE: Added ClassicPress recommendation and updated WordPress compatibility
* UPDATE: Moved Core Web Vitals to its own tab
* UPDATE: Updated Thin UI library to latest version (2.0.2)
* UPDATE: Updated ChartJS to latest version (4.2.1)
* UPDATE: Removed legacy toggle styles
* UPDATE: Optimized toggle UI
* UPDATE: Removed unneeded options and settings

= 3.9.0 =
* FIX: Fixed undefined queries in WordPress back-end
* SECURITY: Added failed login count
* SECURITY: Refactored Dashboard cards and added a Security card

= 3.8.9 =
* UPDATE: Added (experimental) Time to First byte and Interaction to Next Paint to CrUX report
* UPDATE: Tweaked Settings screen header size for better visibility
* UPDATE: Added option to remove the `classic-themes.min.css` file
* SECURITY: Added brute-force login basic functionality

= 3.8.8 =
* FIX: Fixed multiple plugin updates from the same provider

= 3.8.7 =
* FIX: Removed non-functional Git Updater plugin and all dependencies
* UPDATE: Refactored automatic lifetime updates

= 3.8.6 =
* FIX: Removed TGMPA plugin recommendations due to a conflict with PHP 8.1+
* FIX: Removed old, unused CSS styles
* UPDATE: Updated UI massively to use the standardized Thin UI library
* UPDATE: Refactored chart/metric boxes to use less HTML elements and load faster

= 3.8.5 =
* UPDATE: Updated PHP and WordPress recommendations
* UPDATE: Used the IntersectionObserver API to only prerender links when they are visible. This will prevent the browser from prerendering links that the user may never actually interact with, which can improve the overall performance of the page. Additionally, using requestIdleCallback to schedule the prerendering logic to run when the browser is idle can ensure that the user's experience is not impacted by the prerendering process.
* UPDATE: Used the performance.now() function to measure the time it takes to execute the prefetching logic. The prefetch_throttle_delay value is adjusted based on the measured performance, ensuring that the prefetching logic only runs when the browser is able to handle it without impacting the user's experience.
* UPDATE: Optimized back-end performance by refactoring several loops
* UPDATE: Refactored code to allow for faster execution

= 3.8.4 =
* FIX: Removed option to block WebP image creation as it's not a Core feature yet

= 3.8.3 =
* FIX: Fixed TGMPA library conflict with some plugins
* UPDATE: Updated WordPress recommendations

= 3.8.2 =
* FIX: Fixed custom UI fonts to prevent FOUT
* FIX: Fixed SpeedFactor settings redirection (after save)
* FIX: Removed unused function
* UPDATE: Combined query tables
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated WordPress compatibility

= 3.8.1 =
* FIX: Fixed ChartJS version
* FEATURE: Added query tracker
* FEATURE: Added media-related settings
* UPDATE: Added heartbeat settings
* UPDATE: Added new preset "none" (reset all options)
* UI: Made nav tabs smaller to fit another tab

= 3.8.0 =
* FIX: Fixed legend circle being too big and overlapping the text
* UPDATE: Updated back-end fonts
* UPDATE: Updated ChartJS fonts
* UPDATE: Updated Lighthouse UI
* UPDATE: Updated options tab name in SpeedFactor email notification
* UPDATE: Split SpeedFactor settings and prefetch/preconnect settings
* FEATURE: Added server details UI
* FEATURE: Added new Tips & Tricks section

= 3.7.6 =
* FIX: Removed unused option
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated PHP requirements
* UPDATE: Updated ChartJS (3.7.1 to 3.9.1)
* UPDATE: Added database server info
* FEATURE: Added new Storage section
* FEATURE: Added option to block WebP image creation
* FEATURE: Added option to disable application passwords
* FEATURE: Added option to disable big image handling (introduced in WordPress 5.3)

= 3.7.5 =
* FIX: Fixed WordPress recommendations
* UPDATE: Updated WordPress compatibility
* UPDATE: Removed custom SVG URL for front-end only

= 3.7.4 =
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated ChartJS (3.3.2 to 3.7.1)
* UPDATE: Updated WPCS specifications
* UPDATE: Removed unused .eslintrc resource file
* UPDATE: Updated code according to WordPress Coding Standards

= 3.7.3 =
* UPDATE: Remove Dashicons options as it does not apply anymore and, in some rare cases, it breaks the admin bar for non-admin users
* UPDATE: Remove deprecated hooks as they are not being applied anymore

= 3.7.2 =
* FEATURE: Added options to disable automated plugin update email notifications
* FEATURE: Added options to disable automated theme update email notifications
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated WPCS specifications

= 3.7.1 =
* FIX: Fixed 2 typos
* UPDATE: Exposed current database version on the plugin Dashboard
* UPDATE: Removed 8 database queries on plugin installation
* UPDATE: Added PHP requirements (7+)
* UPDATE: Removed CPU and memory check as not many hosts allow running the calls
* UPDATE: Improved back-end performance by removing several OS/server calls

= 3.7.0 =
* FEATURE: Implemented code cleanup on demand
* FEATURE: Implemented optimization presets
* UPDATE: Updated code according to WordPress Coding Standards
* UPDATE: Removed unused file and cleaned up old code
* UPDATE: Removed unused variables and improved audit performance
* UPDATE: Removed emoji from option name
* UPDATE: Removed Security tab and moved options to the Performance tab
* UPDATE: Removed CMS tab and moved options to the Setup tab
* UPDATE: Updated Frequently Asked Questions section

= 3.6.2 =
* UPDATE: Added a Frequently Asked Questions section on the plugin's dashboard
* UPDATE: Added a GitHub.com access token helper for automatic updates
* UPDATE: Updated PHP recommendations

= 3.6.1 =
* FEATURE: Added HTML, inline JS and inline CSS minification
* UPDATE: Updated UI for the options navigation bar

= 3.6.0 =
* FEATURE: Added Core Web Vitals tracking and evolution

= 3.5.4 =
* UPDATE: Removed EDD licensing model and preparing for a subscription model (phase 2)

= 3.5.3 =
* UPDATE: Added TGMPA class to include Git Updater

= 3.5.2 =
* FIX: Fixed beacon creation
* UPDATE: Removed EDD licensing model and preparing for a subscription model
* UPDATE: Minified prefetch.js and prerender.js

= 3.5.1 =
* UPDATE: Removed HTML minification as the algorythm was not saving enough to justify the output buffering time

= 3.5.0 =
* FIX: Only use the wp_enqueue_scripts action once and enqueue/dequeue in one place as required (4 requests -> 1 request)
* FIX: Only use the plugins_loaded action once and filter as required (3 requests -> 1 request)
* FIX: Check and define fallback value for CURL_HTTP_VERSION_2_0 if it is not defined
* FIX: Fixed CRON items being non-accessible
* FIX: Fixed issue with CrUX.js being enabled globally
* FIX: Fixed lots of unused variables being used (leftovers from SpeedFactor transition)
* FIX: Fixed a division by zero error
* UPDATE: Removed error reporting and monitoring and only add a guide (-1 include request, -1 option request)
* UPDATE: Removed 2 options from loading by default (added specific options and disabled them by default) (-2 filters)
* FEATURE: Only load SpeedFactor files in the back-end
* FEATURE: Added block editor (Gutenberg) options
* FEATURE: Added srcset removal option
* FEATURE: Added jetpack.css removal option

= 3.4.8 =
* UPDATE: Added option to deregister mediaelement.js
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations
* FIX: Change some of the option labels to make options more clear

= 3.4.6 =
* FEATURE: Added Chrome User Experience Report (needs a Google Lighthouse API key)
* UPDATE: Added more contextual help for the TTFB measurement
* UPDATE: Improved speed of the SpeedFactor report page
* FIX: Fixed TTFB raw value

= 3.4.5 =
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations

= 3.4.4 =
* UPDATE: Added optional email notification for each audit

= 3.4.3 =
* FIX: Fixed updater path

= 3.4.2 =
* UPDATE: Added automatic blogging/commenting optimization
* UPDATE: UI improvements

= 3.4.1 =
* FIX: Fixed textarea sanitization
* UPDATE: Added automatic Beacon creation

= 3.4.0 =
* FEATURE: Merged SpeedFactor monitoring and tracking
* FEATURE: Merged SpeedFactor payload monitoring
* UPDATE: Switched from Git Updater to proprietary license
* UPDATE: Switched to a yearly support/updates plan

= 3.3.2 =
* UPDATE: Updated minimum PHP recommendations
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations

= 3.3.1 =
* FIX: Removed beacon creation
* UPDATE: Updated minimum PHP recommendations

= 3.3.0 =
* FEATURE: Added instant loading (prerendering and prefetching)
* FEATURE: Added option to remove core lazy loading
* FIX: Remove option to disable archives/taxonomies
* FIX: Remove option to disable REST API as more and more core features depend on this feature
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated minimum PHP recommendations
* UPDATE: Cleaned up plugin back-end and remove statistics

= 3.2.0 =
* UPDATE: Removed jQuery Migrate option as the script will be removed starting with WordPress 5.5
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated WordPress recommendations

= 3.1.1 =
* FEATURE: Added GitHub Updater compatibility and removed hard-coded GitHub API
* UPDATE: Removed questionable scripts-to-footer options
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated minimum PHP recommendations
* UPDATE: Updated WordPress recommendations

= 3.1.0 =
* FEATURE: Added SpeedFactor beacon
* UPDATE: Removed license and hardcode it for easier update
* UPDATE: Added guide for default WordPress optimization

= 3.0.3 =
* FIX: Renamed user agent for the updater class
* FIX: Renamed updater class name to avoid conflicts

= 3.0.2 =
* FIX: Renamed wrong license option name (again)

= 3.0.1 =
* FIX: Renamed wrong license option name

= 3.0.0 =
* FIX: Removed potentially confusing details
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated minimum PHP recommendations
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated UI
* FEATURE: Added SpeedFactor integration

= 2.9.0 =
* UPDATE: Removed all TinyMCE-related options (embeds and emojis)
* UPDATE: Removed `lighthouse_clean_attributes` option, as WordPress 5.3 adds theme support for this
* UPDATE: Removed cached menus as they lose dynamic classes and IDs
* UPDATE: Removed cached template parts as it's not good practice anymore (there's better ways of caching and better ways of optimizing queries)

= 2.8.1 =
* UPDATE: Updated WordPress compatibility
* UPDATE: Removed deprecated Yoast filter
* COMPATIBILITY: Removed several pre-WordPress-5.0 options

= 2.8.0 =
* FIX: Fixed documentation link
* UPDATE: Updated minimum PHP recommendations
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated WordPress compatibility
* FEATURE: Exposed Site Health in Lighthouse Settings screen
* COMPATIBILITY: Removed several pre-WordPress-5.0 options

= 2.7.0 =
* FIX: Removed duplicate option
* UPDATE: Removed MySQL check as it's hard to detect all possible configurations (Maria DB, Percona)
* UPDATE: Removed OPCache check as it's not relevant anymore
* UPDATE: Updated plugin requirements to PHP 7+
* UPDATE: Removed all pre-PHP 7 code
* UPDATE: Removed caching headers in favour of .htaccess rules

= 2.6.1 =
* FIX: Removed obsolete cache purging
* FIX: Removed obsolete cache counter
* FIX: Consolidated __return_false
* FIX: Fixed wrong checked/recommended option count
* UPDATE: Updated minimum PHP recommendations
* UPDATE: Removed OPCache support due to server errors
* UPDATE: Improved pings removal
* FEATURE: Added taxonomy (archives) disabling

= 2.6.0 =
* FIX: Code compliancy fixes
* FIX: Strict check fixes
* FIX: Removed old, unused option
* UPDATE: Updated server software recommendations
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated WordPress compatibility
* UPDATE: Updated oembed removal
* UPDATE: Added 3 more widget removal options
* UPDATE: Added author archives removal option
* UPDATE: Removed presets as they weren't up to date
* UPDATE: Removed unnecessary admin/page check
* PERFORMANCE: Refactored settings count/savings/recommendations

= 2.5.1 =
* UPDATE: Updated PHP 7.2 compatibility
* UPDATE: Removed deprecated function

= 2.5.0 =
* FIX: Fixed undeclared variable
* UPDATE: Removed transient cleaner as WordPress 4.9.0 implements it natively

= 2.4.1 =
* UPDATE: Removed faulty Gravatar caching
* UPDATE: Removed script concatenation as it generated conflicts with lots of incorrectly coded themes
* UPDATE: Added OPcache status
* PERFORMANCE: Added new HTML minification engine

= 2.4.0 =
* UPDATE: Improved emoji removal
* UPDATE: Remove additional frontend styles and scripts as they are against WordPress.org guidelines
* PERFORMANCE: More performance tweaks on theme init

= 2.3.5 =
* FIX: Fixed HSTS help link
* FIX: Removed old nofollow fix breaking the Dashboard
* UPDATE: Removed Zen notice from pages other than Lighthouse settings page
* UPDATE: Updated server software recommendations
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated Normalize.css (6.0.0 to 7.0.0)
* UPDATE: Updated Pure.css (0.6.2 to 1.0.0)
* UPDATE: Removed an incorrect check for server protocol

= 2.3.4 =
* FIX: Fixed commenter link nofollow attribute removal

= 2.3.3 =
* FEATURE: Added memory usage and CPU load
* UPDATE: Updated server software recommendations
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated Normalize.css (5.0.0 to 6.0.0)
* UPDATE: Updated REST API recommendations

= 2.3.2 =
* FIX: Fixed PHP 7 compatibility with Gravatar caching
* FEATURE: Added option to disable REST API
* UPDATE: Added Entypo Fontello to theme tweaks
* UPDATE: Updated Modernizr.js (2.8.3 to 3.3.1)
* UPDATE: Tweaked server software recommendations
* UPDATE: Tweaked option security (and improved performance by forcing strict checks)

= 2.3.1 =
* UPDATE: Removed jQuery UI option as it's a theme specific feature
* UPDATE: Removed ambiguous HTTPS message
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated server software recommendations
* UPDATE: Updated Pure.css (0.6.0 to 0.6.2)

= 2.3.0 =
* FIX: Removed a potentially limiting option
* UPDATE: Updated WordPress recommendations
* UPDATE: Updated server software recommendations
* UPDATE: Updated Normalize.css (4.2.0 to 5.0.0)
* UPDATE: Updated FontAwesome.css (4.6.3 to 4.7.0)
* PERFORMANCE: Replaced a preg_replace() function with a native WordPress filter

= 2.2.1 =
* UPDATE: Merged <head> cleanup options
* UPDATE: Wording and contextual help updates
* UPDATE: Fixed several typos
* UPDATE: Removed the Genericons dequeue option
* UPDATE: Removed the Fancybox dequeue option
* UPDATE: Merged content parsing options
* UPDATE: Added documentation

= 2.2.0 =
* UPDATE: Removed footer link attribution
* UPDATE: Changed method of removing jQuery Migrate and using an outdated jQuery version
* UPDATE: Removed a recommended option which added extra database queries
* UPDATE: Removed two deprecated functions
* UPDATE: Changed a request check after the option check

= 2.1.0 =
* FIX: Checked if cache size is higher than 0 before applying filters
* FIX: Properly formatted numbers and filesize
* FIX: Fixed some ambiguous wording
* FIX: Fixed wrong value in the Sweeper section
* UPDATE: Removed a size calculation function
* UPDATE: Added a Zen mode option which removes most of WordPress-related clutter, notifications, meta boxes and filters
* UPDATE: Combined three options into one
* UPDATE: Removed Open Sans removal option (WordPress 4.6 defaults to system fonts)
* UPDATE: Updated enqueued developer scripts to use HTTPS (cdnjs.com and jsdelivr.com)
* UPDATE: Updated normalize.css to 4.2.0 (from 4.1.1)

= 2.0.6 =
* UPDATE: Made Gravatar cache optional via setting in "Cache & Compression" tab
* UPDATE: Added error reporting option
* UPDATE: Updated Theme Tweaks scripts and stylesheets versions

= 2.0.5 =
* UPDATE: Added more methods for XML-RPC protection
* UPDATE: Merged ping option with XML-RPC as they are related
* UPDATE: Forced removal of pingback URL for themes with hardcoded tag

= 2.0.4 =
* UPDATE: Added option to move scripts to footer
* UPDATE: Added option to cache Gravatars
* UPDATE: Minor UI improvements

= 2.0.3 =
* UPDATE: Updated CSS/JS developer libraries
* UPDATE: Updated recommended PHP version
* UPDATE: Updated recommended MySQL version (decreased to 5.6)
* UPDATE: Updated WordPress version requirement

= 2.0.2 =
* FIX: Fixed a typo
* FIX: Removed unused backup options
* FIX: Fixed an XSS vulnerability in remove_query_arg()
* UPDATE: Updated FontAwesome to version 4.6.2
* UPDATE: Updated attribution link for better appearance
* PERFORMANCE: Combined all initialization actions for faster startup
* PERFORMANCE: Combined all widget initialization actions for faster startup
* PERFORMANCE: Changed version query removal to accept values from an array

= 2.0.1 =
* UPDATE: Updated FontAwesome to version 4.6.1

= 2.0.0 =
* UPDATE: Removed partial backup feature
* UPDATE: Removed LInfo module as it posed a security risk
* UPDATE: Updated FontAwesome to version 4.6.0
* UPDATE: Replaced FontAwesome with Dashicons in admin view

= 1.9.2 =
* UPDATE: Added protocol check
* UPDATE: Added HTTP/2 check
* UPDATE: Removed MySQL client library check and replaced it with $wpdb->db_version()
* UPDATE: Increased recommended PHP version to 7.0.3
* UPDATE: Increased recommended MySQL version to 5.6
* UPDATE: Added link to official WordPress guidelines for site hardening

= 1.9.1 =
* FEATURE: Added HTML minify
* UPDATE: UI improvements

= 1.9.0 =
* FIX: Added autoload argument to all plugin options
* FIX: Fixed ETag generation by using actual filename instead of SCRIPT_FILENAME
* FIX: Fixed call-by-reference variables
* FIX: Removed all session control
* FIX: Changed Cache-Control to public (allow for global caching, instead of per-user)
* FIX: Re-enabled capital_P_dangit() filter :)
* UPDATE: Updated URL schema of included scripts and styles
* UPDATE: Added contextual help and legend

= 1.8.0 =
* UPDATE: Fixed description style
* UPDATE: Merged some options
* FEATURE: Added server information (based on Linfo)
* FEATURE: Added CSS/JS compression
* FEATURE: Added contextual help
* FIX: Removed admin tweaks as it broke some installations
* FIX: Fixed admin FontAwesome enqueuing
* FIX: Reworded the Sweeper clean-up options for less technical users

= 1.7.0 =
* UPDATE: Added WordPress 4.4 compatibility
* UPDATE: Fixed Sweeper UI
* UPDATE: Improved Sweeper functionality
* UPDATE: Added Sweeper backup notice
* FEATURE: Added WordPress version check
* FEATURE: Added WordPress 4.4 oembed option
* FEATURE: Added cache control options
* FIX: Removed a hardcoded link

= 1.6.0 =
* PERFORMANCE: Removed option autoloading (performance gain)
* DEV: Changed version format to x.y.z
* DEV: Removed hardcoded plugin version and switched to get_plugin_data()
* COMPATIBILITY: Added new WordPress 4.4 admin styles
* SECURITY: Added HSTS

= 1.5.0 =
* UPDATE: Reinforced XML-RPC protection by adding pingback protection
* UPDATE: Hidden XML-RPC from HTTP response headers

= 1.4.0 =
* FEATURE: Added widget removal
* FEATURE: Added content filtering removal
* FEATURE: Added various other actions disabling
* FEATURE: Added new helper (template part caching)

= 1.3.0 =
* FIX: Fixed a variable switch for Recommended and Aggresive plans
* FIX: Fixed GZIP detection
* FEATURE: Added transient clean option using CRON
* FEATURE: Added `If Modified Since` HTTP header
* FEATURE: Added autosuggest removal option (wp-admin only)
* FEATURE: Added security options
* FEATURE: Added XML-RPC system.multicall removal
* UPDATE: UI improvements
* UPDATE: Moved XML-RPC options to Security tab

= 1.2.0 =
* FEATURE: Added style tag clean option
* FEATURE: Added script tag clean option
* FEATURE: Added scheme normalization option
* FEATURE: Added CSS attributes removal option
* FEATURE: Added nofollow removal option to scoring/ranking tweaks

= 1.1.0 =
* RELEASE: First public release
