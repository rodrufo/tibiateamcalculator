folder = '/home/rodolfo/.local/share/CipSoft GmbH/Tibia/packages/Tibia/screenshots/';

$(function () {
    selection = {
        char: '',
        date: ''
    };

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
        return false;
    }

    function showPrints(evt) {
        selection.date = $(this).val();
        $('#prints').html('<h3>Clique para aumentar/fechar uma print:</h3>');

        prints = [];
        files = $('#files').get(0).files;

        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            file = f.name.split('_');
            if (file[2] === selection.char && file[0] === selection.date) {
                var reader = new FileReader();
                reader.onload = (function (theFile) {
                    return function (e) {
                        printType = theFile.name.split('_')[3].split('.')[0];
                        hour = theFile.name.split('_')[1].substring(0,2) + ':' + theFile.name.split('_')[1].substring(2,4);
                        print = '<div class="print">';
                        print += ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
                        print += '<span class="legend">' + printType + ' às ' + hour + '</span>';
                        print += '</print>';
                        $('#prints').append(print);
                    };
                })(f);
                reader.onloadstart = function (event) {
                    $('#prints').append('<img src="/src/images/loading.gif" id="loading">');
                };
                reader.onloadend = function (event) {
                    $('#loading').remove();
                };
                reader.readAsDataURL(f);
            }
        }
    }

    function showDates(evt) {
        selection.char = $(this).html();
        $('#dates').html('');
        $('#prints').html('');
        $('#dates').append('<img src="/src/images/loading.gif" id="loading">');

        html = '<h3>Escolha uma data:</h3>';
        dates = [];
        files = $('#files').get(0).files;
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            file = f.name.split('_');
            if (file[2] === selection.char && !inArray(file[0], dates))
                dates.push(file[0]);
        }
        dates.sort((a, b) => {
            if (a > b)
                return -1;
            if (a < b)
                return 1;
            return 0;
        });
        
        html += '<select name="dates" id="dates">';
        html += '<option value=""></option>';

        for (i = 0; i < dates.length; i++) {
            dataBr = dates[i].substring(8, 10) + '/' + dates[i].substring(5, 7) + '/' + dates[i].substring(0, 4);
            html += '<option value="' + dates[i] + '">' + dataBr + '</option>';
        }
        html += '</select>';
        
        $('#dates').html(html);
        $('#loading').remove();
    }

    function showChars(evt) {
        $('#chars').html('<h3>Escolha um Character:</h3>');
        $('#chars').append('<img src="/src/images/loading.gif" id="loading">');
        $('#dates').html('');
        $('#prints').html('');
        var chars = [];
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            charName = f.name.split('_')[2];
            if (charName && !inArray(charName, chars)) {
                html = '<a href="#" class="char">' + charName + '</a>';
                $('#chars').append(html);
                chars.push(charName);
            }
        }
        $('#loading').remove();
    }

    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb" src="', e.target.result,
                        '" title="', escape(theFile.name), '"/>'].join('');
                    document.getElementById('list').insertBefore(span, null);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }
    
    function viewPrint(e) {
        print = '<img class="viewPrint" src="' + $(this).attr('src') + '">';
        $('body').prepend(print);
    }

    $('body').on("click", ".viewPrint", function(){$(this).remove()});
    $('body').on("click", ".thumb", viewPrint);
    $('body').on("click", ".char", showDates);
    $('body').on("change", "select#dates", showPrints);
    document.getElementById('files').addEventListener('change', showChars, false);

});