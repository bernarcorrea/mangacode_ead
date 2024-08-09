<?php
    $v->layout('inc/layout');
?>

<div class="content-login radius-m box-silver reveal_bottom">
    <header>
        <h2 class="f-red f-bold t-upper float_l">
            <i class="icon-dashboard"></i> Login
        </h2>
        <h1 class="f-black f-bold t-upper float_r"><?= COMPANY_NAME ?></h1>
    </header>
    <div class="clear"></div>
    <main>
        <form action="" method="post" class="j_formajax">
            <input type="hidden" name="callback" value="admin/login" class="noclear">

            <div class="mt-40">
                <input type="email" name="email" class="form input-form-medio" placeholder="E-mail">
            </div>

            <div class="mt-20">
                <input type="password" name="password" class="form input-form-medio" placeholder="Senha">
            </div>

            <div class="mt-20 mb-30">
                <button class="btn btn-medio btn-green box100 radius-g">
                    <i class="icon-lock-stroke"></i> Acessar sistema
                </button>
            </div>
    </main>
    <footer>
        <a href="#">
            <p class="back f-silver f-semibold t-upper float_l">
                <i class="icon-arrow-left2"></i> Voltar para o site
            </p>
        </a>
        <a href="#">
            <p class="request f-silver f-semibold t-upper float_r">
                <i class="icon-wondering"></i> Esqueci minha senha!
            </p>
        </a>
    </footer>
    </form>
</div>
