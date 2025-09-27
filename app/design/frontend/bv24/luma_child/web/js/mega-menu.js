define([
    'jquery',
    'underscore'
], function ($, _) {
    'use strict';

    return function(config, element) {
        var $element = $(element);
        var $megaMenu = $element.find('.mega-navigation');
        var closeTimer;

        // Enhanced hover functionality with delay
        $megaMenu.find('.level0.parent').each(function() {
            var $menuItem = $(this);
            var $dropdown = $menuItem.find('.mega-menu-dropdown');

            $menuItem.on('mouseenter', function() {
                clearTimeout(closeTimer);

                // Close other open dropdowns
                $megaMenu.find('.mega-menu-dropdown').not($dropdown).removeClass('show');

                // Show current dropdown
                setTimeout(function() {
                    $dropdown.addClass('show');
                }, 50);
            });

            $menuItem.on('mouseleave', function() {
                closeTimer = setTimeout(function() {
                    $dropdown.removeClass('show');
                }, 300);
            });

            // Keep dropdown open when hovering over it
            $dropdown.on('mouseenter', function() {
                clearTimeout(closeTimer);
            });

            $dropdown.on('mouseleave', function() {
                closeTimer = setTimeout(function() {
                    $dropdown.removeClass('show');
                }, 300);
            });
        });

        // Close all dropdowns when clicking outside
        $(document).on('click', function(e) {
            if (!$megaMenu.is(e.target) && $megaMenu.has(e.target).length === 0) {
                $megaMenu.find('.mega-menu-dropdown').removeClass('show');
            }
        });

        // Keyboard navigation support
        $megaMenu.find('.level-top').on('keydown', function(e) {
            var $this = $(this);
            var $menuItems = $megaMenu.find('.level-top');
            var currentIndex = $menuItems.index($this);

            switch(e.which) {
                case 37: // Left arrow
                    e.preventDefault();
                    if (currentIndex > 0) {
                        $menuItems.eq(currentIndex - 1).focus();
                    }
                    break;
                case 39: // Right arrow
                    e.preventDefault();
                    if (currentIndex < $menuItems.length - 1) {
                        $menuItems.eq(currentIndex + 1).focus();
                    }
                    break;
                case 40: // Down arrow
                    e.preventDefault();
                    var $dropdown = $this.siblings('.mega-menu-dropdown');
                    if ($dropdown.length) {
                        $dropdown.addClass('show');
                        $dropdown.find('a').first().focus();
                    }
                    break;
                case 27: // Escape
                    e.preventDefault();
                    $megaMenu.find('.mega-menu-dropdown').removeClass('show');
                    $this.blur();
                    break;
            }
        });

        // Add show class styles to CSS
        var style = document.createElement('style');
        style.textContent = `
            .mega-menu-dropdown.show {
                opacity: 1 !important;
                visibility: visible !important;
                transform: translateY(0) !important;
            }
        `;
        document.head.appendChild(style);
    };
});