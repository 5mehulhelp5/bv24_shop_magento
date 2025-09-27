define([
    'jquery',
    'Magento_Ui/js/modal/alert'
], function ($, uiAlert) {
    'use strict';

    var mod = {
        init: function () {
            this.bindEvents();
        },

        bindEvents: function () {
            $('body').on('change', '.order-item-status-select', this.updateItemStatus.bind(this));
        },

        updateItemStatus: function (event) {
            var $select    = $(event.target);
            var itemId     = $select.data('item-id');
            var newStatus  = $select.val();
            var self       = this;

            if (!window.txOrderItemStatusUrl) {
                console.error('txOrderItemStatusUrl ist nicht gesetzt.');
                uiAlert({ title: 'Fehler', content: 'Update-URL fehlt. Seite neu laden oder Admin kontaktieren.' });
                return;
            }

            // UI-Feedback während des Requests
            $select.prop('disabled', true).addClass('loading');

            $.ajax({
                url: window.txOrderItemStatusUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    item_id: itemId,
                    status: newStatus,
                    form_key: window.FORM_KEY
                },
                showLoader: true
            })
            .done(function (response) {
                if (response && response.success) {
                    self.showSuccessMessage(response.message || 'Erfolgreich aktualisiert.');
                    // Status-Klasse am Select aktualisieren (für farbliche Hervorhebung)
                    self.updateSelectClass($select, newStatus);
                } else {
                    self.showErrorMessage((response && response.message) || 'Aktualisierung fehlgeschlagen.');
                    // Optional: alten Wert wiederherstellen, wenn Fehler
                    // $select.val($select.data('prev') || '').trigger('change.select2'); // falls select2 o.ä.
                }
            })
            .fail(function () {
                self.showErrorMessage('Es ist ein Fehler beim Aktualisieren aufgetreten.');
            })
            .always(function () {
                $select.prop('disabled', false).removeClass('loading');
            });
        },

        updateSelectClass: function ($select, statusValue) {
            // Entfernt alte status-* Klassen und setzt die neue
            var classes = ($select.attr('class') || '').split(/\s+/);
            classes = classes.filter(function (c) { return c.indexOf('status-') !== 0; });
            classes.push('status-' + statusValue);
            $select.attr('class', classes.join(' '));
        },

        showSuccessMessage: function (message) {
            uiAlert({ title: 'Success', content: message });
        },

        showErrorMessage: function (message) {
            uiAlert({ title: 'Error', content: message });
        }
    };

    return mod;
});
