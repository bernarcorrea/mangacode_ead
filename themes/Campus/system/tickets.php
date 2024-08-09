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
                        <a href="<?= HOME ?>/campus/tickets" class="bg-tertiary f-primary">Tickets</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-message-circle"></i> Tickets
            </h1>
            <p class="subtitle-page f-light f-primary">Gerencie abaixo os seus tickets criados na plataforma:</p>
        </div>

        <nav>
            <a href="<?= HOME ?>/campus/tickets/novo-ticket" class="btn btn-icon-medio btn-orange radius-g j_tooltip ml-20" title="Novo ticket"><i class="icon-pencil"></i></a>
        </nav>
    </header>

    <div class="container">
        <?php if (!$tickets): ?>
            <div class="container padding-total-low radius-p bg-secondary flex-container flex-itens-center">
                <i class="icon-smile f-orange" style="font-size: 40px;"></i>
                <div class="ml-10">
                    <p class="subtitle-page f-primary f-semibold t-upper mb-5">Opa, <?= $student->name ?>!</p>
                    <p class="text-page f-light f-secondary">
                        Parece que você ainda não possui nenhum ticket criado em nossa plataforma. </p>
                </div>
            </div>
        <?php else: ?>
            <div class="container mt-30">
                <div class="content-table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="tb-field f-semibold f-primary t-upper" style="width: 30px;">#</th>
                            <th class="tb-field f-semibold f-primary t-upper" style="width: 40%;">Assunto</th>
                            <th class="tb-field f-semibold f-primary t-upper">Prioridade</th>
                            <th class="tb-field f-semibold f-primary t-upper">Atualização</th>
                            <th class="tb-field f-semibold f-primary t-upper">Status</th>
                            <th class="tb-field f-semibold f-primary t-upper">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $bg = null;
                            $i = 0;
                            foreach ($tickets as $ticket):
                                $i++;
                                $bg = ($bg != 'bg' ? 'bg' : null);
                                $hash = base64_encode("tk=true&tkId={$ticket->id}");
                                ?>
                                <tr class="<?= $bg ?>">
                                    <td class="tb-field f-light f-primary"><?= ($i <= 9 ? '0' . $i : $i) ?></td>
                                    <td class="tb-field f-light f-primary"><?= $ticket->title ?></td>
                                    <td class="tb-field f-light f-orange">
                                        <?= ($ticket->priority == 1 ? '<i class="icon-star"></i>' : ($ticket->priority == 2 ? '<i class="icon-star"></i><i class="icon-star"></i>' : '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>')) ?>
                                    </td>
                                    <td class="tb-field f-light f-primary"><?= date('d/m/Y', strtotime($ticket->created_at)) ?> às <?= date('H:i', strtotime($ticket->created_at)) ?>h</td>
                                    <td class="tb-field f-light f-orange"><?= getTicketStatus($ticket->status) ?></td>
                                    <td class="tb-field f-light f-orange">
                                        <a href="<?= HOME ?>/campus/tickets/t/<?= $hash ?>" class="btn btn-icon-low round btn-orange j_tooltip" title="Abrir ticket"><i class="icon-eye1"></i></a>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
