<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-trophy1 mr-10"></i> Ver certificado</span>
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
                    <a href="<?= HOME ?>/admin/certificates">Certificados</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/certificates/view/<?= $certificate->id ?>">Ver certificado</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/certificates" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <div class="box box70">
        <h3 class="title-page-sec f-black f-semibold mb-20">Dados do aluno:</h3>
        <div class="box-full padding-total-normal box-white radius-m mb-20">
            <div class="box box100">
                <p class="text-page f-black f-light t-upper">Nome:<br>
                    <strong class="f-semibold"><?= $certificate->student->name . ' ' . $certificate->student->lastname ?></strong>
                </p>
            </div>

            <div class="box box50">
                <p class="text-page f-black f-light t-upper">E-mail:<br>
                    <strong class="f-semibold"><?= $certificate->student->email ?></strong>
                </p>
            </div>

            <div class="box box50">
                <p class="text-page f-black f-light t-upper">CPF:<br>
                    <strong class="f-semibold"><?= $certificate->student->document ?></strong>
                </p>
            </div>

            <a href="<?= HOME ?>/admin/students/update/<?= $certificate->student->id ?>" class="btn btn-medio btn-blue radius-g mt-10"><i class="icon-write"></i> Editar aluno</a>
        </div>

        <h3 class="title-page-sec f-black f-semibold mb-20">Dados do curso:</h3>
        <div class="box-full padding-total-normal box-white radius-m mb-20">
            <div class="box box100">
                <p class="text-page f-black f-light t-upper">Título:<br>
                    <strong class="f-semibold"><?= $certificate->course->title ?></strong>
                </p>
            </div>

            <div class="box box50">
                <p class="text-page f-black f-light t-upper">Segmento:<br>
                    <strong class="f-semibold"><?= $certificate->course->segment->title ?></strong>
                </p>
            </div>

            <div class="box box50">
                <p class="text-page f-black f-light t-upper">Tutor:<br>
                    <strong class="f-semibold"><?= $certificate->course->tutor->name ?></strong>
                </p>
            </div>

            <a href="<?= HOME ?>/admin/courses/update/<?= $certificate->course->id ?>" class="btn btn-medio btn-blue radius-g mt-10"><i class="icon-write"></i> Editar curso</a>
        </div>
    </div>

    <div class="box box30">
        <div class="box-full">
            <div class="photo mb-20">
                <?= Helper::image($c->make($certificate->course->cover, 1150, 730), $certificate->course->title, "img radius-m") ?>
            </div>

            <div class="box-full padding-total-normal box-white radius-m mb-20 t-center">
                <h3 class="subtitle-page f-black f-light"><i class="icon-calendar"></i><br> Gerado em:<br> <span class="f-semibold mt-5 title-page" style="display: block;"><?= date('d/m/Y', strtotime($certificate->created_at)) ?></span></h3>
            </div>

            <div class="box-full padding-total-normal box-white radius-m mb-20 t-center">
                <h3 class="subtitle-page f-black f-light"><i class="icon-key"></i><br> Código:<br> <span class="f-semibold mt-5 title-page" style="display: block;"><?= $certificate->cod ?></span></h3>
            </div>
        </div>
    </div>
</div>