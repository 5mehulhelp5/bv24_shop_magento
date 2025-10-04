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

            var self = this;

            // WICHTIG: Entferne ALLE blur Event Handler die von den Original-Dateien hinzugefügt wurden
            this.element.off('blur');

            // Füge eigenen blur Handler hinzu
            this.element.on('blur', $.proxy(function () {
                this.element.on('blur', $.proxy(function () {
                if (!this.searchLabel.hasClass('active')) {
                    return;
                }

                setTimeout($.proxy(function () {
                    if (this.autoComplete.is(':hidden')) {
                        this.setActiveState(false);
                    } else {
                        this.element.trigger('focus');
                    }
                    //this.autoComplete.hide();
                    this._updateAriaHasPopup(false);
                }, this), 250);
            }, this));
            }, this));

            // Click außerhalb von Suchfeld und Autocomplete erkennen
            var touchStartY = 0;
            var touchMoved = false;

            $(document).on('touchstart.searchclose', function(e) {
                touchStartY = e.touches[0].clientY;
                touchMoved = false;
            });

            $(document).on('touchmove.searchclose', function(e) {
                if (Math.abs(e.touches[0].clientY - touchStartY) > 10) {
                    touchMoved = true;
                }
            });

            $(document).on('click.searchclose touchend.searchclose', function(e) {
                // Bei touchend: Nur schließen wenn NICHT gescrollt wurde
                if (e.type === 'touchend' && touchMoved) {
                    return;
                }

                var $target = $(e.target);
                var isSearchField = $target.closest(self.element).length > 0;
                var isAutocomplete = $target.closest(self.autoComplete).length > 0;
                var isSearchForm = $target.closest(self.searchForm).length > 0;

                if (!isSearchField && !isAutocomplete && !isSearchForm) {
                setTimeout($.proxy(function () {
                    self.autoComplete.hide();
                    self._updateAriaHasPopup(false);
                    self.setActiveState(false);
                }, this), 250);

                }
            });

            // Add mutation observer to watch for autocomplete changes
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

        return target;
    };
});