folder = '/home/rodolfo/.local/share/CipSoft GmbH/Tibia/packages/Tibia/screenshots/';

$(function () {
    selection = {
        char: '',
        filter: '',
        printId: []
    };

//    function getIdPrev(id) {
//        idprev = null;
//        selection.printId.sort();
//        for (i = 0; i <= selection.printId.length; i++) {
//            if (id === selection.printId[i])
//                return idprev;
//            else
//                idprev = selection.printId[i];
//        }
//    }

    function ordenaJson(lista, chave, ordem) {
        return lista.sort(function (a, b) {
            var x = a[chave];
            var y = b[chave];
            if (ordem === 'ASC') {
                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            }
            if (ordem === 'DESC') {
                return ((x > y) ? -1 : ((x < y) ? 1 : 0));
            }
        });
    }

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle)
                return true;
        }
        return false;
    }

    function orderPrints(evt) {
        order = $(this).val();
        $('#order').after('<img src="/src/images/loading.gif" id="loading">');

        if (order) {
            $(this).addClass('highlight');

            prints = [];

            $('#prints div.print').each(function (i, e) {
                prints.push({id: $(e).attr('id'), html: e});
            });

            ordenaJson(prints, 'id', order);

            $('#prints div.print').remove();
            
            for (j = 0; j < prints.length; j++)
                $('#prints').append(prints[j]['html']);
            
            $('#loading').remove();
            
        } else
            $(this).removeClass('highlight');

    }

    function showPrints(evt) {
        selection.filter = $(this).val();
        filter = $(this).attr('id');
        if (filter === 'dates') {
            $('select#dates').addClass('highlight');
            $('select#types').removeClass('highlight');
            $('select#types').val('');
        } else {
            $('select#dates').removeClass('highlight');
            $('select#types').addClass('highlight');
            $('select#dates').val('');
        }

        $('#prints').html('<h3 id="hPrints">Clique para aumentar/fechar uma print:</h3>' + '<div id="ordenation"><select name="order" id="order"><option value="">Ordernação</option><option value="ASC">Mais antigos</option><option value="DESC">Mais recentes</option></select></div>');

        files = $('#files').get(0).files;

        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
            file = f.name.split('_');
            if (file.length == 4) {
                filterVal = filter === 'dates' ? file[0] : file[3].split('.')[0];
                if (file[2] === selection.char && filterVal === selection.filter) {
                    var reader = new FileReader();
                    reader.onload = (function (theFile) {
                        return function (e) {
                            printType = theFile.name.split('_')[3].split('.')[0];
                            hour = theFile.name.split('_')[1].substring(0, 2) + ':' + theFile.name.split('_')[1].substring(2, 4);
                            key = theFile.name.split('_')[0].replace('-', '').replace('-', '') + theFile.name.split('_')[1];
                            print = '<div class="print" id="' + key + '">';
                            print += ['<img class="thumb" src="', e.target.result,
                                '" title="', escape(theFile.name), '"/>'].join('');
                            if (filter == 'dates')
                                print += '<span class="legend">' + printType + ' às ' + hour + '</span>';
                            else {
                                date = theFile.name.split('_')[0];
                                dataBr = date.substring(8, 10) + '/' + date.substring(5, 7) + '/' + date.substring(0, 4);
                                print += '<span class="legend">' + dataBr + ' às ' + hour + '</span>';
                            }
                            print += '</div>';
                            // selection.printId.push(key);
                            $('#ordenation').after(print);
//                            if (selection.printId.length === 1)
//                            else if ($('#' + getIdPrev(key)).length === 1)
//                                $('#' + getIdPrev(key)).before(print);
//                            else
//                                $('#hPrints').after(print);
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
        //selection.printId = [];
    }

    function showDates(evt) {
        selection.char = $(this).html();
        $('#dates').html('');
        $('#prints').html('');
        $('#dates').append('<img src="/src/images/loading.gif" id="loading">');

        html = '<h3>Escolha um filtro para ' + selection.char + ':</h3>';
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
        html += '<option value="">Data...</option>';

        for (i = 0; i < dates.length; i++) {
            dataBr = dates[i].substring(8, 10) + '/' + dates[i].substring(5, 7) + '/' + dates[i].substring(0, 4);
            html += '<option value="' + dates[i] + '">' + dataBr + '</option>';
        }
        html += '</select>';
        html += '<select name="types" id="types">';
        html += '<option value="">Tipo...</option>';
        html += '<option value="Achievement">Achievement</option>';
        html += '<option value="BestiaryEntryCompleted">BestiaryEntryCompleted</option>';
        html += '<option value="BossDefeated">BossDefeated</option>';
        html += '<option value="DeathPvE">DeathPvE</option>';
        html += '<option value="HighestDamageDealt">HighestDamageDealt</option>';
        html += '<option value="HighestHealingDone">HighestHealingDone</option>';
        html += '<option value="Hotkey">Hotkey</option>';
        html += '<option value="LevelUp">LevelUp</option>';
        html += '<option value="LowHealth">LowHealth</option>';
        html += '<option value="SkillUp">SkillUp</option>';
        html += '<option value="TreasureFound">TreasureFound</option>';
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

    function viewPrint(e) {
        print = '<img class="viewPrint" src="' + $(this).attr('src') + '">';
        $('body').prepend(print);
        $(document).scrollTop(0);
    }

    $('body').on("click", ".viewPrint", function () {
        $(this).remove()
    });
    $('body').on("click", ".thumb", viewPrint);
    $('body').on("click", ".char", showDates);
    $('body').on("change", "select#order", orderPrints);
    $('body').on("change", "select#dates", showPrints);
    $('body').on("change", "select#types", showPrints);
    document.getElementById('files').addEventListener('change', showChars, false);

});