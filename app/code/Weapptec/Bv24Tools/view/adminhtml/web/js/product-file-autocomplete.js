require([
    'jquery',
    'jquery/ui'
], function($){
    $(document).on('focus', 'input[name="product[bv24_file_id]"]', function() {
        if ($(this).data('autocomplete-initialized')) return;
        $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/admin_u98ww1t/bv24tools/file/autocomplete',
                    dataType: 'json',
                    data: { query: request.term },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.label,
                                value: item.value
                            };
                        }));
                    }
                });
            },
            minLength: 2
        });
        $(this).data('autocomplete-initialized', true);
    });
});