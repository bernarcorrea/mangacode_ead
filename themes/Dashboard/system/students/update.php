<?php
    
    use Source\Support\Helper;
    use CoffeeCode\Cropper\Cropper;
    
    $v->layout('inc/dashboard');
    $c = new Cropper("cache");
    $cover = (empty($student->cover) ? ADMIN . '/images/cover.jpg' : $student->cover);
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-users1 mr-10"></i> Editar aluno
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
                    <a href="<?= HOME ?>/admin/students/update/<?= $student->id ?>">Editar aluno</a>
                </li>
            </ul>
        </div>

        <nav class="options-default j_list">
            <a href="<?= HOME ?>/admin/students" class="btn btn-icon-medio btn-blue radius-g j_tooltip" title="Voltar"><i class="icon-arrow-left2"></i></a>
            <a href="<?= HOME ?>/admin/students/history/<?= $student->id ?>" class="btn btn-icon-medio btn-black radius-g j_tooltip" title="Ver histórico"><i class="icon-chart"></i></a>
            <a rel="<?= $student->id ?>" id="<?= HOME ?>/admin/students/delete" class="btn btn-icon-medio btn-red radius-g j_delete j_tooltip" title="Excluir aluno"><i class="icon-trash"></i></a>
        </nav>
    </header>
</div>

<div class="box-full">
    <form action="" method="post" class="j_formajax" enctype="multipart/form-data">
        <input type="hidden" name="callback" value="<?= HOME ?>/admin/students/manager" class="noclear">
        <input type="hidden" value="1" name="status">
        <input type="hidden" value="<?= $student->id ?>" name="id">

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
                        <input type="text" name="name" required class="form input-form-medio" placeholder="Nome" value="<?= $student->name ?>">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Sobrenome
                        </small>
                        <input type="text" name="lastname" required class="form input-form-medio" placeholder="Sobrenome" value="<?= $student->lastname ?>">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> CPF
                        </small>
                        <input type="text" name="document" required class="form input-form-medio formCpf" placeholder="CPF" value="<?= $student->document ?>">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Nascimento
                        </small>
                        <input type="text" name="birthday" required class="form input-form-medio datepicker formAniver" autocomplete="off" placeholder="Nascimento" value="<?= date('d/m/Y', strtotime($student->birthday)) ?>">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Gênero
                        </small>
                        <div class="select">
                            <select name="genre" required class="select-medio">
                                <option value="<?= $student->genre ?>" selected>&raquo; <?= getGenre($student->genre) ?></option>
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
                        <input type="text" name="phone" required class="form input-form-medio formFone" placeholder="Celular" value="<?= $student->phone ?>">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Telefone</small>
                        <input type="text" name="telephone" class="form input-form-medio formTel" placeholder="Telefone" value="<?= $student->telephone ?>">
                    </label>
                </div>

                <div class="tabs" id="tab2">
                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> CEP
                        </small>
                        <input type="text" name="cep" required class="form input-form-medio formCep sg_getCep" autocomplete="off" placeholder="Nome" value="<?= $student->cep ?>">
                    </label>

                    <div></div>

                    <label class="box box70">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Endereço
                        </small>
                        <input type="text" name="address" required class="form input-form-medio box-silver2 sg_logradouro" readonly placeholder="Endereço" value="<?= $student->address ?>">
                    </label>

                    <label class="box box30">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Número
                        </small>
                        <input type="text" name="number" required class="form input-form-medio" placeholder="Número" value="<?= $student->number ?>">
                    </label>

                    <label class="box box100">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Complemento</small>
                        <input type="text" name="complement" class="form input-form-medio" placeholder="Complemento" value="<?= $student->complement ?>">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Estado
                        </small>
                        <input type="text" name="state" required class="form input-form-medio box-silver2 sg_uf" readonly placeholder="Estado" value="<?= $student->state ?>">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Cidade
                        </small>
                        <input type="text" name="city" required class="form input-form-medio box-silver2 sg_localidade" readonly placeholder="Cidade" value="<?= $student->city ?>">
                    </label>

                    <label class="box box33">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">
                            <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Bairro
                        </small>
                        <input type="text" name="district" required class="form input-form-medio box-silver2 sg_bairro" readonly placeholder="Bairro" value="<?= $student->district ?>">
                    </label>
                </div>

                <div class="tabs" id="tab3">
                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Facebook</small>
                        <input type="text" name="facebook" class="form input-form-medio" placeholder="@" value="<?= $student->facebook ?>">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Instagram</small>
                        <input type="text" name="instagram" class="form input-form-medio" placeholder="@" value="<?= $student->instagram ?>">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Twitter</small>
                        <input type="text" name="twitter" class="form input-form-medio" placeholder="@" value="<?= $student->twitter ?>">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Youtube</small>
                        <input type="text" name="youtube" class="form input-form-medio" placeholder="@" value="<?= $student->youtube ?>">
                    </label>
                </div>

                <div class="tabs" id="tab4">
                    <label class="box box100">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">E-mail</small>
                        <input type="email" name="email" class="form input-form-medio" placeholder="E-mail" value="<?= $student->email ?>">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Senha</small>
                        <input type="password" name="password" class="form input-form-medio" placeholder="Senha">
                    </label>

                    <label class="box box50">
                        <small class="small-titulo-2 f-silver f-semibold t-upper">Confirme a senha</small>
                        <input type="password" name="password_confirm" class="form input-form-medio" placeholder="Confirme a senha">
                    </label>
                </div>
            </div>

            <div class="photo">
                <label class="box box100">
                    <img id="blah" src="#" class="mb-20 round" style="display: none"/>
                    <?= Helper::image($c->make($cover, 850, 850), $student->cover, "img round j_cover mb-20") ?>
                    <small class="small-titulo-2 f-silver f-semibold t-upper">
                        <i class="f-red j_tooltip" title="Campo obrigatório!">*</i> Avatar do aluno
                    </small>
                    <input type="file" name="cover" class="form input-form-medio file box-white" onchange="readURL(this);">
                    <input type="hidden" name="image_current" value="<?= $student->cover ?>">
                </label>

                <div class="box box100">
                    <button class="btn btn-medio btn-green radius-g float_r">
                        <i class="icon-check-alt mr-5"></i> Atualizar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>