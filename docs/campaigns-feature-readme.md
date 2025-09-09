# Portfolio Theme Campaigns & Projects Feature

## Overview

The Campaigns & Projects feature allows you to showcase your social media posts, campaigns, and projects in an organized and visually appealing way. This feature includes:

1. A custom post type for campaigns
2. A quick add form for easily adding social media posts
3. A dedicated showcase page template
4. Filtering by platform and campaign type
5. Featured campaign highlight section

## Features

### 1. Custom Post Type: Campaign

- **Post Type**: `portfolio_campaign`
- **Features**: Title, content, featured image, platform selection, URL
- **Custom Fields**: Campaign URL, platform, featured status
- **Taxonomy**: Campaign Type for categorization

### 2. Quick Social Posts Form

- **Floating Action Button**: Quick access from anywhere in admin
- **URL Preview**: Paste a URL and get post preview
- **Simplified Publishing**: Streamlined workflow for adding social content

### 3. Dedicated Showcase Page

- **Template**: `templates/template-campaigns.php`
- **Filter System**: Filter by platform and campaign type
- **Featured Campaign**: Highlight important campaigns
- **Responsive Grid**: Works on all devices
- **Pagination**: For large collections

## File Structure

```
├── inc/
│   ├── campaigns.php             # Core campaign functionality
│   ├── campaigns-dashboard.php   # Admin dashboard page
│   ├── quick-social-posts.php    # Quick add form
│   └── widgets/
│       └── recent-campaigns-widget.php  # Widget for recent campaigns
├── assets/
│   ├── css/
│   │   ├── campaigns.css         # Main campaign styling
│   │   └── quick-posts.css       # Quick form styling
│   └── js/
│       ├── campaigns.js          # General campaign functionality
│       ├── campaigns-template.js # Template-specific JS
│       └── quick-posts.js        # Quick form functionality
├── templates/
│   └── template-campaigns.php    # Campaigns showcase template
└── docs/
    └── campaigns-showcase-guide.md  # User guide
```

## How to Use

### Creating a Campaign

1. Go to Campaigns > Add New in the WordPress admin
2. Add title, content, and featured image
3. Use the Campaign Settings meta box to add URL and select platform
4. Choose or create a Campaign Type
5. Publish

### Using the Quick Add Form

1. Click the floating "+" button in the admin
2. Paste the URL of a social media post
3. Add a title and adjust other settings as needed
4. Save

### Setting Up the Showcase Page

1. Create a new page in WordPress admin
2. Select "Campaigns & Projects Showcase" template
3. Publish the page
4. Add to your site navigation

### Marking Featured Campaigns

1. Edit any campaign
2. In the Campaign Settings meta box, check "Feature this campaign"
3. Save

## Styling

The campaigns feature comes with comprehensive styling that matches the portfolio theme. You can customize the appearance by modifying:

- `/assets/css/campaigns.css`: Main styling for campaign displays
- `/assets/css/quick-posts.css`: Styling for the quick add form

## Development Notes

- Uses WordPress metadata API for storing campaign details
- Compatible with both classic editor and Gutenberg
- Mobile-responsive design
- Optimized for performance with pagination and lazy loading

## Support

For questions or support with the campaigns feature, refer to:
- The user guide at `/docs/campaigns-showcase-guide.md`
- WordPress documentation on custom post types and templates
