# Seer Blocks

A WordPress Gutenberg block suite powered by [Seer](https://github.com/jacobsandersen). All requests to Seer are made server-side, so your auth token never reaches the browser.

## Modules

### Reading List

A query loop block that fetches books from Seer by status (previously read / currently reading / want to read).

| Block | Purpose |
| --- | --- |
| **Seer Book Query** (`seer/reading-list-query`) | The loop block: picks the component, book count, and columns; paginates independently per instance |
| **Seer Book Cover** | Cover image with configurable width |
| **Seer Book Title** | Title, own size control |
| **Seer Book Author** | Author name, own size control |
| **Seer Read Count** | "Read N times" - hidden when the book has not been read |
| **Seer Last Read** | "Last read {date}" - hidden when unavailable |
| **Seer Pagination** | Previous/Next links scoped per query block; omit to hide pagination |

### Now Listening

Shows the track you are currently listening to via Last.fm.

| Block | Purpose |
| --- | --- |
| **Seer Now Listening** (`seer/now-listening/track`) | Fetches the current track; configurable fallback text when nothing is playing |
| **Seer Song Name** | Song title, optionally linked to its Last.fm page |
| **Seer Artist Name** | Artist name |
| **Seer Album Art** | Album artwork with selectable source size and display width |

Item blocks only appear inside their module's wrapper block (enforced via `ancestor`/`parent` restrictions), but can be arranged freely within it - including inside core Group/Row/Stack blocks. Every item renders the same arrangement, and multiple query blocks on a page paginate independently.

Pagination is server-rendered with full page loads, mirroring the core Query Loop.

## Installation

1. Download the latest `seer-<version>.zip` (or run `npm run package` locally) and upload it via *Plugins > Add New > Upload Plugin*, or copy the folder into `wp-content/plugins/`.
2. Activate the plugin.
3. Configure your Seer instance under *Settings > Seer Blocks* (base URL and auth token).

### Upgrading from Seer Reading List 1.x (breaking)

Version 2.0.0 renames the plugin folder and all block names. On activation, existing posts, pages, templates, block widgets, and settings are migrated automatically to the new names.

1. Deactivate and delete the old **Seer Reading List** plugin.
2. Install and activate **Seer Blocks**.
3. Clear any caching/optimization plugin after activating.

Do not keep both plugins active at once.

## Development

```bash
npm install
npm start      # watch/build dev assets
npm run build  # production build
npm run lint:js
npm run lint:css
npm run package  # reproducible release zip -> dist/seer-<version>.zip
```

The plugin ships compiled assets from `build/`; there is no separate CI build step.

## Releases

Pushing a semver tag (`v1.2.3`) triggers the release workflow, which packages the plugin and publishes a GitHub release with the zip attached. The tag must match the version in `package.json`.

## License

GPL-2.0-or-later
