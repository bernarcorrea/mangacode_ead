<?php
    $v->layout('inc/dashboard');
?>

<div class="box-full mb-50">
    <header class="pb-60">
        <h1 class="title-page f-black f-semibold mb-10">
            <i class="icon-cog2 mr-10"></i> Configurações
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
                    <a href="<?= HOME ?>/admin/config">Configurações</a>
                </li>
            </ul>
        </div>
    </header>
</div>

<div class="box-full mb-20">
    <div class="box box100">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-users1 mr-10"></i> Administradores do sistema
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Visualize abaixo os
                <span class="f-semibold">administradores</span> atuais do sistema:
            </p>

            <nav class="options-default box_1">
                <a href="<?= HOME ?>/admin/users" class="btn btn-medio btn-blue radius-g"><i class="icon-plus2 mr-5"></i> Ver todos</a>
            </nav>

            <table class="table box-full" cellspacing="0" cellpadding="0">
                <tr class="box-white">
                    <td class="tb-field f-semibold f-black t-upper">#</td>
                    <td class="tb-field f-semibold f-black t-upper">Nome</td>
                    <td class="tb-field f-semibold f-black t-upper">E-mail</td>
                    <td class="tb-field f-semibold f-black t-upper">Nível</td>
                    <td class="tb-field f-semibold f-black t-upper">&nbsp;</td>
                </tr>
                <?php
                    $i = 0;
                    $color = 'box-white';
                    foreach ($users as $us):
                        $i++;
                        $color = ($color == 'box-white' ? 'box-silver' : 'box-white');
                        $i = ($i <= 9 ? '0' . $i : $i);
                        $nivel = ($us->nivel == 1 ? 'Administrador' : ($us->nivel == 2 ? 'Editor' : 'Atendimento'));
                        ?>
                        <tr class="<?= $color ?>">
                            <td class="tb-field f-light f-black"><?= $i ?></td>
                            <td class="tb-field f-light f-black"><?= $us->name ?></td>
                            <td class="tb-field f-light f-black"><?= $us->email ?></td>
                            <td class="tb-field f-light f-black"><?= $nivel ?></td>
                            <td class="tb-field f-light f-black j_list t-right">
                                <a href="<?= HOME ?>/admin/users/update/<?= $us->id ?>" class="btn btn-icon-medio btn-blue round"><i class="icon-write"></i></a>
                                <a rel="<?= $us->id ?>" id="users/update/delete" class="btn btn-icon-medio btn-red round j_delete"><i class="icon-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div class="box-full mb-20">
    <div class="box box100">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-reddit mr-10"></i> Rastreamento
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Adicione os pixels de rastreamento para o
                <span class="f-semibold">Google Analytics</span> e
                <span class="f-semibold">Facebooks Ads</span>:
            </p>

            <form action="" method="post" class="j_formajax">
                <nav class="options-default box_1">
                    <button class="btn btn-medio btn-green radius-g">
                        <i class="icon-check-alt mr-5"></i> Salvar dados
                    </button>
                </nav>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Google Analytics</small>
                    <input type="text" name="analytics" class="form input-form-larg box-silver" placeholder="Código do Google Analytics">
                </label>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Facebook Ads</small>
                    <textarea name="facebook" class="form area-form-larg box-silver" placeholder="Pixel do Facebook Ads"></textarea>
                </label>
            </form>
        </div>
    </div>
</div>

<div class="box-full mb-20">
    <div class="box box100">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-share1 mr-10"></i> Redes sociais
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Personalize as
                <span class="f-semibold">Redes Sociais</span> do site:
            </p>

            <form action="" method="post" class="j_formajax">
                <input type="hidden" name="callback" value="config/social" class="noclear">
                <input type="hidden" name="id" value="<?= $social->id ?>" class="noclear">
                
                <nav class="options-default box_1">
                    <button class="btn btn-medio btn-green radius-g">
                        <i class="icon-check-alt mr-5"></i> Salvar dados
                    </button>
                </nav>

                <label class="box box33">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Facebook</small>
                    <input type="text" name="facebook" class="form input-form-larg box-silver" placeholder="Facebook" value="<?= $social->facebook ?>">
                </label>

                <label class="box box33">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Instagram</small>
                    <input type="text" name="instagram" class="form input-form-larg box-silver" placeholder="Instagram" value="<?= $social->instagram ?>">
                </label>

                <label class="box box33">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Youtube</small>
                    <input type="text" name="youtube" class="form input-form-larg box-silver" placeholder="Youtube" value="<?= $social->youtube ?>">
                </label>

                <label class="box box33">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Twitter</small>
                    <input type="text" name="twitter" class="form input-form-larg box-silver" placeholder="Twitter" value="<?= $social->twitter ?>">
                </label>

                <label class="box box33">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Google</small>
                    <input type="text" name="google" class="form input-form-larg box-silver" placeholder="Google" value="<?= $social->google ?>">
                </label>
            </form>
        </div>
    </div>
</div>

<div class="box-full mb-20">
    <div class="box box100">
        <div class="box-full box-white padding-total-normal">
            <h2 class="title-page-sec f-black f-semibold mb-10">
                <i class="icon-mobile2 mr-10"></i> Contatos
            </h2>
            <p class="f-light f-silver subtitle-page mb-30">Personalize os dados de
                <span class="f-semibold">contatos</span> do site:
            </p>

            <form action="" method="post" class="j_formajax">
                <input type="hidden" name="callback" value="config/contact" class="noclear">
                <input type="hidden" name="id" value="<?= $cont->id ?>" class="noclear">
                
                <nav class="options-default box_1">
                    <button class="btn btn-medio btn-green radius-g">
                        <i class="icon-check-alt mr-5"></i> Salvar dados
                    </button>
                </nav>

                <label class="box box100">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Endereço</small>
                    <input type="text" name="address" class="form input-form-larg box-silver" placeholder="Endereço" value="<?= $cont->address ?>">
                </label>

                <label class="box box50">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">Telefone</small>
                    <input type="text" name="phone" class="form input-form-larg box-silver" placeholder="Telefone" value="<?= $cont->phone ?>">
                </label>

                <label class="box box50">
                    <small class="small-titulo-2 f-silver f-semibold t-upper">E-mail</small>
                    <input type="text" name="email" class="form input-form-larg box-silver" placeholder="E-mail" value="<?= $cont->email ?>">
                </label>
            </form>
        </div>
    </div>
</div>
