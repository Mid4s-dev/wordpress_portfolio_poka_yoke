#!/bin/bash

# Deep cleanup script to remove all testimonials-related files and code

THEME_DIR="/home/mid4s/Local Sites/pokayoka/app/public/wp-content/themes/portfolio"

echo "========================================"
echo "Starting deep testimonials cleanup"
echo "========================================"

# 1. Delete all testimonial PHP files
echo "Deleting testimonial PHP files..."
find "$THEME_DIR" -type f -name "*testimonial*.php" -delete

# 2. Delete all testimonial documentation files
echo "Deleting testimonial documentation files..."
find "$THEME_DIR" -type f -name "*testimonial*.md" -delete

# 3. Delete all testimonial asset files
echo "Deleting testimonial asset files..."
find "$THEME_DIR/assets" -type f -name "*testimonial*.*" -delete

# 4. Delete testimonial widget files
echo "Deleting testimonial widget files..."
find "$THEME_DIR/inc/widgets" -type f -name "*testimonial*.*" -delete

# 5. Delete remaining testimonial related files with different naming patterns
echo "Deleting other testimonial related files..."
find "$THEME_DIR" -type f -name "fix-testimonials*" -delete
find "$THEME_DIR" -type f -name "*testimonial*" -delete

echo "========================================"
echo "Cleanup complete!"
echo "========================================"
