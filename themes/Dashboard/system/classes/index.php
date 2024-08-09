<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-play4 mr-10"></i> Aulas</span>
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
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
            <a href="<?= HOME ?>/admin/classes/<?= $module->id ?>/create" class="btn btn-icon-medio btn-black radius-g j_tooltip" title="Nova aula"><i class="icon-write"></i></a>
        </nav>
    </header>
</div>

<div class="box-full mb-50">
    <div class="content-resume-course">
        <article class="box-full padding-total-low radius-m box-white mb-20">
            <div class="photo float_l">
                <?= Helper::image($c->make($course->cover, 800, 500), $course->title, "img radius-m") ?>
            </div>
            <header>
                <h1 class="f-black f-semibold mb-5"><?= $course->title ?></h1>
                <p class="f-black f-light mb-5">
                    <i class="icon-arrow-right2"></i> <?= $course->segment_title ?>
                </p>
                <p class="f-black f-light mb-10">
                    <i class="icon-list2"></i> Módulo: <?= $module->title ?>
                </p>
                <a href="<?= HOME ?>/admin/courses/update/<?= $course->id ?>" class="btn btn-medio btn-blue radius-g"><i class="icon-write"></i> Editar curso</a>
                <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>/update/<?= $module->id ?>" class="btn btn-medio btn-black radius-g"><i class="icon-write"></i> Editar módulo</a>
            </header>
        </article>
    </div>

    <h3 class="title-page-sec f-semibold f-black mb-20">Aulas do módulo:</h3>
    <?php
        if ($classes):
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellspacing="0" cellpadding="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 35px;">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 80px;">Título</td>
                    <td class="tb-field f-semibold f-black" style="width: 40%;">&nbsp;</td>
                    <td class="tb-field f-semibold f-black">Dificuldade</td>
                    <td class="tb-field f-semibold f-black">Tempo</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($classes as $class):
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $class->ord = ($class->ord <= 9 ? '0' . $class->ord : $class->ord);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 35px;"><?= $class->ord ?></td>
                            <td class="tb-field f-regular f-black" style="width: 80px;">
                                <img src="<?= HOME ?>/<?= $c->make($class->cover, 500, 350) ?>" width="70" class="radius-m">
                            </td>
                            <td class="tb-field f-regular f-black" style="width: 40%;"><?= $class->title ?></td>
                            <td class="tb-field f-regular f-black"><?= ($class->level == 1 ? '<i class="icon-star-empty"></i>' : ($class->level == 2 ? '<i class="icon-star-half"></i>' : '<i class="icon-star-full"></i>')) . ' ' . getLevel($class->level) ?></td>
                            <td class="tb-field f-regular f-black"><?= $class->time ?> min</td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/classes/<?= $module->id ?>/update/<?= $class->id ?>" class="btn btn-icon-low btn-blue j_tooltip round" title="Editar aula"><i class="icon-write"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        <?php
        else:
            echo error("Ainda não existem aulas cadastradas para este módulo do curso.", INFO);
        endif;
    ?>
</div>