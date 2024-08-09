<?php use Source\Support\Helper; ?>

<!doctype html>
<html lang="pt-br">
<head>
    <?= $v->insert('inc/head') ?>
</head>
<body>
<div class="trigger-box"></div>
<div class="mask_modal" style="<?= (!empty($error) ? 'display:block' : null) ?>"></div>
<div class="load_modal">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>

<div class="content-login flex-container flex-direction-column flex-justify-center flex-itens-center">
    <div class="login bg-tertiary radius-m">
        <div class="logo"><?= Helper::image(CAMPUS . '/images/logo.png', COMPANY_NAME, "img") ?></div>
        <form action="" method="post" class="j_formajax" autocomplete="off">
            <input type="hidden" name="callback" value="<?= HOME ?>/campus/forgot-password/execute">

            <div class="content-form flex-container flex-direction-column mt-30 t-center">
                <p class="f-secondary f-light text-page">Digite seu e-mail abaixo para receber um link de redefinição de senha:</p>
                
                <label class="flex flex100 flex-container flex-itens-center">
                    <i class="icon-alternate_email"></i>
                    <input type="email" name="email" autofocus placeholder="Digite seu e-mail" required>
                </label>

                <button class="btn btn-medio btn-orange radius-g mt-20">
                    Enviar link de redefinição
                </button>

                <p class="f-secondary f-light mt-30 t-center">
                    Lembrou sua senha?
                    <a href="<?= HOME ?>/campus/login" class="f-semibold">Faça o seu login!</a>
                </p>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($error)): ?>
    <div class="content-modal" style="display: block;">
        <div class="modal" id="error" style="display: block;">
            <span class="btn btn-icon-medio btn-black round close_modal"><i class="icon-x"></i></span>
            <div class="container padding-total-high radius-m bg-red t-center">
                <i class="icon-sentiment_very_dissatisfied f-white title-page" style="font-size: 60px;"></i>
                <h2 class="title-page-sec f-semibold f-white mb-10 mt-20"><?= $titleError ?></h2>
                <p class="subtitle-page f-regular f-white mb-30"><?= $descError ?></p>
                <a href="<?= HOME ?>" class="btn btn-medio btn-black radius-g">
                    <i class="icon-home1"></i> Voltar para home
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>