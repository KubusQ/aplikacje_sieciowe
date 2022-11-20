{extends file="main.tpl"}

{block name=content}

<div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
</div>

<form action="{$conf->action_url}calcCompute" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Kalkulator</legend>
	<fieldset>
        <div class="pure-control-group">
			<label for="id_x">Podaj kwotę: </label>
			<input id="id_x" type="text" name="x" value="{$form->x}" />
		</div>
        <div class="pure-control-group">
		<label for="id_y">Podaj oprocentowanie: </label>
		<input id="id_y" type="text" name="y" value="{$form->y}" />
		</div>
        <div class="pure-control-group">
			<label for="id_z">Podaj liczbę lat: </label>
			<input id="id_z" type="text" name="z" value="{$form->z}" />
		</div>
		<div class="pure-controls">
			<input type="submit" value="Oblicz" class="pure-button pure-button-primary"/>
		</div>
	</fieldset>
</form>	

{include file='messages.tpl'}

{if isset($res->res)}
<div class="messages info">
	<p>Miesięczna rata: {$res->res}</p>
	<p>Suma kredytu: {{$res->sum}}</p>
</div>
{/if}

{/block}