<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
    $cover = (empty($doubt->student->cover) ? ADMIN . '/images/cover.jpg' : $doubt->student->cover);
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-question mr-10"></i> Ver dúvida
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
                    <a href="<?= HOME ?>/admin/doubts">Dúvidas</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/doubts/view/<?= $doubt->id ?>">Ver dúvida</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/doubts" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <div class="box box70">
        <div class="content-ticket box-full mb-30">
            <article class="box-full padding-total-normal box-white radius-m">
                <header>
                    <p class="text-page f-silver f-semibold mb-20"><small class="small-titulo t-upper">Curso:</small> <?= $doubt->course->title ?></p>
                    <h1 class="title-page-sec f-black f-semibold mb-30"><small class="small-titulo t-upper">Aula:</small> <?= $doubt->class->title ?></h1>
                    <div class="details">
                        <div class="mr-30">
                            <div class="photo float_l">
                                <?= Helper::image($c->make($cover, 800, 800), $doubt->student->name, "img round"); ?>
                            </div>
                            <div class="student">
                                <p class="f-black f-regular">Por:
                                    <strong class="f-semibold"><?= $doubt->student->name . ' ' . $doubt->student->lastname ?></strong>
                                </p>
                            </div>
                        </div>
                        <div class="mr-30">
                            <p class="f-black f-regular j_replacebox">Status:
                                <strong class="f-semibold j_replace"><?= getDoubtStatus($doubt->status) ?></strong>
                            </p>
                        </div>
                        <div>
                            <p class="f-black f-regular">Atualizado em:
                                <strong class="f-semibold"><?= date('d/m/Y H:i', strtotime($doubt->updated_at)) ?>h</strong>
                            </p>
                        </div>
                    </div>
                    <div class="text mt-30"><?= html_entity_decode($doubt->description) ?></div>
                </header>

                <form action="" method="post" class="mt-30 j_formajax">
                    <input type="hidden" name="callback" value="<?= HOME ?>/admin/doubts/resolved" class="noclear">
                    <input type="hidden" name="id" value="<?= $doubt->id ?>" class="noclear">
                    <button class="btn btn-medio btn-green radius-g">
                        <i class="icon-checkmark"></i> Marcar como resolvido
                    </button>
                </form>
            </article>
        </div>

        <div class="box-full content-ticket-reply">
            <h2 class="title-page-sec f-semibold f-black mb-30">Respostas do ticket:</h2>
            
            <?php
                if ($doubtReply):
                    foreach ($doubtReply as $d):
                        ?>
                        <article class="mb-50">
                            <div class="photo">
                                <?= Helper::image($c->make($d->author_cover, 800, 800), $d->author_name, "img round"); ?>
                            </div>
                            <header>
                                <div class="details pb-10 mb-10">
                                    <p class="f-black f-light mr-30">Por:
                                        <strong class="f-semibold"><?= $d->author_name ?></strong>
                                    </p>
                                    <p class="f-black f-light">Enviado em:
                                        <strong class="f-semibold"><?= date('d/m/Y H:i', strtotime($d->created_at)) ?></strong>
                                    </p>
                                </div>
                                <div class="text"><?= html_entity_decode($d->description) ?></div>
                            </header>
                        </article>
                    <?php
                    endforeach;
                    echo "<div class='j_newresult'></div>";
                else:
                    echo error("Ainda não existem respostas para esta dúvida.", INFO);
                    echo "<div class='mb-20'></div>";
                endif;
            ?>
        </div>

        <form action="" method="post" class="j_formajax">
            <input type="hidden" name="callback" value="<?= HOME ?>/admin/doubts/reply" class="noclear">
            <input type="hidden" name="doubt" value="<?= $doubt->id ?>" class="noclear">
            <input type="hidden" name="author_type" value="2" class="noclear">
            <input type="hidden" name="author" value="<?= $_SESSION['acesso']['id'] ?>" class="noclear">
            <div class="box-full mt-30">
                <div class="box-full padding-total-normal box-white radius-m">
                    <textarea name="description" id="elm3"></textarea>
                </div>
                <div class="box-full t-right mt-20">
                    <button class="btn btn-medio btn-green radius-g">
                        <i class="icon-checkmark"></i> Enviar resposta
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>