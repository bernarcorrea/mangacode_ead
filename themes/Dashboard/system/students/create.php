<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Novo aluno
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
                    <a href="<?= HOME ?>/admin/students">Alunos</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="t-upper">
                    <a href="<?= HOME ?>/admin/students/create">Novo aluno</a>
                </li>
            </ul>
        </div>

        <nav class="options-default">
            <a href="<?= HOME ?>/admin/students" class="btn btn-icon-medio btn-blue radius-g"><i class="icon-arrow-left2"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="<?= HOME ?>/admin/students/manager" class="noclear">
        <input type="hidden" value="1" name="status">

        <div class="content-insert-student">
            <div class="data">
                <nav class="nav-tab nav-dash mb-30">
                    <ul>
                        <li class="current">
                            <a href="#tab1">Dados pessoais</a>
                        </li>
                        <li>
                            <a href="#tab2">Endereço</a>
                        </li>
                        <li>
                            <a href="#tab3">Redes sociais</a>
                        </li>
                        <li>
                            <a href="#tab4">Acesso</a>
                        </li>
                    </ul>
                </nav>

                <div class="tabs" id="tab1">
                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Nome
                        </small>
                        <input type="text" name="name" required class="form input-form-medio" placeholder="Nome">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Sobrenome
                        </small>
                        <input type="text" name="lastname" required class="form input-form-medio" placeholder="Sobrenome">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> CPF
                        </small>
                        <input type="text" name="document" required class="form input-form-medio formCpf" placeholder="CPF">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Nascimento
                        </small>
                        <input type="text" name="birthday" required class="form input-form-medio datepicker formAniver" autocomplete="off" placeholder="Nascimento">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Gênero
                        </small>
                        <div class="select">
                            <select name="genre" required class="select-medio">
                                <option value="" selected disabled>Selecione um item</option>
                                <?php
                                    foreach (getGenre() as $k => $v):
                                        echo "<option value=\"{$k}\">{$v}</option>";
                                    endforeach;
                                ?>
                            </select>
                        </div>
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Celular
                        </small>
                        <input type="text" name="phone" required class="form input-form-medio formFone" placeholder="Celular">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Telefone</small>
                        <input type="text" name="telephone" class="form input-form-medio formTel" placeholder="Telefone">
                    </label>
                </div>

                <div class="tabs" id="tab2">
                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> CEP
                        </small>
                        <input type="text" name="cep" required class="form input-form-medio formCep sg_getCep" autocomplete="off" placeholder="Nome">
                    </label>

                    <div></div>

                    <label class="box box70">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Endereço
                        </small>
                        <input type="text" name="address" required class="form input-form-medio box-silver2 sg_logradouro" readonly placeholder="Endereço">
                    </label>

                    <label class="box box30">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Número
                        </small>
                        <input type="text" name="number" required class="form input-form-medio" placeholder="Número">
                    </label>

                    <label class="box box100">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Complemento</small>
                        <input type="text" name="complement" class="form input-form-medio" placeholder="Complemento">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Estado
                        </small>
                        <input type="text" name="state" required class="form input-form-medio box-silver2 sg_uf" readonly placeholder="Estado">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Cidade
                        </small>
                        <input type="text" name="city" required class="form input-form-medio box-silver2 sg_localidade" readonly placeholder="Cidade">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Bairro
                        </small>
                        <input type="text" name="district" required class="form input-form-medio box-silver2 sg_bairro" readonly placeholder="Bairro">
                    </label>
                </div>

                <div class="tabs" id="tab3">
                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Facebook</small>
                        <input type="text" name="facebook" class="form input-form-medio" placeholder="@">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Instagram</small>
                        <input type="text" name="instagram" class="form input-form-medio" placeholder="@">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Twitter</small>
                        <input type="text" name="twitter" class="form input-form-medio" placeholder="@">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Youtube</small>
                        <input type="text" name="youtube" class="form input-form-medio" placeholder="@">
                    </label>
                </div>

                <div class="tabs" id="tab4">
                    <label class="box box100">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">E-mail</small>
                        <input type="email" name="email" class="form input-form-medio" placeholder="E-mail">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Senha</small>
                        <input type="password" required name="password" class="form input-form-medio" placeholder="Senha">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Confirme a senha</small>
                        <input type="password" required name="password_confirm" class="form input-form-medio" placeholder="Confirme a senha">
                    </label>
                </div>
            </div>

            <div class="photo">
                <label class="box box100">
                    <img id="blah" src="#" class="mb-20 round" style="display: none"/>
                    <?= Helper::image($c->make(ADMIN . '/images/cover.jpg', 850, 850), "", "img round j_cover mb-20") ?>
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Avatar do aluno
                    </small>
                    <input type="file" name="cover" class="form input-form-medio file box-white" onchange="readURL(this);">
                </label>

                <div class="box box100">
                    <button class="btn btn-medio btn-green radius-g float_r">
                        <i class="icon-check-alt mr-5"></i> Cadastrar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>