<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    use Source\Models\SiteView;
    
    $c = new Cropper("cache");
    $v->layout('inc/dashboard');
?>
<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-chart1 mr-10"></i> Analytics
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
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-50">
    <div class="content-numbers-resume">
        <article class="box box25">
            <div class="box-full box-white">
                <div class="btn-icon-larg round users">
                    <i class="icon-users1 f-green"></i>
                </div>
                <p class="mt-15 t-center f-bold f-black">
                    <span class="j_count"><?= $numberClients ?></span>
                    <small class="f-semibold">Clientes</small>
                </p>
            </div>
        </article>

        <article class="box box25">
            <div class="box-full box-white">
                <div class="btn-icon-larg round views">
                    <i class="icon-windows1 f-red"></i>
                </div>
                <p class="mt-15 t-center f-bold f-black">
                    <span class="j_count"><?= $numberContracts ?></span>
                    <small class="f-semibold">Contratos ativos</small>
                </p>
            </div>
        </article>

        <article class="box box25">
            <div class="box-full box-white">
                <div class="btn-icon-larg round posts">
                    <i class="icon-coin-dollar f-blue"></i>
                </div>
                <p class="mt-15 t-center f-bold f-black">
                    <span class="j_count"><?= $numberInvoices ?></span>
                    <small class="f-semibold">Faturas vencidas</small>
                </p>
            </div>
        </article>

        <article class="box box25">
            <div class="box-full box-white">
                <div class="btn-icon-larg round msgs">
                    <i class="icon-barcode f-purple"></i>
                </div>
                <p class="mt-15 t-center f-bold f-black">
                    <span class="j_count"><?= $numberBillets ?></span>
                    <small class="f-semibold">Boletos gerados</small>
                </p>
            </div>
        </article>
    </div>
</div>

