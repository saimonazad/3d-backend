=== WooCommerce - Product Importer ===

Contributors: visser, visser.labs, byronkeet
Donate link: https://visser.com.au/donations/
Tags: woocommerce import, woocommerce product import, woocommerce import products, woocommerce import categories, import woocommerce products, product import, csv, excel
Requires at least: 2.9.2
Tested up to: 5.8.2
Stable tag: 1.5.2
License: GPLv2 or later

Import Products, Categories, Tags and product images into your WooCommerce store from Excel spreadsheet and other simple formatted files (e.g. CSV, TSV, TXT, etc.).

== Description ==

= Introduction - WooCommerce Product Import Plugin =

[Premium](https://visser.com.au/solutions/woocommerce-import/) | [Documentation](https://visser.com.au/documentation/product-importer-deluxe/)

**Import Products, Categories, Tags and product images into your WooCommerce store.**

Import detailed Products into your WooCommerce store from simple formatted files (e.g. CSV, TSV, TXT, etc.).

This WooCommerce Product import Plugin maintains compatibility with the latest WooCommerce release through regular Plugin updates, we also proudly maintain compatibility with legacy releases of WooCommerce.

Supported since 2012 Product importer for WooCommerce is maintained by an active community of store owners and developers providing feature suggestions and feedback.

= WooCommerce import features =

&#128312; Import new Products
&#128312; Delete existing Products by SKU
&#128312; Update existing Products (*)
&#128312; Import Product Categories
&#128312; Import Product Tags
&#128312; Import Product images (*)
&#128312; Import from CSV, TSV and TXT file
&#128312; Supports external CRON commands (*)
&#128312; WP-CLI support (*)

Supported Product fields include:

* SKU
* Product Name
* Description
* Excerpt
* Price
* Sale Price
* Weight
* Length
* Width
* Height
* Category
* Tag
* Quantity (*)
* Sort Order (*)
* Product Status (*)
* Comment Status (*)
* Tax Status (*)
* Sale Price Dates From (*)
* Sale Price Dates To (*)
* Permalink (*)
* Images (*)
* Featured Image (*)
* Product Gallery (*)
* Post Date (*)
* Post Modified (*)
* Type (*)
* Visibility (*)
* Featured (*)
* Tax Status (*)
* Tax Class (*)
* Manage Stock (*)
* Stock Status (*)
* Allow Backorders (*)
* Sold Individually (*)
* Up-sells (*)
* Cross-sells (*)
* File Download (*)
* Download Limit (*)
* Product URL (*)
* Button Text (*)
* Purchase Note (*)

Additional import features are introduced in regular major Plugin updates, minor Plugin updates address import issues and compatibility with new WooCommerce releases.

(*) Requires the Pro upgrade to enable additional Product import functionality.

= Native export integration with WooCommerce Plugins =

Features unlocked in the Pro upgrade of Product Importer include:

* Import All in One SEO Pack (AIOSEOP)
* Import Advanced Google Product Feed
* Import Ultimate SEO
* Import Yoast SEO

... and more free and Premium extensions for WooCommerce.

[For more information visit our site.](https://visser.com.au/solutions/woocommerce-import/)

Happy importing! :)

== Installation ==

1. Upload the folder 'woocommerce-product-importer' to the '/wp-content/plugins/' directory
2. Activate 'WooCommerce - Product Importer' through the 'Plugins' menu in WordPress
3. You can now import Products by reading the below Usage section

== Usage ==

1. Open WooCommerce > Product Importer
2. Using the file upload field select your CSV-formatted Product Catalog
3. Set the matching import field beside each corresponding column in your uploaded CSV file, this is usually selected automatically
4. Click Import Products
5. Review the Import Log updated during the live import
6. Press Finish Import
7. Review any Products that were skipped during the import
8. You can now manage Products within WooCommerce

Done!

== Screenshots ==

1. From the Import screen you can upload CSV files for import
3. The Settings screen includes options to alter the default formatting and behaviour of import files
3. Link CSV columns to WooCommerce Product fields and review the Import Options
4. Watch as new Products are populated within your WooCommerce store
5. A final review report includes skipped Products with reasons and a detailed import log for re-import

== Support ==

If you have any problems, questions or suggestions please raise a support topic on our dedicated WooCommerce support forum.

http://www.visser.com.au/woocommerce/forums/

== Changelog ==

= 1.5.2 =
* Fixed: Excess line ending on some PHP files
* Fixed: Removed closing PHP tag on all PHP files

= 1.5.1 =
* Added: Check for existing Encoding class

= 1.5 =
* Added: toggleback.js
* Update: Deprecated code in Encoding updated
* Tested: Up to WP 5.6

= 1.4 =
* Added: Import with PI button to Products screen
* Fixed: Warning: “continue” targeting switch is equivalent to “break” in PHP 7.3

= 1.3.1 =
* Fixed: Import file validation
* Changed: Moved Import Modules to Tools

= 1.3 =
* Changed: Compatibility with WordPress 4.5
* Fixed: Encoding detection on file uploads
* Changed: Text domain to woocommerce-product-importer

= 1.2 =
* Added: WooCommerce Branding support
* Added: Tools screen
* Added: Skip import log if generating more than 1000 Categories
* Added: Skip import log if generating more than 1000 Product Tags
* Changed: UI of the Import Options meta box on the Import screen
* Changed: Moved Product related functions to products.php
* Added: Pause and resume support to import engine
* Fixed: Display Price in final import report of skipped Products
* Added: Additional diagnostic/server notices on Import screen

= 1.1 =
* Added: Alias support for Product import columns
* Added: Delete matched Products import method

= 1.0 =
* Initial release of Plugin
* Added: Import new Products import method

== Disclaimer ==

It is not responsible for any harm or wrong doing this Plugin may cause. Users are fully responsible for their own use. This Plugin is to be used WITHOUT warranty.