=== Seer Blocks ===
Contributors:      Jacob Andersen
Tags:              block, books, music, reading, query loop
Tested up to:      6.8
Stable tag:        2.0.1
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Gutenberg block suite for Seer: render your reading list as a query loop and share what you are listening to right now.

== Description ==

Seer Blocks is a Gutenberg block suite powered by [Seer](https://github.com/jacobsandersen). All requests to Seer are made server-side, so your auth token never reaches the browser.

The suite ships two modules:

**Reading List** - a query loop block that fetches books from Seer by status (previously read / currently reading / want to read), rendered with draggable inner blocks:

* **Seer Book Query** - pick the component, book count, columns; paginates independently per instance.
* **Seer Book Cover**, **Seer Book Title**, **Seer Book Author** - cover image, title, and author with individual size/width controls.
* **Seer Read Count** - "Read N times" (hidden when the book has not been read).
* **Seer Last Read** - "Last read {date}" (hidden when unavailable).
* **Seer Pagination** - Previous/Next links scoped per query block; omit this block to hide pagination.

**Now Listening** - shows the track you are currently listening to via Last.fm:

* **Seer Now Listening** - fetches the current track; configurable fallback text when nothing is playing.
* **Seer Song Name** - song title, optionally linked to its Last.fm page.
* **Seer Artist Name** - artist name.
* **Seer Album Art** - album artwork with selectable source size and display width (hidden when no artwork exists).

Item blocks only appear inside their module's wrapper block, but can be arranged freely within it, including inside core Group/Row/Stack blocks.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/seer`, or install the plugin zip through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Configure your Seer instance under Settings -> Seer Blocks (base URL and auth token).

= Upgrading from Seer Reading List 1.x =

This version renames the plugin folder and all block names. On activation, existing posts, pages, templates, block widgets, and settings are migrated automatically to the new names. If you use another caching or optimization plugin, clear its cache after activating.

Do not keep both plugins active at the same time: deactivate and delete Seer Reading List before installing Seer Blocks.

== Frequently Asked Questions ==

= Does my Seer token get exposed to visitors? =

No. The plugin proxies every request through PHP (`wp_remote_get`), so the token stays on the server.

= Can I place multiple reading lists on one page? =

Yes. Each query block paginates independently via its own stable identifier.

== Changelog ==

= 2.0.1 =
* Fix pagination not rendering on the front end after the namespace migration.
* Allow Group/Row/Stack blocks inside the Now Listening wrapper for free formatting.
* Missing book covers and album art now render a styled placeholder instead of collapsing.

= 2.0.0 =
* Rebrand to Seer Blocks: new seer/* block namespace organized by module (reading-list, now-listening).
* New Now Listening module: current track from Last.fm with Song Name, Artist Name, and Album Art blocks.
* Automatic migration on activation rewrites existing content, block widgets, and settings to the new names.
* Breaking change: requires the one-time migration above; see the upgrade notes in the Installation section.

= 1.0.1 =
* Restrict book item blocks to render only inside a Seer Book Query block; pagination must be a direct child of the query.

= 1.0.0 =
* Initial release: query loop block with cover, title, author, read count, last read, and pagination blocks.
