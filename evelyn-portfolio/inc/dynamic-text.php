<?php
/**
 * Dynamic Text Helper Functions
 *
 * Helper functions to replace hardcoded names and text with dynamic content
 * from the WordPress admin settings.
 */

if (!function_exists('portfolio_owner_name')) {
    /**
     * Get the portfolio owner's name
     *
     * @param string $default Default value if no name is set
     * @return string The portfolio owner's name
     */
    function portfolio_owner_name($default = 'Evelyn') {
        return get_option('portfolio_owner_name', $default);
    }
}

if (!function_exists('portfolio_owner_job_title')) {
    /**
     * Get the portfolio owner's job title
     *
     * @param string $default Default value if no job title is set
     * @return string The portfolio owner's job title
     */
    function portfolio_owner_job_title($default = 'PR & Comms Lead') {
        return get_option('portfolio_owner_job_title', $default);
    }
}

if (!function_exists('portfolio_owner_company')) {
    /**
     * Get the portfolio owner's company
     *
     * @param string $default Default value if no company is set
     * @return string The portfolio owner's company
     */
    function portfolio_owner_company($default = 'Immobilis') {
        return get_option('portfolio_owner_company', $default);
    }
}

if (!function_exists('portfolio_owner_bio')) {
    /**
     * Get the portfolio owner's bio
     *
     * @param string $default Default value if no bio is set
     * @return string The portfolio owner's bio
     */
    function portfolio_owner_bio($default = 'A passionate photographer and storyteller, capturing moments that matter.') {
        return get_option('portfolio_owner_bio', $default);
    }
}

if (!function_exists('portfolio_owner_email')) {
    /**
     * Get the portfolio owner's email
     *
     * @param string $default Default value if no email is set
     * @return string The portfolio owner's email
     */
    function portfolio_owner_email($default = '') {
        return get_option('portfolio_owner_email', $default);
    }
}

if (!function_exists('portfolio_get_title')) {
    /**
     * Get dynamically generated page title
     * 
     * @param string $title_format Format string with {name} placeholder
     * @return string Formatted title with owner name
     */
    function portfolio_get_title($title_format) {
        $owner_name = portfolio_owner_name();
        return str_replace('{name}', $owner_name, $title_format);
    }
}

if (!function_exists('portfolio_get_description')) {
    /**
     * Get dynamically generated description
     * 
     * @param string $desc_format Format string with {name}, {job_title}, and {company} placeholders
     * @return string Formatted description
     */
    function portfolio_get_description($desc_format) {
        $owner_name = portfolio_owner_name();
        $job_title = portfolio_owner_job_title();
        $company = portfolio_owner_company();
        
        $desc = str_replace('{name}', $owner_name, $desc_format);
        $desc = str_replace('{job_title}', $job_title, $desc);
        $desc = str_replace('{company}', $company, $desc);
        
        return $desc;
    }
}
