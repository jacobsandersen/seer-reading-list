=== Seer Reading List ===
Contributors:      Jacob Andersen
Tags:              block, books, reading, query loop
Tested up to:      6.8
Stable tag:        1.0.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Render a Seer-managed reading list with a query loop block and draggable book item blocks.

== Description ==

Seer Reading List is a Gutenberg block suite that displays your reading list managed by [Seer](https://github.com/jacobsandersen). All requests to Seer are made server-side, so your auth token never reaches the browser.

The suite ships six blocks:

* **Seer Book Query** - the loop block. Pick a Seer component (previously read / currently reading / want to read), how many books to show, the column count, and it fetches a page of books from your Seer instance.
* **Seer Book Cover** - the cover image, with a configurable width.
* **Seer Book Title** - the title, with its own size control.
* **Seer Book Author** - the author name, with its own size control.
* **Seer Read Count** - "Read N times" (hidden when the book has not been read).
* **Seer Last Read** - "Last read {date}" (hidden when unavailable).
* **Seer Pagination** - Previous/Next links scoped per query block; omit this block to hide pagination.

Drop the item blocks inside a query block and arrange them however you like - including inside core Group/Row/Stack blocks for side-by-side layouts. Every book in the loop renders the same arrangement. Multiple query blocks on one page paginate independently.

Pagination uses server-rendered links (full page loads), mirroring the core Query Loop.

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/seer-reading-list`, or install the plugin zip through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Configure your Seer instance under Settings -> Seer Reading List (base URL and auth token).

== Frequently Asked Questions ==

= Does my Seer token get exposed to visitors? =

No. The plugin proxies every request through PHP (`wp_remote_get`), so the token stays on the server.

= Can I place multiple reading lists on one page? =

Yes. Each query block paginates independently via its own stable identifier.

== Changelog ==

= 1.0.0 =
* Initial release: query loop block with cover, title, author, read count, last read, and pagination blocks.
