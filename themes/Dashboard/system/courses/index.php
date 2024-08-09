<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-book1 mr-10"></i> Cursos</span>
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
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/courses/create" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Novo curso"><i class="icon-write"></i></a>
            <a href="<?= HOME ?>/admin/segments" class="btn btn-icon-medio btn-black radius-g j_tooltip" title="Segmentos"><i class="icon-list2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full mb-50">
    <div class="box box33">
        <form action="" method="post" class="j_formajax">
            <input type="hidden" name="callback" value="contracts/filter">
            <div class="box-form">
                <div class="select">
                    <select name="status" class="select-medio">
                        <option value="" selected disabled>Filtre por Status</option>
                        <option value="1">Contratos ativos</option>
                        <option value="0">Contratos inativos</option>
                    </select>
                </div>
                <button class="btn btn-icon-larg btn-green round">
                    <i class="icon-filter"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="box box33">
        <form action="" method="post" class="j_formajax">
            <input type="hidden" name="callback" value="contracts/search">
            <div class="box-form">
                <div class="select">
                    <select name="client" class="select-medio">
                        <option value="" selected disabled>Filtre por Cliente</option>
                        <?php foreach ($clients as $c): ?>
                            <option value="<?= $c->id ?>"><?= $c->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-icon-larg btn-green round">
                    <i class="icon-filter"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="content-serv mt-20">
        <div class="j_replacebox">
            <div class="j_replace">
                <?php
                    if ($courses):
                        foreach ($courses as $course):
                            $color = ($course->status == 1 ? '4ece53' : 'ef3735');
                            ?>
                            <article class="box box25">
                                <div class="box-full padding-total-normal radius-m box-white" style="border-bottom: 8px solid #<?= $color ?>;">
                                    <?= Helper::image($c->make($course->cover, 800, 500), $course->title, "img radius-m") ?>
                                    
                                    <header class="box-full box-white j_list mt-20">
                                        <a href="<?= HOME ?>/admin/courses/update/<?= $course->id ?>">
                                            <h1 class="f-bold t-upper mb-20"><?= $course->title ?></h1>
                                        </a>
                                        <p class="date f-black f-light t-upper">
                                            <i class="icon-user1"></i> Segmento:
                                            <b class="f-bold"><?= $course->segment->title ?></b>
                                        </p>
                                        <p class="date f-black f-light t-upper">
                                            <i class="icon-user1"></i> Tutor:
                                            <b class="f-bold"><?= $course->tutor->name ?></b>
                                        </p>
                                        <p class="date f-black f-light t-upper mb-20">
                                            <i class="icon-clock3"></i> Atualizado em <?= date('d/m/Y', strtotime($course->updated_at)) ?> às <?= date('H:i', strtotime($course->updated_at)) ?>h
                                        </p>

                                        <div class="line mt-10"></div>
                                        <div class="clear"></div>

                                        <a href="<?= HOME ?>/admin/courses/update/<?= $course->id ?>" class="btn btn-icon-medio btn-green round j_tooltip" title="Editar curso"><i class="icon-write f-white"></i></a>
                                        <a href="<?= HOME ?>/admin/modules/<?= $course->id ?>" class="btn btn-icon-medio btn-blue round j_tooltip" title="Ver módulos"><i class="icon-list2 f-white"></i></a>
                                        <a rel="<?= $course->id ?>" id="<?= HOME ?>/admin/courses/delete" class="btn btn-icon-medio btn-red round j_delete j_tooltip" title="Excluir curso"><i class="icon-trash f-white"></i></a>
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
</div>