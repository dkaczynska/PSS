<?php
/* Smarty version 3.1.30, created on 2024-05-09 02:16:59
  from "C:\xampp\htdocs\php_07_role\app\views\LoginView.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_663c15fb7a0d99_95369888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '61e7a82ccd1747d6c26028906ddea5bb2c6acfa0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\php_07_role\\app\\views\\LoginView.tpl',
      1 => 1715212385,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:main.tpl' => 1,
    'file:messages.tpl' => 1,
  ),
),false)) {
function content_663c15fb7a0d99_95369888 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1172611861663c15fb79bb80_10925428', 'footer');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_795063831663c15fb7a07b6_33877389', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'footer'} */
class Block_1172611861663c15fb79bb80_10925428 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Zadanie wykonane na potrzeby zajęć z Projektowania Systemów Sieciowych<?php
}
}
/* {/block 'footer'} */
/* {block 'content'} */
class Block_795063831663c15fb7a07b6_33877389 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<form action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
login" method="post"  class="pure-form pure-form-aligned bottom-margin">
	<legend>Logowanie do systemu</legend>
	<fieldset>
        <div class="pure-control-group">
			<label for="id_login">login: </label>
			<input id="id_login" type="text" name="login"/>
		</div>
        <div class="pure-control-group">
			<label for="id_pass">pass: </label>
			<input id="id_pass" type="password" name="pass" /><br />
		</div>
		<div class="pure-controls">
			<input type="submit" value="zaloguj" class="pure-button pure-button-primary"/>
		</div>
	</fieldset>
</form>	

<?php $_smarty_tpl->_subTemplateRender("file:messages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php
}
}
/* {/block 'content'} */
}
