<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/layout');
    $c = new Cropper("cache");
    $cover = (empty($student->cover) ? CAMPUS . '/images/user.jpg' : $student->cover);
?>

<div class="padding-total-normal">
    <header class="header-default flex-container flex-nowrap flex-itens-center flex-justify-space-between">
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
                        <a href="<?= HOME ?>/campus/minha-conta" class="bg-tertiary f-primary">Minha conta</a>
                        <span class="arrow-left bg-primary"></span>
                        <span class="arrow-right bg-tertiary"></span>
                    </li>
                </ul>
            </nav>

            <h1 class="f-primary f-light title-page mt-20 mb-10">
                <i class="icon-user1"></i> Minha conta
            </h1>
            <p class="subtitle-page f-light f-primary">Visualize ou altere seus dados de perfil, endereço e redes sociais:</p>
        </div>
    </header>

    <section class="container mt-50">
        <nav class="nav-tab dash-nav mb-30">
            <ul class="flex-container flex-wrap">
                <li class="current">
                    <a href="#tab1" class="radius-g">Dados pessoais</a>
                </li>
                <li>
                    <a href="#tab2" class="radius-g">Endereço</a>
                </li>
                <li>
                    <a href="#tab3" class="radius-g">Redes sociais</a>
                </li>
            </ul>
        </nav>

        <!-- PESSOAL -->
        <div id="tab1" class="tabs">
            <h3 class="title-page-sec f-regular f-primary mb-20">
                <i class="icon-user1"></i> Dados pessoais
            </h3>
            <div class="flex-container content-profile">
                <form action="" method="post" class="j_photoprofile" enctype="multipart/form-data">
                    <input type="hidden" name="callback" value="<?= HOME ?>/campus/account/update" class="noclear">
                    <input type="hidden" name="type" value="5" class="noclear">
                    <div class="photo round">
                        <div class="photo-upload">
                            <div class="upload transition round">
                                <input type="file" name="cover" class="fake-file-student j_cover_student" onchange="sendPhotoProfile()">
                                <i class="icon-upload-cloud f-orange"></i>
                            </div>
                            <div class="img">
                                <?= Helper::image($c->make($cover, 500, 500), $student->name . ' ' . $student->lastname, 'img round') ?>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="itens-profile flex70 padding-total-normal bg-secondary radius-p">
                    <form action="" method="post" class="j_formajax">
                        <input type="hidden" name="callback" value="<?= HOME ?>/campus/account/update" class="noclear">
                        <input type="hidden" name="type" value="1" class="noclear">

                        <div class="flex-container flex-wrap">
                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Nome
                                </small>
                                <input type="text" name="name" class="form input-form-medio" placeholder="Nome" required value="<?= $student->name ?>">
                            </div>

                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Sobrenome
                                </small>
                                <input type="text" name="lastname" class="form input-form-medio" placeholder="Sobrenome" required value="<?= $student->lastname ?>">
                            </div>

                            <div class="flex flex100">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> E-mail
                                </small>
                                <input type="email" name="email" class="form input-form-medio" placeholder="E-mail" required value="<?= $student->email ?>">
                            </div>

                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Gênero
                                </small>
                                <div class="select">
                                    <select name="genre" required class="select-medio">
                                        <?php if (!empty($student->genre)): ?>
                                            <option value="<?= $student->genre ?>" selected>&raquo; <?= getGenre($student->genre) ?></option>
                                        <?php else: ?>
                                            <option value="" selected disabled>Selecione um item</option>
                                        <?php endif; ?>
                                        <option value="1">Masculino</option>
                                        <option value="2">Feminino</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> CPF
                                </small>
                                <input type="text" name="document" class="form input-form-medio disabled formCpf" placeholder="CPF" disabled value="<?= $student->document ?>">
                            </div>

                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Nascimento
                                </small>
                                <input type="text" name="birthday" class="form input-form-medio formAniver" placeholder="dd/mm/yyyy" required value="<?= $student->birthday ?>">
                            </div>

                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">Telefone</small>
                                <input type="text" name="telephone" class="form input-form-medio formTel" placeholder="Telefone" value="<?= $student->telephone ?>">
                            </div>

                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Celular
                                </small>
                                <input type="text" name="phone" class="form input-form-medio formFone" placeholder="Celular" required value="<?= $student->phone ?>">
                            </div>

                            <div class="flex flex100 t-right mt-20">
                                <button class="btn btn-medio btn-orange radius-g">
                                    <i class="icon-check-circle"></i> Salvar dados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ENDEREÇO -->
        <div id="tab2" class="tabs">
            <h3 class="title-page-sec f-regular f-primary mb-20">
                <i class="icon-location-outline"></i> Endereço
            </h3>
            <div class="flex-container">
                <div class="flex70 padding-total-normal bg-secondary radius-p">
                    <form action="" method="post" class="j_formajax">
                        <input type="hidden" name="callback" value="<?= HOME ?>/campus/account/update" class="noclear">
                        <input type="hidden" name="type" value="2" class="noclear">

                        <div class="flex-container flex-wrap">
                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> CEP
                                </small>
                                <input type="text" name="cep" class="form input-form-medio formCep sg_getCep" placeholder="CEP" required value="<?= $student->cep ?>">
                            </div>

                            <div class="flex flex80">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Endereço
                                </small>
                                <input type="text" name="address" class="form input-form-medio sg_logradouro disabled" placeholder="Endereço" required readonly value="<?= $student->address ?>">
                            </div>

                            <div class="flex flex20">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Número
                                </small>
                                <input type="text" name="number" class="form input-form-medio" placeholder="Número" required value="<?= $student->number ?>">
                            </div>

                            <div class="flex flex100">
                                <small class="small-title f-secondary f-semibold t-upper">Complemento</small>
                                <input type="text" name="complement" class="form input-form-medio" placeholder="Complemento" value="<?= $student->complement ?>">
                            </div>

                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Bairro
                                </small>
                                <input type="text" name="district" class="form input-form-medio sg_bairro disabled" placeholder="Bairro" required readonly value="<?= $student->district ?>">
                            </div>

                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Estado
                                </small>
                                <input type="text" name="state" class="form input-form-medio sg_uf disabled" placeholder="Estado" required readonly value="<?= $student->state ?>">
                            </div>

                            <div class="flex flex33">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="f-orange">*</i> Cidade
                                </small>
                                <input type="text" name="city" class="form input-form-medio sg_localidade disabled" placeholder="Cidade" required readonly value="<?= $student->city ?>">
                            </div>

                            <div class="flex flex100 t-right mt-20">
                                <button class="btn btn-medio btn-orange radius-g">
                                    <i class="icon-check-circle"></i> Salvar dados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SOCIAL -->
        <div id="tab3" class="tabs">
            <h3 class="title-page-sec f-regular f-primary mb-20">
                <i class="icon-share-2"></i> Redes sociais
            </h3>
            <div class="flex-container">
                <div class="flex60 padding-total-normal bg-secondary radius-p">
                    <form action="" method="post" class="j_formajax">
                        <input type="hidden" name="callback" value="<?= HOME ?>/campus/account/update" class="noclear">
                        <input type="hidden" name="type" value="3" class="noclear">

                        <div class="flex-container flex-wrap">
                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="icon-facebook"></i> Facebook
                                </small>
                                <input type="text" name="facebook" class="form input-form-medio" placeholder="@" value="<?= $student->facebook ?>">
                            </div>

                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="icon-instagram"></i> Instagram
                                </small>
                                <input type="text" name="instagram" class="form input-form-medio" placeholder="@" value="<?= $student->instagram ?>">
                            </div>

                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="icon-twitter"></i> Twitter
                                </small>
                                <input type="text" name="twitter" class="form input-form-medio" placeholder="@" value="<?= $student->twitter ?>">
                            </div>

                            <div class="flex flex50">
                                <small class="small-title f-secondary f-semibold t-upper">
                                    <i class="icon-youtube"></i> Youtube
                                </small>
                                <input type="text" name="youtube" class="form input-form-medio" placeholder="@" value="<?= $student->youtube ?>">
                            </div>

                            <div class="flex flex100 t-right mt-20">
                                <button class="btn btn-medio btn-orange radius-g">
                                    <i class="icon-check-circle"></i> Salvar dados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>