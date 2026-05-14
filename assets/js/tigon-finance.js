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
            if (box.classList.contains('tigon-finance-user')) {
                initUserBox(box);
                return;
            }

            var tabs   = box.querySelectorAll('.tigon-finance-tab');
            var panels = box.querySelectorAll('.tigon-finance-panel');

            // Tab switching.
            tabs.forEach(function (tab) {
                tab.addEventListener('click', function (e) {
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
     * Run any initial setup that's box-local for the user calculator.
     * All actual event wiring is done globally via delegation (see below)
     * so dynamically rendered widgets (Elementor editor preview, AJAX, etc.)
     * still work without re-binding.
     */
    function initUserBox(box) {
        // Set initial state from current input values.
        recalcFromBox(box);
    }

    /**
     * Read the current input + select values out of a user box and recalc.
     */
    function recalcFromBox(box) {
        var priceInput = box.querySelector('.tigon-finance-user-price');
        var termSelect = box.querySelector('.tigon-finance-user-term');
        if (!priceInput || !termSelect) return;

        var price = parseFloat(priceInput.value);
        var term  = parseInt(termSelect.value, 10);
        recalcUser(box, price, term);
    }

    /**
     * Recalculate both user panels (financing + 0% financing).
     */
    function recalcUser(box, price, term) {
        var apr = parseFloat(box.getAttribute('data-annual-rate'));
        if (isNaN(apr)) apr = 7.99;

        var feePct = parseFloat(box.getAttribute('data-best-fee'));
        if (isNaN(feePct)) feePct = 5.25;

        if (!isNaN(term) && term > 0) {
            box.setAttribute('data-term', term);
        } else {
            term = parseInt(box.getAttribute('data-term'), 10) || 60;
        }

        var termLabels = box.querySelectorAll('.tigon-finance-user-term-label');
        termLabels.forEach(function (el) { el.textContent = term; });

        var normalValue = box.querySelector('.tigon-finance-panel[data-tab="normal"] .tigon-finance-value');
        var zeroValue   = box.querySelector('.tigon-finance-panel[data-tab="zero"] .tigon-finance-value');

        if (!price || price <= 0 || isNaN(price)) {
            if (normalValue) normalValue.textContent = '0.00';
            if (zeroValue)   zeroValue.textContent   = '0.00';
            box.setAttribute('data-price', '');
            return;
        }

        box.setAttribute('data-price', price);

        var normalPayment = calcAmortized(price, apr, term);
        var zeroPayment   = (price * (1 + feePct / 100)) / term;

        if (normalValue) normalValue.textContent = numberFormat(normalPayment.toFixed(2));
        if (zeroValue)   zeroValue.textContent   = numberFormat(zeroPayment.toFixed(2));
    }

    /**
     * Global delegated handlers so the user calculator works no matter when
     * its DOM appears (initial render, Elementor preview, AJAX swap, etc).
     */
    function bindDelegatedHandlers() {
        document.addEventListener('input', function (e) {
            var target = e.target;
            if (!target || !target.classList) return;
            if (target.classList.contains('tigon-finance-user-price')) {
                var box = target.closest('.tigon-finance-box.tigon-finance-user');
                if (box) recalcFromBox(box);
            }
        });

        document.addEventListener('change', function (e) {
            var target = e.target;
            if (!target || !target.classList) return;
            if (target.classList.contains('tigon-finance-user-term') ||
                target.classList.contains('tigon-finance-user-price')) {
                var box = target.closest('.tigon-finance-box.tigon-finance-user');
                if (box) recalcFromBox(box);
            }
        });

        document.addEventListener('click', function (e) {
            var target = e.target;
            if (!target || !target.closest) return;

            var calcBtn = target.closest('.tigon-finance-calculate');
            if (calcBtn) {
                e.preventDefault();
                var userBox = calcBtn.closest('.tigon-finance-box.tigon-finance-user');
                if (userBox) recalcFromBox(userBox);
                return;
            }

            var tab = target.closest('.tigon-finance-tab');
            if (tab) {
                var tabBox = tab.closest('.tigon-finance-box');
                if (!tabBox) return;
                var tabId = tab.getAttribute('data-tab');
                tabBox.querySelectorAll('.tigon-finance-tab').forEach(function (t) { t.classList.remove('active'); });
                tabBox.querySelectorAll('.tigon-finance-panel').forEach(function (p) { p.classList.remove('active'); });
                tab.classList.add('active');
                var panel = tabBox.querySelector('.tigon-finance-panel[data-tab="' + tabId + '"]');
                if (panel) panel.classList.add('active');
            }
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
            if (lowestDetails) lowestDetails.textContent = 'for ' + LOWEST_MONTHS + ' months';
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
            if (bestDetails) bestDetails.textContent = 'for ' + BEST_MONTHS + ' months \u2022 0% APR';
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
    bindDelegatedHandlers();

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
