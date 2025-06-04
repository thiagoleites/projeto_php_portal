<?php 
use Core\View;
View::extend('layouts/main'); 

?>

<?php View::start('content'); ?>
<div class="container">
    <h1>Bem vindo</h1>
    <p>Bem-vindo ao painel de controle! - Página Dashboard</p>
<?php View::end(); ?>