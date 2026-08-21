# Seer Reading List

A WordPress Gutenberg block suite that renders a reading list managed by [Seer](https://github.com/jacobsandersen). All requests to Seer are made server-side, so your auth token never reaches the browser.

## Blocks

| Block | Purpose |
| --- | --- |
| **Seer Book Query** | The loop block: picks a Seer component (previously read / currently reading / want to read), book count, columns, and fetches a page of books from Seer |
| **Seer Book Cover** | Cover image with configurable width |
| **Seer Book Title** | Title, own size control |
| **Seer Book Author** | Author name, own size control |
| **Seer Read Count** | "Read N times" - hidden when the book has not been read |
| **Seer Last Read** | "Last read {date}" - hidden when unavailable |
| **Seer Pagination** | Previous/Next links scoped per query block; omit to hide pagination |

Drop the item blocks inside a query block and arrange them however you like, including inside core Group/Row/Stack blocks for side-by-side layouts. Every book in the loop renders the same arrangement, and multiple query blocks on a page paginate independently (each block gets a stable identifier on insert).

Pagination is server-rendered with full page loads, mirroring the core Query Loop.

## Installation

1. Download the latest `seer-reading-list.zip` (or run `npm run package` locally) and upload it via *Plugins > Add New > Upload Plugin*, or copy the folder into `wp-content/plugins/`.
2. Activate the plugin.
3. Configure your Seer instance under *Settings > Seer Reading List* (base URL and auth token).

## Development

```bash
npm install
npm start      # watch/build dev assets
npm run build  # production build
npm run lint:js
npm run lint:css
npm run package  # reproducible release zip -> dist/seer-reading-list.zip
```

The plugin ships compiled assets from `build/`; there is no separate CI build step.

## License

GPL-2.0-or-later
