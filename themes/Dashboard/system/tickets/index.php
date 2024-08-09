<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-comment-alt2-stroke mr-10"></i> Tickets</span>
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
                    <a href="<?= HOME ?>/admin/tickets">Tickets</a>
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-50">
    <?php
        if ($tickets):
            $i = 0;
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellpadding="0" cellspacing="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 40px">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 50px">Assunto</td>
                    <td class="tb-field f-semibold f-black">Aluno</td>
                    <td class="tb-field f-semibold f-black">Prioridade</td>
                    <td class="tb-field f-semibold f-black">Status</td>
                    <td class="tb-field f-semibold f-black">Atualizado em</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($tickets as $t):
                        $i++;
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $i = ($i <= 9 ? '0' . $i : $i);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 40px"><?= $i ?></td>
                            <td class="tb-field f-regular f-black" style="width: 25%"><?= Helper::lmWord($t->title, 35) ?></td>
                            <td class="tb-field f-regular f-black"><?= $t->student_name ?></td>
                            <td class="tb-field f-regular f-black"><?= getTicketPriority($t->priority) ?></td>
                            <td class="tb-field f-regular f-black"><?= getTicketStatus($t->status) ?></td>
                            <td class="tb-field f-regular f-black"><?= date('d/m/Y H:i', strtotime($t->updated_at)) ?>h</td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/tickets/view/<?= $t->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Abrir ticket"><i class="icon-eye1"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
            <div class="line mt-30 t-right"><?= $paginator ?></div>
        <?php
        else:
            echo error("Ainda não existem alunos cadastrados na plataforma.", INFO);
        endif;
    ?>
</div>