<script>
    tinymce.init({
        theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
        theme_advanced_blockformats: "p,h2,h3,h4,pre,address",
        font_size_style_values: "12px,13px,14px,16px,18px,20px",
        selector: "textarea#elm1, textarea#elm2, textarea#elm3",
        theme: "modern",
        skin: 'custom',
        width: '100%',
        relative_urls: false,
        remove_script_host: false,
        menubar:false,
        statusbar: false,
        plugins: [
            "advlist autolink autoresize link charmap anchor pagebreak spellchecker",
            "searchreplace wordcount code nonbreaking",
            "save table contextmenu directionality template paste"
        ],
        autoresize_min_height: 0,
        autoresize_max_height: 400,
        content_css: "<?= HOME ?>/<?= CAMPUS ?>/css/tiny.css",
        toolbar: "bold italic styleselect link",
        style_formats: [
            {
                title: 'Título',
                block: 'h1'
            },
            {
                title: 'Subtítulo',
                block: 'h2'
            },
            {
                title: 'Subtítulo',
                block: 'h4'
            },
            {
                title: 'Texto Padrão',
                block: 'p'
            }
        ],
        /*
         * UPLOAD DE IMAGENS
         */
        setup: function (editor) {
            editor.addButton('btnimage', {
                title: 'Enviar Imagem',
                icon: 'image',
                onclick: function () {
                    $('.tiny_imageupload').fadeIn('fast');
                    $('.mask-modal').fadeIn('fast');
                }
            });
        }
    });
</script>
