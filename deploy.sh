#!/bin/bash
echo "🚀 Deploying YPS Theme to /wp-content/themes/yps-theme..."
TARGET_DIR="/home/site/wwwroot/wp-content/themes/yps-theme"
mkdir -p "$TARGET_DIR"

# Copy theme files into theme directory without deleting root WordPress files
cp -r . "$TARGET_DIR/"

echo "✅ Theme deployed successfully to $TARGET_DIR!"
