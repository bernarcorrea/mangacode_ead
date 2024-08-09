<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
    $cover = (empty($student->cover) ? ADMIN . '/images/user.jpg' : $student->cover);
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Histórico do aluno</span>
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
                    <a href="<?= HOME ?>/admin/students">Alunos</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/students/history/<?= $student->id ?>">Histórico do aluno</a>
                </li>
            </ul>
        </div>
    </header>

    <nav class="options-default j_list">
        <a href="<?= HOME ?>/admin/students" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
    </nav>
</div>

<div class="box-full">
    <div class="box box100">
        <div class="box-full content-resume-student larg mb-20">
            <article class="box-full padding-total-low radius-m box-white mb-20">
                <div class="photo float_l">
                    <?= Helper::image($c->make($cover, 800, 800), $student->name, "img round") ?>
                </div>
                <header>
                    <h1 class="f-black f-semibold mb-5"><?= $student->name . ' ' . $student->lastname ?></h1>
                    <p class="f-black f-light mb-5">E-mail: <?= $student->email ?></p>
                    <p class="f-black f-light mb-10">CPF: <?= $student->document ?></p>
                    <a href="<?= HOME ?>/admin/students/update/<?= $student->id ?>" class="btn btn-low btn-blue radius-g"><i class="icon-write"></i> Editar aluno</a>
                </header>
            </article>
        </div>

        <div class="content-serv">
            <?php
                if ($subscribers):
                    foreach ($subscribers as $sub):
                        ?>
                        <article class="box box25">
                            <div class="box-full padding-total-normal radius-m box-white">
                                <?= Helper::image($c->make($sub->course_cover, 800, 500), $sub->course_title, "img radius-m") ?>

                                <header class="box-full box-white j_list mt-20">
                                    <a href="<?= HOME ?>/admin/students/progress/<?= $student->id ?>/course/<?= $sub->course ?>">
                                        <h1 class="f-bold t-upper mb-20"><?= $sub->course_title ?></h1>
                                    </a>
                                    <p class="date f-black f-light t-upper">
                                        <i class="icon-list2"></i> Segmento:
                                        <b class="f-bold"><?= $sub->segment_title ?></b>
                                    </p>
                                    <p class="date f-black f-light t-upper">
                                        <i class="icon-user1"></i> Tutor:
                                        <b class="f-bold"><?= $sub->tutor_name ?></b>
                                    </p>
                                    <p class="date f-black f-light t-upper">
                                        <i class="icon-drawer2"></i> Status:
                                        <b class="f-bold"><?= getSubscriberStatus($sub->status) ?></b>
                                    </p>

                                    <div class="line mt-10"></div>
                                    <div class="clear"></div>

                                    <div class="progress-bar radius-p box-silver mb-15">
                                        <div class="bar box-green radius-p f-bold f-black" style="width: <?= courseProgress($sub->course, $student->id) ?>%"><?= courseProgress($sub->course, $student->id) ?>%</div>
                                    </div>

                                    <a href="<?= HOME ?>/admin/students/progress/<?= $student->id ?>/course/<?= $sub->course ?>" class="btn btn-low btn-blue radius-g" style="color: #fff;"><i class="icon-eye"></i> Visualizar andamento</a>
                                </header>
                            </div>
                        </article>
                    <?php
                    endforeach;
                endif;
            ?>
        </div>
    </div>
</div>