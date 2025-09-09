# Campaigns & Projects Showcase Guide

This guide will help you set up and use the Campaigns & Projects Showcase template that has been created for your portfolio theme.

## 1. Creating a Campaigns Showcase Page

1. **Create a new page**: 
   - Go to WordPress Admin → Pages → Add New
   - Give your page a title (e.g., "Campaigns & Projects")
   - In the Page Attributes section on the right side, select "Campaigns & Projects Showcase" from the Template dropdown
   - Publish the page

2. **Add to navigation**:
   - Go to WordPress Admin → Appearance → Menus
   - Add your new page to your main navigation menu
   - Save the menu

## 2. Marking Campaigns as Featured

To highlight important campaigns at the top of your showcase page:

1. Edit the campaign you want to feature
2. Look for the "Campaign Settings" meta box
3. Check the box labeled "Feature this campaign on the campaigns page"
4. Update the campaign

Only one campaign will be displayed as featured (the most recent one marked as featured). If you want to change which campaign is featured, simply mark a different campaign as featured.

## 3. Filtering Capabilities

The template includes filtering options that allow visitors to filter campaigns by:

- **Platform**: LinkedIn, Twitter, Instagram, etc.
- **Campaign Type**: Whatever campaign types you have created

The filtering works through the URL parameters, so there's no need for additional setup.

## 4. Understanding the Campaign Display

The template displays campaigns in the following layout:

1. **Featured Campaign**: At the top, with a larger image and more prominent display
2. **Filter Section**: Allows visitors to filter by platform and campaign type
3. **Campaign Grid**: Displays all campaigns in a responsive grid layout
4. **Pagination**: If you have many campaigns, they'll be paginated automatically

## 5. Campaign Card Elements

Each campaign card includes:

- Thumbnail/Featured image
- Title
- Excerpt
- Platform icon and name
- Date published
- Link to view the full campaign
- Link to the original social media post (if applicable)

## 6. Styling Customization

The styling for the campaign showcase is in:
`/themes/portfolio/assets/css/campaigns.css`

You can modify this file to change colors, spacing, and other visual aspects to match your portfolio's style.

## 7. Adding Quick Social Posts

Remember that you can quickly add social media posts using the Quick Social Post tool:

1. Look for the floating "+" button in the admin area
2. Click it to open the Quick Post form
3. Paste the URL of your social media post
4. Add a title and select the platform
5. Save the post

## 8. Troubleshooting

If campaigns aren't displaying properly:

1. Make sure you've published some campaigns (post type: portfolio_campaign)
2. Verify that your campaigns have featured images for optimal display
3. Check that your page is using the "Campaigns & Projects Showcase" template
4. If the styles aren't loading, check that campaigns.css is being loaded correctly

## 9. Next Steps

Consider enhancing your campaign showcase with:

- Adding more campaign types through the taxonomy
- Creating custom icons for different platforms
- Setting up automatic social media imports

For any questions or additional customizations, refer to the theme documentation or contact your developer.
