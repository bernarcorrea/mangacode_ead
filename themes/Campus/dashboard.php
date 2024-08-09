<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
?>

<section class="container">
    <div class="content-welcome">
        <div class="slide_courses_home">
            <?php
                if ($subscribers):
                    foreach ($subscribers as $sub):
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
                    endforeach;
                else:
                    foreach ($courses as $course):
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
                    endforeach;
                endif;
            ?>
        </div>
        
        <?php if (!$subscribers): ?>
            <span class="arrow prev transition round"><i class="icon-chevron-left"></i></span>
            <span class="arrow next transition round"><i class="icon-chevron-right"></i></span>
        <?php endif; ?>
    </div>
</section>

<div class="padding-total-normal">
    <section class="container">
        <div class="content-profile-home">
            <h3 class="title-page-sec f-primary f-regular mb-10">
                <i class="icon-user1"></i> Dados de perfil
            </h3>
            <p class="subtitle-page f-secondary f-light mb-20">Acesse abaixo os seus dados de perfil, <?= $student->name ?>:</p>

            <div class="flex-container">
                <div class="flex flex100 padding-total-normal radius-p bg-secondary">
                    <div class="flex-container flex-wrap">
                        <div class="flex flex100">
                            <h4 class="subtitle-page f-semibold t-upper f-primary"><?= $student->name ?> <?= $student->lastname ?></h4>
                        </div>
                    </div>
                    <div class="flex-container flex-wrap content-resume-account">
                        <div class="flex flex25 padding-total-low radius-p bg-primary">
                            <p class="text-page f-light t-upper f-primary">CPF:<br>
                                <span class="f-semibold"><?= $student->document ?></span>
                            </p>
                        </div>

                        <div class="flex flex25 padding-total-low radius-p bg-primary">
                            <p class="text-page f-light t-upper f-primary">Nascimento:<br>
                                <span class="f-semibold"><?= $student->birthday ?></span>
                            </p>
                        </div>

                        <div class="flex flex25 padding-total-low radius-p bg-primary">
                            <p class="text-page f-light f-primary">
                                <span class="t-upper">E-mail:</span><br>
                                <span class="f-semibold"><?= $student->email ?></span>
                            </p>
                        </div>

                        <div class="flex flex25 padding-total-low radius-p bg-primary">
                            <p class="text-page f-light f-primary">
                                <span class="t-upper">Senha:</span><br>
                                <span class="f-semibold">****</span>
                            </p>
                        </div>

                        <div class="flex flex100 mt-20">
                            <a href="<?= HOME ?>/campus/minha-conta" class="btn btn-medio btn-orange radius-g"><i class="icon-pencil"></i> Alterar meus dados</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-50">
        <div class="content-profile-home">
            <h3 class="title-page-sec f-primary f-regular mb-10">
                <i class="icon-play"></i> Últimas aulas cadastradas
            </h3>
            <p class="subtitle-page f-secondary f-light mb-20">Conteúdos exclusivos que estão saindo do forno:</p>

            <div class="on-desktop">
                <div class="content-last-class flex-container flex-wrap">
                    <?php
                        if ($classes):
                            foreach ($classes as $class):
                                ?>
                                <article class="flex flex25 transition">
                                    <a href="<?= HOME ?>/campus/aulas/<?= $class->uri ?>">
                                        <?= Helper::image($c->make($class->cover, 800, 460), $class->title, "img radius-p") ?>
                                        <div class="cover" style="background: none;"></div>
                                        <div class="play round transition">
                                            <i class="icon-play f-orange"></i>
                                        </div>
                                        <header class="shadow-title radius-p transition">
                                            <h1 class="f-white f-semibold"><?= $class->title ?></h1>
                                            <div class="flex-container flex-itens-center mt-5">
                                                <p class="f-orange f-light mr-10 star j_tooltip" title="Nível <?= getLevel($class->level) ?>">
                                                    <?php
                                                        if ($class->level == 1):
                                                            echo "<i class=\"icon-star\"></i>";
                                                        elseif ($class->level == 2):
                                                            echo "<i class=\"icon-star\"></i>";
                                                            echo "<i class=\"icon-star\"></i>";
                                                        else:
                                                            echo "<i class=\"icon-star\"></i>";
                                                            echo "<i class=\"icon-star\"></i>";
                                                            echo "<i class=\"icon-star\"></i>";
                                                        endif;
                                                    ?>
                                                </p>
                                                <p class="f-white f-semibold"><?= $class->time ?> min</p>
                                            </div>
                                        </header>
                                    </a>
                                </article>
                            <?php
                            endforeach;
                        endif;
                    ?>
                </div>
            </div>

            <div class="content-last-class on-mobile">
                <div class="slide_classes_home">
                    <?php
                        if ($classes):
                            foreach ($classes as $class):
                                ?>
                                <article class="flex flex25 transition pb-10">
                                    <a href="<?= HOME ?>/campus/aulas/<?= $class->uri ?>">
                                        <?= Helper::image($c->make($class->cover, 800, 460), $class->title, "img radius-p") ?>
                                        <div class="cover" style="background: none;"></div>
                                        <div class="play round transition">
                                            <i class="icon-play f-orange"></i>
                                        </div>
                                        <header class="shadow-title radius-p transition">
                                            <h1 class="f-white f-semibold"><?= $class->title ?></h1>
                                            <div class="flex-container flex-itens-center mt-5">
                                                <p class="f-orange f-light mr-10 star j_tooltip" title="Nível <?= getLevel($class->level) ?>">
                                                    <?php
                                                        if ($class->level == 1):
                                                            echo "<i class=\"icon-star\"></i>";
                                                        elseif ($class->level == 2):
                                                            echo "<i class=\"icon-star\"></i>";
                                                            echo "<i class=\"icon-star\"></i>";
                                                        else:
                                                            echo "<i class=\"icon-star\"></i>";
                                                            echo "<i class=\"icon-star\"></i>";
                                                            echo "<i class=\"icon-star\"></i>";
                                                        endif;
                                                    ?>
                                                </p>
                                                <p class="f-white f-semibold"><?= $class->time ?> min</p>
                                            </div>
                                        </header>
                                    </a>
                                </article>
                            <?php
                            endforeach;
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="container content-invoice-home mt-30">
        <div class="flex-container flex-itens-center flex-justify-space-between mb-20">
            <h3 class="title-page-sec f-primary f-regular">
                <i class="icon-layers"></i> Minhas Faturas
            </h3>
            <a href="<?= HOME ?>/campus/faturas" class="btn btn-medio btn-orange radius-g"><i class="icon-layers"></i> Ver todas</a>
        </div>

        <div class="padding-total-normal radius-p bg-secondary">
            <?php if (!$invoices): ?>
                <i class="icon-smile f-tertiary" style="font-size: 80px;"></i>
                <h3 class="f-tertiary mt-20 title-page">Opsss!</h3>
                <p class="subtitle-page f-light f-tertiary mt-15">Parece que você ainda não possui faturas geradas em sua conta, <?= $student->name ?>!</p>
            <?php else: ?>
                <div class="content-table">
                    <table class="table">
                        <thead>
                        <tr class="bg-secondary">
                            <th class="tb-field f-semibold f-primary t-upper">#</th>
                            <th class="tb-field f-semibold f-primary t-upper">Título</th>
                            <th class="tb-field f-semibold f-primary t-upper">Método</th>
                            <th class="tb-field f-semibold f-primary t-upper">Valor</th>
                            <th class="tb-field f-semibold f-primary t-upper">Data</th>
                            <th class="tb-field f-semibold f-primary t-upper">Status</th>
                            <th class="tb-field f-semibold f-primary t-upper">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            $color = 'bg-tertiary';
                            foreach ($invoices as $inv):
                                $i++;
                                $color = ($color == 'bg-tertiary' ? 'bg-primary' : 'bg-tertiary');
                                $hash = base64_encode("inv=true&invId={$inv->id}");
                                ?>
                                <tr class="<?= $color ?>">
                                    <td class="tb-field f-light f-primary"><?= ($i <= 9 ? '0' . $i : $i) ?></td>
                                    <td class="tb-field f-light f-primary"><?= $inv->course_title ?></td>
                                    <td class="tb-field f-light f-primary"><?= getTypePayment($inv->method_pay) ?></td>
                                    <td class="tb-field f-light f-primary">R$ <?= Helper::real($inv->price) ?></td>
                                    <td class="tb-field f-light f-primary"><?= date('d/m/Y', strtotime($inv->created_at)) ?> às <?= date('H:i', strtotime($inv->created_at)) ?>h</td>
                                    <td class="tb-field f-light f-orange"><?= getStatusPayment($inv->status_pay) ?></td>
                                    <td class="tb-field f-light f-orange">
                                        <a href="<?= HOME ?>/campus/faturas/<?= $hash ?>" class="btn btn-icon-low round btn-orange j_tooltip" title="Visualizar fatura"><i class="icon-eye1"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mt-30">
        <div class="flex-container flex-itens-center flex-justify-space-between mb-20">
            <h3 class="title-page-sec f-primary f-regular">
                <i class="icon-award"></i> Meus Certificados
            </h3>
            <a href="<?= HOME ?>/campus/certificados" class="btn btn-medio btn-orange radius-g"><i class="icon-award"></i> Ver todos</a>
        </div>

        <div class="padding-total-normal radius-p bg-secondary">
            <?php if (!$certificates): ?>
                <i class="icon-smile f-tertiary" style="font-size: 80px;"></i>
                <h3 class="f-tertiary mt-20 title-page">Opsss!</h3>
                <p class="subtitle-page f-light f-tertiary mt-15">Parece que você ainda não possui certificados cadastrados em sua conta, <?= $student->name ?>!</p>
            <?php
            else:
                echo "<div class='content-certificates flex-container flex-wrap'>";
                foreach ($certificates as $cert):
                    ?>
                    <article class="flex flex25">
                        <div class="photo">
                            <div class="icon f-orange">
                                <i class="icon-award"></i>
                            </div>
                            <?= Helper::image($c->make($cert->course->cover, 400, 250), $cert->course->title, 'img radius-m') ?>
                        </div>
                        <header class="bg-primary t-center mt-10 radius-m">
                            <div class="frame bg-orange"></div>
                            <h3 class="subtitle-page f-primary f-semibold mb-15"><?= $cert->course->title ?></h3>
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
                <?php
                endforeach;
                echo "</div>";
            endif;
            ?>
        </div>
    </div>
</div>