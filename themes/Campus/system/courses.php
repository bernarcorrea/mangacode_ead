<?php
    
    use CoffeeCode\Cropper\Cropper;
    use Source\Support\Helper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
?>

<section class="container">
    <div class="content-welcome courses">
        <?php
            if ($subscribers):
                $i = 0;
                foreach ($subscribers as $sub):
                    $i++;
                    if ($i == 1):
                        $subtitle = (isset($sub->lastclass) ? "Continue assistindo a aula <span class='f-orange f-semibold'>{$sub->lastclass->title}</span>" : $sub->lastcourse->subtitle);
                        $cover = (isset($sub->lastclass) ? $sub->lastclass->cover : $sub->lastcourse->cover);
                        ?>
                        <article class="wall" style="background-image: url(<?= HOME ?>/<?= $cover ?>)">
                            <div class="cover"></div>
                            <div class="frame shadow-title"></div>
                            <div class="description">
                                <header>
                                    <?php if (isset($sub->lastclass)): ?>
                                        <p class="f-white f-light mb-20 on-desktop">Você estava assistindo o curso de:
                                            <br><span class="f-semibold f-orange"><?= $sub->lastcourse->title ?></span>
                                        </p>
                                        <p class="f-white f-regular">Continue assistindo a aula</p>
                                        <h2 class="f-white f-semibold mb-20"><?= $sub->lastclass->title ?></h2>
                                    <?php else: ?>
                                        <h2 class="f-white f-semibold mb-20"><?= $sub->lastcourse->title ?></h2>
                                        <p class="f-white f-light"><?= $sub->lastcourse->subtitle ?></p>
                                    <?php endif; ?>
                                </header>

                                <div class="actions flex-container mt-30 flex-itens-start flex-wrap">
                                    <?php if (isset($sub->lastclass)): ?>
                                        <span class="on-desktop"><a href="<?= HOME ?>/campus/aulas/<?= $sub->lastclass->uri ?>" class="btn btn-medio btn-orange radius-g mr-10"><i class="icon-play"></i> Continuar assistindo</a></span>
                                        <span class="on-desktop"><a rel="<?= $sub->lastcourse->uri ?>" id="<?= HOME ?>/campus/opencourse" class="btn btn-medio btn-black radius-g mr-10 j_open_course"><i class="icon-book1"></i> Ver curso</a></span>
                                        <span class="on-mobile"><a href="<?= HOME ?>/campus/aulas/<?= $sub->lastclass->uri ?>" class="btn btn-icon-low btn-orange radius-g mr-10"><i class="icon-play"></i></a></span>
                                        <span class="on-mobile"><a rel="<?= $sub->lastcourse->uri ?>" id="<?= HOME ?>/campus/opencourse" class="btn btn-icon-low btn-black radius-g mr-10 j_open_course"><i class="icon-book1"></i></a></span>
                                    <?php else: ?>
                                        <a rel="<?= $sub->lastcourse->uri ?>" id="<?= HOME ?>/campus/opencourse" class="btn btn-medio btn-orange radius-g mr-10 j_open_course"><i class="icon-play"></i> Iniciar curso</a>
                                        <a href="<?= HOME ?>/cursos" target="_blank" class="btn btn-medio btn-black radius-g mr-10"><i class="icon-book1"></i> Conhecer outros cursos</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php
                    endif;
                endforeach;
            else:
                if ($courses):
                    $i = 0;
                    foreach ($courses as $course):
                        $i++;
                        if ($i == 1):
                            ?>
                            <article class="wall" style="background-image: url(<?= HOME ?>/<?= $course->cover ?>)">
                                <div class="cover"></div>
                                <div class="frame shadow-title"></div>
                                <div class="description">
                                    <header>
                                        <h2 class="f-white f-semibold mb-20"><?= $course->title ?></h2>
                                        <p class="f-white f-light"><?= $course->subtitle ?></p>
                                    </header>

                                    <div class="actions flex-container mt-30 flex-itens-start flex-wrap">
                                        <a href="<?= HOME ?>/curso/<?= $course->uri ?>" target="_blank" class="btn btn-medio btn-orange radius-g mr-10"><i class="icon-play"></i> Comece a estudar!</a>
                                        <a href="<?= HOME ?>/cursos" target="_blank" class="btn btn-medio btn-black radius-g mr-10"><i class="icon-book1"></i> Conhecer outros cursos</a>
                                    </div>
                                </div>
                            </article>
                        <?php
                        endif;
                    endforeach;
                endif;
            endif;
        ?>
    </div>
