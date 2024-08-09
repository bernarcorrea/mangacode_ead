<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-drawer2 mr-10"></i> Assinaturas</span>
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
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-50">
    <?php
        if ($subscribers):
            $i = 0;
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellpadding="0" cellspacing="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 40px">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 25%">Aluno</td>
                    <td class="tb-field f-semibold f-black">Curso</td>
                    <td class="tb-field f-semibold f-black">Início</td>
                    <td class="tb-field f-semibold f-black">Fim</td>
                    <td class="tb-field f-semibold f-black">Status</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($subscribers as $sub):
                        $i++;
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $i = ($i <= 9 ? '0' . $i : $i);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 40px"><?= $i ?></td>
                            <td class="tb-field f-regular f-black" style="width: 25%"><?= $sub->student_name ?></td>
                            <td class="tb-field f-regular f-black"><?= $sub->course_title ?></td>
                            <td class="tb-field f-regular f-black"><?= date('d/m/Y', strtotime($sub->start_date)) ?></td>
                            <td class="tb-field f-regular f-black"><?= date('d/m/Y', strtotime($sub->end_date)) ?></td>
                            <td class="tb-field f-regular f-black"><?= getSubscriberStatus($sub->status) ?></td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/subscribers/view/<?= $sub->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Ver assinatura"><i class="icon-eye1"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
            <div class="line mt-30 t-right"><?= $paginator ?></div>
        <?php
        else:
            echo error("Ainda não existem assinaturas cadastradas na plataforma.", INFO);
        endif;
    ?>
</div>