<script>
    $(function () {
        $('.payment_form').submit(function (event) {
            var form = $(this);
            var typeTransaction = form.find('input[name="typeTransaction"]').val();

            if (typeTransaction == 'credit_card') {
                // CREDIT_CARD
                event.preventDefault();
                var card = {}

                card.card_holder_name = $("#form #card_holder_name").val()
                card.card_expiration_date = $("#form #card_expiration_month").val() + '/' + $("#form #card_expiration_year").val()
                card.card_number = $("#form #card_number").val()
                card.card_cvv = $("#form #card_cvv").val()

                // CAPTURA ERROS DE VALIDAÇÃO E BANDEIRA DO CARTÃO
                var cardValidations = pagarme.validate({card: card})

                // VERIFICA POSSÍVEIS ERROS
                if (!cardValidations.card.card_number) {
                    console.log('Oops, número de cartão incorreto.')
                } else if (!cardValidations.card.card_expiration_date) {
                    console.log('A data de expiração do cartão não é válida.')
                } else {
                    pagarme.client.connect({encryption_key: '<?= PAGARME_SANDBOX['cript'] ?>'})
                        .then(client => client.security.encrypt(card))
                        .then(
                            // CARD_HASH
                            function (hash) {
                                $.ajax({
                                    url: "<?= HOME ?>/admin/checkout/transaction",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        transaction: typeTransaction,
                                        card_hash: hash,
                                        card: card,
                                    },
                                    success: function (response) {

                                    }
                                });
                            }
                        );
                }
            } else {
                // BILLET
                $.ajax({
                    url: "<?= HOME ?>/admin/checkout/transaction",
                    type: "POST",
                    dataType: "json",
                    data: {
                        transaction: typeTransaction,
                    },
                    success: function (response) {

                    }
                });
            }
            return false
        });
        
        $('.payment_form_mercado').submit(function (event) {
            var form = $(this);
            var typeTransaction = form.find('input[name="typeTransaction"]').val();
            
            // BILLET
            $.ajax({
                url: "<?= HOME ?>/admin/checkout/transactionMercado",
                type: "POST",
                dataType: "json",
                data: {
                    transaction: typeTransaction,
                },
                success: function (response) {

                }
            });
            return false
        });
    });
</script>