</section>

<div class="padding-total-normal">
    <section class="container">
        <div class="content-courses sub">
            <header>
                <h3 class="title-page-sec f-primary f-regular mb-10">
                    <i class="icon-book1"></i> <?= ($subscribers ? 'Meus cursos' : 'Cursos ' . COMPANY_NAME); ?>
                </h3>
            </header>

            <div class="content-last-class courses flex-container flex-wrap">
                <?php
                    if ($subscribers):
                        foreach ($subscribers as $sub):
                            $hashId = base64_encode("co=true&coId={$sub->lastcourse->id}");
                            $expiry = ($sub->status == 1 ? "Expira em " . date('d/m/Y', strtotime($sub->end_date)) : 'Curso expirado!');
                            ?>
                            <article class="flex flex33 transition">
                                <div class="expiry j_tooltip round bg-black <?= ($sub->status == 1 ? 'f-green' : 'f-red') ?>" title="<?= $expiry ?>">
                                    <i class="icon-<?= ($sub->status == 1 ? 'check1' : 'warning-outline') ?>"></i>
                                </div>
                                <a rel="<?= $sub->lastcourse->uri ?>" id="<?= HOME ?>/campus/opencourse" class="j_open_course" style="cursor: pointer;">
                                    <?= Helper::image($c->make($sub->lastcourse->cover, 800, 418), $sub->lastcourse->title, "img radius-p") ?>
                                    <div class="cover" style="background: none"></div>
                                    <div class="play round transition">
                                        <i class="icon-play f-orange"></i>
                                    </div>
                                    <header class="shadow-title radius-p transition">
                                        <h1 class="f-white f-semibold"><?= $sub->lastcourse->title ?></h1>
                                        <div class="flex-container flex-itens-center mt-10">
                                            <p class="f-white f-light mr-10">
                                                <span class="f-orange"><i class="icon-user1"></i> Tutor:<br></span> <?= $sub->tutor ?>
                                            </p>
                                            <p class="f-white f-light mr-10">
                                                <span class="f-orange"><i class="icon-link1"></i> Segmento:<br></span> <?= $sub->segment ?>
                                            </p>
                                            <p class="f-white f-light mr-10">
                                                <span class="f-orange"><i class="icon-clock"></i> Progresso:<br></span> <?= courseProgress($sub->lastcourse->id, $sub->student) ?>%
                                            </p>
                                        </div>
                                    </header>
                                </a>
                            </article>
                        <?php
                        endforeach;
                    else:
                        if ($courses):
                            foreach ($courses as $course):
                                ?>
                                <article class="flex flex33 transition">
                                    <a href="<?= HOME ?>/curso/<?= $course->uri ?>" target="_blank">
                                        <?= Helper::image($c->make($course->cover, 800, 418), $course->title, "img radius-p") ?>
                                        <div class="cover" style="background: none"></div>
                                        <div class="play round transition">
                                            <i class="icon-play f-orange"></i>
                                        </div>
                                        <header class="shadow-title radius-p transition">
                                            <h1 class="f-white f-semibold"><?= $course->title ?></h1>
                                            <div class="flex-container flex-itens-center mt-10">
                                                <p class="f-white f-light mr-10">
                                                    <span class="f-orange"><i class="icon-user1"></i> Tutor:<br></span> <?= $course->tutor_name ?>
                                                </p>
                                                <p class="f-white f-light mr-10">
                                                    <span class="f-orange"><i class="icon-link1"></i> Segmento:<br></span> <?= $course->segment_title ?>
                                                </p>
                                            </div>
                                        </header>
                                    </a>
                                </article>
                            <?php
                            endforeach;
                        endif;
                    endif;
                ?>
            </div>
        </div>
    </section>
</div>