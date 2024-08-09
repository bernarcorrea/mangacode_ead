<?php
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Novo Usuário
        </h1>
        <div class="nav float_l">
            <ul>
                <li class="t-upper">
                    <a href="<?= HOME ?>"><?= COMPANY_NAME ?></a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/users">Usuários</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/users/create">Novo Usuário</a>
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/users" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" class="noclear" name="callback" value="manager">
        
        <div class="box box60">
            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper"><span class="f-red j_tooltip" title="Este campo é obrigatório!">*</span> Nome</small>
                <input type="text" name="name" class="form input-form-larg" placeholder="Nome">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper"><span class="f-red j_tooltip" title="Este campo é obrigatório!">*</span> E-mail</small>
                <input type="email" name="email" class="form input-form-larg" placeholder="E-mail">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper"><span class="f-red j_tooltip" title="Este campo é obrigatório!">*</span> Senha</small>
                <input type="password" name="password" class="form input-form-larg" placeholder="Senha">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper"><span class="f-red j_tooltip" title="Este campo é obrigatório!">*</span> Nível</small>
                <div class="select">
                    <select name="nivel" class="select-larg">
                        <option value="" selected disabled>Selecione um nível</option>
                        <option value="1">Administrador</option>
                        <option value="2">Editor</option>
                        <option value="3">Atendimento</option>
                    </select>
                </div>
            </label>

            <div class="box box100">
                <button class="btn btn-medio btn-green radius-g float_r">
                    <i class="icon-check-alt mr-5"></i> Cadastrar usuário
                </button>
            </div>
        </div>
    </form>
</div>