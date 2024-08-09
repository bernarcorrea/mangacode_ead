<?php
    
    use Source\Support\Helper;
    
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-list2 mr-10"></i> Segmentos</span>
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
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/courses" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
            <a href="<?= HOME ?>/admin/segments/create" class="btn btn-icon-medio btn-black radius-g j_tooltip" title="Novo segmento"><i class="icon-write"></i></a>
        </nav>
    </header>
</div>

<div class="box-full mb-50">
    <div class="content-serv">
        <?php
            if ($segments):
                foreach ($segments as $seg):
                    ?>
                    <article class="box box25">
                        <div class="box-full padding-total-normal radius-m box-white">
                            <header class="box-full box-white j_list">
                                <a href="<?= HOME ?>/admin/segments/update/<?= $seg->id ?>">
                                    <h1 class="f-bold t-upper mb-10"><?= $seg->title ?></h1>
                                </a>
                                <p class="date f-black f-light t-upper mb-10">
                                    <i class="icon-clock3"></i> Atualizado em <?= date('d/m/Y', strtotime($seg->updated_at)) ?> às <?= date('H:i', strtotime($seg->updated_at)) ?>h
                                </p>

                                <div class="line"></div>
                                <div class="clear"></div>

                                <a href="<?= HOME ?>/admin/segments/update/<?= $seg->id ?>" class="btn btn-icon-medio btn-green round j_tooltip" title="Editar segmento"><i class="icon-write f-white"></i></a>
                                <a rel="<?= $seg->id ?>" id="<?= HOME ?>/admin/segments/delete" class="btn btn-icon-medio btn-red round j_delete j_tooltip" title="Excluir segmento"><i class="icon-trash f-white"></i></a>
                            </header>
                        </div>
                    </article>
                <?php
                endforeach;
            endif;
        ?>
    </div>
</div>