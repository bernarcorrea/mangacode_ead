$(document).ready(function () {
    //MENU MOBILE SLIDE
    $('.j_menu_anchor').on('click touchstart', function (e) {
        $('html').toggleClass('menu-active');
        e.preventDefault();
        var title = $('.nav-menu-fix nav ul li .title');

        if (title.is(":hidden")) {
            setTimeout(function () {
                title.fadeIn();
            }, 400);
        } else {
            title.hide();
        }
    });

    // EFFECT COUNT NUMBERS
    $('.j_count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // CUSTOM TOOLTIP
    Tipped.create('.j_tooltip',
        {
            size: 'large',
        }
    );

    // FECHA JANELAS DE ERRO NO SISTEMA
    $('.trigger-close').click(function () {
        $('.trigger').slideUp(300);
    });

    // GESTÃO DE JANELA MODAL
    $('.btn_modal').click(function () {
        var modal = $(this).attr('rel');

        $('.mask_modal').fadeIn();
        $('.form_load').fadeIn().delay(400).fadeOut(100, function () {
            $('.content-modal').fadeIn();
            $('#' + modal).fadeIn();
        });
    });

    $('.close_modal').click(function () {
        $('.mask_modal').fadeOut(300);
        $('.content-modal').fadeOut(300);
    });

    // GESTÃO DE JANELA MODAL
    $('.btn_modal').click(function () {
        $('.form_load').fadeIn(300).delay(400).fadeOut(100, function () {
            $('.mask_modal').fadeIn(200);
            $('.content-modal').fadeIn(200);
        });
    });

    $('.close_modal').click(function () {
        $('.mask_modal').fadeOut(300);
        $('.content-modal').fadeOut(300);
    });

    $('.tiny_imageupload .close').click(function () {
        $('.mask_modal').fadeOut(300);
        $('.tiny_imageupload').fadeOut(300);
    });

    $('.nav-tab ul li a').click(function (event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tabs").not(tab).css("display", "none");
        $(tab).fadeIn();
    });

    $('.j_change1').change(function () {
        var callback = $(this).attr('id');
        var Change1 = $('.j_change1');
        var Change2 = $('.j_change2');

        Change1.attr('disabled', 'true');
        Change2.attr('disabled', 'true');

        Change2.html('<option value="">Carregando...</option>');

        $.post('_ajax/ajax' + callback + '.php', {id: $(this).val()}, function (data) {
            Change2.html(data).removeAttr('disabled');
            Change1.removeAttr('disabled');
        });
    });

    //GET CEP
    $('.sg_getCep').keyup(function () {
        var cep = $(this).val().replace('-', '').replace('.', '').replace('_', '');

        if (cep.length === 8) {
            $.get("https://viacep.com.br/ws/" + cep + "/json", function (data) {
                if (!data.erro) {
                    $('.sg_bairro').val(data.bairro);
                    $('.sg_complemento').val(data.complemento);
                    $('.sg_localidade').val(data.localidade);
                    $('.sg_logradouro').val(data.logradouro);
                    $('.sg_uf').val(data.uf);
                } else {
                    $('.trigger-box').html('<div class="trigger-modal"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error">Não foi possível encontrar o endereço através do CEP informado. Por favor, <b>insira seu endereço manualmente.</b></div></div>');
                    $('.trigger-modal').fadeIn();

                    $('.trigger-modal .close-modal').click(function () {
                        $('.trigger-modal').fadeOut();
                    });

                    $('.sg_logradouro').removeClass('box-silver2').attr('readonly', false);
                    $('.sg_bairro').removeClass('box-silver2').attr('readonly', false);
                    $('.sg_localidade').removeClass('box-silver2').attr('readonly', false);
                    $('.sg_uf').removeClass('box-silver2').attr('readonly', false);
                }
            }, 'json');
        }
    });

    /********************
     ADD INSTALLTMENT
     ***************** */
    $('.type_contract').change(function () {
        var val = $(this).val();

        if (val == 1) {
            $('#installment').fadeIn();
            $('.j_val_install').prop('disabled', false);
        } else {
            $('#installment').fadeOut();
            $('.j_val_install').prop('disabled', true);
        }
    });

    /********************
     ADD INSTALLTMENT
     ***************** */
    $('.add_installment').click(function () {
        var input = "<div class='j_installment'><label class=\"box box100 box-form\"><input type=\"text\" name=\"invoice_price[]\" required class=\"form input-form-medio formVal j_val_install\" placeholder=\"R$\"><a class=\"btn btn-icon-larg btn-red round float_r f-white close_installment\" style='margin-top: 10px;'><i class=\"icon-minus1\"></i></a></label></div>";
        var box = $('.j_box_installment');
        box.append(input);

        $(".formVal").maskMoney({
            prefix: "R$ ",
            decimal: ",",
            thousands: "."
        });

        // CLOSE INSTALLMENT
        $('.j_installment').on('click', '.close_installment', function () {
            $(this).parent().fadeOut(function () {
                $(this).remove();
            });
        });

        // CÁLCULO VALOR PARCELA/TOTAL
        $('.j_val_install').keyup(function () {
            var total = 0;
            $('.j_val_install').each(function () {
                var valor = number_format($(this).val());
                valor = Number(valor);
                if (!isNaN(valor)) total += valor;
            });
            $('.j_val_total').val('R$ ' + number_format_real(total, '2', ',', '.'));
        });
    });

    // CLOSE INSTALLMENT
    $('.j_installment').on('click', '.close_installment', function () {
        $(this).parent().fadeOut(function () {
            $(this).remove();
        });
    });
    /********************
     END ADD INSTALLTMENT
     ***************** */


});

// CONFIRMATION SYSTEM
function Confirmation(action) {
    if (action == 'delete') {
        if (!confirm("Você tem certeza que deseja deletar este item?")) {
            return false;
        }
        return true;
    } else {
        if (!confirm("Você tem certeza que deseja realizar esta ação?")) {
            return false;
        }
        return true;
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result).width('100%').height();
            $('.j_cover').hide();
        };

        reader.readAsDataURL(input.files[0]);
        $('#blah').fadeIn();
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah2').attr('src', e.target.result).width('100%').height();
            $('.j_cover2').hide();
        };

        reader.readAsDataURL(input.files[0]);
        $('#blah2').fadeIn();
    }
}

function readMediaTinyMCE(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image_up').attr('src', e.target.result).width('100%').height();
            $('.tiny_imageupload .image_up .image_default').hide();
        };
        reader.readAsDataURL(input.files[0]);
        $('#image_up').fadeIn();
    }
}

function number_format(Number) {
    Number = (Number).replace('R$ ', '');
    Number = (Number).replace('.', '');
    Number = (Number).replace(',', '.');

    return Number;
}

function number_format_real(numero, decimal, decimal_separador, milhar_separador) {
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
        prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
        sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
        dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// INICIA SHADOWBOX
Shadowbox.init();
