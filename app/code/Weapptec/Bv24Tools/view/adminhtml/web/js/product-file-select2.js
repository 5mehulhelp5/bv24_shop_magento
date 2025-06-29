require([
    'jquery',
    'domReady!'
], function($){
    var $input = $('input[name="product[bv24_file_id]"]');
    if ($input.length) {
        // Ersetze Input durch Select für Select2
        var values = $input.val() ? $input.val().split(',') : [];
        var $select = $('<select multiple="multiple" style="width:100%"></select>').attr('name', $input.attr('name'));
        $input.after($select).hide();

        // Vorbelegte Werte einfügen
        values.forEach(function(val){
            if(val.trim()) {
                $select.append('<option selected value="'+val.trim()+'">'+val.trim()+'</option>');
            }
        });

        $select.select2({
            ajax: {
                url: '/admin_u98ww1t/bv24tools/file/autocomplete',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { query: params.term };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return { id: item.value, text: item.label + ' (' + item.value + ')' };
                        })
                    };
                },
                cache: true
            },
            tags: true,
            tokenSeparators: [',']
        });

        // Beim Absenden Wert ins ursprüngliche Input-Feld schreiben
        $select.on('change', function(){
            var vals = $(this).val();
            $input.val(vals ? vals.join(',') : '');
        });
    }
});