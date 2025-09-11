#!/bin/bash

# Script to prepare WordPress for Heroku deployment
# This script helps with migrating a local WordPress installation to Heroku

# Set environment variables
echo "Setting environment variables for Heroku..."
heroku config:set AUTH_KEY=$(openssl rand -base64 32)
heroku config:set SECURE_AUTH_KEY=$(openssl rand -base64 32)
heroku config:set LOGGED_IN_KEY=$(openssl rand -base64 32)
heroku config:set NONCE_KEY=$(openssl rand -base64 32)
heroku config:set AUTH_SALT=$(openssl rand -base64 32)
heroku config:set SECURE_AUTH_SALT=$(openssl rand -base64 32)
heroku config:set LOGGED_IN_SALT=$(openssl rand -base64 32)
heroku config:set NONCE_SALT=$(openssl rand -base64 32)

# Get the Heroku app name
echo "Enter your Heroku app name (e.g., your-app-name):"
read APP_NAME

# Set WP_HOME and WP_SITEURL
heroku config:set WP_HOME=https://$APP_NAME.herokuapp.com
heroku config:set WP_SITEURL=https://$APP_NAME.herokuapp.com

echo "Environment variables have been set!"

# Rename wp-config-heroku.php to wp-config.php
cp -f wp-config-heroku.php wp-config.php

echo "WordPress configuration for Heroku is complete!"
echo "Don't forget to commit these changes to your repository."
echo "Then deploy to Heroku using 'git push heroku main'"
