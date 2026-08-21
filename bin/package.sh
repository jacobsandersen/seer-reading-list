#!/usr/bin/env bash
#
# Packages the Seer Reading List plugin into a clean, installable zip.
#
# Stages only the files WordPress needs (plugin bootstrap, compiled build
# assets, includes, readme) and zips them under a top-level plugin folder,
# ready for "Plugins > Add New > Upload" or manual extraction into
# wp-content/plugins/.
#
# Usage: npm run package   (or: bash bin/package.sh)

set -euo pipefail

cd "$(dirname "$0")/.."

PLUGIN_SLUG="seer"
VERSION=$(node -p "require('./package.json').version")
STAGE="dist/${PLUGIN_SLUG}"
ZIP="dist/${PLUGIN_SLUG}-${VERSION}.zip"

# 1. Build fresh assets (also regenerates build/blocks-manifest.php).
npm run build

# 2. Stage only shippable files.
rm -rf dist
mkdir -p "${STAGE}"

cp seer.php readme.txt "${STAGE}/"
cp -r includes build "${STAGE}/"

# 3. Zip with a top-level plugin folder so extraction lands in
#    wp-content/plugins/seer-reading-list/.
(
	cd dist
	zip -rq "${ZIP##*/}" "${PLUGIN_SLUG}"
)

# 4. Drop the staging copy; keep only the archive.
rm -rf "dist/${PLUGIN_SLUG}"

echo
echo "Packaged ${PLUGIN_SLUG} v${VERSION}: ${ZIP}"
unzip -l "${ZIP}" | tail -1
