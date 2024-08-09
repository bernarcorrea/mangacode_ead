<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $studentName = (!empty($_SESSION['campusmanga']['name']) ? $_SESSION['campusmanga']['name'] : 'Não identificado');
    $studentId = (!empty($_SESSION['campusmanga']['id']) ? $_SESSION['campusmanga']['id'] : 0);
    $studentCover = (!empty($_SESSION['campusmanga']['cover']) ? $_SESSION['campusmanga']['cover'] : CAMPUS . '/images/user.jpg');
    
    $c = new Cropper("cache");
?>

<!doctype html>
<html lang="pt-br">
<head>
    <?= $v->insert('inc/head'); ?>
    <?= $v->insert("js/tiny") ?>
</head>
<body class="<?= (isset($_SESSION['theme_user']) ? $_SESSION['theme_user'] : null); ?>">
<div class="trigger-box"></div>
<div class="trigger-result"></div>
<div class="mask_modal"></div>
<div class="load_modal">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>

<div class="dashboard">
    <div class="dashboard-nav-fix transition bg-tertiary flex-container flex-direction-column flex-justify-space-between">
        <div class="profile round transition">
            <div class="status round"></div>
            <div class="img">
                <?= Helper::image($c->make($studentCover, 500, 500), $studentName, 'img round') ?>
                <div class="title">
                    <h2 class="f-primary f-light t-upper">Olá, <strong class="f-semibold"><?= $studentName ?>!</strong></h2>
                </div>
            </div>

            <nav class="profile-submenu">
                <div class="arrow bg-tertiary"></div>
                <ul class="flex-container flex-direction-column bg-tertiary radius-p">
                    <li>
                        <a href="<?= HOME ?>/campus/minha-conta" class="f-primary"><i class="icon-user1 mr-5"></i> Minha conta</a>
                    </li>
                    <li>
                        <a href="<?= HOME ?>/campus/alterar-senha" class="f-primary"><i class="icon-lock mr-5"></i> Alterar senha</a>
                    </li>
                    <li>
                        <!--
                        <a class="f-primary j_change_theme" id="<?= HOME ?>/campus/changetheme">
                            <i class="icon-weather-sunny mr-5"></i> Tema escuro
                            <?php
//                                if (isset($_SESSION['theme_user'])):
//                                    if ($_SESSION['theme_user'] == 'dark'):
//                                        echo "<i class=\"icon-toggle-right f-orange ml-5\" style=\"font-size: 15px;\"></i>";
//                                    else:
//                                        echo "<i class=\"icon-toggle-left f-secondary ml-5\" style=\"font-size: 15px;\"></i>";
//                                    endif;
//                                else:
//                                    echo "<i class=\"icon-toggle-right f-orange ml-5\" style=\"font-size: 15px;\"></i>";
//                                endif;
                            ?>
                        </a>
                        -->
                    </li>
                </ul>
            </nav>
        </div>

        <nav class="dashboard-nav">
            <?= $v->insert('inc/menu'); ?>
        </nav>

        <div class="dashboard-logout round">
            <a class="j_logout" id="<?= HOME ?>/campus/logout" style="cursor: pointer;"><i class="icon-log-out"></i><p>Sair</p></a>
        </div>
    </div>

    <div class="dashboard-main transition bg-primary">
        <div class="dashboard-header-mobile bg-tertiary radius-g flex-justify-space-between">
            <div class="profile transition">
                <div class="img">
                    <?= Helper::image($c->make($studentCover, 500, 500), $studentName, 'img round') ?>
                </div>
            </div>
            
            <div class="menu">
                <span class="menu-anchor btn-orange j_menu_anchor round"><i class="icon-menu"></i></span>
            </div>
        </div>
        
        <?= $v->section('content'); ?>
    </div>
</div>
</body>
</html>
