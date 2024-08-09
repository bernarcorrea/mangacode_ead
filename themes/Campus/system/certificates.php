<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
?>

<div class="padding-total-normal">
    <header class="header-default flex-container flex-nowrap flex-itens-center flex-justify-space-between mb-40">
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
                        <a href="<?= HOME ?>/campus/certificados" class="bg-tertiary f-primary">Certificados</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-award"></i> Certificados
            </h1>
            <p class="subtitle-page f-light f-primary">Visualize abaixo todos os seus certificados gerados na plataforma:</p>
        </div>
    </header>

    <div class="container">
        <?php if (!$certificates): ?>
            <div class="container padding-total-low radius-p bg-secondary flex-container flex-itens-center">
                <i class="icon-smile f-orange" style="font-size: 40px;"></i>
                <div class="ml-10">
                    <p class="subtitle-page f-primary f-semibold t-upper mb-5">Opa, <?= $student->name ?>!</p>
                    <p class="text-page f-light f-secondary">
                        Parece que você ainda não possui nenhum certificado gerado em nossa plataforma. </p>
                </div>
            </div>
        <?php else: ?>
            <div class="content-certificates flex-container mt-30">
                <?php
                    foreach ($certificates as $cert):
                        $hash = base64_encode("cert=true&certCode={$cert->cod}");
                        ?>
                        <article class="flex flex25">
                            <div class="photo">
                                <div class="icon f-orange">
                                    <i class="icon-award"></i>
                                </div>
                                <?= Helper::image($c->make($cert->course_certificate->cover, 400, 250), $cert->course_certificate->title, 'img radius-m') ?>
                            </div>
                            <header class="bg-secondary t-center mt-10 radius-m">
                                <div class="frame bg-orange"></div>
                                <h3 class="subtitle-page f-primary f-semibold mb-15"><?= $cert->course_certificate->title ?></h3>
                                <div class="flex-container flex-wrap flex-justify-center mb-20">
                                    <p class="text-page f-secondary mr-10 f-regular">
                                        <i class="icon-check1 f-orange"></i> <?= date('d/m/Y', strtotime($cert->created_at)) ?>
                                    </p>
                                    <p class="text-page f-secondary f-regular">
                                        <i class="icon-key1 f-orange"></i> <?= $cert->cod ?>
                                    </p>
                                </div>
                                <a href="<?= HOME ?>/campus/certificados/<?= $hash ?>" class="btn btn-low btn-orange radius-g"><i class="icon-printer1"></i> Imprimir certificado</a>
                            </header>
                        </article>
                    <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
