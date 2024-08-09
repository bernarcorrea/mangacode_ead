<?php
    
    use Source\Support\Helper;
    
    $v->layout('inc/layout');
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
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-layers"></i> Faturas
            </h1>
            <p class="subtitle-page f-light f-primary">Visualize abaixo o seu histórico de faturas e pagamentos na plataforma:</p>
        </div>
    </header>

    <div class="content-invoices mt-50">
        <?php if ($invoices): ?>
        <div class="content-table">
            <table class="table">
                <thead>
                <tr>
                    <th class="tb-field f-semibold f-primary t-upper">#</th>
                    <th class="tb-field f-semibold f-primary t-upper">Título</th>
                    <th class="tb-field f-semibold f-primary t-upper">Método</th>
                    <th class="tb-field f-semibold f-primary t-upper">Valor</th>
                    <th class="tb-field f-semibold f-primary t-upper">Data</th>
                    <th class="tb-field f-semibold f-primary t-upper">Status</th>
                    <th class="tb-field f-semibold f-primary t-upper">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $bg = null;
                    $i = 0;
                    foreach ($invoices as $inv):
                        $i++;
                        $bg = ($bg != 'bg' ? 'bg' : null);
                        $hash = base64_encode("inv=true&invId={$inv->id}");
                        ?>
                        <tr class="<?= $bg ?>">
                            <td class="tb-field f-light f-primary"><?= ($i <= 9 ? '0' . $i : $i) ?></td>
                            <td class="tb-field f-light f-primary"><?= $inv->course_invoice->title ?></td>
                            <td class="tb-field f-light f-primary"><?= getTypePayment($inv->method_pay) ?></td>
                            <td class="tb-field f-light f-primary">R$ <?= Helper::real($inv->price) ?></td>
                            <td class="tb-field f-light f-primary"><?= date('d/m/Y', strtotime($inv->created_at)) ?> às <?= date('H:i', strtotime($inv->created_at)) ?>h</td>
                            <td class="tb-field f-light f-orange"><?= getStatusPayment($inv->status_pay) ?></td>
                            <td class="tb-field f-light f-orange">
                                <a href="<?= HOME ?>/campus/faturas/<?= $hash ?>" class="btn btn-icon-low round btn-orange j_tooltip" title="Visualizar fatura"><i class="icon-eye1"></i></a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                ?>
                </tbody>
            </table>
            <?php
                else:
                    echo "
                        <div class=\"container padding-total-low radius-p bg-secondary flex-container flex-itens-center\">
                            <i class=\"icon-smile f-orange\" style=\"font-size: 40px;\"></i>
                            <div class=\"ml-10\">
                                <p class=\"subtitle-page f-primary f-semibold t-upper mb-5\">Opa, {$student->name}!</p>
                                <p class=\"text-page f-light f-secondary\">
                                    Parece que você ainda não possui nenhuma fatura gerada em nossa plataforma.</p>
                            </div>
                        </div>
                    ";
                endif;
            ?>
        </div>
    </div>
</div>
