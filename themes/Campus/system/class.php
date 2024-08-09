<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
?>

<div class="content-class">
    <header class="padding-total-normal header-default flex-container flex-nowrap flex-itens-center flex-justify-space-between">
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
                        <a href="<?= HOME ?>/campus/meus-cursos#<?= $course->uri ?>" class="bg-tertiary f-primary"><?= $course->title ?></a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus/aulas/<?= $class->uri ?>" class="bg-tertiary f-primary"><?= $class->title ?></a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-20"><?= $class->title ?></h1>

            <div class="class-resume flex-container flex-wrap flex-itens-center">
                <div class="item mr-20 flex-container">
                    <span><i class="icon-book1 f-orange"></i></span>
                    <h3 class="f-primary f-light ml-10">Módulo:
                        <strong class="f-semibold"><?= $module->title ?></strong>
                    </h3>
                </div>

                <div class="item mr-20 flex-container">
                    <span><i class="icon-clock f-orange"></i></span>
                    <h3 class="f-primary f-light ml-10">Tempo:
                        <strong class="f-semibold"><?= $class->time ?> min</strong>
                    </h3>
                </div>

                <div class="item mr-20 flex-container">
                    <span><i class="icon-star-outline f-orange"></i></span>
                    <h3 class="f-primary f-light ml-10">Nível:
                        <strong class="f-semibold"><?= getLevel($class->level) ?></strong>
                    </h3>
                </div>

                <div class="item flex-container">
                    <a rel="course_folder" class="btn btn-medio btn-orange radius-g btn_modal"><i class="icon-folder"></i> Pasta do curso</a>
                </div>
            </div>
        </div>

        <nav>
            <a href="<?= HOME ?>/campus/meus-cursos#<?= $course->uri ?>" class="btn btn-icon-medio btn-orange round j_tooltip ml-20" title="Voltar"><i class="icon-chevron-left"></i></a>
        </nav>
    </header>

    <section class="container">
        <div class="content-video bg-secondary padding-total-normal">
            <div class="nav-class flex-container flex-justify-space-between flex-itens-center flex-wrap mb-30">
                <?php if (!$class->prevclass): ?>
                    <a href="<?= HOME ?>/campus/meus-cursos" class="btn btn-low btn-black radius-p flex-container flex-itens-center flex-justify-start">
                        <i class="icon-chevron-left f-orange"></i>
                        <span>Início do curso: <strong>Voltar para meus cursos</strong></span>
                    </a>
                <?php else: ?>
                    <a href="<?= HOME ?>/campus/aulas/<?= $class->prevclass->uri ?>" class="btn btn-low btn-black radius-p flex-container flex-itens-center flex-justify-start">
                        <i class="icon-chevron-left f-orange"></i>
                        <span>Aula anterior: <strong><?= $class->prevclass->title ?></strong></span>
                    </a>
                <?php endif; ?>

                <div class="status_class">
                    <?php
                        if (isset($class->statusclass)):
                            if ($class->statusclass->status == 2):
                                echo "<span class=\"btn btn-icon-larg bg-green radius-p j_tooltip\" title=\"Aula concluída!\"><i class=\"icon-check\"></i></span>";
                            else:
                                echo "<span class=\"btn btn-icon-larg bg-black radius-p j_tooltip j_pending\" rel='" . HOME . "/campus/autocheck' title=\"Aula pendente!\"><i class=\"icon-clock\"></i><span class='frame bg-orange'></span></span>";
                            endif;
                        else:
                            echo "<span class=\"btn btn-icon-larg bg-black radius-p j_tooltip j_pending\" rel='" . HOME . "/campus/autocheck' title=\"Aula pendente!\"><i class=\"icon-clock\"></i><span class='frame bg-orange'></span></span>";
                        endif;
                    ?>
                </div>
                
                <?php if (!$class->nextclass): ?>
                    <a href="#" class="btn btn-low btn-black radius-p flex-container flex-itens-center flex-justify-end">
                        <span>Fim do curso: <strong> Voltar para meus cursos</strong></span>
                        <i class="icon-chevron-right f-orange"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= HOME ?>/campus/aulas/<?= $class->nextclass->uri ?>" class="btn btn-low btn-black radius-p flex-container flex-itens-center flex-justify-end">
                        <span>Próxima aula: <strong><?= $class->nextclass->title ?></strong></span>
                        <i class="icon-chevron-right f-orange"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="video-container">
                <?= Helper::video($class->video, "vimeo") ?>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="padding-total-normal">
            <header class="mb-20" id="boxreply">
                <h3 class="title-page-sec f-semibold f-primary mb-10">
                    <i class="icon-message-circle"></i> Dúvidas sobre esta aula?
                </h3>
                <p class="subtitle-page f-light f-primary"><?= $student->name ?>, caso algo nesta aula não tenha sido compreendido por você, não deixe de perguntar através do campo abaixo, beleza?</p>
            </header>

            <form action="" method="post" class="j_formajax">
                <input type="hidden" name="callback" value="<?= HOME ?>/campus/createdoubt" class="noclear">
                <input type="hidden" name="class" value="<?= $class->id ?>" class="noclear">
                <input type="hidden" name="student" value="<?= $student->id ?>" class="noclear">
                <span class="doubt_id"></span>

                <div class="bg-secondary padding-total-small radius-p">
                    <textarea name="description" id="elm1" placeholder="Descreva sua dúvida aqui..."></textarea>
                </div>
                <div class="t-right mt-20">
                    <button class="btn btn-medio btn-orange radius-g">
                        <i class="icon-send1"></i> Enviar dúvida
                    </button>
                </div>
            </form>

            <div class="content-class-comment flex-container flex-direction-column flex-wrap mt-30">
                <div class="j_newresult"></div>
                <?php
                    if ($doubts):
                        foreach ($doubts as $doubt):
                            ?>
                            <article class="flex-container flex-itens-start">
                                <div class="photo round">
                                    <?= Helper::image($c->make((!empty($doubt->stud->cover) ? $doubt->stud->cover : CAMPUS . '/images/user.jpg'), 300, 300), $doubt->stud->name . ' ' . $doubt->stud->lastname, 'img round') ?>
                                </div>
                                <header class="flex100">
                                    <h4 class="f-primary f-semibold mb-10"><?= $doubt->stud->name . ' ' . $doubt->stud->lastname ?></h4>
                                    <div class="desc">
                                        <?= html_entity_decode($doubt->description) ?>
                                    </div>
                                    <div class="flex-container flex-itens-center">
                                        <p class="f-light f-primary date mr-20">Em <?= date('d/m/Y', strtotime($doubt->created_at)) ?> às <?= date('H:i', strtotime($doubt->created_at)) ?>h</p>
                                        <?php if ($doubt->student == $student->id): ?>
                                            <a rel="core" href="#boxreply" id="<?= $doubt->id ?>" class="btn btn-low btn-orange radius-g j_reply_doubt"><i class="icon-reply"></i> Responder</a>
                                        <?php endif; ?>
                                    </div>
                                </header>
                            </article>

                            <div class="comment-reply flex-container flex-wrap" id="reply<?= $doubt->id ?>">
                                <?php
                                    if ($doubt->replys):
                                        foreach ($doubt->replys as $reply):
                                            ?>
                                            <article class="flex-container flex-itens-start">
                                                <div class="photo round">
                                                    <?= Helper::image($c->make($reply->author_cover, 300, 300), $reply->author_name, 'img round') ?>
                                                </div>
                                                <header class="flex100">
                                                    <h4 class="f-primary f-semibold mb-10"><?= $reply->author_name ?></h4>
                                                    <div class="desc">
                                                        <?= html_entity_decode($reply->description) ?>
                                                    </div>
                                                    <p class="date f-light f-primary">Em <?= date('d/m/Y', strtotime($reply->created_at)) ?> às <?= date('H:i', strtotime($reply->created_at)) ?>h</p>
                                                </header>
                                            </article>
                                        <?php
                                        endforeach;
                                    endif;
                                ?>
                            </div>
                        <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </section>
