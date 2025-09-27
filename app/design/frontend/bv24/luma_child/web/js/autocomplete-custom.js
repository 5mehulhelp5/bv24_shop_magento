define([
    'jquery',
    'underscore'
], function ($, _) {
    'use strict';

    return function (originalComponent) {
        return originalComponent.extend({
            /**
             * Reorder autocomplete results
             */
            _sortAutocompleteResults: function (results) {
                // Define the desired order
                var desiredOrder = ['terms', 'categories', 'products'];
                var sortedResults = {};

                // Sort based on desired order
                _.each(desiredOrder, function (type) {
                    if (results[type]) {
                        sortedResults[type] = results[type];
                    }
                });

                // Add any remaining types not in the desired order
                _.each(results, function (data, type) {
                    if (!sortedResults[type]) {
                        sortedResults[type] = data;
                    }
                });

                return sortedResults;
            }
        });
    };
});