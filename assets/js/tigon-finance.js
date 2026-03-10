/**
 * TIGON Financing Calculator – Tab switching & live price calculation.
 * © TIGON Golf Carts – All rights reserved.
 */
(function () {
    'use strict';

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

                    var months = this.getAttribute('data-months');

                    // Deactivate all tabs & panels.
                    tabs.forEach(function (t) { t.classList.remove('active'); });
                    panels.forEach(function (p) { p.classList.remove('active'); });

                    // Activate clicked tab & matching panel.
                    this.classList.add('active');
                    var target = box.querySelector('.tigon-finance-panel[data-months="' + months + '"]');
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
     * Recalculate displayed monthly payments for a new price.
     */
    function recalculate(box, price) {
        price = parseFloat(price);
        if (!price || price <= 0) return;

        box.setAttribute('data-price', price);

        var terms    = [60, 48, 36];
        var currency = box.querySelector('.tigon-finance-currency');
        var symbol   = currency ? currency.textContent : '$';

        terms.forEach(function (months) {
            var panel = box.querySelector('.tigon-finance-panel[data-months="' + months + '"]');
            if (!panel) return;

            var monthly = (price / months).toFixed(2);

            var valueEl   = panel.querySelector('.tigon-finance-value');
            var detailsEl = panel.querySelector('.tigon-finance-details');

            if (valueEl)   valueEl.textContent = numberFormat(monthly);
            if (detailsEl) detailsEl.textContent = 'for ' + months + ' months \u2022 0% APR \u2022 ' + symbol + numberFormat(price.toFixed(2)) + ' total';
        });
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
