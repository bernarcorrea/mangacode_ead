<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-play4"></i> Editar aula
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
                    <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>"><?= $module->title ?></a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/classes/<?= $module->id ?>">Aulas</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/classes/<?= $module->id ?>/update/<?= $class->id ?>">Editar aula</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/classes/<?= $module->id ?>" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
            <a rel="<?= $class->id ?>" id="<?= HOME ?>/admin/classes/delete" class="btn btn-icon-medio btn-red radius-g j_delete"><i class="icon-trash"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="<?= HOME ?>/admin/classes/manager" class="noclear">
        <input type="hidden" name="id" value="<?= $class->id ?>" class="noclear">

        <div class="box box60">
            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">Curso selecionado</small>
                <input type="text" disabled class="form input-form-larg box-silver2" placeholder="Curso" value="<?= $course->title ?>">
                <input type="hidden" name="course" value="<?= $course->id ?>">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">Módulo selecionado</small>
                <input type="text" disabled class="form input-form-larg box-silver2" placeholder="Módulo" value="<?= $module->title ?>">
                <input type="hidden" name="module" value="<?= $module->id ?>">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Título da aula
                </small>
                <input type="text" name="title" required class="form input-form-larg" placeholder="Título da aula" value="<?= $class->title ?>">
            </label>

            <label class="box box50">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Ordem da aula
                </small>
                <input type="number" name="ord" required class="form input-form-larg" placeholder="Ordem da aula" value="<?= $class->ord ?>">
            </label>

            <label class="box box50">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Dificuldade
                </small>
                <div class="select">
                    <select name="level" class="select-larg">
                        <option value="<?= $class->level ?>" selected>&raquo; <?= getLevel($class->level) ?></option>
                        <?php
                            foreach (getLevel() as $k => $v):
                                echo "<option value=\"{$k}\">{$v}</option>";
                            endforeach;
                        ?>
                    </select>
                </div>
            </label>

            <label class="box box50">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Tempo da aula
                </small>
                <input type="number" name="time" required class="form input-form-larg" placeholder="Tempo da aula" value="<?= $class->time ?>">
            </label>

            <label class="box box50">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Código do vídeo
                    <a style="cursor:pointer;" rel="video" class="j_tooltip btn_modal" title="Ver aula"><i class="icon-eye1"></i></a>
                </small>
                <input type="text" name="video" required class="form input-form-larg" placeholder="Código do vídeo" value="<?= $class->video ?>">
            </label>
        </div>

        <div class="box box40">
            <label class="box box100">
                <img id="blah" src="#" class="mb-20 radius-m" style="display: none"/>
                <?= Helper::image($c->make($class->cover, 1500, 850), $class->title, "img radius-m j_cover mb-20") ?>
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Miniatura da aula
                </small>
                <input type="file" name="cover" class="form input-form-medio file box-white" onchange="readURL(this);">
                <input type="hidden" name="image_current" value="<?= $class->cover ?>">
            </label>

            <div class="box box100">
                <button class="btn btn-medio btn-green radius-g float_r">
                    <i class="icon-check-alt mr-5"></i> Atualizar
                </button>
            </div>
        </div>
    </form>
</div>

<div class="content-modal">
    <div class="modal" id="video" style="display: none;">
        <span class="close_modal btn btn-icon-medio btn-red round"><i class="icon-x"></i></span>
        <div class="box-full box-white padding-total-low radius-m">
            <div class="video-container">
                <iframe src="https://player.vimeo.com/video/<?= $class->video ?>" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>