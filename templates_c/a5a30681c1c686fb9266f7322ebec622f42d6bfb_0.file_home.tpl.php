<?php
/* Smarty version 5.8.0, created on 2026-05-13 11:09:44
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a045bf8570a13_69939484',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5a30681c1c686fb9266f7322ebec622f42d6bfb' => 
    array (
      0 => 'home.tpl',
      1 => 1778670582,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:partials/posts.tpl' => 1,
  ),
))) {
function content_6a045bf8570a13_69939484 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/templates';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_15916998996a045bf856d8c0_81996680', "title");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_284782156a045bf856e692_41046530', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout.tpl", $_smarty_current_dir);
}
/* {block "title"} */
class Block_15916998996a045bf856d8c0_81996680 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/templates';
?>

    Список постов
<?php
}
}
/* {/block "title"} */
/* {block "content"} */
class Block_284782156a045bf856e692_41046530 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/var/www/html/templates';
?>

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
        <?php $_smarty_tpl->renderSubTemplate("file:partials/posts.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('posts'=>$_smarty_tpl->getValue('categoryData')['posts']), (int) 0, $_smarty_current_dir);
?>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}
}
/* {/block "content"} */
}
