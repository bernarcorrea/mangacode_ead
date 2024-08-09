<?php
    $v->layout('inc/layout');
?>

<div class="padding-total-normal">
    <header class="header-default flex-container flex-nowrap flex-itens-center flex-justify-space-between">
        <div class="title">
            <nav>
                <ul class="flex-container">
                    <li>
                        <a href="#" class="bg-tertiary f-primary"><?= COMPANY_NAME ?></a>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus" class="bg-tertiary f-primary">Dashboard</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus/alterar-senha" class="bg-tertiary f-primary">Alterar senha</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-lock"></i> Alterar senha
            </h1>
            <p class="subtitle-page f-light f-primary">Preencha os campos abaixo para alterar a sua senha de acesso:</p>
        </div>
    </header>

    <section class="container mt-50">
        <!-- PASSWORD -->
        <div class="flex-container">
            <div class="flex70 padding-total-normal bg-secondary radius-p">
                <form action="" method="post" class="j_formajax">
                    <input type="hidden" name="callback" value="<?= HOME ?>/campus/account/update" class="noclear">
                    <input type="hidden" name="type" value="4" class="noclear">
                    
                    <div class="flex-container flex-wrap">
                        <div class="flex flex50">
                            <small class="small-title f-secondary f-semibold t-upper">Nova senha</small>
                            <input type="password" name="password" class="form input-form-medio" placeholder="Nova senha" required>
                        </div>

                        <div class="flex flex50">
                            <small class="small-title f-secondary f-semibold t-upper">Confirme sua nova senha</small>
                            <input type="password" name="password_confirm" class="form input-form-medio" placeholder="Confirme sua nova senha" required>
                        </div>

                        <div class="flex flex100 t-right mt-20">
                            <button class="btn btn-medio btn-orange radius-g">
                                <i class="icon-check-circle"></i> Salvar dados
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>