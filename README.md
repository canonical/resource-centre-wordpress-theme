# Ubuntu Resources

A headless WordPress theme for managing Ubuntu resource content. This theme serves as a backend content management system for the Ubuntu resource hub, providing custom post types, taxonomies, and REST API extensions.

## Overview

Ubuntu Resources is designed as a headless WordPress theme, meaning it functions as a content API backend only. The frontend is served by a separate application. All direct frontend access is redirected to the WordPress admin panel.

**Author:** Canonical Ltd
**Version:** 1.0
**License:** Copyright 2012 Canonical Ltd

## Requirements

- WordPress 6.8 or higher
- PHP 8.3 or higher
- REST API support (WordPress native)

## Features

### Custom Post Types

The theme registers four custom post types:

1. **Event** - Public post type for events
   - REST API enabled
   - Supports: title, editor, thumbnail, comments, revisions, author
   - Hierarchical structure
   - Custom metadata: location, venue, registration, start/end dates

2. **Webinar** - Public post type for webinars
   - Admin-only (REST API disabled)
   - Supports: title, editor, excerpt, thumbnail, author, comments, revisions
   - Hierarchical structure

3. **Product Business Cards** - Internal, non-public post type
   - Used for product marketing materials
   - Admin-only management

4. **Topic CTA** - Internal, non-public post type
   - Custom calls-to-action for topics
   - Admin-only management

### Custom Taxonomies

1. **Topic** (Hierarchical)
   - Applied to: posts, events, webinars, product business cards, topic CTAs, attachments
   - REST API enabled
   - Primary content categorization system

2. **Group** (Hierarchical)
   - Auto-assigned based on topic selection
   - Categories: cloud-and-server, internet-of-things, desktop, phone-and-tablet
   - Automated via taxonomy sync system

### REST API Extensions

The theme extends the WordPress REST API with custom fields:

**Event Fields:**
- `_event_location` - Event location
- `_event_venue` - Venue name
- `_event_registration` - Registration URL
- Date fields: `_start_day`, `_start_month`, `_start_year`, `_end_day`, `_end_month`, `_end_year`

**User Fields:**
- Custom profile information exposed to REST API

### Admin Features

- Custom metaboxes for event metadata management
- Event date fields with separated day/month/year inputs
- Admin menu customizations
- Custom icons for post types

### Utility Features

- Reading time calculation for posts
- Automatic taxonomy synchronization (topic to group mapping)
- Data validation helpers
- RSS feed customizations

### Navigation Menus

Three registered navigation menu locations:
- Primary Products
- Primary Categories
- Press Centre

### Widget Areas

- Search Sidebar

## Installation

1. Upload the theme directory to `/wp-content/themes/`
2. Activate the theme through the WordPress admin panel
3. Configure navigation menus in Appearance > Menus
4. Set up custom post types and taxonomies as needed

## Theme Structure

```
resource-centre/
├── functions/                    # Modular theme functionality
│   ├── bootstrap.php            # Theme initialization hub
│   ├── post-types/              # Custom post type definitions
│   │   ├── event.php
│   │   ├── webinar.php
│   │   └── internal.php
│   ├── taxonomies/              # Custom taxonomy definitions
│   │   ├── topic.php
│   │   └── group.php
│   ├── rest/                    # REST API extensions
│   │   ├── event-fields.php
│   │   └── user-fields.php
│   ├── admin/                   # Admin-only functionality
│   │   ├── menu.php
│   │   └── metaboxes.php
│   ├── helpers/                 # Utility functions
│   │   ├── taxonomy-sync.php
│   │   └── validation.php
│   ├── Tax-meta-class/          # Taxonomy metadata handling
│   ├── profile.php              # User profile functionality (legacy)
│   ├── rss.php                  # RSS feed customizations (legacy)
│   └── read-time.php            # Reading time calculation widget
├── static/                      # Static assets
│   └── img/                     # Admin interface icons
├── functions.php                # Main functions file
├── index.php                    # Headless theme redirect
├── style.css                    # Theme stylesheet with metadata
└── screenshot.png               # Theme thumbnail
```

## Development

### Architecture

The theme follows a modular architecture pattern:

- **Bootstrap System**: `functions/bootstrap.php` serves as the central initialization hub
- **Separation of Concerns**: Each feature is isolated in its own file
- **Admin Context Loading**: Admin-specific code only loads in admin context
- **Security**: Consistent use of ABSPATH checks for WordPress security

### Theme Constants

The following constants are defined for theme paths:

- `RC_THEME_DIR` - Theme directory path
- `RC_THEME_URI` - Theme URI for assets
- `RC_FUNCTIONS_DIR` - Functions directory path

### Content Width

Default content width is set to 540px.

### Taxonomy Sync

The theme includes automatic taxonomy synchronization that assigns the appropriate `group` taxonomy based on the selected `topic`. This automation ensures content is properly categorized across both taxonomic systems.

## REST API Usage

Since this is a headless theme, content is accessed via the WordPress REST API:

```
GET /wp-json/wp/v2/posts
GET /wp-json/wp/v2/event
GET /wp-json/wp/v2/webinar
```

Custom fields are automatically included in REST API responses for supported post types.

## Recent Changes

- Reorganized theme for headless architecture
- Resolved PHP 8.3 and WordPress 6.8 compatibility issues
- Modular structure implementation for better maintainability

## Legacy Code

The theme maintains backward compatibility with:
- `rss.php` - RSS feed customizations
- `profile.php` - User profile functionality

These files are preserved for compatibility purposes and may be deprecated in future versions.

## Support

For issues, questions, or contributions, please contact Canonical Ltd.

**Website:** http://canonical.com

---

Copyright 2012 Canonical Ltd
