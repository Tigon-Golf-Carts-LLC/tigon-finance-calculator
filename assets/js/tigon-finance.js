/**
 * TIGON Financing Calculator – Tab switching & live price calculation.
 * © TIGON Golf Carts – All rights reserved.
 */
(function () {
    'use strict';

    // Finance constants.
    var LOWEST_MONTHS   = 60;
    var LOWEST_APR      = 7.99;
    var BEST_MONTHS     = 36;
    var BEST_FEE_DEFAULT = 5.25;

    function init() {
        var boxes = document.querySelectorAll('.tigon-finance-box');
        if (!boxes.length) return;

        boxes.forEach(function (box) {
            var tabs   = box.querySelectorAll('.tigon-finance-tab');
            var panels = box.querySelectorAll('.tigon-finance-panel');

            // Tab switching – prevent the tab click from following the outer link.
            tabs.forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var tabId = this.getAttribute('data-tab');

                    tabs.forEach(function (t) { t.classList.remove('active'); });
                    panels.forEach(function (p) { p.classList.remove('active'); });

                    this.classList.add('active');
                    var target = box.querySelector('.tigon-finance-panel[data-tab="' + tabId + '"]');
                    if (target) target.classList.add('active');
                });
            });

            // Live-update when WooCommerce variations change the price.
            observePriceChanges(box);
        });
    }

    /**
     * Watch for WooCommerce variable product price changes and recalculate.
     */
    function observePriceChanges(box) {
        if (typeof jQuery !== 'undefined') {
            jQuery(document).on('found_variation', function (event, variation) {
                if (variation && variation.display_price) {
                    recalculate(box, variation.display_price);
                }
            });

            jQuery(document).on('reset_data', function () {
                var original = parseFloat(box.getAttribute('data-price'));
                if (original) recalculate(box, original);
            });
        }
    }

    /**
     * Calculate monthly payment using standard amortization formula.
     */
    function calcAmortized(principal, annualRate, months) {
        var r = (annualRate / 100) / 12;
        var n = months;
        return (principal * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
    }

    /**
     * Recalculate displayed monthly payments for a new price.
     */
    function recalculate(box, price) {
        price = parseFloat(price);
        if (!price || price <= 0) return;

        box.setAttribute('data-price', price);

        var currency = box.querySelector('.tigon-finance-currency');
        var symbol   = currency ? currency.textContent : '$';

        // LOWEST PAYMENT panel: 60 months @ 7.99% APR.
        var lowestPanel = box.querySelector('.tigon-finance-panel[data-tab="lowest"]');
        if (lowestPanel) {
            var lowestPayment = calcAmortized(price, LOWEST_APR, LOWEST_MONTHS);
            var lowestTotal   = lowestPayment * LOWEST_MONTHS;

            var lowestValue   = lowestPanel.querySelector('.tigon-finance-value');
            var lowestDetails = lowestPanel.querySelector('.tigon-finance-details');

            if (lowestValue)   lowestValue.textContent = numberFormat(lowestPayment.toFixed(2));
            if (lowestDetails) lowestDetails.textContent = 'for ' + LOWEST_MONTHS + ' months \u2022 ' + LOWEST_APR + '% APR \u2022 ' + symbol + numberFormat(lowestTotal.toFixed(2)) + ' total';
        }

        // BEST DEAL panel: 36 months, 0% APR + fee (per-widget override via data-best-fee).
        var bestPanel = box.querySelector('.tigon-finance-panel[data-tab="best"]');
        if (bestPanel) {
            var bestFeePct  = parseFloat(box.getAttribute('data-best-fee')) || BEST_FEE_DEFAULT;
            var bestTotal   = price * (1 + bestFeePct / 100);
            var bestPayment = bestTotal / BEST_MONTHS;

            var bestValue   = bestPanel.querySelector('.tigon-finance-value');
            var bestDetails = bestPanel.querySelector('.tigon-finance-details');

            if (bestValue)   bestValue.textContent = numberFormat(bestPayment.toFixed(2));
            if (bestDetails) bestDetails.textContent = 'for ' + BEST_MONTHS + ' months \u2022 0% APR + ' + bestFeePct + '% fee \u2022 ' + symbol + numberFormat(bestTotal.toFixed(2)) + ' total';
        }
    }

    /**
     * Simple number formatter with commas.
     */
    function numberFormat(n) {
        var parts = n.toString().split('.');
        parts[0]  = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return parts.join('.');
    }

    // Boot up.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
