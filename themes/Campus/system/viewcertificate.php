<!doctype html>
<html lang="pt-br">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap');
        
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        @page {margin: 0 0 -40px 0; !important;}
        
        body {
            background: #fff !important;
            font-family: 'Rubik', sans-serif;
        }

        .img {width: 100%; height: auto;}

        .bg-orange {background-color: #f9bf1e;}
        .f-black {color: #333;}
        .f-orange {color: #f9bf1e;}

        .f-light {}
        .f-regular {}
        .f-semibold {}

        .t-center {text-align: center}
        .t-upper {text-transform: uppercase}
        .round {-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;}

        .flex-container {display: flex;}
        .flex-direction-column {flex-direction: column;}
        .flex-justify-center {justify-content: center;}
        .flex-itens-center {align-items: center;}

        .content-certificate-single {height: calc(100vh);}
        .content-certificate-single .certificate {
            width: 100%;
            min-height: 400px;
            padding: 40px 40px 0 40px;
            position: relative;
        }

        .content-certificate-single .certificate aside {
            width: 250px;
            height: 100%;
            position: absolute;
            right: 20px;
            top: 0;
            background-color: rgba(249, 191, 30, .2);
        }
        .content-certificate-single .certificate aside .content-aside {
            width: 190px;
            height: 100%;
            position: absolute;
            left: 30px;
            top: 0;
        }
        .content-certificate-single .certificate aside .content-aside .icon {
            position: absolute;
            width: 230px;
            height: 230px;
            top: 80px;
            left: -20px;
        }

        .content-certificate-single .certificate .content {margin-right: 250px;}
        .content-certificate-single .certificate .content .logo {width: 250px; margin: 0 auto; margin-bottom: 50px;}
        .content-certificate-single .certificate .content .frame {width: 80px; height: 2px; margin: 0 auto;}
        .content-certificate-single .certificate .content h1 {font-size: 70px; margin-bottom: 15px;}
        .content-certificate-single .certificate .content .title h1 span {font-size: 30px; font-weight: lighter; display: block; letter-spacing: 8px;}
        .content-certificate-single .certificate .content .description {margin-top: 50px;}
        .content-certificate-single .certificate .content .description .text {font-size: 17px;}
        .content-certificate-single .certificate .content .description h2 {font-size: 26px; letter-spacing: 2px;}
        .content-certificate-single .certificate .content .description .desc {font-size: 17px; line-height: 29px; margin-top: 50px;}
        .content-certificate-single .certificate .content .signature {width: 220px; position: absolute; bottom: 10px; left: 50%; margin-left: -50px}
        .content-certificate-single .certificate .content .signature .img {margin-bottom: 0;}
        .content-certificate-single .certificate .content .signature .text {font-size: 15px; margin-top: 5px;}
        .content-certificate-single .certificate .content .signature .text strong {font-size: 13px; display: block;}
    </style>
</head>
<body>
<div class="content-certificate-single flex-container flex-direction-column flex-justify-center flex-itens-center">
    <div class="certificate">
        <div class="content">
            <div class="logo">
                <img src="<?= CAMPUS ?>/images/logo2.png" class="img">
            </div>

            <div class="title t-center">
                <h1 class="t-upper f-semibold f-orange">Certificado
                    <span class="f-black f-light">de conclusão</span>
                </h1>
                <div class="frame bg-orange"></div>
            </div>

            <div class="description t-center">
                <p class="text f-light f-black">Informamos que o aluno:</p>
                <h2 class="t-upper f-semibold f-black"><?= $student->name ?> <?= $student->lastname ?></h2>
                <p class="desc f-light f-black">
                    Cujo o CPF é
                    <span class="f-regular"><?= $student->document ?></span>, foi certificado no curso
                    <strong class="f-regular f-orange-2"><?= $course->title ?></strong>
                    pela empresa
                    <strong class="f-regular"><?= MANGACODE['company'] ?></strong>, cujo o CNPJ é
                    <span class="f-regular"><?= MANGACODE['cnpj'] ?></span> no período de
                    <span class="f-regular"><?= date('d/m/Y', strtotime($certificate->start_view)) ?></span> a
                    <span class="f-regular"><?= date('d/m/Y', strtotime($certificate->end_view)) ?></span>.
                </p>
            </div>

            <div class="signature t-center">
                <div class="img">
                    <img src="<?= CAMPUS ?>/images/signature.png" class="img">
                </div>
                <div class="frame bg-orange"></div>
                <p class="text f-light f-black"><?= MANGACODE['responsible'] ?>
                    <strong class="f-orange f-regular">CEO - <?= COMPANY_NAME ?></strong>
                </p>
            </div>
        </div>
        <aside>
            <div class="content-aside bg-orange">
                <div class="icon">
                    <img src="<?= CAMPUS ?>/images/logo3.png" class="img round">
                </div>
            </div>
        </aside>
    </div>
</div>
</body>
</html>