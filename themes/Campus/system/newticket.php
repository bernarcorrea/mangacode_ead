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

                    <li>
                        <a href="<?= HOME ?>/campus/tickets/novo-ticket" class="bg-tertiary f-primary">Novo ticket</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-message-circle"></i> Novo ticket
            </h1>
            <p class="subtitle-page f-light f-primary">Preencha os campos abaixo para cadastrar o seu ticket:</p>
        </div>

        <nav>
            <a href="<?= HOME ?>/campus/tickets" class="btn btn-icon-medio btn-orange radius-g j_tooltip" title="Voltar"><i class="icon-chevron-left"></i></a>
        </nav>
    </header>

    <div class="container">
        <form action="" method="post" class="j_formajax">
            <input type="hidden" name="callback" value="<?= HOME ?>/campus/tickets/create" class="noclear">
            <input type="hidden" name="student" value="<?= $student->id ?>" class="noclear">
            
            <div class="flex-container flex-wrap">
                <div class="flex flex70">
                    <small class="small-title f-secondary f-semibold t-upper">Assunto</small>
                    <input type="text" name="title" class="form input-form-medio" placeholder="Assunto" required>
                </div>

                <div class="flex flex30">
                    <small class="small-title f-secondary f-semibold t-upper">Prioridade</small>
                    <div class="select">
                        <select name="priority" class="select-medio">
                            <option value="" selected disabled>Selecione</option>
                            <option value="1">Baixa</option>
                            <option value="2">Normal</option>
                            <option value="3">Alta</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex100">
                    <small class="small-title f-secondary f-semibold t-upper">Descrição</small>
                    <div class="bg-secondary padding-total-small radius-p">
                        <textarea name="description" id="elm1" placeholder="Descreva sua dúvida aqui..."></textarea>
                    </div>
                </div>

                <div class="flex flex100 t-right">
                    <button class="btn btn-medio btn-orange radius-g">
                        <i class="icon-send1"></i> Cadastrar ticket
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
