<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-trophy1 mr-10"></i> Certificados</span>
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
                    <a href="<?= HOME ?>/admin/certificates">Certificados</a>
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-50">
    <?php
        if ($certificates):
            $i = 0;
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellpadding="0" cellspacing="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 40px">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 50px">Nome</td>
                    <td class="tb-field f-semibold f-black" style="width: 30%">&nbsp;</td>
                    <td class="tb-field f-semibold f-black">Cursos</td>
                    <td class="tb-field f-semibold f-black">Cód.</td>
                    <td class="tb-field f-semibold f-black">Gerado em</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($certificates as $cert):
                        $i++;
                        $cover = (empty($cert->student->cover) ? ADMIN . '/images/user.jpg' : $cert->student->cover);
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $i = ($i <= 9 ? '0' . $i : $i);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 40px"><?= $i ?></td>
                            <td class="tb-field f-regular f-black" style="width: 45px">
                                <img src="<?= HOME . '/' ?><?= $c->make($cover, 80, 80) ?>" alt="<?= $cert->student->name . ' ' . $cert->student->lastname ?>" width="45" class="round">
                            </td>
                            <td class="tb-field f-regular f-black" style="width: 30%"><?= $cert->student->name . ' ' . $cert->student->lastname ?></td>
                            <td class="tb-field f-regular f-black"><?= Helper::lmWord($cert->course->title, 40) ?></td>
                            <td class="tb-field f-regular f-black"><?= $cert->cod ?></td>
                            <td class="tb-field f-regular f-black"><?= date('d/m/Y H:i', strtotime($cert->created_at)) ?>h</td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/certificates/view/<?= $cert->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Ver detalhes"><i class="icon-eye1"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
            <div class="line mt-30 t-right"><?= $paginator ?></div>
        <?php
        else:
            echo error("Ainda não existem certificados gerados na plataforma.", INFO);
        endif;
    ?>
</div>