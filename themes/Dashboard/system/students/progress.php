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
            <i class="icon-users1 mr-10"></i> Progresso do aluno</span>
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
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/students/progress/<?= $student->id ?>/course/<?= $course->id ?>">Progresso do aluno</a>
                </li>
            </ul>
        </div>
    </header>

    <nav class="options-default j_list">
        <a href="<?= HOME ?>/admin/students/history/<?= $student->id ?>" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
    </nav>
</div>

<div class="box-full">
    <div class="box box70">
        <div class="box-full padding-total-normal box-white radius-m mb-30">
            <p class="text-page f-black f-regular mb-5">
                <i class="icon-chart1"></i> Andamento do aluno:
            </p>
            <div class="progress-bar radius-p box-silver">
                <div class="bar box-green radius-p f-bold f-black" style="width: <?= courseProgress($course->id, $student->id) ?>%"><?= courseProgress($course->id, $student->id) ?>%</div>
            </div>
        </div>

        <h3 class="title-page-sec f-black f-semibold mb-20">Histórico de aulas:</h3>
        <div class="box-full padding-total-normal box-white radius-m mb-20">
            <?php
                if ($modules):
                    $i = 0;
                    foreach ($modules as $md):
                        ?>
                        <div class="box-full box-silver radius-m padding-total-low">
                            <small class="small-titulo f-light f-black mb-5">Módulo <?= $md->ord ?></small>
                            <h3 class="subtitle-page f-semibold f-black"><?= $md->title ?></h3>
                        </div>
                        
                        <?php if ($md->classes): ?>
                        <table class="table box-full mt-10" cellspacing="0" cellpadding="0">
                            <tr class="box-white">
                                <td class="tb-field f-semibold f-black" style="width: 30px;">#</td>
                                <td class="tb-field f-semibold f-black" style="width: 40%">Aula</td>
                                <td class="tb-field f-semibold f-black">Aberto em</td>
                                <td class="tb-field f-semibold f-black">Atualizado em</td>
                                <td class="tb-field f-semibold f-black">Status</td>
                            </tr>
                            <?php
                                $color = 'box-white';
                                foreach ($md->classes as $class):
                                    $i++;
                                    $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                                    $i = ($i <= 9 ? '0' . $i : $i);
                                    ?>
                                    <tr class="<?= $color ?>">
                                        <td class="tb-field f-semibold f-black" style="width: 30px;"><?= $i ?></td>
                                        <td class="tb-field f-regular f-black" style="width: 40%;"><?= Helper::lmWord($class->title, 30) ?></td>
                                        <td class="tb-field f-regular f-black"><?= $class->date_open ?></td>
                                        <td class="tb-field f-regular f-black"><?= $class->date_updated ?></td>
                                        <td class="tb-field f-regular f-black"><?= getStatusClass($class->status_class) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                        </table>
                    <?php
                    else:
                        echo error("Ainda não existem faturas cadastradas para essa assinatura.", INFO);
                    endif;
                    endforeach;
                endif
            ?>
        </div>
    </div>

    <div class="box box30">
        <div class="box-full">
            <div class="photo mb-20">
                <?= Helper::image($c->make($course->cover, 1150, 730), $course->title, "img radius-m") ?>
            </div>

            <div class="box-full padding-total-normal box-white radius-m mb-20">
                <h3 class="subtitle-page f-black f-semibold mb-20"><?= $course->title ?></h3>
                <p class="text-page f-black f-regular mb-10">
                    <i class="icon-arrow-up2"></i> Iniciou em:
                    <strong class="f-semibold"><?= date('d/m/Y', strtotime($subscriber->start_date)) ?></strong>
                </p>
                <p class="text-page f-black f-regular mb-10 j_replacebox">
                    <i class="icon-arrow-down2"></i> Expira em:
                    <strong class="f-semibold j_replace"><?= date('d/m/Y', strtotime($subscriber->end_date)) ?></strong>
                </p>
                <p class="text-page f-black f-regular">
                    <i class="icon-star-empty"></i> Status:
                    <strong class="f-semibold f-green">Ativo</strong>
                </p>
            </div>

            <div class="box-full content-resume-student mb-20">
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
        </div>
    </div>
</div>