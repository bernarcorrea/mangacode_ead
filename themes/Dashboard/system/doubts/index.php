<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-question mr-10"></i> Dúvidas</span>
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
                    <a href="<?= HOME ?>/admin/doubts">Dúvidas</a>
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-50">
    <?php
        if ($doubts):
            $i = 0;
            $color = 'box-silver';
            ?>
            <div class="content-table">
                <table class="table box-full" cellpadding="0" cellspacing="0">
                    <tr class="box-silver">
                        <td class="tb-field f-semibold f-black" style="width: 40px">#</td>
                        <td class="tb-field f-semibold f-black" style="width: 80px">&nbsp;</td>
                        <td class="tb-field f-semibold f-black" style="width: 25%">Aluno</td>
                        <td class="tb-field f-semibold f-black">Aula</td>
                        <td class="tb-field f-semibold f-black">Status</td>
                        <td class="tb-field f-semibold f-black">Atualizado em</td>
                        <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                    </tr>
                    <?php
                        foreach ($doubts as $d):
                            $i++;
                            $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                            $i = ($i <= 9 ? '0' . $i : $i);
                            ?>
                            <tr class="<?= $color ?>">
                                <td class="tb-field f-regular f-black" style="width: 40px"><?= $i ?></td>
                                <td class="tb-field f-regular f-black" style="width: 80px"><?= Helper::image($c->make($d->course->cover, 50, 30), $d->course->title, "img radius-p") ?></td>
                                <td class="tb-field f-regular f-black" style="width: 25%"><?= $d->student->name . ' ' . $d->student->lastname ?></td>
                                <td class="tb-field f-regular f-black"><?= Helper::lmWord($d->class->title, 35) ?></td>
                                <td class="tb-field f-regular f-black"><?= getDoubtStatus($d->status) ?></td>
                                <td class="tb-field f-regular f-black"><?= date('d/m/Y H:i', strtotime($d->updated_at)) ?>h</td>
                                <td class="tb-field f-regular f-black t-right">
                                    <a href="<?= HOME ?>/admin/doubts/view/<?= $d->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Abrir dúvida"><i class="icon-eye1"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </table>
            </div>
            <div class="line mt-30 t-right"><?= $paginator ?></div>
        <?php
        else:
            echo error("Ainda não existem dúvidas na plataforma.", INFO);
        endif;
    ?>
</div>