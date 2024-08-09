<?php
    $id = (!isset($_SESSION['acesso']) ? $v($id) : $_SESSION['acesso']['id']);
    $name = (!isset($_SESSION['acesso']) ? $v($name) : $_SESSION['acesso']['nome']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?= $v->insert("inc/head") ?>
    <?= $v->insert("js/tiny") ?>
</head>
<body>
<div class="nav-menu-fix box-white">
    <span class="menu-anchor transition j_menu_anchor"><i class="icon-menu"></i></span>
    <nav>
        <?= $v->insert("inc/menu") ?>
    </nav>
</div>

<div class="dashboard-main box-silver">
    <header class="header box-white box-full">
        <span class="menu-anchor transition  j_menu_anchor float_l"><i class="icon-menu"></i></span>
        <h1 class="f-semibold f-black float_l">
            <i class="icon-dashboard mr-5 f-red"></i> <?= COMPANY_NAME ?>
        </h1>
        <nav class="float_r">
            <div class="options float_l on-desktop">
                <a href="<?= HOME ?>" target="_blank" class="btn btn-icon-medio round" title="Ver site"><i class="icon-link1"></i></a>
                <a href="#" class="btn btn-icon-medio round" title="Configurações"><i class="icon-cog2"></i></a>
            </div>
            <div class="user float_r">
                <div class="photo float_l round">
                    <img src="<?= HOME ?>/<?= ADMIN ?>/images/user.jpg" alt="Bernardo Corrêa" class="img round">
                </div>
                <p class="f-regular f-black transition on-desktop">
                    <?= $name ?>
                    <i class="fa fa-angle-down ml-15 f-silver"></i>
                </p>
                <ul>
                    <li>
                        <a href="<?= HOME ?>/admin/users/update/<?= $id ?>"><i class="icon-user2 mr-10"></i> Editar perfil</a>
                    </li>
                    <li>
                        <a href="<?= HOME ?>/admin/users"><i class="icon-users1 mr-10"></i> Usuários</a>
                    </li>
                    <li>
                        <a class="j_logout" id="<?= HOME ?>/admin/logout"><i class="icon-exit mr-10"></i> Sair</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="dashboard box-full padding-total-high">
        <?= $v->section('content') ?>
    </div>
</div>

<div class="mask_modal"></div>
<div class="form_load">
    <div></div>
    <div></div>
</div>
<div class="trigger-box"></div>

</body>
</html>