</div>

<aside class="other-class bg-secondary">
    <div class="course flex-container flex-nowrap padding-total-normal flex-itens-center">
        <div class="photo round">
            <?= Helper::image($c->make($course->cover, 300, 300), $course->title, 'img round') ?>
        </div>
        <div class="title ml-20">
            <h2 class="f-primary f-semibold"><?= $course->title ?></h2>
            <div class="bar-progress bg-primary radius-p mt-10">
                <div class="progress radius-p f-bold f-white" style="width: <?= courseProgress($course->id, $student->id) ?>%;"><?= courseProgress($course->id, $student->id) ?>%</div>
            </div>
        </div>
    </div>

    <div class="classes flex-container flex-direction-column">
        <?php
            if ($classes):
                foreach ($classes as $cl):
                    ?>
                    <article class="padding-total-low flex-container flex-itens-center <?= ($cl->ord == $class->ord ? 'active' : null) ?>">
                        <div class="photo mr-20">
                            <a href="<?= HOME ?>/campus/aulas/<?= $cl->uri ?>">
                                <?= Helper::image($c->make($cl->cover, 400, 270), $cl->title, 'img radius-p') ?>
                            </a>
                        </div>
                        <header>
                            <p class="f-light t-upper f-orange mb-5">Aula <?= $cl->ord ?></p>
                            <a href="<?= HOME ?>/campus/aulas/<?= $cl->uri ?>">
                                <h3 class="f-primary f-semibold mb-5"><?= $cl->title ?></h3>
                            </a>
                            <div class="details flex-container flex-itens-center">
                                <span class="j_tooltip" title="Nível <?= getLevel($cl->level) ?>">
                                    <?= ($cl->level == 1 ? '<i class="icon-star f-orange mr-5"></i>' : ($cl->level == 2 ? '<i class="icon-star f-orange"></i><i class="icon-star f-orange mr-5"></i>' : '<i class="icon-star f-orange"></i><i class="icon-star f-orange"></i><i class="icon-star f-orange mr-5"></i>')) ?>
                                </span>
                                <p class="f-semibold f-primary"><?= $cl->time ?> min</p>
                            </div>
                        </header>
                    </article>
                <?php
                endforeach;
            endif;
        ?>
    </div>
</aside>

<div class="content-modal">
    <div class="modal" id="course_folder">
        <span class="close_modal btn btn-icon-medio btn-red round"><i class="icon-x"></i></span>
        <div class="padding-total-normal radius-m bg-primary">
            <h3 class="title-page-sec f-primary f-semibold mb-10">
                <i class="icon-folder_open"></i> Pasta do curso
            </h3>
            <p class="subtitle-page f-primary f-regular mb-20">Faça download abaixo dos anexos disponíveis para o curso:</p>

            <div class="content-folder-course flex-container flex-wrap">
                <?php
                    if ($courseFolder):
                        foreach ($courseFolder as $cf):
                            $hash = base64_encode("down=true&cfId=" . base64_encode($cf->id));
                            ?>
                            <article class="flex flex25 radius-p t-center transition">
                                <a href="<?= HOME ?>/campus/download-file/<?= $hash ?>">
                                    <div class="container padding-total-low">
                                        <p class="f-secondary mb-10">
                                            <i class="icon-file_present" style="font-size: 30px;"></i>
                                        </p>
                                        <h1 class="f-light f-primary"><?= $cf->title ?></h1>
                                    </div>
                                </a>
                            </article>
                        <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>