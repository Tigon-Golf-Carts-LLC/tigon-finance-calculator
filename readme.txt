=== TIGON Financing Calculator ===
Contributors: noahjaslow
Tags: financing, woocommerce, payments, golf carts, tigon, elementor
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.1
Stable tag: 2.3.0
License: Proprietary
License URI: https://tigongolfcarts.com

The TIGON enterprise WordPress plugin that bridges ZERO Percent Financing Option with WooCommerce — automatically syncing inventory pricing with monthly payments using product data in real time.

== Description ==

TIGON Financing Calculator displays two financing options on every WooCommerce product page:

* **Lowest Payment** — 60 months at 7.99% APR (standard amortized monthly payment)
* **Best Deal** — 36 months at 0% APR + 5.25% fee (lowest total cost)

Prices sync in real time from WooCommerce product data, including variable product support.

= Manufacturer Widgets =

Dedicated widgets for each brand — available as both WordPress shortcodes and Elementor widgets:

* Denago — `[tigon_finance_denago]`
* Evolution — `[tigon_finance_evolution]`
* TEKO — `[tigon_finance_teko]`
* TARA — `[tigon_finance_tara]`
* Atlas — `[tigon_finance_atlas]`
* Club Car — `[tigon_finance_clubcar]`
* E-Z-GO — `[tigon_finance_ezgo]`
* Swift EV — `[tigon_finance_swiftev]`
* Used — `[tigon_finance_used]`

Generic shortcode: `[tigon_finance_calculator]`

= Shortcode Attributes =

* `price` — Override the auto-detected WooCommerce product price.
* `label` — CTA button text (default: "Apply for Financing").
* `url` — CTA button link (default: "https://tigongolfcarts.com/apply-for-financing").

= Elementor Integration =

The plugin registers a custom **TIGON Financing** widget category in the Elementor editor. All manufacturer widgets plus the generic calculator appear under this category for drag-and-drop placement.

Each Elementor widget includes a **Content** tab (price override, CTA text, CTA URL) and a full **Style** tab for per-widget CSS customization via Elementor wrappers:

* **Box** — Border color, background color, border radius, padding
* **Header** — Background color, text color, typography
* **Tabs** — Background color, text color, active tab background, active tab border color, typography
* **Price** — Price color, label color, price font size
* **CTA Button** — Background color, text color, border radius, padding, typography
* **Disclaimer** — Text color, background color, typography

Style overrides use Elementor's `{{WRAPPER}}` selectors, so each widget instance can be styled independently — no custom CSS needed.

== Installation ==

1. Upload the `tigon-finance-calculator` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Ensure WooCommerce 8.0+ is installed and active.
4. Use any shortcode or Elementor widget on product pages.

== Changelog ==

= 2.3.0 =
* Simplified financing detail lines (removed APR/fee/total from visible text)
* Active tab styled with red background; inactive tabs use blue
* Version cache-bust for CSS/JS assets

= 2.1.0 =
* Added Elementor Style tab controls for per-widget CSS customization via wrappers
* Added financing disclaimer to all widgets
* Used widget Best Deal fee set to 10%

= 2.0.0 =
* Two financing tabs: Lowest Payment (60mo @ 7.99% APR) and Best Deal (36mo 0% + 5.25% fee)
* Manufacturer-specific widgets: Denago, Evolution, TEKO, TARA, Atlas, Club Car, E-Z-GO, Swift EV, Used
* Elementor widgets for each manufacturer plus generic calculator
* Real-time WooCommerce variable product price sync

== License ==

Proprietary. All rights reserved. © TIGON Golf Carts.

Plugin Developer: Noah Jaslow © Jaslow Digital — jaslowdigital.com | PH: 215-789-1955
