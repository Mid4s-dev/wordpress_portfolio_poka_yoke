# Testimonials System Guide

## Overview

The testimonials system allows you to display client testimonials throughout your portfolio website. This guide explains how the system works, how to use it, and how to troubleshoot any issues.

## System Components

1. **Post Type Registration**: The `portfolio_testimonial` custom post type is registered with priority through several mechanisms to ensure reliability.
2. **Admin Interface**: Custom meta boxes for testimonial details (client name, rating, etc.)
3. **Display Templates**: Custom templates for single testimonials and archives
4. **Shortcode**: `[portfolio_testimonials]` for displaying testimonials on any page

## How to Use Testimonials

### Adding a New Testimonial

1. Go to WordPress admin → Testimonials → Add New
2. Enter the testimonial text in the main content area
3. Fill in the Client Name, Company, and Rating in the meta boxes
4. Add a featured image (optional) for the client's photo
5. Publish the testimonial

### Displaying Testimonials

**Using Shortcode:**
```
[portfolio_testimonials count="3" layout="grid" columns="2"]
```

**Shortcode Parameters:**
- `count`: Number of testimonials to display (default: all)
- `layout`: Display style - "slider", "grid", or "list" (default: slider)
- `columns`: For grid layout, number of columns (default: 3)
- `orderby`: Sort by "date", "title", or "random" (default: date)
- `min_rating`: Filter by minimum rating (1-5)

**Using Template Tags:**
```php
<?php 
if (function_exists('display_portfolio_testimonials')) {
    display_portfolio_testimonials(array(
        'count' => 3,
        'layout' => 'grid',
        'columns' => 2
    ));
}
?>
```

## Troubleshooting

### Post Type Not Registered

If testimonials disappear from the admin menu:

1. Visit `/wp-content/themes/portfolio/testimonials-immediate-fix.php` in your browser for an immediate fix that:
   - Registers the post type directly
   - Creates a super-priority fix file
   - Adds it to your functions.php
   
2. If you still have issues:
   - Visit `/wp-content/themes/portfolio/testimonials-fix-now.php` for a diagnostic report
   - Use the "Force Register" option to immediately register the post type
   - Use the "Create Super-Priority Fix" button to implement a comprehensive fix

3. For conflict resolution:
   - Visit `/wp-content/themes/portfolio/testimonials-conflict-fix.php` to identify conflicting hooks
   
4. Always finish by visiting Settings → Permalinks and clicking "Save Changes"

### Template Issues

If testimonials aren't displaying correctly on the frontend:

1. Check if your theme has custom templates:
   - `single-portfolio_testimonial.php` (single testimonial view)
   - `archive-portfolio_testimonial.php` (testimonials archive)

2. If not, the system will use default templates from the theme

### Shortcode Not Working

If the shortcode isn't displaying testimonials:

1. Verify that testimonials exist in the system
2. Check if the shortcode function is registered properly
3. Try clearing cache if you're using a caching plugin

## Emergency Recovery

If all else fails, the emergency fix will ensure testimonials keep working:

1. The emergency fix registers the testimonial post type with the highest priority
2. It's designed to override any conflicts from other parts of the code
3. You'll see admin notices if the emergency fix is active

## Technical Details

### Files Involved

- `functions.php`: Includes the testimonials system
- `inc/testimonials.php`: Main testimonials functionality
- `inc/testimonials-display.php`: Display functions and shortcodes
- `assets/css/testimonials.css`: Styling for testimonials
- `assets/js/testimonials.js`: JavaScript for testimonial sliders/features
- `single-portfolio_testimonial.php`: Single testimonial template
- `archive-portfolio_testimonial.php`: Testimonials archive template

### Post Type Arguments

The testimonials post type is registered with these settings:

```php
register_post_type('portfolio_testimonial', array(
    'labels' => array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial',
        // Other labels...
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'menu_icon' => 'dashicons-format-quote',
    'rewrite' => array('slug' => 'testimonials'),
));
```

## Maintenance Recommendations

1. **Regular Backups**: Always back up your site before making changes
2. **Update Permalinks**: After theme updates, visit Settings → Permalinks
3. **Check for Conflicts**: Be careful with plugins that might register similar post types
4. **Testing**: After updates, test the testimonials system with the check tool
