<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
    $hash = base64_encode("inv=true&invId={$invoice->id}");
?>

<div class="padding-total-normal">
    <header class="header-default flex-container flex-nowrap flex-itens-center flex-justify-space-between">
        <div class="title">
            <nav>
                <ul class="flex-container">
                    <li>
                        <a href="#" class="bg-tertiary f-primary"><?= COMPANY_NAME ?></a>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus" class="bg-tertiary f-primary">Dashboard</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus/faturas" class="bg-tertiary f-primary">Faturas</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus/faturas/<?= $hash ?>" class="bg-tertiary f-primary">Ver fatura</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-layers"></i> Ver fatura
            </h1>
            <p class="subtitle-page f-light f-primary">Visualize abaixo o resumo da sua fatura ou realize o pagamento:</p>
        </div>

        <nav>
            <a href="<?= HOME ?>/campus/faturas" class="btn btn-icon-medio btn-orange round j_tooltip ml-20" title="Voltar"><i class="icon-chevron-left"></i></a>
        </nav>
    </header>

    <div class="content-invoices mt-50 flex-container flex-itens-start">
        <div class="course">
            <div class="photo">
                <?= Helper::image($c->make($course->cover, 400, 250), $course->title, 'img radius-m') ?>
            </div>
            <header class="bg-secondary radius-m mt-10">
                <div class="frame bg-orange"></div>
                <h3 class="f-primary f-semibold mb-10"><?= $course->title ?></h3>
                <p class="f-primary f-light t-upper mb-5">
                    <i class="icon-chevron-right f-orange"></i> Status:
                    <span class="f-secondary f-semibold"><?= getStatusPayment($invoice->status_pay) ?></span>
                </p>
                <p class="f-primary f-light t-upper">
                    <i class="icon-chevron-right f-orange"></i> Valor:
                    <span class="f-secondary f-semibold">R$ <?= Helper::real($invoice->price) ?></span>
                </p>
            </header>
        </div>

        <div class="resume ml-30 padding-total-low radius-p bg-secondary">
            <div class="flex-container flex-wrap">
                <div class="flex flex30 padding-total-low radius-p bg-primary">
                    <small class="small-title f-orange f-semibold t-upper">Cód.</small>
                    <p class="subtitle-page f-primary f-light">#<?= $invoice->cod ?></p>
                </div>

                <div class="flex flex70 padding-total-low radius-p bg-primary">
                    <small class="small-title f-orange f-semibold t-upper">Método de pagamento</small>
                    <?php if ($invoice->method_pay == 'credit_card'): ?>
                        <p class="subtitle-page f-primary f-light">
                            <i class="icon-credit-card1"></i> Cartão de crédito
                        </p>
                    <?php else: ?>
                        <p class="subtitle-page f-primary f-light">
                            <i class="icon-line_weight"></i> Boleto bancário
                        </p>
                    <?php endif; ?>
                </div>
                
                <?php if ($invoice->method_pay == 'credit_card'): ?>
                    <div class="flex flex100 padding-total-low radius-p bg-primary">
                        <small class="small-title f-orange f-semibold t-upper">Qtd. de parcelas</small>
                        <p class="subtitle-page f-primary f-light"><?= $invoice->installments ?>x de R$ <?= Helper::real($invoice->price / $invoice->installments) ?></p>
                    </div>
                <?php
                else:
                    if ($invoice->status_pay == 'billet_printed'):
                        ?>
                        <div class="flex flex100 padding-total-low radius-p bg-primary">
                            <small class="small-title f-orange f-semibold t-upper">Código do boleto</small>
                            <p class="subtitle-page f-primary f-light"><?= $invoice->code_billet ?></p>
                        </div>
                        <div class="flex flex100 padding-total-low radius-p bg-primary">
                            <small class="small-title f-orange f-semibold t-upper">Link do boleto</small>
                            <div class="clear mt-10"></div>
                            <a href="<?= $invoice->link_billet ?>" target="_blank" class="btn btn-low btn-orange radius-g">Imprimir boleto</a>
                        </div>
                    <?php else: ?>
                        <div class="flex flex100 padding-total-low radius-p bg-primary">
                            <small class="small-title f-orange f-semibold t-upper">Código do boleto</small>
                            <p class="subtitle-page f-primary f-light">######## ######## ########</p>
                        </div>
                        <div class="flex flex100 padding-total-low radius-p bg-primary">
                            <small class="small-title f-orange f-semibold t-upper">Link do boleto</small>
                            <div class="clear mt-10"></div>
                            <a href="#" target="_blank" class="btn btn-low bg-black radius-g">Boleto pago ou expirado!</a>
                        </div>
                    <?php
                    endif;
                endif;
                ?>

                <div class="flex flex100 padding-total-low radius-p bg-primary">
                    <small class="small-title f-orange f-semibold t-upper">Data de pagamento</small>
                    <p class="subtitle-page f-primary f-light"><?= date('d/m/Y', strtotime($invoice->payment_date)) ?> às <?= date('H:i', strtotime($invoice->payment_date)) ?>h</p>
                </div>
            </div>
        </div>
    </div>
</div>
