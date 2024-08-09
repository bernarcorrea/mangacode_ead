<script>
    $(function () {
        var cartTag = null;
        PagSeguroDirectPayment.setSessionId('<?= $sessionId; ?>');

        //BILLET SUBMITE
        $("form#billet").submit(function () {
            var Form = $(this);
            var senderHash = PagSeguroDirectPayment.getSenderHash();
            var Data = Form.serialize() + "&senderHash=" + senderHash;

            $.ajax({
                url: '<?= HOME ?>/admin/invoices/checkout',
                data: Data,
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $('.mask_modal').fadeIn();
                    $('.load_modal').fadeIn();
                    $('.trigger-modal').fadeOut(500, function () {
                        $(this).remove();
                    });
                },
                success: function (data) {
                    if (data.error) {
                        $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-wondering"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + data.error + '</p></div></div>');
                        setTimeout(function () {
                            $('.trigger-modal').css("right", '20px');
                        }, 90);
                    } else {
                        $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger accept radius-m"><span class="load"></span><i class="icon-happy"></i><p class="f-white f-regular"><strong class="f-bold">Perfeito!</strong>' + data.accept + '</p></div></div>');
                        setTimeout(function () {
                            $('.trigger-modal').css("right", '20px');
                        }, 90);

                        if (data.billet) {
                            window.open(data.billet, "popupWindow", "width=960,height=600,scrollbars=yes");
                        }
                        
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    }

                    $('.trigger-modal .trigger').click(function () {
                        setTimeout(function () {
                            $('.trigger-modal').css("right", '-400px');
                        }, 90);
                    });

                    $('.trigger-modal .close-modal').click(function () {
                        setTimeout(function () {
                            $('.trigger-modal').css("right", '-400px');
                        }, 90);
                    });

                    $('.load_modal').fadeOut();
                    $('.mask_modal').fadeOut();

                    /* PROGRESS BAR */
                    load();
                }
            });

            PagSeguroDirectPayment.getSenderHash();
            return false;
        });

        /*
         * PROGRESSBAR TRIGGER
         */
        function load() {
            var Element = $('.trigger-modal .trigger .load');
            var width = 1;
            var ElementId = setInterval(progressbar, 40);

            function progressbar() {
                if (width >= 94) {
                    clearInterval(ElementId);
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '-400px');
                    }, 90);
                } else {
                    width++;
                    $(Element).css("width", width + "%");
                }
            }
        }
    });
</script>