<div class="box-full mb-20">
    <div class="box box100">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-chart1 mr-10"></i> Últimas Visitas
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Visualize o total de visitas no site dos últimos
                <span class="f-semibold">8 dias</span> através do gráfico abaixo:
            </p>

            <div class="j_chart">
                <canvas id="myChart"></canvas>
            </div>

            <div class="j_chart_2">
                <canvas id="myChart2"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="box-full mb-20">
    <div class="box box100">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-users1 mr-10"></i> Usuários Online
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Visualize os
                <span class="f-semibold">5 usuários online</span> atuais do sistema:
            </p>

            <nav class="options-default box_1">
                <a href="<?= HOME ?>/admin/analytics/usersonline" class="btn btn-medio btn-blue radius-g"><i class="icon-plus2 mr-5"></i> Ver todos</a>
            </nav>

            <div class="content-table">
                <table class="table box100" cellspacing="0" cellpadding="0">
                    <tr class="box-white">
                        <td class="tb-field f-semibold f-black t-upper">Ip</td>
                        <td class="tb-field f-semibold f-black t-upper">Início de sessão</td>
                        <td class="tb-field f-semibold f-black t-upper">Limite de sessão</td>
                        <td class="tb-field f-semibold f-black t-upper">Pagina atual</td>
                        <td class="tb-field f-semibold f-black t-upper">Navegador</td>
                    </tr>
                    <?php
                        $color = 'box-white';
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
                        <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="box-full">
    <div class="box box50 content-last-posts">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-calendar2 mr-10"></i> Visitas por mês
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Quantidade de visitas dos últimos
                <span class="f-semibold">4 meses</span>:
            </p>
            <nav class="options-default box_1 float_r">
                <a href="<?= HOME ?>/admin/analytics/listmonth" class="btn btn-medio btn-red radius-g"><i class="fa fa-filter fa-r1"></i> Filtrar</a>
            </nav>

            <div class="content-status-agent">
                <?php
                    $monthNow = date('n') + 1;
                    for ($m = 0; $m < 4; $m++):
                        $monthNow--;
                        $monthNowZ = ($monthNow <= 9 ? '0' . $monthNow : $monthNow);
                        $viewMonth = 0;
                        
                        $siteView = (new SiteView())->find("month(date) = :m", "m={$monthNowZ}")->fetch(true);
                        if (!$siteView):
                            $viewMonth = 0;
                        else:
                            foreach ($siteView as $s):
                                $viewMonth += $s->views;
                            endforeach;
                        endif;
                        ?>
                        <article class="box100 float_l">
                            <h3 class="small-titulo f-silver t-upper f-semibold">Mês de <?= getMonth("{$monthNowZ}") ?></h3>
                            <div class="status-box">
                                <div class="status-bar other radius-p t-center f-bold f-black t-upper" style="width: 100%"><?= $viewMonth ?> visitas</div>
                            </div>
                        </article>
                    <?php endfor; ?>
            </div>
        </div>
    </div>

    <div class="box box50 content-browsers">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-earth mr-10"></i> Visitas por navegador
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Acompanhe os índices de visitas por navegador:</p>
            
            <?php
                foreach ($browsers as $ag):
                    $agentName = ($ag->name == 'Chrome' ? 'Google Chrome' : ($ag->name == 'Firefox' ? 'Mozilla Firefox' : ($ag->name == 'Internet Explorer' ? 'Internet Explorer' : 'Outros')));
                    $agentIcon = ($ag->name == 'Chrome' ? 'icon-chrome' : ($ag->name == 'Firefox' ? 'icon-firefox' : ($ag->name == 'Internet Explorer' ? 'fa fa-internet-explorer' : 'icon-earth')));
                    $agentColor = ($ag->name == 'Chrome' ? 'chrome' : ($ag->name == 'Firefox' ? 'firefox' : ($ag->name == 'Internet Explorer' ? 'ie' : 'out')));
                    
                    //PORCENTAGEM
                    $percent = substr(($ag->views / $totalViewBrowsers) * 100, 0, 4);
                    ?>
                    <h3 class="f-semibold f-silver t-upper mb-5">
                        <i class="<?= $agentIcon ?>"></i> <?= $agentName ?>
                    </h3>
                    <article class="mb-20 radius-g box-silver <?= $agentColor ?>">
                        <div style="width: <?= $percent ?>%" class="padding-total-low radius-g <?= $agentColor ?>">
                            <p class="f-semibold t-upper f-white t-center"><?= $percent ?>%</p>
                        </div>
                    </article>
                <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    let myChart = document.getElementById('myChart').getContext('2d');
    let myChart2 = document.getElementById('myChart2').getContext('2d');

    // Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 18;
    Chart.defaults.global.defaultFontColor = '#777';

    let massPopChart = new Chart(myChart, {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($graphic as $gp): ?>
                '<?= date('d/m/Y', strtotime($gp->date)) ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Total de Visitas',
                data: [
                    <?php
                    foreach ($graphic as $gp):
                        echo $gp->views . ",";
                    endforeach;
                    ?>
                ],
                backgroundColor: ['rgba(255, 99, 132, 0.6)'],
                borderWidth: 1,
                borderColor: '#777',
                hoverBorderWidth: 3,
                hoverBorderColor: '#000',
            }]
        },
        options: {
            title: {
                display: false
            },
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        fontSize: 12
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontSize: 12
                    }
                }]
            }
        }
    });

    let massPopChart2 = new Chart(myChart2, {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($graphic as $gp): ?>
                '<?= date('d/m/Y', strtotime($gp->date)) ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Total de Visitas',
                data: [
                    <?php
                    foreach ($graphic as $gp):
                        echo $gp->views . ",";
                    endforeach;
                    ?>
                ],
                backgroundColor: ['rgba(255, 99, 132, 0.6)'],
                borderWidth: 1,
                borderColor: '#777',
                hoverBorderWidth: 3,
                hoverBorderColor: '#000',
            }]
        },
        options: {
            title: {
                display: false
            },
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    }
                }]
            }
        }
    });
</script>