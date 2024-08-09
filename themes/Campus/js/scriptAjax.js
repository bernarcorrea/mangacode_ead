$(function () {
    BASE = $("link[rel='base']").attr("href");

    // AJAX SUBMIT DEFAULT
    $('.j_formajax').submit(function () {
        var form = $(this);
        var callback = form.find('input[name="callback"]').val();

        if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
        }

        form.ajaxSubmit({
            url: callback,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('.mask_modal').fadeIn();
                $('.load_modal').fadeIn();
                $('.trigger-modal').fadeOut(500, function () {
                    $(this).remove();
                });
            },
            success: function (resposta) {
                console.clear();
                console.log(resposta);

                if (resposta.info) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger info radius-m"><span class="load"></span><i class="icon-sentiment_satisfied_alt"></i><p class="f-white f-regular"><strong class="f-bold">Informativo!</strong>' + resposta.info + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else if (resposta.alert) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger alert radius-m"><span class="load"></span><i class="icon-sentiment_neutral"></i><p class="f-white f-regular"><strong class="f-bold">Atenção!</strong>' + resposta.alert + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else if (resposta.error) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-sentiment_very_dissatisfied"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + resposta.error + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger accept radius-m"><span class="load"></span><i class="icon-sentiment_very_satisfied"></i><p class="f-white f-regular"><strong class="f-bold">Perfeito!</strong>' + resposta.accept + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);

                    if (resposta.redirect) {
                        setTimeout(function () {
                            location.href = resposta.redirect;
                        }, resposta.time);
                    }

                    if (resposta.replace) {
                        $('.j_replace').slideUp(function () {
                            $(this).remove();
                        });

                        $('.j_replacebox').html(resposta.replace, function () {
                            $('.j_replace').fadeIn();
                        });
                    }

                    if (resposta.result) {
                        $(resposta.result).prependTo($('.j_newresult'));
                        $('.j_new').fadeIn();
                    }

                    if (resposta.reply) {
                        $(resposta.reply).appendTo($(resposta.result2));
                    }

                    if (resposta.prev) {
                        $(resposta.prev).fadeOut(function () {
                            $(resposta.next).fadeIn();
                        })
                    }

                    if (resposta.tinyMCE) {
                        tinyMCE.activeEditor.insertContent(resposta.tinyMCE);
                    }

                    if (resposta.text) {
                        $('.j_box_text').html(resposta.text);
                    }

                    if (resposta.clear) {
                        form.find('input[class!="noclear"], textarea').val('');
                    }

                    if (resposta.modal) {
                        $('.content-modal').fadeOut();
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

                $('.mask_modal').fadeOut();
                $('.load_modal').fadeOut();

                /* PROGRESS BAR */
                load();
            }
        });
        return false;
    });

    $(".j_photoprofile").on('submit', function () {
        var form = $(this);
        var callback = form.find('input[name="callback"]').val();

        form.ajaxSubmit({
            url: callback,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('.mask_modal').fadeIn();
                $('.load_modal').fadeIn();
                $('.trigger-modal').fadeOut(500, function () {
                    $(this).remove();
                });
            },
            success: function (resposta) {
                console.clear();
                console.log(resposta);

                if (resposta.error) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-sentiment_very_dissatisfied"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + resposta.error + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger accept radius-m"><span class="load"></span><i class="icon-sentiment_very_satisfied"></i><p class="f-white f-regular"><strong class="f-bold">Perfeito!</strong>' + resposta.accept + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                }

                if (resposta.img) {
                    $('.photo-upload .img').html(resposta.img);
                    $('.dashboard-nav-fix .profile .img').html(resposta.img);
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

                $('.mask_modal').fadeOut();
                $('.load_modal').fadeOut();

                /* PROGRESS BAR */
                load();
            }
        });
        return false;
    });

    $('.j_open_course').click(function () {
        var id = $(this).attr('rel');
        var callback = $(this).attr('id');

        $.ajax({
            url: callback,
            type: 'POST',
            dataType: 'json',
            data: {id},
            beforeSend: function () {
                $('.mask_modal').fadeIn();
                $('.load_modal').fadeIn();
                $('.trigger-modal').fadeOut(500, function () {
                    $(this).remove();
                });
            },
            success: function (resposta) {
                console.clear();
                console.log(resposta);

                if (resposta.error) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-sentiment_very_dissatisfied"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + resposta.error + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                    $('.mask_modal').fadeOut();
                } else {
                    $('.trigger-result').html(resposta.result);
                    $('.content-modal').fadeIn();
                    $('.modal').fadeIn();
                }

                $('.trigger-result .close_modal').click(function () {
                    $('.mask_modal').fadeOut();
                    $('.content-modal').fadeOut(function () {
                        $(this).remove();
                    });
                });

                $('.load_modal').fadeOut();
            }
        });
        return false;
    });

    $('.j_formajax_gb').submit(function () {
        var form = $(this);
        var callback = form.find('input[name="callback"]').val();

        form.ajaxSubmit({
            url: callback,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {

            },
            uploadProgress: function (evento, posicao, total, completo) {
                form.find('.bar-loading').fadeIn();
                form.find('.bar-loading .bar').text(completo + "%").width(completo + "%");
            },
            success: function (resposta) {
                console.clear();
                console.log(resposta);

                if (resposta.error) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-wondering"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + resposta.error + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger accept radius-m"><span class="load"></span><i class="icon-happy"></i><p class="f-white f-regular"><strong class="f-bold">Perfeito!</strong>' + resposta.accept + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);

                    if (resposta.redirect) {
                        setTimeout(function () {
                            location.href = resposta.redirect;
                        }, resposta.time);
                    }

                    if (resposta.result) {
                        $(resposta.result).prependTo($('.j_newresult'));
                        $('.j_new').fadeIn();
                    }

                    if (resposta.clear) {
                        form.find('input[class!="noclear"], textarea').val('');
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

                /* PROGRESS BAR */
                load();
            }
        });
        return false;
    });

    //DELETA DADOS 
    $('.j_list').on('click', '.j_delete', function () {
        var id = $(this).attr('rel');
        var callback = $(this).attr('id');

        if (!confirm("Você tem certeza que deseja deletar este item?")) {
            return false;
        }
        $.ajax({
            url: callback,
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('.mask_modal').fadeIn();
                $('.load_modal').fadeIn();
                $('.trigger-modal').fadeOut(500, function () {
                    $(this).remove();
                });
            },
            success: function (resposta) {
                if (resposta.error) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-wondering"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + resposta.error + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger accept radius-m"><span class="load"></span><i class="icon-happy"></i><p class="f-white f-regular"><strong class="f-bold">Perfeito!</strong>' + resposta.accept + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                    $('.j_list #' + id).fadeOut();

                    if (resposta.redirect) {
                        setTimeout(function () {
                            location.href = resposta.redirect;
                        }, resposta.time);
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

                $('.mask_modal').fadeOut();
                $('.load_modal').fadeOut();

                /* PROGRESS BAR */
                load();
            }
        });
    });

    // SYSTEM LOGOUT
    $('.j_logout').click(function () {
        var callback = $(this).attr('id');

        $.ajax({
            url: callback,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('.mask_modal').fadeIn();
                $('.load_modal').fadeIn();
                $('.trigger-modal').fadeOut(500, function () {
                    $(this).remove();
                });
            },
            success: function (resposta) {
                if (resposta.error) {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger error radius-m"><span class="load"></span><i class="icon-sentiment_very_dissatisfied"></i><p class="f-white f-regular"><strong class="f-bold">Oooops!</strong>' + resposta.error + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);
                } else {
                    $('.trigger-box').html('<div class="trigger-modal transition"><span class="close-modal"><i class="fa fa-close"></i></span><div class="trigger accept radius-m"><span class="load"></span><i class="icon-sentiment_very_satisfied"></i><p class="f-white f-regular"><strong class="f-bold">Perfeito!</strong>' + resposta.accept + '</p></div></div>');
                    setTimeout(function () {
                        $('.trigger-modal').css("right", '20px');
                    }, 90);

                    if (resposta.redirect) {
                        setTimeout(function () {
                            location.href = resposta.redirect;
                        }, resposta.time);
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

                $('.mask_modal').fadeOut();
                $('.load_modal').fadeOut();

                /* PROGRESS BAR */
                load();
            }
        });
    });

    $('.j_reply_doubt').click(function () {
        var id = $(this).attr('id');
        var boxInput = $('.doubt_id');
        boxInput.html("<input type='hidden' name='id' value='" + id + "'>");
    });

    // ACTION VIDEO PLAYER
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);

    player.on('play', function () {
        $('.status_class .j_pending').addClass('class_pending');
        // AUTOCHECK AULA
        executeTaskClass();
    });

    function executeTaskClass() {
        if ($('.class_pending').length) {
            var callback = $('.class_pending').attr('rel');
            var boxButton = $('.status_class');
            var taskManager = setInterval(function () {
                $.ajax({
                    url: callback,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.progress) {
                            boxButton.find('.class_pending .frame').width(response.progress + "%");
                        }

                        if (response.replace) {
                            boxButton.html(response.replace);
                        }

                        if (response.stop) {
                            clearTimeout(taskManager);
                        }
                    }
                });
            }, 5000);
        }
    }

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