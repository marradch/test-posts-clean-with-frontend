<?php
/* Smarty version 5.8.0, created on 2026-05-13 09:53:22
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a044a12d5fcb1_86117797',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5a30681c1c686fb9266f7322ebec622f42d6bfb' => 
    array (
      0 => 'home.tpl',
      1 => 1778665999,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a044a12d5fcb1_86117797 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/templates';
?><!DOCTYPE html>
<html>
<head>
    <title>Тестовый блог</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<h1>Тестовый блог</h1>
<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categoriesData'), 'categoryData', false, 'categoryId');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('categoryId')->value => $_smarty_tpl->getVariable('categoryData')->value) {
$foreach0DoElse = false;
?>
    <h2><?php echo $_smarty_tpl->getValue('categoryData')['title'];?>
&nbsp;&nbsp;&nbsp;<a href="/category/<?php echo $_smarty_tpl->getValue('categoryId');?>
">Смотреть все</a></h2>
    <div class="category_posts">
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('categoryData')['posts'], 'post');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('post')->value) {
$foreach1DoElse = false;
?>
            <div class="post_container">
                <div class="img_wrapper">
                    <img src="<?php echo $_smarty_tpl->getValue('post')['image'];?>
"/>
                </div>
                <p><?php echo $_smarty_tpl->getValue('post')['title'];?>
</p>
                <p><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('post')['published_at'],"%d.%m.%Y");?>
</p>
                <p><?php echo $_smarty_tpl->getValue('post')['description'];?>
</p>
                <a href="/post/<?php echo $_smarty_tpl->getValue('post')['id'];?>
">Читать полностью</a>
            </div>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </div>
<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

</body>
</html><?php }
}
