jQuery(function ($) {
    $(".formVal").maskMoney({
        prefix: "R$ ",
        decimal: ",",
        thousands: "."
    });

    $(".formDate").mask("99/99/9999 99:99:99");
    $(".formFone").mask("(99) 999999999");
    $(".formTel").mask("(99) 99999999");
    $(".formCep").mask("99999-999");
    $(".formCpf").mask("999.999.999-99");
    $(".formCnpj").mask("99.999.999/9999-99");
    $(".formAniver").mask("99/99/9999");
});