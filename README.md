# TIGON Financing Calculator

The TIGON enterprise WordPress plugin that bridges ZERO Percent Financing Option with WooCommerce — automatically syncing inventory pricing with monthly payments using product data in real time.

## Plugin Details

- **Plugin Name:** TIGON Financing Calculator
- **Version:** 2.0.0
- **Author:** Noah Jaslow & Jaslow Digital
- **Requires:** WordPress 6.0+ · WooCommerce 8.0+ · PHP 8.1+

## Description

TIGON Financing Calculator displays two financing options for every WooCommerce product:

| Tab | Terms | Details |
|-----|-------|---------|
| **Lowest Payment** | 60 months @ 7.99% APR | Standard amortized monthly payment |
| **Best Deal** | 36 months @ 0% APR + 5.25% fee | Lowest total cost for the buyer |

Prices sync in real time from WooCommerce product data, including variable product support.

### Manufacturer Widgets

The plugin ships with dedicated widgets for each manufacturer brand. Each is available as both a **WordPress shortcode** and an **Elementor widget**:

| Manufacturer | Shortcode | Elementor Widget |
|-------------|-----------|-----------------|
| Denago | `[tigon_finance_denago]` | TIGON Finance — Denago |
| Evolution | `[tigon_finance_evolution]` | TIGON Finance — Evolution |
| TEKO | `[tigon_finance_teko]` | TIGON Finance — TEKO |
| TARA | `[tigon_finance_tara]` | TIGON Finance — TARA |
| Atlas | `[tigon_finance_atlas]` | TIGON Finance — Atlas |
| Club Car | `[tigon_finance_clubcar]` | TIGON Finance — Club Car |
| E-Z-GO | `[tigon_finance_ezgo]` | TIGON Finance — E-Z-GO |
| Swift EV | `[tigon_finance_swiftev]` | TIGON Finance — Swift EV |
| Used | `[tigon_finance_used]` | TIGON Finance — Used |

A generic (unbranded) widget is also available:

- Shortcode: `[tigon_finance_calculator]`
- Elementor: **TIGON Finance Calculator**

### Shortcode Attributes

All shortcodes accept the same optional attributes:

| Attribute | Default | Description |
|-----------|---------|-------------|
| `price` | *(WooCommerce product price)* | Override the auto-detected product price |
| `label` | `Apply for Financing` | CTA button text |
| `url` | `https://tigongolfcarts.com/apply-for-financing` | CTA button link |

## Installation

1. Upload the `tigon-finance-calculator` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Ensure WooCommerce is installed and active.
4. Use any shortcode or Elementor widget on product pages.

## License

Proprietary. All rights reserved. © TIGON Golf Carts.

## Developer

**Noah Jaslow** © Jaslow Digital — [jaslowdigital.com](https://jaslowdigital.com)
PH: 215-789-1955
