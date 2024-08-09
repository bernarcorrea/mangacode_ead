<?php use Source\Support\Helper; ?>

<!doctype html>
<html lang="pt-br">
<head>
    <?= $v->insert('inc/head') ?>
</head>
<body>
<div class="trigger-box"></div>
<div class="mask_modal"></div>
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
    <div class="login register bg-tertiary radius-m">
        <div class="logo"><?= Helper::image(CAMPUS . '/images/logo.png', COMPANY_NAME, "img") ?></div>
        <div class="content-form mt-20">
            <div id="step1" style="display: block;">
                <form action="" method="post" class="j_formajax" autocomplete="off">
                    <input type="hidden" name="callback" value="<?= HOME ?>/campus/register/execute">
                    <input type="hidden" name="step" value="1">
                    
                    <div class="nav-register flex-container flex-justify-center mt-30">
                        <span class="round active"><i class="icon-user-outline"></i></span>
                        <span class="round"><i class="icon-location-arrow-outline"></i></span>
                        <span class="round"><i class="icon-key-outline"></i></span>
                    </div>

                    <div class="flex-container flex-itens-center flex-wrap mt-10">
                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-user1"></i>
                            <input type="text" name="name" autofocus placeholder="Nome" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-user-add-outline"></i>
                            <input type="text" name="lastname" placeholder="Sobrenome" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-document-text"></i>
                            <input type="text" name="document" placeholder="CPF" class="formCpf" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-calendar"></i>
                            <input type="text" name="birthday" placeholder="Nascimento" class="formAniver" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-phone-outline"></i>
                            <input type="text" name="phone" placeholder="Celular" class="formFone" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-users"></i>
                            <select name="genre">
                                <option value="" selected disabled>Selecione um gênero</option>
                                <?php
                                    foreach (getGenre() as $k => $v):
                                        echo "<option value=\"{$k}\">{$v}</option>";
                                    endforeach;
                                ?>
                            </select>
                        </label>

                        <div class="flex flex100 t-right">
                            <button class="btn btn-medio btn-orange radius-g mt-20">
                                Próximo passo
                                <i class="icon-arrow-right1"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="step2" style="display: none;">
                <form action="" method="post" class="j_formajax" autocomplete="off">
                    <input type="hidden" name="callback" value="<?= HOME ?>/campus/register/execute">
                    <input type="hidden" name="step" value="2">
                    
                    <div class="nav-register flex-container flex-justify-center mt-30">
                        <span class="round"><i class="icon-user-outline"></i></span>
                        <span class="round active"><i class="icon-location-arrow-outline"></i></span>
                        <span class="round"><i class="icon-key-outline"></i></span>
                    </div>

                    <div class="flex-container flex-itens-center flex-wrap mt-10">
                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-location"></i>
                            <input type="text" name="cep" class="formCep sg_getCep" placeholder="CEP" required>
                        </label>

                        <label class="flex flex70 flex-container flex-itens-center">
                            <i class="icon-location-outline"></i>
                            <input type="text" name="address" class="sg_logradouro" readonly placeholder="Endereço" required>
                        </label>

                        <label class="flex flex30 flex-container flex-itens-center">
                            <i class="icon-document-text"></i>
                            <input type="text" name="number" placeholder="Nº" required>
                        </label>

                        <label class="flex flex100 flex-container flex-itens-center">
                            <i class="icon-document-text"></i>
                            <input type="text" name="complement" placeholder="Complemento">
                        </label>

                        <label class="flex flex33 flex-container flex-itens-center">
                            <i class="icon-location-arrow-outline"></i>
                            <input type="text" name="district" class="sg_bairro" readonly placeholder="Bairro" required>
                        </label>

                        <label class="flex flex33 flex-container flex-itens-center">
                            <i class="icon-location_city"></i>
                            <input type="text" name="city" class="sg_localidade" readonly placeholder="Cidade" required>
                        </label>

                        <label class="flex flex33 flex-container flex-itens-center">
                            <i class="icon-location_city"></i>
                            <input type="text" name="state" class="sg_uf" readonly placeholder="Estado" required>
                        </label>

                        <div class="flex flex100 t-right">
                            <button class="btn btn-medio btn-orange radius-g mt-20">
                                Próximo passo
                                <i class="icon-arrow-right1"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="step3" style="display: none;">
                <form action="" method="post" class="j_formajax" autocomplete="off">
                    <input type="hidden" name="callback" value="<?= HOME ?>/campus/register/execute">
                    <input type="hidden" name="step" value="3">
                    
                    <div class="nav-register flex-container flex-justify-center mt-30">
                        <span class="round"><i class="icon-user-outline"></i></span>
                        <span class="round"><i class="icon-location-arrow-outline"></i></span>
                        <span class="round active"><i class="icon-key-outline"></i></span>
                    </div>

                    <div class="flex-container flex-itens-center flex-wrap mt-10">
                        <label class="flex flex100 flex-container flex-itens-center">
                            <i class="icon-alternate_email"></i>
                            <input type="email" name="email" placeholder="E-mail" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-key-outline"></i>
                            <input type="password" name="password" placeholder="Senha" required>
                        </label>

                        <label class="flex flex50 flex-container flex-itens-center">
                            <i class="icon-key-outline"></i>
                            <input type="password" name="password_confirm" placeholder="Confirme sua senha" required>
                        </label>

                        <div class="flex flex100 t-right">
                            <button class="btn btn-medio btn-orange radius-g mt-20">
                                Finalizar cadastro
                                <i class="icon-check"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex flex100">
                <p class="f-secondary f-light mt-30 t-center">
                    Já possui conta? Então
                    <a href="<?= HOME ?>/campus" class="f-semibold">faça login!</a>
                </p>
            </div>

        </div>
    </div>
</div>

</body>
</html>