require([
    'jquery',
    'domReady!',
    'select2'
], function ($) {
    function initSelect2() {
        var $input = $('input[name="product[bv24_file_id]"]');
                    alert($input );

        if ($input.length && !$input.data('select2-initialized')) {
            alert('Element!');
            // ... Select2-Initialisierung wie gehabt ...
            var values = $input.val() ? $input.val().split(',') : [];
            var $select = $('<select multiple="multiple" style="width:100%"></select>').attr('name', $input.attr('name') + '_select2');
            values.forEach(function (val) {
                var parts = val.split(':');
                if (parts.length === 2) {
                    $select.append('<option selected value="' + parts[0] + ':' + parts[1] + '">' + parts[1] + ' (' + parts[0] + ')</option>');
                }
            });
            $input.after($select).hide();
            $select.select2({
                ajax: {
                    url: '/admin_u98ww1t/bv24tools/file/autocomplete',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { query: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return { id: item.value + ':' + item.label, text: item.label + ' (' + item.value + ')' };
                            })
                        };
                    },
                    cache: true
                },
                tags: false,
                tokenSeparators: [',']
            });
            $select.on('change', function () {
                var vals = $(this).val();
                $input.val(vals ? vals.join(',') : '');
            });
            $input.data('select2-initialized', true);
        }
    }

    // Prüfe alle 500ms, ob das Feld da ist
    var interval = setInterval(function () {
        initSelect2();
        if ($('input[name="product[bv24_file_id]"]').data('select2-initialized')) {
            clearInterval(interval);
        }
    }, 500);
});