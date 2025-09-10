# Testimonials System Documentation

## Overview

The testimonials system in the Portfolio theme allows you to showcase client testimonials on your website. The system is built around a custom post type called `portfolio_testimonial` and includes:

1. Core post type registration
2. Admin interface for managing testimonials
3. Meta boxes for client information
4. Shortcodes for displaying testimonials on the front-end
5. Dashboard widget for quick access to testimonials
6. Custom widget for displaying testimonials in sidebars

## File Structure

The testimonials functionality is split across several files to maintain clean code organization:

- `inc/testimonials-core.php` - Core post type registration and basic functionality
- `inc/testimonials-admin.php` - Admin menu setup
- `inc/testimonials-dashboard.php` - Dashboard page functionality
- `inc/widgets/testimonials-widget.php` - Widget implementation
- `assets/css/testimonials.css` - Frontend styling
- `assets/js/testimonials.js` - JavaScript functionality

## Core Registration

The post type is registered in `testimonials-core.php` with the following key aspects:

1. Post type name: `portfolio_testimonial`
2. Slug: `testimonial`
3. Support for: title, editor, featured image
4. Custom meta fields for client details

## Custom Meta Fields

Each testimonial stores the following meta fields:

- `_portfolio_testimonial_client_name` - Client's name
- `_portfolio_testimonial_client_title` - Client's job title/position
- `_portfolio_testimonial_client_company` - Client's company
- `_portfolio_testimonial_rating` - Rating (1-5 stars)

## Displaying Testimonials

### Shortcodes

You can display testimonials using the following shortcodes:

```
[portfolio_testimonials count="3" layout="grid" columns="3"]
```

Available parameters:

- `count` - Number of testimonials to display (default: -1, all)
- `layout` - Display layout (grid, slider, carousel)
- `columns` - Number of columns for grid layout (1-4)
- `orderby` - Order by parameter (date, title, rand)
- `order` - Sort order (ASC, DESC)
- `min_rating` - Minimum rating to display (1-5)

### Widget

The testimonials widget allows you to display testimonials in widget areas. You can configure:

1. Title
2. Number of testimonials to show
3. Display style
4. Order
5. Minimum rating filter

## Troubleshooting

### Invalid Post Type Error

If you encounter an "Invalid Post Type" error, try these steps:

1. Go to Settings > Permalinks and click "Save Changes" to flush rewrite rules
2. Check that `testimonials-core.php` is properly included in `functions.php`
3. Verify that no other code is trying to register the same post type
4. Run the cleanup script at `/wp-content/themes/portfolio/testimonials-cleanup.php`

## Custom Development

### Adding New Meta Fields

To add new meta fields to testimonials:

1. Add the field to the meta box in `testimonials-core.php`
2. Add the save logic in the save meta box function
3. Update the admin column display if needed
4. Update the shortcode display function to show the new field

### Styling Testimonials

The testimonials appearance can be customized by modifying:

- `assets/css/testimonials.css` - Main styling file
- `assets/js/testimonials.js` - For interactive features

## Credits

The testimonials system was built specifically for the Portfolio theme and optimized for simplicity and ease of use.

## Version History

- v1.0 - Initial implementation
- v1.1 - Added ratings system
- v1.2 - Added testimonials dashboard
- v2.0 - Consolidated code and fixed registration issues
