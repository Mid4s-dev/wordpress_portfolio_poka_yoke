#!/bin/bash

# Testimonials Cleanup Script
# This script will clean up redundant testimonial files and fix the testimonial post type issues

# Friendly banner
echo "====================================================="
echo "       Portfolio Theme Testimonials Cleanup          "
echo "====================================================="
echo ""

# Display working directory
THEME_DIR="/home/mid4s/Local Sites/pokayoka/app/public/wp-content/themes/portfolio"
echo "Working in directory: $THEME_DIR"

# Check if we're in the right directory
if [ ! -f "$THEME_DIR/functions.php" ]; then
    echo "Error: functions.php not found. Are you in the theme directory?"
    exit 1
fi

echo "Step 1: Creating backup of current state..."
# Backup important files
mkdir -p "$THEME_DIR/backups/$(date +%Y%m%d)"
cp "$THEME_DIR/functions.php" "$THEME_DIR/backups/$(date +%Y%m%d)/functions.php.bak"
cp "$THEME_DIR/inc/testimonials-core.php" "$THEME_DIR/backups/$(date +%Y%m%d)/testimonials-core.php.bak" 2>/dev/null
cp "$THEME_DIR/inc/testimonials.php" "$THEME_DIR/backups/$(date +%Y%m%d)/testimonials.php.bak" 2>/dev/null
echo "Backup created in $THEME_DIR/backups/$(date +%Y%m%d)/"

# Step 2: Remove redundant files
echo ""
echo "Step 2: Removing redundant testimonial files..."
REDUNDANT_FILES=(
  "$THEME_DIR/inc/new-testimonials.php"
  "$THEME_DIR/inc/core-testimonials.php"
  "$THEME_DIR/inc/testimonials.php"
  "$THEME_DIR/portfolio-testimonials-core.php"
  "$THEME_DIR/portfolio-testimonials-fix.php"
  "$THEME_DIR/debug-post-types.php"
  "$THEME_DIR/create-testimonials.php"
  "$THEME_DIR/fix-testimonials-post-type.php"
  "$THEME_DIR/testimonials-diagnostic.php"
  "$THEME_DIR/flush-rules.php"
)

for file in "${REDUNDANT_FILES[@]}"; do
  if [ -f "$file" ]; then
    echo "Removing: $file"
    rm "$file"
  else
    echo "Not found: $file (skipping)"
  fi
done

echo ""
echo "Step 3: Flushing rewrite rules..."
# Create a temporary script to flush rewrite rules through WordPress
cat > "$THEME_DIR/flush-rewrite-rules.php" << 'EOF'
<?php
/**
 * Flush Rewrite Rules Script
 * 
 * This script will flush WordPress rewrite rules to ensure permalinks work correctly.
 */

// Bootstrap WordPress
define('WP_USE_THEMES', false);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php';

// Check permissions
if (!current_user_can('manage_options')) {
    wp_die('You need administrator permissions to run this tool.');
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Flush Rewrite Rules</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6; }
        h1, h2 { color: #23282d; }
        .card { background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 15px; margin-bottom: 20px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Flush Rewrite Rules</h1>';

echo '<div class="card">';
echo '<h2>Registered Post Types</h2>';
echo '<ul>';

$post_types = get_post_types(array(), 'objects');
foreach ($post_types as $post_type) {
    echo '<li>' . esc_html($post_type->name) . ' - ' . esc_html($post_type->label) . '</li>';
}

echo '</ul>';
echo '</div>';

echo '<div class="card">';
echo '<h2>Flushing Rewrite Rules</h2>';

// Flush rewrite rules
flush_rewrite_rules(true);
echo '<p class="success">✅ Rewrite rules flushed successfully.</p>';

// Check if testimonial post type is registered
$testimonial_exists = post_type_exists('portfolio_testimonial');
echo '<p>' . ($testimonial_exists ? '✅ portfolio_testimonial post type is registered.' : '❌ portfolio_testimonial post type is NOT registered!') . '</p>';

echo '<p>Return to <a href="' . admin_url() . '">WordPress Dashboard</a></p>';
echo '</div>';

echo '</body>
</html>';

// Delete this file after execution
@unlink(__FILE__);
EOF

echo "Created temporary flush rewrite rules script."

echo ""
echo "Step 4: Verification..."
echo "Please check that:"
echo "1. Visit your WordPress admin"
echo "2. Go to Testimonials section"
echo "3. Confirm you can see and edit testimonials"
echo "4. Visit /wp-content/themes/portfolio/flush-rewrite-rules.php in your browser"
echo ""
echo "Done! All unnecessary testimonial files have been cleaned up."
echo "The core testimonials-core.php and testimonials-admin.php files remain intact."
echo "====================================================="
