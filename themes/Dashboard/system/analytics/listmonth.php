<?php
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-calendar2 mr-10"></i> Visitas por mês
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
                    <a href="<?= HOME ?>/admin/analytics">Dashboard</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/analytics/listmonth">Visitas por mês</a>
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/analytics" class="btn btn-icon-medio btn-blue round"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <div class="box box100">
        <h2 class="f-black f-bold title-page t-upper mb-10">Mês de <?= getMonth("{$monthNow}") ?></h2>
        <p class="f-silver f-regular subtitle-page">Abaixo você poderá conferir mais detalhes de acesso no mês de <?= getMonth("{$monthNow}") ?>:</p>

        <div class="options-default">
            <form action="" method="post">
                <div class="select">
                    <select name="search" required class="select-larg box-white" onchange="this.form.submit()">
                        <option value="">Selecione um Mês</option>
                        <?php
                            for ($i = 1; $i < count(getMonth()); $i++):
                                $i = ($i <= 9 ? "0" . $i : $i);
                                echo "<option value=\"{$i}\">" . getMonth($i) . "</option>";
                            endfor;
                        ?>
                    </select>
                </div>
            </form>
        </div>

        <div class="box-full mt-20">
            <div class="content-numbers-resume">
                <article class="box box50">
                    <div class="box-full box-white">
                        <div class="btn-icon-larg round views">
                            <i class="icon-eye2 f-red"></i>
                        </div>
                        <p class="mt-15 t-center f-bold f-black">
                            <span class="j_count"><?= $totalView ?></span>
                            <small class="f-semibold">Total de visitas</small>
                        </p>
                    </div>
                </article>

                <article class="box box50">
                    <div class="box-full box-white">
                        <div class="btn-icon-larg round posts">
                            <i class="icon-windows1 f-blue"></i>
                        </div>
                        <p class="mt-15 t-center f-bold f-black">
                            <span class="j_count"><?= $totalPages ?></span>
                            <small class="f-semibold">Total de Páginas</small>
                        </p>
                    </div>
                </article>
            </div>

            <div class="line mb-20"></div>
            <div class="clear"></div>

            <h2 class="f-black f-bold title-page-sec t-upper">Detalhes por dia</h2>

            <table class="table box-full mt-10" cellpadding="0" cellspacing="0">
                <?php
                    $color = 'box-silver';
                    if ($views):
                        ?>
                        <tr class="box-silver t-upper">
                            <td class="f-bold f-black tb-field">Dia do Mês</td>
                            <td class="f-bold f-black tb-field">Total de Visitas</td>
                            <td class="f-bold f-black tb-field">Qtd. de Páginas</td>
                        </tr>
                        <?php
                        foreach ($views as $vs):
                            $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                            ?>
                            <tr class="<?= $color ?>">
                                <td class="f-light f-black tb-field"><?= date('d/m/Y', strtotime($vs->date)) ?></td>
                                <td class="f-light f-black tb-field"><?= $vs->views ?></td>
                                <td class="f-light f-black tb-field"><?= $vs->pages ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                ?>
            </table>
        </div>
    </div>
</div>