<?php
    
    use Source\Support\Helper;
    
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-list2 mr-10"></i> Novo módulo
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
                    <a href="<?= HOME ?>/admin/courses">Cursos</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/courses"><?= $course->title ?></a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>">Módulos</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>/create">Novo módulo</a>
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="<?= HOME ?>/admin/modules/manager" class="noclear">

        <div class="box box60">
            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">Curso selecionado</small>
                <input type="text" disabled class="form input-form-larg box-silver2" placeholder="Curso" value="<?= $course->title ?>">
                <input type="hidden" name="course" value="<?= $course->id ?>">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Título do módulo
                </small>
                <input type="text" name="title" required class="form input-form-larg" placeholder="Título do módulo">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Ordem do módulo
                </small>
                <input type="number" name="ord" required class="form input-form-larg" placeholder="Ordem do módulo">
            </label>

            <div class="box box100">
                <button class="btn btn-medio btn-green radius-g float_r">
                    <i class="icon-check-alt mr-5"></i> Cadastrar
                </button>
            </div>
        </div>
    </form>
</div>