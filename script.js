$(function () {

    $("input[type=radio],input[type=checkbox]").checkboxradio({
        icon: false
    });

    $('button').button();

    var reset = function (inited = false) {
        $('input[type=checkbox],input[type=radio]').each(function (i, v) {
            if ($(v).attr('name') != 'members' || !inited) {
                $(v).get(0).checked = '';
                $(v).next('label').removeClass('ui-state-active');
            }
        });
        $('#data input').val('');
    };
    reset();

    var members = 0;

    $('#party input').click(function () {
        if ($(this).val() == 'n') {
            $('#vocation').fadeOut();
            $('#data').fadeOut();
            $('#type').fadeOut();
            $('#calc').fadeOut();
            $('#member').slideDown();
        } else if (members == 0) {
            $('#member').fadeOut();
            $('#vocation').slideDown();
        } else {
            $('#member').fadeOut();
            $('#type').fadeOut();
            $('#data').fadeOut();
            $('#calc').fadeOut();
            $('#result').fadeOut().html('');
            $('#vocation').slideDown();
            reset(true);
        }
        members = $(this).attr('id').substring(1);
        if (members == 4)
            $('#vocation input').click();
    });

    $('#vocation input').click(function () {
        var selected = 0;
        $('#vocation input').each(function (i, v) {
            if ($(v).get(0).checked)
                selected++;
        });
        if (selected > members) {
            $(this).next('label').removeClass('ui-state-focus').removeClass('ui-visual-focus');
            return false;
        }
        if (selected == members)
            $('#type').slideDown();
    });

    $('#type input').change(function () {
        $('#data,#calc').fadeOut('fast', function () {
            $('#data h2').html($('#simple').get(0).checked ? 'Supplies (valores positivos)' : 'Balance (valores positivou ou negativos)');
            $('#data input').val('');

            $('#vocation input').each(function (i, v) {
                if (!$(v).get(0).checked)
                    $('.' + $(v).attr('id')).hide();
                else
                    $('.' + $(v).attr('id')).show();
            });

            if ($('#advanced').get(0).checked)
                $('.loot').hide();
            else
                $('.loot').show();

            $('#data,#calc').slideDown('fast', function () {
                $([document.documentElement, document.body]).animate({
                    scrollTop: $('#type').offset().top
                }, 500);
            });
        });
    });

    $('input[type=number],input[type=text]').keypress(function (e) {
        var number = parseInt(e.key);
        if (isNaN(number) && e.key != '-' && e.key != '+')
            return false;
    });

    $(document).on("change", '.nomen', function() {
       nome = $(this).val();
       $(this).parent().next().attr('title', nome);
    });

    $(document).on("click", '.docalc', function () {

        var valid = true;

        $('#result').html('');
        
        inputs = $(this).hasClass('n') ? 'input.datan' : '#data .data input';
        
        $(inputs).each(function (i, v) {
            if ($(v).is(":visible"))
                if ($(v).val() == '') {
                    $('#result').attr('title', 'Ops...');
                    label = $(v).attr('title') ? $(v).attr('title') : $(v).attr('name').toUpperCase()
                    $('#result').append('<h4>Faltou preencher o valor para ' + label + '.</h4>');
                    $('#result').dialog({modal: true, width: '50%'});
                    valid = false;
                }
        });

        if (!valid)
            return false;

        var payment = {waste: 0, pay: {}, payto: {}, sentences: []};
        
        inputs = $(this).hasClass('n') ? 'input.datan' : '#data .data input';

        $(inputs).each(function (i, v) {
            if ($(v).val())
                payment['waste'] += parseInt($(v).val());
        });

        payment['individualbalance'] = 0;
        if ($('#simple').get(0).checked) {
            payment['loot'] = parseInt($('#loot').val());
            payment['balance'] = payment.loot - payment.waste;

        } else
            payment['balance'] = payment.waste;

        if (payment.balance != 0)
            payment['individualbalance'] = payment.balance / parseInt(members);

        $(inputs).each(function (i, v) {
            if ($(v).val()) {
                label = $(v).attr('title') ? $(v).attr('title') : $(v).attr('name');
                if ($('#simple').get(0).checked)
                    payment.pay[label] = parseInt($(v).val()) + payment.individualbalance;
                else {
                    var balance = parseInt($(v).val());
                    payment.pay[label] = payment.individualbalance - parseInt($(v).val());
                }
            }
        });

        $.each(payment.pay, function (i, v) {
            if (v < 0)
                payment.payto[i] = v;
        });

        $.each(payment.pay, function (i, v) {
            if (v > 0) {
                $.each(payment.payto, function (j, u) {
                    if (v > 0 && u != 0) {
                        if ((-1 * u) > v) {
                            payment.sentences.push(j.toUpperCase() + ' deve pagar ' + Math.round(v) + ' para ' + i.toUpperCase() + '.');
                            payment.payto[j] = u + v;
                            v = 0;
                        } else {
                            payment.sentences.push(j.toUpperCase() + ' deve pagar ' + Math.round(-1 * u) + ' para ' + i.toUpperCase() + '.');
                            payment.payto[j] = 0;
                            v = v + u;
                        }
                    }
                });
            }
        });

        var html = '';
        html += '<br><p>O ' + (payment.balance >= 0 ? 'LUCRO' : 'PREJUÍZO') + ' da hunt foi de ' + Math.round(payment.balance) + '.</p>';
        html += '<p>O ' + (payment.individualbalance >= 0 ? 'LUCRO' : 'PREJUÍZO') + ' individual foi de ' + Math.round(payment.individualbalance) + '.</p>';
        html += '<h3>' + ($('#simple').get(0).checked ? 'Cada membro da PT deve receber o seguinte:' : 'Os seguintes pagamentos devem ser realizados:') + '</h3><ul>';

        if ($('#simple').get(0).checked) {
            $.each(payment.pay, function (i, v) {
                html += '<li>' + i.toUpperCase() + ': ' + v + '</li>';
            });
        } else {
            $.each(payment.sentences, function (i, v) {
                html += '<li>' + v + '</li>';
            });
        }

        html += '</ul>';
        html += '<a href="https://www.twitch.tv/rodsrufo/" target="blank">Gostou? Por favor, siga na twitch.tv!</a><br>';

        $('#result').attr('title', 'Prontinho xD');
        $('#result').html(html);
        $('#result').dialog({modal: true, width: '50%'});
    });

    $('#n').change(function () {
        members = $(this).val();
        if (members == 0) {
            $('#datan').html('');
        } else {
            html = '';

            for (i = 1; i <= members; i++)
                html += '<div class="data"><label for="data' + i + '">Nome ' + i + ':<input type="text" class="nomen" name="nome' + i + '" id="nome' + i + '"></label><input type="text" class="datan" title="Nome ' + i + '" name="data' + i + '" id="data' + i + '" placeholder="balance..."></div>';

            html += '<div class="field"><button id="docalcn" class="n docalc">Calcular</button></div>';
            $('#datan').html(html);
            $('#nome1').focus();
            $('button').button();
        }
    });

});













