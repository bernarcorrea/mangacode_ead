<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-book1 mr-10"></i> Editar curso
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
                    <a href="<?= HOME ?>/admin/courses/update/<?= $course->id ?>">Editar curso</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/courses" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
            <a rel="<?= $course->id ?>" id="<?= HOME ?>/admin/courses/delete" class="btn btn-icon-medio btn-red radius-g j_delete"><i class="icon-trash"></i></a>
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
        <input type="hidden" name="id" value="<?= $course->id ?>" class="noclear">

        <div class="box box60">
            <div class="tabs" id="tab1">
                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Título do curso
                    </small>
                    <input type="text" name="title" required class="form input-form-larg" placeholder="Título do curso" value="<?= $course->title ?>">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Subtítulo
                    </small>
                    <textarea name="subtitle" required class="form area-form-medio" placeholder="Subtítulo"><?= $course->subtitle ?></textarea>
                </label>

                <label class="box box50">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Segmento
                    </small>
                    <div class="select">
                        <select name="segment" required class="select-medio">
                            <option value="<?= $course->segment ?>" selected>&raquo; <?= $course->segment_title ?></option>
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
                            <option value="<?= $course->tutor ?>" selected>&raquo; <?= $course->tutor_name ?></option>
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
                        <textarea name="description" id="elm1"><?= $course->description ?></textarea>
                    </div>
                </label>
            </div>

            <div class="tabs" id="tab2">
                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Preço
                    </small>
                    <input type="text" required class="form input-form-larg formVal" name="price" placeholder="R$" value="R$ <?= Helper::real($course->price) ?>">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Preço no boleto
                    </small>
                    <input type="text" required class="form input-form-larg formVal" name="price_billet" placeholder="R$" value="R$ <?= Helper::real($course->price_billet) ?>">
                </label>
            </div>

            <div class="tabs" id="tab3">
                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Código do Produto (Hotmart)
                    </small>
                    <input type="text" required class="form input-form-larg" name="hotmart_prod" placeholder="Cód. do produto" value="<?= $course->hotmart_prod ?>">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Link de checkout (Hotmart)
                    </small>
                    <input type="text" required class="form input-form-larg" name="hotmart_link" placeholder="Link de checkout" value="<?= $course->hotmart_link ?>">
                </label>
            </div>

            <!--
            <div class="tabs" id="tab4">
                <label class="box box100">
                    <img id="blah2" src="#" class="mb-20 radius-m" style="display: none"/>
                    <?//= Helper::image($c->make($course->certificate, 1500, 850), "", "img radius-m j_cover2 mb-20") ?>
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Certificado
                    </small>
                    <input type="file" name="certificate" class="form input-form-medio file box-white" onchange="readURL2(this);">
                    <input type="hidden" name="image_cert_current" value="<?//= $course->certificate ?>">
                </label>
            </div>
            -->
        </div>

        <div class="box box40">
            <div class="box-full mb-20">
                <label class="box box100">
                    <img id="blah" src="#" class="mb-20 radius-m" style="display: none"/>
                    <?= Helper::image($c->make($course->cover, 1500, 850), "", "img radius-m j_cover mb-20") ?>
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Imagem do curso
                    </small>
                    <input type="file" name="cover" class="form input-form-medio file box-white" onchange="readURL(this);">
                    <input type="hidden" name="image_current" value="<?= $course->cover ?>">
                </label>

                <div class="box box100">
                    <button class="btn btn-medio btn-green radius-g float_r">
                        <i class="icon-check-alt mr-5"></i> Atualizar
                    </button>

                    <div class="float_r mr-20 mt-15">
                        <input type="checkbox" value="1" name="status" <?= ($course->status ? 'checked' : null) ?> id="check">
                        <label for="check">Publicar</label>
                    </div>
                </div>
            </div>
    </form>

    <div class="box-full padding-total-normal radius-m box-silver2">
        <h3 class="title-page-sec f-semibold f-black mb-10">
            <i class="icon-folder-open"></i> Pasta do curso
        </h3>
        <div class="box-full">
            <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
                <input type="hidden" name="callback" value="<?= HOME ?>/admin/courses/folder/insert" class="noclear">
                <input type="hidden" name="course" value="<?= $course->id ?>" class="noclear">
                <input type="text" name="title" class="form input-form-low box-silver mb-10" placeholder="Digite o título do arquivo">
                <input type="file" name="file" class="form input-form-low file box-silver">
                <div class="t-right mt-10">
                    <button class="btn btn-low btn-green radius-g">
                        <i class="icon-check-alt mr-5"></i> Enviar arquivo para a pasta
                    </button>
                </div>
            </form>
        </div>

        <div class="box-full mt-20 content-folder-course j_list">
            <h4 class="subtitle-page f-semibold f-black mb-10">
                <i class="icon-file-zip"></i> Arquivos atuais:
            </h4>
            <span class="j_newresult"></span>
            <?php
                if ($courseFolder):
                    foreach ($courseFolder as $cf):
                        ?>
                        <article class="box box33" id="<?= $cf->id ?>">
                            <div class="box-full radius-p box-silver padding-total-low t-center">
                                <span rel="<?= $cf->id ?>" id="<?= HOME ?>/admin/courses/folder/delete" class="j_delete delete btn btn-icon-low btn-red round"><i class="icon-x"></i></span>
                                <a href="<?= HOME ?>/<?= $cf->file ?>" target="_blank">
                                    <p class="f-silver mb-10">
                                        <i class="icon-file-zip" style="font-size: 25px;"></i>
                                    </p>
                                    <h1 class="small-titulo f-black f-light"><?= Helper::lmWord($cf->title, 28) ?></h1>
                                </a>
                            </div>
                        </article>
                    <?php
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</div></div>