<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Alunos</span>
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
                    <a href="<?= HOME ?>/admin/students">Alunos</a>
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/students/create" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Novo aluno"><i class="icon-write"></i></a>
        </nav>
    </header>
</div>

<div class="box-full mb-50">
    <?php
        if ($students):
            $i = 0;
            $color = 'box-silver';
            ?>
            <table class="table box-full" cellpadding="0" cellspacing="0">
                <tr class="box-silver">
                    <td class="tb-field f-semibold f-black" style="width: 40px">#</td>
                    <td class="tb-field f-semibold f-black" style="width: 50px">Nome</td>
                    <td class="tb-field f-semibold f-black" style="width: 40%">&nbsp;</td>
                    <td class="tb-field f-semibold f-black">E-mail</td>
                    <td class="tb-field f-semibold f-black">Cadastrado em</td>
                    <td class="tb-field f-semibold f-black t-right">&nbsp;</td>
                </tr>
                <?php
                    foreach ($students as $stud):
                        $i++;
                        $cover = (empty($stud->cover) ? ADMIN . '/images/user.jpg' : $stud->cover);
                        $color = ($color == 'box-silver' ? 'box-white' : 'box-silver');
                        $i = ($i <= 9 ? '0' . $i : $i);
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-regular f-black" style="width: 40px"><?= $i ?></td>
                            <td class="tb-field f-regular f-black" style="width: 45px">
                                <img src="<?= HOME . '/' ?><?= $c->make($cover, 80, 80) ?>" alt="<?= $stud->name . ' ' . $stud->lastname ?>" width="45" class="round">
                            </td>
                            <td class="tb-field f-regular f-black" style="width: 40%"><?= $stud->name . ' ' . $stud->lastname ?></td>
                            <td class="tb-field f-regular f-black"><?= $stud->email ?></td>
                            <td class="tb-field f-regular f-black"><?= date('d/m/Y H:i', strtotime($stud->created_at)) ?>h</td>
                            <td class="tb-field f-regular f-black t-right">
                                <a href="<?= HOME ?>/admin/students/update/<?= $stud->id ?>" class="btn btn-icon-low btn-blue round j_tooltip" title="Editar aluno"><i class="icon-write"></i></a>
                                <a href="<?= HOME ?>/admin/students/history/<?= $stud->id ?>" class="btn btn-icon-low btn-black round j_tooltip" title="Visualizar histórico"><i class="icon-chart"></i></a>
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