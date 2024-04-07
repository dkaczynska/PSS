{extends file="../templates/main.tpl"}

{block name=footer}Zadanie wykonane na potrzeby zajęć z Projektowania Systemów Sieciowych{/block}

{block name=content}

<h2 class="content-head is-center">Kalkulator Kredytowy</h2>

<div class="pure-g">
<div class="l-box-lrg pure-u-1 pure-u-med-2-5">
	<form class="pure-form pure-form-stacked" action="{$app_url}/app/calc.php" method="post">
		<fieldset>

                    <label for="id_kwota">Kwota kredytu: </label>
                    <input id="id_kwota" type="text" name="kwota" value="{$form['kwota']}">
                    <label for="id_okres">Ile lat: </label>
                    <input id="id_okres" type="text" name="okres" value="{$form['okres']}">
                    <label for="id_procent">Oprocentowanie: </label>
                    <input id="id_procent" type="text" name="procent" value="{$form['procent']}">

			<button type="submit" class="pure-button">Oblicz</button>
		</fieldset>
	</form>
</div>

<div class="l-box-lrg pure-u-1 pure-u-med-3-5">

{* wyświeltenie listy błędów, jeśli istnieją *}
{if isset($messages)}
	{if count($messages) > 0} 
		<h4>Wystąpiły błędy: </h4>
		<ol class="err">
		{foreach  $messages as $msg}
		{strip}
			<li>{$msg}</li>
		{/strip}
		{/foreach}
		</ol>
	{/if}
{/if}

{* wyświeltenie listy informacji, jeśli istnieją *}
{if isset($infos)}
	{if count($infos) > 0} 
		<h4>Informacje: </h4>
		<ol class="inf">
		{foreach  $infos as $msg}
		{strip}
			<li>{$msg}</li>
		{/strip}
		{/foreach}
		</ol>
	{/if}
{/if}

{if isset($result)}
	<h4>Miesięczna kwota kredytu:</h4>
	<p class="res">
	{$result}
	</p>
{/if}

</div>
</div>

{/block}
