=== TIGON Financing Calculator ===
Contributors: noahjaslow
Tags: financing, woocommerce, payments, 0% apr, tigon
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.1
Stable tag: 2.0.0
License: Proprietary
License URI: https://tigongolfcarts.com

The TIGON enterprise WordPress plugin that bridges ZERO Percent Financing Option with WooCommerce — automatically syncing inventory pricing with monthly payments using product data in real time.

== Description ==

TIGON Financing Calculator connects your WooCommerce product catalog with a 0% financing option, displaying real-time monthly payment breakdowns (36, 48, and 60 months) directly on product pages. It works as both a WordPress shortcode and an Elementor widget.

**Features:**

* Real-time WooCommerce price sync with automatic monthly payment calculations
* 0% APR financing display across 36, 48, and 60-month terms
* Shortcode support: `[tigon_finance-calculator]`
* Elementor drag-and-drop widget
* Custom price override option
* Configurable CTA button text and URL

== Installation ==

1. Upload the `tigon-finance-calculator` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Ensure WooCommerce 8.0+ is installed and active.
4. Use the `[tigon_finance-calculator]` shortcode or the Elementor widget on any product page.

== Shortcode Usage ==

`[tigon_finance-calculator]`
`[tigon_finance-calculator price="12999" label="Get Financing" url="https://example.com/apply"]`

**Attributes:**

* `price` — Override the auto-detected WooCommerce product price.
* `label` — CTA button text (default: "Apply for 0% Financing").
* `url` — CTA button link (default: "https://tigongolfcarts.com/apply-for-financing").

== Changelog ==

= 2.0.0 =
* Rebranded as TIGON Financing Calculator
* Elementor widget support
* Shortcode with WooCommerce real-time price sync
* 36, 48, and 60-month 0% APR payment display

== License ==

Proprietary. All rights reserved. © TIGON Golf Carts.

Plugin Developer: Noah Jaslow © Jaslow Digital — jaslowdigital.com | PH: 215-789-1955
