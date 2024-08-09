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
            <i class="icon-coin-dollar mr-10"></i> Ver fatura
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
                    <a href="<?= HOME ?>/admin/invoices">Faturas</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/invoices/view/<?= $invoice->id ?>">Ver fatura</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/invoices" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
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
            <?php if ($invoice): ?>
                <div class="box box100">
                    <p class="text-page f-black f-light t-upper">Código:<br>
                        <strong class="f-semibold">#<?= $invoice->cod ?></strong>
                    </p>
                </div>

                <div class="box box33">
                    <p class="text-page f-black f-light t-upper">Valor:<br>
                        <strong class="f-semibold">R$ <?= Helper::real($invoice->price) ?></strong>
                    </p>
                </div>

                <div class="box box33">
                    <p class="text-page f-black f-light t-upper">Gerado em:<br>
                        <strong class="f-semibold"><?= date('d/m/Y H:i', strtotime($invoice->created_at)) ?>h</strong>
                    </p>
                </div>

                <div class="box box33">
                    <p class="text-page f-black f-light t-upper">Pago em:<br>
                        <strong class="f-semibold"><?= date('d/m/Y H:i', strtotime($invoice->payment_date)) ?>h</strong>
                    </p>
                </div>

                <div class="box box33">
                    <p class="text-page f-black f-light t-upper">Método de pgto.:<br>
                        <strong class="f-semibold"><?= getTypePayment($invoice->method_pay) ?></strong>
                    </p>
                </div>
                
                <?php if ($invoice->method_pay == 1): ?>
                    <div class="box box65">
                        <p class="text-page f-black f-light t-upper">Qtd. de parcelas<br>
                            <strong class="f-semibold"><?= $invoice->installments ?>x de R$ <?= Helper::real($invoice->price / $invoice->installments) ?></strong>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="box box65">
                        <p class="text-page f-black f-light t-upper">Cód. do boleto<br>
                            <strong class="f-semibold"><?= $invoice->code_billet ?></strong>
                        </p>
                    </div>
                <?php endif; ?>
            
            <?php endif; ?>
        </div>
    </div>

    <div class="box box30">
        <div class="box-full">
            <h3 class="title-page-sec f-black f-semibold mb-20">Status:</h3>
            <div class="box-full padding-total-normal box-white radius-m mb-20">
                <p class="title-page-sec f-black f-semibold mb-10 j_replacebox"><span class="j_replace"><?= getStatusPayment($invoice->status_pay) ?></span></p>
                <a rel="status" class="btn btn-low btn-blue radius-g btn_modal"><i class="icon-write"></i> Alterar status</a>
            </div>

            <h3 class="title-page-sec f-black f-semibold mb-20">Curso:</h3>
            <div class="box-full padding-total-normal box-white radius-m mb-20">
                <h3 class="subtitle-page f-semibold f-black t-upper mb-10"><?= $course->title ?></h3>

                <p class="text-page f-black f-light mb-5">
                    <i class="icon-list2"></i> Segmento:
                    <b class="f-semibold"><?= $segment->title ?></b>
                </p>
                <p class="text-page f-black f-light">
                    <i class="icon-user1"></i> Tutor:
                    <b class="f-semibold"><?= $tutor->name ?></b>
                </p>
                <a href="<?= HOME ?>/admin/courses/update/<?= $course->id ?>" class="btn btn-low btn-blue radius-g mt-10"><i class="icon-write"></i> Editar curso</a>
            </div>
        </div>
    </div>
</div>

<div class="content-modal">
    <div class="modal" id="status" style="display: none;">
        <span class="btn btn-icon-medio btn-red round close_modal"><i class="icon-x"></i></span>
        <div class="box-full padding-total-normal box-white radius-m">
            <h2 class="title-page-sec f-black f-semibold mb-30">Editar status de pagamento:</h2>

            <div class="box-full padding-total-normal box-silver radius-m mb-20">
                <div class="box-full padding-total-low radius-m box-white mb-20">
                    <h3 class="subtitle-page f-black f-semibold mb-5"><?= $course->title ?></h3>
                    <p class="text-page f-black f-light mb-5">Aluno: <?= $student->name . ' ' . $student->lastname ?></p>
                    <p class="text-page f-black f-light">Status: <span class="j_replacebox"><span class="j_replace"><?= getStatusPayment($invoice->status_pay) ?></span></span></p>
                </div>

                <form action="" method="post" class="j_formajax">
                    <input type="hidden" name="callback" value="<?= HOME ?>/admin/invoices/status" class="noclear">
                    <input type="hidden" name="id" value="<?= $invoice->id ?>" class="noclear">

                    <label class="mt-10">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Alterar status</small>
                        <div class="select">
                            <select name="status_pay" class="select-larg">
                                <option value="<?= $invoice->status_pay ?>" selected>&raquo; <?= getStatusPayment($invoice->status_pay) ?></option>
                                <?php
                                    foreach (getStatusPayment() as $k => $v):
                                        echo "<option value='{$k}'>{$v}</option>";
                                    endforeach;
                                ?>
                            </select>
                        </div>
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