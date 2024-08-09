<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?= $v->insert("inc/head") ?>
</head>
<body class="bg-login">
<?= $v->section('content') ?>

<div class="mask_modal"></div>
<div class="form_load">
    <div></div>
    <div></div>
</div>
<div class="trigger-box"></div>

<script type="text/javascript">
    window.sr = ScrollReveal({reset: false});
    sr.reveal('.reveal_bottom', {
        duration: 300,
        origin: 'bottom',
        distance: "20px"
    });
</script>
</body>
</html>