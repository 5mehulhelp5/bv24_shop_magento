require([
    'jquery',
    'jquery/ui'
], function($){
    $(document).on('focus', 'input[name="product[bv24_file_id]"]', function() {
        if ($(this).data('autocomplete-initialized')) return;
        var $input = $(this);
        var selected = [];

        $input.autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/admin_u98ww1t/bv24tools/file/autocomplete',
                    dataType: 'json',
                    data: { query: request.term },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.label + ' (' + item.value + ')',
                                value: item.value,
                                name: item.label
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                // Füge das ausgewählte Dokument zur Liste hinzu
                selected.push(ui.item.value + ':' + ui.item.name);
                // Schreibe alle ausgewählten Dokumente kommasepariert ins Feld
                $input.val(selected.join(', '));
                // Verhindere, dass der Wert überschrieben wird
                return false;
            }
        });

        $input.data('autocomplete-initialized', true);
    });
});