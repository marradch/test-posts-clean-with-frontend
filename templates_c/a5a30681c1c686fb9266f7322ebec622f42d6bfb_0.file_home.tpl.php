<?php
/* Smarty version 5.8.0, created on 2026-05-12 15:48:10
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a034bbad8ec18_28907608',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5a30681c1c686fb9266f7322ebec622f42d6bfb' => 
    array (
      0 => 'home.tpl',
      1 => 1778600608,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a034bbad8ec18_28907608 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/templates';
?><!DOCTYPE html>
<html>
<head>
    <title><?php echo $_smarty_tpl->getValue('title');?>
</title>
</head>
<body>

<h1>Привет, <?php echo $_smarty_tpl->getValue('name');?>
!</h1>

</body>
</html><?php }
}
