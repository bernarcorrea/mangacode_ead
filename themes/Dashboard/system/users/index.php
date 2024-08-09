<?php
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Usuários
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
                    <a href="<?= HOME ?>/admin/users">Usuários</a>
                </li>
            </ul>
        </div>
        
        <nav class="options-default">
            <a href="<?= HOME ?>/admin/users/create" class="btn btn-medio btn-green radius-g"><i class="icon-write mr-5"></i> Novo usuário</a>
        </nav>
    </header>
</div>

<div class="box-full mb-50">
    <table class="table box-full" cellspacing="0" cellpadding="0">
        <tr class="box-silver">
            <td class="tb-field f-semibold f-black t-upper">#</td>
            <td class="tb-field f-semibold f-black t-upper">Nome</td>
            <td class="tb-field f-semibold f-black t-upper">E-mail</td>
            <td class="tb-field f-semibold f-black t-upper">Nível</td>
            <td class="tb-field f-semibold f-black t-upper">&nbsp;</td>
        </tr>
        <?php
            $i = 0;
            $color = 'box-silver';
            foreach ($users as $us):
                $i++;
                $color = ($color == 'box-white' ? 'box-silver' : 'box-white');
                $i = ($i <= 9 ? '0' . $i : $i);
                $nivel = ($us->nivel == 1 ? 'Administrador' : ($us->nivel == 2 ? 'Editor' : 'Atendimento'));
                ?>
                <tr class="<?= $color ?>">
                    <td class="tb-field f-light f-black"><?= $i ?></td>
                    <td class="tb-field f-light f-black"><?= $us->name ?></td>
                    <td class="tb-field f-light f-black"><?= $us->email ?></td>
                    <td class="tb-field f-light f-black"><?= $nivel ?></td>
                    <td class="tb-field f-light f-black j_list t-right">
                        <a href="<?= HOME ?>/admin/users/update/<?= $us->id ?>" class="btn btn-icon-medio btn-blue round"><i class="icon-write"></i></a>
                        <a rel="<?= $us->id ?>" id="users/update/delete" class="btn btn-icon-medio btn-red round j_delete"><i class="icon-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
    </table>
</div>