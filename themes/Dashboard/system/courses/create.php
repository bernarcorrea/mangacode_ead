<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-book1 mr-10"></i> Novo curso
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
                    <a href="<?= HOME ?>/admin/courses/create">Novo curso</a>
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/courses" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">

    <div class="box box100">
        <nav class="nav-tab nav-dash mb-10">
            <ul>
                <li class="current">
                    <a href="#tab1">Dados do curso</a>
                </li>
                <li>
                    <a href="#tab2">Preços</a>
                </li>
                <li>
                    <a href="#tab3">Hotmart</a>
                </li>
                <!--
                <li>
                    <a href="#tab4">Certificado</a>
                </li>
                -->
            </ul>
        </nav>
    </div>

    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="<?= HOME ?>/admin/courses/manager" class="noclear">

        <div class="box box60">
            <div class="tabs" id="tab1">
                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Título do curso
                    </small>
                    <input type="text" name="title" required class="form input-form-larg" placeholder="Título do curso">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Subtítulo
                    </small>
                    <textarea name="subtitle" required class="form area-form-medio" placeholder="Subtítulo"></textarea>
                </label>

                <label class="box box50">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Segmento
                    </small>
                    <div class="select">
                        <select name="segment" required class="select-medio">
                            <option value="" selected disabled>Selecione um item</option>
                            <?php
                                if ($segments):
                                    foreach ($segments as $s):
                                        echo "<option value=\"{$s->id}\">{$s->title}</option>";
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </label>

                <label class="box box50">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Tutor
                    </small>
                    <div class="select">
                        <select name="tutor" required class="select-medio">
                            <option value="" selected disabled>Selecione um item</option>
                            <?php
                                if ($tutors):
                                    foreach ($tutors as $t):
                                        echo "<option value=\"{$t->id}\">{$t->name}</option>";
                                    endforeach;
                                endif;
                            ?>
                        </select>
                    </div>
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Descrição
                    </small>

                    <div class="box-full padding-total-low radius-m box-white">
                        <textarea name="description" id="elm1"></textarea>
                    </div>
                </label>
            </div>

            <div class="tabs" id="tab2">
                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Preço
                    </small>
                    <input type="text" required class="form input-form-larg formVal" name="price" placeholder="R$">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Preço no boleto
                    </small>
                    <input type="text" required class="form input-form-larg formVal" name="price_billet" placeholder="R$">
                </label>
            </div>

            <div class="tabs" id="tab3">
                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Código do Produto (Hotmart)
                    </small>
                    <input type="text" required class="form input-form-larg" name="hotmart_prod" placeholder="Cód. do produto">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Link de checkout (Hotmart)
                    </small>
                    <input type="text" required class="form input-form-larg" name="hotmart_link" placeholder="Link de checkout">
                </label>
            </div>

            <!--
            <div class="tabs" id="tab4">
                <label class="box box100">
                    <img id="blah2" src="#" class="mb-20 radius-m" style="display: none"/>
                    <?//= Helper::image($c->make(ADMIN . '/images/cover.jpg', 1500, 850), "", "img radius-m j_cover2 mb-20") ?>
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Certificado
                    </small>
                    <input type="file" required name="certificate" class="form input-form-medio file box-white" onchange="readURL2(this);">
                </label>
            </div>
            -->
        </div>

        <div class="box box40">
            <label class="box box100">
                <img id="blah" src="#" class="mb-20 radius-m" style="display: none"/>
                <?= Helper::image($c->make(ADMIN . '/images/cover.jpg', 1500, 850), "", "img radius-m j_cover mb-20") ?>
                <small class="small-titulo-2 f-silver f-semibold t-upper">
                    <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Imagem do curso
                </small>
                <input type="file" required name="cover" class="form input-form-medio file box-white" onchange="readURL(this);">
            </label>

            <div class="box box100">
                <button class="btn btn-medio btn-green radius-g float_r">
                    <i class="icon-check-alt mr-5"></i> Cadastrar
                </button>

                <div class="float_r mr-20 mt-15">
                    <input type="checkbox" value="1" name="status" id="check">
                    <label for="check">Publicar</label>
                </div>
            </div>
        </div>
    </form>
</div>