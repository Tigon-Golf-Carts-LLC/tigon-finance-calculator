# TIGON Financing Calculator

The TIGON enterprise WordPress plugin that bridges ZERO Percent Financing Option with WooCommerce — automatically syncing inventory pricing with monthly payments using product data in real time.

## Plugin Details

- **Plugin Name:** TIGON Financing Calculator
- **Version:** 2.3.0
- **Author:** Noah Jaslow & Jaslow Digital
- **Requires:** WordPress 6.0+ · WooCommerce 8.0+ · PHP 8.1+

## Description

TIGON Financing Calculator displays two financing options for every WooCommerce product:

| Tab | Terms | Details |
|-----|-------|---------|
| **Lowest Payment** | 60 months @ 7.99% APR | Standard amortized monthly payment |
| **Best Deal** | 36 months @ 0% APR + 5.25% fee | Lowest total cost for the buyer |

Prices sync in real time from WooCommerce product data, including variable product support. When a customer selects a product variation, the calculator automatically recalculates both financing options.

### Manufacturer Widgets

The plugin ships with dedicated widgets for each manufacturer brand. Each is available as both a **WordPress shortcode** and an **Elementor widget**:

| Manufacturer | Shortcode | Elementor Widget |
|-------------|-----------|-----------------|
| Denago | `[tigon_finance_denago]` | Denago Financing |
| Evolution | `[tigon_finance_evolution]` | Evolution Financing |
| TEKO | `[tigon_finance_teko]` | TEKO Financing |
| TARA | `[tigon_finance_tara]` | TARA Financing |
| Atlas | `[tigon_finance_atlas]` | Atlas Financing |
| Club Car | `[tigon_finance_clubcar]` | Club Car Financing |
| E-Z-GO | `[tigon_finance_ezgo]` | E-Z-GO Financing |
| Swift EV | `[tigon_finance_swiftev]` | Swift EV Financing |
| Used | `[tigon_finance_used]` | Used Financing |

A generic (unbranded) widget is also available:

- Shortcode: `[tigon_finance_calculator]`
- Elementor: **TIGON Financing Calculator**

### Shortcode Attributes

All shortcodes accept the same optional attributes:

| Attribute | Default | Description |
|-----------|---------|-------------|
| `price` | *(WooCommerce product price)* | Override the auto-detected product price |
| `label` | `Apply for Financing` | CTA button text |
| `url` | `https://tigongolfcarts.com/apply-for-financing` | CTA button link |

## Elementor Integration

The plugin registers a custom **TIGON Financing** widget category in the Elementor editor. All manufacturer widgets plus the generic calculator appear under this category, so you can drag-and-drop any financing widget directly onto a page.

### Content Controls

Each Elementor widget exposes a **Content** tab with the following controls:

| Control | Description |
|---------|-------------|
| **Custom Price Override** | Enter a numeric price to override the WooCommerce product price. Leave blank to auto-detect. |
| **CTA Button Text** | Customize the call-to-action button label (default: "Apply for Financing"). |
| **CTA Button URL** | Set the destination URL for the CTA button. |

### Style Controls (CSS via Elementor Wrappers)

Every widget includes a full **Style** tab that lets you override the default CSS directly within the Elementor editor — no custom CSS required. Elementor uses `{{WRAPPER}}` selectors internally, so style overrides are scoped to each individual widget instance. This means you can place multiple financing calculators on the same page with different visual styles.

| Style Section | Controls |
|---------------|----------|
| **Box** | Border color, background color, border radius, padding |
| **Header** | Background color, text color, typography |
| **Tabs** | Background color, text color, active tab background, active tab border color, typography |
| **Price** | Price color, label color, price font size |
| **CTA Button** | Background color, text color, border radius, padding, typography |
| **Disclaimer** | Text color, background color, typography |

All typography controls include font family, size, weight, style, line height, and letter spacing via Elementor's built-in typography group control. Responsive controls (border radius, padding, price font size) adapt per device breakpoint (desktop, tablet, mobile).

## Installation

1. Upload the `tigon-finance-calculator` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Ensure WooCommerce is installed and active.
4. Use any shortcode or Elementor widget on product pages.

## Changelog

### 2.3.0
- Simplified financing detail lines (removed APR/fee/total from visible text)
- Active tab styled with red background; inactive tabs use blue
- Version cache-bust for CSS/JS assets

### 2.1.0
- Added Elementor Style tab controls for per-widget CSS customization via wrappers
- Added financing disclaimer to all widgets
- Used widget Best Deal fee set to 10%

### 2.0.0
- Two financing tabs: Lowest Payment (60mo @ 7.99% APR) and Best Deal (36mo 0% + fee)
- Manufacturer-specific widgets for Denago, Evolution, TEKO, TARA, Atlas, Club Car, E-Z-GO, Swift EV, Used
- Elementor widgets with custom category for each manufacturer plus generic calculator
- Real-time WooCommerce variable product price sync

## License

Proprietary. All rights reserved. © TIGON Golf Carts.

## Developer

**Noah Jaslow** © Jaslow Digital — [jaslowdigital.com](https://jaslowdigital.com)
PH: 215-789-1955
