<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-list2 mr-10"></i> Módulos</span>
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
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/courses" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
            <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>/create" class="btn btn-icon-medio btn-black radius-g j_tooltip" title="Novo módulo"><i class="icon-write"></i></a>
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
                <p class="f-black f-light mb-10">
                    <i class="icon-arrow-right2"></i> <?= $course->segment_title ?>
                </p>
                <a href="<?= HOME ?>/admin/courses/update/<?= $course->id ?>" class="btn btn-medio btn-blue radius-g"><i class="icon-write"></i> Editar curso</a>
            </header>
        </article>
    </div>

    <h3 class="title-page-sec f-semibold f-black mb-20">Módulos do curso:</h3>
    <?php
        if ($modules):
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellspacing="0" cellpadding="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 35px;">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 40%;">Título</td>
                    <td class="tb-field f-semibold f-black">Qtd. de aulas</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($modules as $mod):
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $mod->ord = ($mod->ord <= 9 ? '0' . $mod->ord : $mod->ord);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 35px;"><?= $mod->ord ?></td>
                            <td class="tb-field f-regular f-black" style="width: 40%;"><?= $mod->title ?></td>
                            <td class="tb-field f-regular f-black"><?= ($mod->classes == 0 ? 'Nenhuma' : $mod->classes) . ' ' . ($mod->classes <= 1 ? 'aula' : 'aulas') ?></td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>/update/<?= $mod->id ?>" class="btn btn-icon-low btn-blue j_tooltip round" title="Editar módulo"><i class="icon-write"></i></a>
                                <a href="<?= HOME ?>/admin/classes/<?= $mod->id ?>" class="btn btn-icon-low btn-black j_tooltip round" title="Ver aulas do módulo"><i class="icon-play4"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        <?php
        else:
            echo error("Ainda não existem módulos cadastrados para este curso.", INFO);
        endif;
    ?>
</div>