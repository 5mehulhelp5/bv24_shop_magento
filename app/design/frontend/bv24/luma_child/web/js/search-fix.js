define([
    'jquery',
    'underscore'
], function ($, _) {
    'use strict';

    return function (target) {
        console.log('Search Fix Mixin loaded', target);

        // Store the original _blur method
        var originalBlur = target.prototype._blur;

        // Try to hook into _create to add event listeners
        var originalCreate = target.prototype._create;
        target.prototype._create = function() {
            console.log('Create called');
            originalCreate.apply(this, arguments);

            // Add mutation observer to watch for autocomplete changes
            var self = this;
            if (this.autoComplete && this.autoComplete.length) {
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                            setTimeout(function() {
                                self.addShowAllLink();
                            }, 50);
                        }
                    });
                });

                observer.observe(this.autoComplete[0], {
                    childList: true,
                    subtree: true
                });
            }
        };

        // Add method to add "Show All" link
        target.prototype.addShowAllLink = function() {
            if (this.autoComplete && this.autoComplete.is(':visible')) {
                var searchTerm = this.element.val();
                console.log('Adding show all link for term:', searchTerm);

                if (searchTerm && searchTerm.trim().length >= 2) {
                    // Remove existing "show all" link
                    this.autoComplete.find('.show-all-results').remove();

                    // Create and add new "show all" link
                    var showAllLink = $('<div class="show-all-results">Alle Suchergebnisse anzeigen</div>');

                    // Add click handler
                    showAllLink.on('click', $.proxy(function() {
                        this.searchForm.trigger('submit');
                    }, this));

                    // Append to autocomplete
                    this.autoComplete.append(showAllLink);
                    console.log('Show all link added successfully');
                }
            }
        };

        // Override the _blur method
        target.prototype._blur = function() {
            this.element.on('blur', $.proxy(function () {
                if (!this.searchLabel.hasClass('active')) {
                    return;
                }
                // First hide autocomplete immediately
                this.autoComplete.hide();
                this._updateAriaHasPopup(false);

                // Then handle focus removal with short delay
                setTimeout($.proxy(function () {
                    $('#search').trigger('blur');
                    this.setActiveState(false);
                }, this), 100);
            }, this));
        };

        return target;
    };
});