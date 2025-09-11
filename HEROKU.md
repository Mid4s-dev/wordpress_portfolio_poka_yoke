# Heroku WordPress Deployment

This repository contains a WordPress site configured for deployment on Heroku.

## Deploying to Heroku

### Option 1: Deploy with Heroku Button

[![Deploy to Heroku](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

### Option 2: Manual Deployment

1. Create a Heroku app:
   ```
   heroku create your-app-name
   ```

2. Add a PostgreSQL database:
   ```
   heroku addons:create heroku-postgresql:hobby-dev
   ```

3. Configure the environment variables:
   ```
   heroku config:set AUTH_KEY=`openssl rand -base64 32`
   heroku config:set SECURE_AUTH_KEY=`openssl rand -base64 32`
   heroku config:set LOGGED_IN_KEY=`openssl rand -base64 32`
   heroku config:set NONCE_KEY=`openssl rand -base64 32`
   heroku config:set AUTH_SALT=`openssl rand -base64 32`
   heroku config:set SECURE_AUTH_SALT=`openssl rand -base64 32`
   heroku config:set LOGGED_IN_SALT=`openssl rand -base64 32`
   heroku config:set NONCE_SALT=`openssl rand -base64 32`
   heroku config:set WP_HOME=https://your-app-name.herokuapp.com
   heroku config:set WP_SITEURL=https://your-app-name.herokuapp.com
   ```

4. Deploy your code:
   ```
   git push heroku main
   ```

## File Storage on Heroku

Heroku has an ephemeral filesystem, meaning that any files uploaded through WordPress (such as media files) will be lost when the dyno restarts. To store uploads persistently, consider using a plugin that integrates with Amazon S3 or another cloud storage provider.

## Recommended Plugins for Heroku

- **WP Offload Media Lite**: For storing media files on Amazon S3
- **Redis Object Cache**: For improved performance
- **WP Redis**: For Redis-based object caching

## Local Development

For local development, we recommend using Local by Flywheel, MAMP, or a similar local development environment for WordPress.
