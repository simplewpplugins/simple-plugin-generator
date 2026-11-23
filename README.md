# Simple Plugin Generator

## Description

Simple Plugin Generator is a lightweight, customizable WordPress plugin boilerplate generator that helps developers create consistent, well-structured plugins with minimal setup.

Using a shortcode-based interface, developers can configure plugin details, select core classes, include optional assets and directories, and download a ready-to-install plugin ZIP.

It features namespace-aware class autoloading, support for underscore-separated class names, documented initialization classes, and a reusable master-template architecture.

Designed to simplify repetitive setup tasks while maintaining clean, organized, and consistent WordPress plugin development practices.

## Installation

## Installation

1. Download the latest version of **Simple Plugin Generator** from the [GitHub Releases](https://github.com/simplewpplugins/simple-plugin-generator/releases) page.
2. Log in to your WordPress admin dashboard.
3. Navigate to **Plugins → Add New Plugin → Upload Plugin**.
4. Select the downloaded ZIP file and click **Install Now**.
5. Once installed, click **Activate Plugin**.
6. Create a new WordPress page or edit an existing one.
7. Add the following shortcode to the page:

   `[plugin_generator_form]`

8. Publish or update the page.
9. Open the page while logged in as an administrator to access the plugin generator.

### Generating Your First Plugin

1. Enter the plugin name, description, version, author, and other required details.
2. Configure the plugin slug, namespace, class name, and constant prefix.
3. Select the core classes you want to include in the generated plugin.
4. Choose optional assets, templates, language files, and publishing resources.
5. Review the generated file structure.
6. Click **Generate Plugin** to create your customized WordPress plugin.
7. Download the generated ZIP file.

The generated plugin can be installed directly through the WordPress admin dashboard or extracted for further development.

**Note:** Simple Plugin Generator does not automatically install generated plugins or create plugin directories inside `wp-content/plugins/`. Generated plugins are provided as downloadable ZIP archives.

## Usage

## Usage

Simple Plugin Generator provides a shortcode-based interface for creating customized WordPress plugin boilerplates. You can configure plugin information, select the classes and files you need, and download a ready-to-install ZIP archive.

### 1. Access the Plugin Generator

Create a WordPress page and insert the following shortcode:

`[plugin_generator_form]`

Publish the page and open it while logged in as an administrator.

For security reasons, the generator is accessible only to users with administrator privileges.

### 2. Configure Plugin Information

Complete the plugin information fields:

- **Plugin Name:** The display name of your WordPress plugin.
- **Plugin Slug:** A unique, lowercase identifier used for the plugin directory and main PHP file.
- **Plugin Description:** A brief description of the plugin's purpose.
- **Plugin Version:** The initial version number, such as `1.0.0`.
- **Author Name:** The plugin developer or organization.
- **Author URI:** The developer's website or GitHub profile.
- **Plugin URI:** The plugin's website or repository URL.
- **Namespace:** The PHP namespace used to organize plugin classes.
- **Main Class Name:** The primary class responsible for plugin initialization.
- **Constant Prefix:** A unique prefix used for plugin constants.

Some values are automatically suggested based on the plugin name and can be customized.

### 3. Select Plugin Classes

Choose which classes to include in your generated plugin:

- **Actions:** Organizes WordPress actions and filters.
- **Enqueue:** Handles frontend and admin asset registration.
- **Helper:** Provides reusable utility methods.
- **Shortcode:** Manages custom WordPress shortcodes.
- **Admin:** Contains WordPress administration functionality.

Only selected classes are included in the generated plugin. The initialization class automatically references the selected components.

### 4. Configure Files and Directories

Select the additional resources you want to generate:

- **Frontend CSS:** Creates frontend stylesheet files.
- **Frontend JavaScript:** Creates frontend JavaScript files.
- **Admin Assets:** Includes administration-specific CSS and JavaScript.
- **Templates:** Adds a directory for reusable PHP templates.
- **Languages:** Includes a directory for translation files.
- **Publishing Assets:** Includes the `publish/` directory for WordPress.org-related assets.
- **GitHub Files:** Includes optional GitHub documentation and repository configuration files.

Unselected optional components are excluded from the generated plugin structure.

### 5. Preview the Plugin Structure

Review the generated file structure before creating your plugin.

The preview reflects your selected classes, assets, and optional directories, allowing you to verify the configuration before downloading.

### 6. Generate and Download

Once the configuration is complete:

1. Click **Generate Plugin**.
2. The generator validates your configuration.
3. The selected files and classes are generated using the master template.
4. A downloadable ZIP archive is created.
5. Download the ZIP file to your computer.

The generator does not automatically install the generated plugin or save it inside the WordPress plugins directory.

### 7. Install or Customize the Generated Plugin

You can install the generated ZIP through **Plugins → Add New Plugin → Upload Plugin** in WordPress.

Alternatively, extract the archive and open the generated plugin folder in your preferred code editor.

The generated plugin provides a consistent starting structure for implementing custom WordPress functionality.

### 8. Class Naming and Autoloading

Simple Plugin Generator supports namespace-aware class autoloading and underscore-separated PHP class names.

For example:

| PHP Class | File Name |
|---|---|
| `Helper` | `class-helper.php` |
| `User_Profile` | `class-user-profile.php` |
| `Custom_Post_Type` | `class-custom-post-type.php` |
| `WooCommerce_Integration` | `class-woocommerce-integration.php` |

Classes are automatically loaded according to the generated plugin's naming conventions.

### 9. Further Development

After generating your plugin, you can:

- Add custom WordPress actions and filters.
- Implement frontend shortcodes.
- Develop administration functionality.
- Register and enqueue CSS and JavaScript.
- Create reusable templates.
- Extend existing classes or introduce new ones.
- Publish your completed plugin on GitHub or submit it to WordPress.org after meeting its requirements.

**Note:** Simple Plugin Generator creates a development-ready plugin bootstrap. Additional functionality, testing, security reviews, and compatibility verification may be required before distributing generated plugins.

## Changelog

### 2.0.0 — 2026-11-23

# Simple Plugin Generator v2.0.0

## Release Highlights

Simple Plugin Generator v2.0.0 introduces a redesigned shortcode-based interface, customizable plugin scaffolding, improved class autoloading, and downloadable ZIP generation.

This release focuses on making WordPress plugin development faster and more consistent while maintaining a lightweight, reusable plugin architecture.

## What's New

### Improved Plugin Generator Interface
- Redesigned, responsive shortcode form.
- Added helpful descriptions and instructions for configuration fields.
- Automatic generation of plugin slugs, class names, namespaces, and prefixes.
- Improved validation and error handling.
- Added a live preview of the generated plugin structure.

### Customizable Plugin Structure
- Select which core classes to include:
  - Actions
  - Enqueue
  - Helper
  - Shortcode
  - Admin
- Optional frontend and admin CSS/JavaScript files.
- Optional templates and language directories.
- Optional WordPress.org publishing assets.
- Optional GitHub-related files and documentation.
- Automatically exclude unselected components and their initialization references.

### ZIP Download
- Generate downloadable, installable WordPress plugin ZIP files.
- Removed the requirement to save generated plugins directly inside the WordPress plugins directory.
- Improved temporary file handling and cleanup.

### Improved Plugin Bootstrap
- Updated the generated initialization class with consistent formatting.
- Added PHPDoc comments and method documentation.
- Improved singleton initialization and component loading.
- Added support for underscore-separated class names.
- Improved namespace-aware class autoloading.

### Security Improvements
- Restricted generator access to authorized administrators.
- Added nonce verification and input validation.
- Improved filesystem handling and generation error reporting.
- Added safeguards against unintended file overwrites.

### GitHub Documentation
- Added a comprehensive `README.md`.
- Documented installation, shortcode usage, configuration options, generated directory structure, and troubleshooting.
- Added licensing and contribution information.

## Improvements
- Preserved the existing master-template architecture.
- Improved generated code consistency and readability.
- Reduced unnecessary files in generated plugins.
- Improved compatibility with different plugin configurations.
- Simplified the plugin generation workflow.

## Upgrade Notes

This release changes how generated plugins are delivered. Instead of creating plugin directories directly under `wp-content/plugins/`, the generator now provides downloadable ZIP archives.

The existing `[plugin_generator_form]` shortcode remains available.

## Requirements

- WordPress installation
- PHP with ZIP extension enabled
- Administrator access to use the generator

## License

GPL-2.0-or-later

**Developed by Simple Plugins**

https://github.com/simplewpplugins

## Earlier Changelog

### Version 2.0.0
- Renamed the plugin to Simple Plugin Generator.
- Redesigned the shortcode-based generator interface.
- Added configurable plugin classes and optional directories.
- Added automatic ZIP generation and download.
- Improved class autoloading with support for underscore-separated class names.
- Improved generated initialization class formatting and PHPDoc documentation.
- Added security improvements and input validation.
- Added a live preview of the generated plugin structure.
- Added comprehensive GitHub documentation.

### Version 1.x
- Initial development of the WordPress plugin generator.
- Introduced shortcode-based plugin generation.
- Added configurable plugin information and naming conventions.
- Implemented a reusable master-copy template structure.
- Added automatic generation of plugin classes and directories.
- Included standard Actions, Enqueue, Helper, Shortcode, and Admin classes.
- Implemented namespace-based class autoloading.
- Supported generating plugin files directly inside the WordPress plugins directory.
- Included basic WordPress.org publishing assets.
