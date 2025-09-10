#!/bin/bash

# Rebuild Tailwind CSS with our custom colors
echo "Building Tailwind CSS with maroon color scheme..."
npm run build

# Clear any caches
echo "Clearing WordPress caches..."
if [ -f "wp-cli.phar" ]; then
  php wp-cli.phar cache flush
fi

echo "CSS rebuild complete! The theme now uses a maroon and yellow color scheme."
