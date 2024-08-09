<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-coin-dollar mr-10"></i> Faturas</span>
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
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-50">
    <?php
        if ($invoices):
            $i = 0;
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellpadding="0" cellspacing="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 40px">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 25%">Aluno</td>
                    <td class="tb-field f-semibold f-black">Curso</td>
                    <td class="tb-field f-semibold f-black">Valor</td>
                    <td class="tb-field f-semibold f-black">Método</td>
                    <td class="tb-field f-semibold f-black">Status</td>
                    <td class="tb-field f-semibold f-black">Data</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($invoices as $inv):
                        $i++;
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $i = ($i <= 9 ? '0' . $i : $i);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 40px"><?= $i ?></td>
                            <td class="tb-field f-regular f-black" style="width: 25%"><?= $inv->student_name ?></td>
                            <td class="tb-field f-regular f-black"><?= $inv->course_title ?></td>
                            <td class="tb-field f-regular f-black">R$ <?= Helper::real($inv->price) ?></td>
                            <td class="tb-field f-regular f-black"><?= getTypePayment($inv->method_pay) ?></td>
                            <td class="tb-field f-regular f-black"><?= getStatusPayment($inv->status_pay) ?></td>
                            <td class="tb-field f-regular f-black"><?= date('d/m/Y H:i', strtotime($inv->created_at)) ?></td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/invoices/view/<?= $inv->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Ver fatura"><i class="icon-eye1"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
            <div class="line mt-30 t-right"><?= $paginator ?></div>
        <?php
        else:
            echo error("Ainda não existem faturas geradas na plataforma.", INFO);
        endif;
    ?>
</div>