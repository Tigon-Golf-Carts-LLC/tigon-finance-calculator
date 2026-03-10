# TIGON Financing Calculator

The TIGON enterprise WordPress plugin that bridges ZERO Percent Financing Option with WooCommerce — automatically syncing inventory pricing with monthly payments using product data in real time.

## Plugin Details

- **Plugin Name:** TIGON Financing Calculator
- **Version:** 2.0.0
- **Author:** Noah Jaslow & Jaslow Digital
- **Requires:** WordPress 6.0+ · WooCommerce 8.0+ · PHP 8.1+

## Description

TIGON Financing Calculator connects your WooCommerce product catalog with a 0% financing option, displaying real-time monthly payment breakdowns (36, 48, and 60 months) directly on product pages. It works as both a WordPress shortcode (`[tigon_finance-calculator]`) and an Elementor widget.

### Features

- **Real-Time Price Sync** — Automatically pulls WooCommerce product prices and calculates monthly payments.
- **0% APR Financing Display** — Shows customers their monthly cost across 36, 48, and 60-month terms.
- **Shortcode Support** — Use `[tigon_finance-calculator]` anywhere in WordPress with optional `price`, `label`, and `url` attributes.
- **Elementor Widget** — Drag-and-drop TIGON 0% Finance Calculator widget with built-in controls.
- **Custom Price Override** — Optionally set a manual price instead of using the WooCommerce product price.
- **Configurable CTA** — Customize the financing application button text and URL.

## Installation

1. Upload the `tigon-finance-calculator` folder to `/wp-content/plugins/`.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Ensure WooCommerce is installed and active.
4. Use the `[tigon_finance-calculator]` shortcode or the Elementor widget on any product page.

## Shortcode Usage

```
[tigon_finance-calculator]
[tigon_finance-calculator price="12999" label="Get Financing" url="https://example.com/apply"]
```

### Attributes

| Attribute | Default | Description |
|-----------|---------|-------------|
| `price` | *(WooCommerce product price)* | Override the auto-detected product price |
| `label` | `Apply for 0% Financing` | CTA button text |
| `url` | `https://tigongolfcarts.com/apply-for-financing` | CTA button link |

## License

Proprietary. All rights reserved. © TIGON Golf Carts.

## Developer

**Noah Jaslow** © Jaslow Digital — [jaslowdigital.com](https://jaslowdigital.com)
PH: 215-789-1955
