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
            <i class="icon-drawer2 mr-10"></i> Ver assinatura
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
                    <a href="<?= HOME ?>/admin/subscribers">Assinaturas</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/subscribers/view/<?= $subscriber->id ?>">Ver assinatura</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/subscribers" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <div class="box box70">
        <h3 class="title-page-sec f-black f-semibold mb-20">Dados do aluno:</h3>
        <div class="box-full padding-total-normal box-white radius-m mb-20">
            <div class="box box100">
                <p class="text-page f-black f-light t-upper">Nome:<br>
                    <strong class="f-semibold"><?= $student->name . ' ' . $student->lastname ?></strong>
                </p>
            </div>

            <div class="box box50">
                <p class="text-page f-black f-light t-upper">E-mail:<br>
                    <strong class="f-semibold"><?= $student->email ?></strong>
                </p>
            </div>

            <div class="box box50">
                <p class="text-page f-black f-light t-upper">CPF:<br>
                    <strong class="f-semibold"><?= $student->document ?></strong>
                </p>
            </div>

            <a href="<?= HOME ?>/admin/students/update/<?= $student->id ?>" class="btn btn-medio btn-blue radius-g mt-10"><i class="icon-write"></i> Editar aluno</a>
        </div>

        <h3 class="title-page-sec f-black f-semibold mb-20">Resumo da fatura:</h3>
        <div class="box-full padding-total-normal box-white radius-m mb-20">
            <?php if ($invoices): ?>
                <table class="table box-full" cellspacing="0" cellpadding="0">
                    <tr class="box-white">
                        <td class="tb-field f-semibold f-black" style="width: 30px;">#</td>
                        <td class="tb-field f-semibold f-black" style="width: 27%">Curso</td>
                        <td class="tb-field f-semibold f-black">Valor</td>
                        <td class="tb-field f-semibold f-black">Método</td>
                        <td class="tb-field f-semibold f-black">Status</td>
                        <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                    </tr>
                    <?php
                        $color = 'box-white';
                        $i = 0;
                        foreach ($invoices as $inv):
                            $i++;
                            $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                            $i = ($i <= 9 ? '0' . $i : $i);
                            ?>
                            <tr class="<?= $color ?>">
                                <td class="tb-field f-semibold f-black" style="width: 30px;"><?= $i ?></td>
                                <td class="tb-field f-regular f-black" style="width: 27%;"><?= $course->title ?></td>
                                <td class="tb-field f-regular f-black">R$ <?= Helper::real($inv->price) ?></td>
                                <td class="tb-field f-regular f-black"><?= getTypePayment($inv->method_pay) ?></td>
                                <td class="tb-field f-regular f-black"><?= getStatusPayment($inv->status_pay) ?></td>
                                <td class="tb-field f-regular f-black t-right">
                                    <a href="<?= HOME ?>/admin/invoices/view/<?= $inv->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Visualizar fatura"><i class="icon-eye1"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </table>
            <?php
            else:
                echo error("Ainda não existem faturas cadastradas para essa assinatura.", INFO);
            endif;
            ?>
        </div>

        <h3 class="title-page-sec f-black f-semibold mb-20">Histórico de aulas:</h3>
        <div class="box-full padding-total-normal box-white radius-m mb-20">
            <?php if ($statusClass): ?>
                <table class="table box-full" cellspacing="0" cellpadding="0">
                    <tr class="box-white">
                        <td class="tb-field f-semibold f-black" style="width: 30px;">#</td>
                        <td class="tb-field f-semibold f-black" style="width: 40%">Aula</td>
                        <td class="tb-field f-semibold f-black">Data</td>
                        <td class="tb-field f-semibold f-black">Status</td>
                    </tr>
                    <?php
                        $color = 'box-white';
                        $i = 0;
                        foreach ($statusClass as $st):
                            $i++;
                            $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                            $i = ($i <= 9 ? '0' . $i : $i);
                            ?>
                            <tr class="<?= $color ?>">
                                <td class="tb-field f-semibold f-black" style="width: 30px;"><?= $i ?></td>
                                <td class="tb-field f-regular f-black" style="width: 40%;"><?= Helper::lmWord($st->class_title, 30) ?></td>
                                <td class="tb-field f-regular f-black"><?= date('d/m/Y H:i', strtotime($st->updated_at)) ?>h</td>
                                <td class="tb-field f-regular f-black"><?= getStatusClass($st->status) ?></td>
                            </tr>
                        <?php endforeach; ?>
                </table>
            <?php
            else:
                echo error("Ainda não existem faturas cadastradas para essa assinatura.", INFO);
            endif;
            ?>

            <a href="<?= HOME ?>/admin/students/progress/<?= $student->id ?>/course/<?= $course->id ?>" class="btn btn-medio btn-blue radius-g mt-20"><i class="icon-eye1"></i> Visualizar andamento</a>
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

                <a rel="validate" class="btn btn-low btn-blue radius-g mt-20 btn_modal"><i class="icon-write"></i> Editar validade</a>
            </div>

            <div class="box-full padding-total-normal box-white radius-m">
                <p class="text-page f-black f-regular mb-5">
                    <i class="icon-chart1"></i> Andamento do aluno:
                </p>
                <div class="progress-bar radius-p box-silver">
                    <div class="bar box-green radius-p f-bold f-black" style="width: <?= courseProgress($course->id, $student->id) ?>%"><?= courseProgress($course->id, $student->id) ?>%</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-modal">
    <div class="modal" id="validate" style="display: none;">
        <span class="btn btn-icon-medio btn-red round close_modal"><i class="icon-x"></i></span>
        <div class="box-full padding-total-normal box-white radius-m">
            <h2 class="title-page-sec f-black f-semibold mb-30">Editar validade</h2>

            <div class="box-full padding-total-normal box-silver radius-m mb-20">
                <h3 class="subtitle-page f-black f-semibold mb-10"><?= $course->title ?></h3>

                <div class="box box100 box-white radius-g mb-10" style="border: 1px solid #f0f0f0">
                    <p class="text-page f-black f-regular">
                        <i class="icon-user1"></i> Aluno:
                        <strong class="f-semibold"><?= $student->name . ' ' . $student->lastname ?></strong>
                    </p>
                </div>
                <div class="box box-white radius-g mr-20" style="border: 1px solid #f0f0f0">
                    <p class="text-page f-black f-regular">
                        <i class="icon-arrow-up2"></i> Iniciou em:
                        <strong class="f-semibold "><?= date('d/m/Y', strtotime($subscriber->start_date)) ?></strong>
                    </p>
                </div>
                <div class="box box-white radius-g" style="border: 1px solid #f0f0f0">
                    <p class="text-page f-black f-regular j_replacebox">
                        <i class="icon-arrow-down2"></i> Expira em:
                        <strong class="f-semibold j_replace"><?= date('d/m/Y', strtotime($subscriber->end_date)) ?></strong>
                    </p>
                </div>

                <form action="" method="post" class="j_formajax">
                    <input type="hidden" name="callback" value="<?= HOME ?>/admin/subscribers/validate" class="noclear">
                    <input type="hidden" name="id" value="<?= $subscriber->id ?>" class="noclear">
                    
                    <label class="box box100 mt-10">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Nova validade</small>
                        <input type="text" name="end_date" class="form input-form-larg datepicker" autocomplete="off" placeholder="dd/mm/aaaa">
                    </label>
                    <div class="box box100 t-right">
                        <button class="btn btn-medio btn-green radius-g">
                            <i class="icon-checkmark"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>