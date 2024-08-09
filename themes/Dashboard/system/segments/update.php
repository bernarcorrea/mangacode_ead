<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-list2 mr-10"></i> Editar segmento
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
                    <a href="<?= HOME ?>/admin/segments">Segmentos</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/segments/update/<?= $segment->id ?>">Editar segmento</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/segments" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
            <a rel="<?= $segment->id ?>" id="<?= HOME ?>/admin/segments/delete" class="btn btn-icon-medio btn-red radius-g j_delete j_tooltip" title="Excluir segmento"><i class="icon-trash"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="<?= HOME ?>/admin/segments/manager" class="noclear">
        <input type="hidden" name="id" value="<?= $segment->id ?>" class="noclear">

        <div class="box box60">
            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Título do segmento
                </small>
                <input type="text" name="title" required class="form input-form-larg" placeholder="Título do curso" value="<?= $segment->title ?>">
            </label>

            <label class="box box100">
                <small class="small-titulo-2 f-silver f-semibold t-upper">Descrição</small>
                <textarea name="description" class="form area-form-medio" placeholder="Descrição"><?= $segment->description ?></textarea>
            </label>

            <div class="box box100">
                <button class="btn btn-medio btn-green radius-g float_r">
                    <i class="icon-check-alt mr-5"></i> Atualizar
                </button>
            </div>
        </div>
    </form>
</div>