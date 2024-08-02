<p>This is an exhaustive list of technical tips and tricks that will help improve your page speed and increase your performance score.</p>

<h3>DNS Lookup & Connection</h3>

<ol>
    <li>Check your DNS records and remove any that you don't need. Use a DNS server, such as Cloudflare, to improve the DNS lookup speed.</li>
</ol>

<h3>TTFB (Time To First Byte)</h3>

<ol>
    <li>Upgrade your server software (Apache, Nginx, Litespeed, IIS) to the latest available version.</li>
    <li>Upgrade your server PHP to the latest available version (8+).</li>
    <li>Upgrade your server database engine (MySQL, MariaDB, Percona, SQLite) to the latest available version.</li>
    <li>Create a static <code>robots.txt</code> file to avoid WordPress initializing every time a bot requests it.</li>
    <li>Create a static <code>favicon.ico</code> file to avoid slowdowns every time the browser requests it.</li>
</ol>

<p><b>Set up a backup server before taking the steps below.</b></p>

<h3>Response Time, Page Speed & Performance</h3>

<ol>
    <li>Upgrade your WordPress plugins to the latest available version.</li>
    <li>Upgrade your WordPress CMS to the latest available version.</li>
    <li>Upgrade your WordPress theme to the latest available version.</li>
    <li>Do not use a redirection plugin, if possible. Set your redirects server-side, in your <code>.htaccess</code> file or your Nginx configuration file.</li>
</ol>

<hr>

<ol>
    <li>Upgrade your WordPress plugins to the latest available version.</li>
    <li>Upgrade your WordPress CMS to the latest available version.</li>
    <li>Upgrade your WordPress theme to the latest available version.</li>
    <li>Make sure your database engine is InnoDB.</li>
    <li>Make sure your database encoding/collation is <code>utf8mb4</code>.</li>
    <li>Increase your WordPress memory constant &ndash; <code>WP_MEMORY_LIMIT</code> &ndash; to 128M+.</li>
    <li>Consider disabling revisions &ndash; <code>WP_POST_REVISIONS</code> (see example below).</li>
    <li>Consider disabling the trash &ndash; <code>MEDIA_TRASH</code> and <code>EMPTY_TRASH_DAYS</code> (see example below).</li>
</ol>

<pre>define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_POST_REVISIONS', false );
define( 'MEDIA_TRASH', false );
define( 'EMPTY_TRASH_DAYS', 0 );</pre>

<h3>Assets & Resources</h3>

<ol>
    <li>Reduce the number of JavaScript resources &ndash; use Google Tag Manager to load all external tracking snippets, analytics and more.</li>
    <li>Optimize your theme to load all JavaScript resources in the footer.</li>
    <li>Reduce the number of JavaScript resources and CSS stylesheets by cleaning up your plugins, refactoring your website's functionality or finding alternative plugins.</li>
    <li>Reduce the number of JavaScript resources and CSS stylesheets by combining them (either by refactoring your theme/plugins or by programmatically concatenating them).</li>
    <li>Minify your JavaScript resources and CSS stylesheets, either manually or by using Cloudflare.</li>
    <li>Load your custom fonts locally.</li>
    <li>Get rid of all unnecessary font subsets (based on your target audience's language).</li>
    <li>Get rid of all font versions, except for WOFF2.</li>
    <li>Use resource hints and early hints.</li>
</ol>

<hr>

<ol>
    <li>Use server caching (OPcache, XCache, Varnish, Redis, etc.).</li>
    <li>Use a caching plugin.</li>
</ol>

<h3>Prefetching</h3>

<p>Because <code>dns-prefetch</code> resolves only the domain name but doesn't <code>preconnect</code> to the remote server or preload the resource, it requires little bandwidth. However, it can significantly improve DNS latency — the total request-response time between the DNS server and the user's browser.</p>
<p>You'll only need to use <code>dns-prefetch</code> when the resource is hosted on a different domain, since you don't need to resolve your own domain name. <code>dns-prefetch</code> is typically recommended when prefetching domain names for: web fonts, such as Google Fonts or custom CDN fonts, analytics scripts, scripts coming from third-party resources, social media widgets or any widget that loads third-party content via the <code>&lt;script&gt;</code> tag, resources hosted on a CDN.</p>

<h3>Preconnecting</h3>

<p>For the most part, you can use the <code>preconnect</code> resource hint for the same things as <code>dns-prefetch</code>. You should choose it only <b>if you are sure</b> the user will request the script, font, stylesheet, or other resource from the third-party server.</p>
<p>Since <code>preconnect</code> exchanges more data, it also needs more bandwidth. So you have to be more careful with it to avoid slowing down the page and wasting your user's bandwidth with redundant data.</p>
<p>Be careful to not add too many resource hints, as they could quite easily negatively impact performance, especially on mobile.</p>

<p>Check the <a href="https://getbutterfly.com/using-resource-hints-to-optimize-wordpress-performance/" rel="external noopener" target="_blank">Using Resource Hints to Optimize WordPress Performance</a> guide.</p>

<h3>Content</h3>

<ol>
    <li>Get rid of your current page builder or reconsider its usability. Use the native WordPress block editor instead.</li>
    <li>Make sure all your images are lazy loaded.</li>
    <li>Replace your vector images and/or icons with inline SVG.</li>
    <li>Resize and compress your JPEG images.</li>
    <li>Use a third-party service (not a plugin) to optimize your images <b>before uploading them</b>.</li>
</ol>

<hr>

<ol>
    <li>Remove (or disable) your lazy-loading plugin (or script). Modern browsers now include native lazy-loading.</li>
</ol>

<hr>

<ol>
    <li>Check the <a href="https://getbutterfly.com/how-to-optimize-wordpress-native-settings-for-performance/" rel="external noopener" target="_blank">WordPress Native Settings Optimization</a> guide to squeeze even more speed from your WordPress site.</li>
</ol>

<h3><?php _e( 'Error Logging', 'lighthouse' ); ?></h3>

<p>Stay on top of errors, warnings, and notices as they occur.</p>
<p>See all errors, warnings, and notices in a file generally called <code>debug.log</code> in <code>wp-content</code> folder. If Apache does not have write permissions, you may need to create the file first and set the appropriate permissions (e.g. <code>0666</code>).</p>
<p>In order for errors to be logged, you need to edit your <code>wp-config.php</code> file and change the following values:</p>

<pre>define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
ini_set( 'display_errors', 0 );</pre>

<p>Find your error log (in document root or in <code>wp-content</code> directory):</p>
<p>
    Example #1: <code><?php echo $_SERVER['DOCUMENT_ROOT']; ?>/debug.log</code><br>
    Example #2: <code><?php echo WP_CONTENT_DIR; ?>/debug.log</code>
</p>

<h3>Other</h3>

<p>The suggestions below might not apply to your website.</b></p>

<ol>
    <li>Remove Google Analytics and replace it with a lighter solution, such as <a href="https://getbutterfly.com/wordpress-plugins/active-analytics/" rel="external noopener" target="_blank">Active Analytics</a>.</li>
    <li>Remove Google reCAPTCHA and replace it with Akismet or a lighter solution.</li>
</ol>
