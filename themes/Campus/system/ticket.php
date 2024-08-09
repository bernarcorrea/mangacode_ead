<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
    $hash = base64_encode("tk=true&tkId={$ticket->id}");
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
                        <a href="<?= HOME ?>/campus/tickets" class="bg-tertiary f-primary">Tickets</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>

                    <li>
                        <a href="<?= HOME ?>/campus/tickets/t/<?= $hash ?>" class="bg-tertiary f-primary">Ver ticket</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-message-circle"></i> Ver ticket
            </h1>
            <p class="subtitle-page f-light f-primary">Visualize os detalhes do seu ticket abaixo:</p>
        </div>

        <nav>
            <a href="<?= HOME ?>/campus/tickets" class="btn btn-icon-medio btn-orange radius-g j_tooltip" title="Voltar"><i class="icon-chevron-left"></i></a>
        </nav>
    </header>

    <div class="container">
        <div class="flex-container flex-wrap">
            <div class="flex flex100 padding-total-low radius-p bg-secondary">
                <small class="small-title f-orange f-semibold t-upper">Assunto:</small>
                <p class="subtitle-page f-primary f-light"><?= $ticket->title ?></p>
            </div>
            <div class="flex flex33 padding-total-low radius-p bg-secondary">
                <small class="small-title f-orange f-semibold t-upper">Prioridade</small>
                <p class="subtitle-page f-primary f-light">
                    <?= ($ticket->priority == 1 ? '<i class="icon-star"></i>' : ($ticket->priority == 2 ? '<i class="icon-star"></i><i class="icon-star"></i>' : '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>')) ?>
                </p>
            </div>
            <div class="flex flex33 padding-total-low radius-p bg-secondary">
                <small class="small-title f-orange f-semibold t-upper">Última atualização:</small>
                <p class="subtitle-page f-primary f-light"><?= date('d/m/Y', strtotime($ticket->updated_at)) ?> às <?= date('H:i', strtotime($ticket->updated_at)) ?>h</p>
            </div>
            <div class="flex flex33 padding-total-low radius-p bg-secondary">
                <small class="small-title f-orange f-semibold t-upper">Status:</small>
                <span class="j_replacebox"><p class="subtitle-page f-primary f-light j_replace"><?= getTicketStatus($ticket->status) ?></p></span>
            </div>
        </div>

        <div class="flex flex100 mt-20" id="boxreply">
            <h3 class="subtitle-page f-light f-primary mb-10">Digite sua resposta aqui:</h3>
            <form action="" method="post" class="j_formajax">
                <input type="hidden" name="callback" value="<?= HOME ?>/campus/tickets/create" class="noclear">
                <input type="hidden" name="ticket" value="<?= $ticket->id ?>" class="noclear">
                <input type="hidden" name="student" value="<?= $student->id ?>" class="noclear">
                
                <div class="bg-secondary padding-total-small radius-p">
                    <textarea name="description" id="elm1" placeholder="Descreva sua dúvida aqui..."></textarea>
                </div>

                <div class="t-right mt-20">
                    <button class="btn btn-medio btn-orange radius-g">
                        <i class="icon-send1"></i> Enviar resposta
                    </button>
                </div>
            </form>
        </div>

        <div class="content-class-comment flex-container flex-direction-column flex-wrap mt-30">
            <article class="flex-container flex-itens-start">
                <div class="photo round">
                    <?= Helper::image($c->make((empty($student->cover) ? CAMPUS . '/images/user.jpg' : $student->cover), 300, 300), $student->name . ' ' . $student->lastname, 'img round') ?>
                </div>
                <header class="flex100">
                    <h4 class="f-primary f-semibold mb-10"><?= $student->name . ' ' . $student->lastname ?></h4>
                    <div class="desc mb-10">
                        <?= html_entity_decode($ticket->description) ?>
                    </div>
                    <div class="flex-container flex-itens-center">
                        <p class="f-light f-primary date mr-20">Em <?= date('d/m/Y', strtotime($ticket->created_at)) ?> às <?= date('H:i', strtotime($ticket->created_at)) ?>h</p>
                        <a rel="core" href="#boxreply" class="btn btn-low btn-orange radius-p"><i class="icon-reply"></i> Responder</a>
                    </div>
                </header>
            </article>

            <div class="comment-reply flex-container flex-wrap" id="reply<?= $ticket->id ?>">
                <?php
                    if ($ticket->replys):
                        foreach ($ticket->replys as $rl):
                            ?>
                            <article class="flex-container flex-itens-start">
                                <div class="photo round">
                                    <?= Helper::image($c->make($rl->author_cover, 300, 300), $rl->author_name, 'img round') ?>
                                </div>
                                <header class="flex100">
                                    <h4 class="f-primary f-semibold mb-10"><?= $rl->author_name ?></h4>
                                    <div class="desc mb-10">
                                        <?= html_entity_decode($rl->description) ?>
                                    </div>
                                    <p class="date f-light f-primary">Em <?= date('d/m/Y', strtotime($rl->created_at)) ?> às <?= date('H:i', strtotime($rl->created_at)) ?>h</p>
                                </header>
                            </article>
                        <?php
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>
