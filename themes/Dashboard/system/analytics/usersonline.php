<?php
    
    use Source\Support\Helper;
    
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Usuários Online
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
                    <a href="<?= HOME ?>/admin/analytics">Analytics</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/analytics/usersonline">Usuários Online</a>
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
        <div class="content-table">
            <table class="table box100" cellpadding="0" cellspacing="0">
                <?php
                    $color = 'box-silver';
                    if ($lastUserOnline):
                        ?>
                        <tr class="box-silver">
                            <td class="tb-field f-semibold f-black t-upper">Ip</td>
                            <td class="tb-field f-semibold f-black t-upper">Início de sessão</td>
                            <td class="tb-field f-semibold f-black t-upper">Limite de sessão</td>
                            <td class="tb-field f-semibold f-black t-upper">Pagina atual</td>
                            <td class="tb-field f-semibold f-black t-upper">Navegador</td>
                        </tr>
                        <?php
                        foreach ($lastUserOnline as $users):
                            $color = ($color == 'box-white' ? 'box-silver' : 'box-white');
                            $arr = explode('/', $users->url);
                            $UrlOnline = (isset($arr[3]) ? '/' . $arr[2] . '/' . $arr[3] : (isset($arr[2]) ? '/' . $arr[1] . '/' . $arr[2] : '/' . $arr[1]));
                            ?>
                            <tr class="<?= $color ?>">
                                <td class="tb-field f-light f-black"><?= $users->ip ?></td>
                                <td class="tb-field f-light f-black"><?= date('d/m/Y H:i', strtotime($users->startview)) ?>h</td>
                                <td class="tb-field f-light f-black"><?= date('d/m/Y H:i', strtotime($users->endview)) ?>h</td>
                                <td class="tb-field f-light f-black"><?= Helper::lmWord($UrlOnline, 40) ?></td>
                                <td class="tb-field f-light f-black"><?= $users->name ?></td>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                ?>
            </table>
        </div>
    </div>
</div></div>