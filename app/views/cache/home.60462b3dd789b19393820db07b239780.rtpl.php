<?php if(!class_exists('Rain\Tpl')){exit;}?><h1>Seja bem-vind@ à nova versão beta da calculadora!</h1>

<p>Nesta nova versão, o processo de cálculo é otimizado a partir do Party Hunt.</p>
<p>Para utilizar a calculadora, siga os seguintes passos:</p>
<ul>
    <li>No Tibia, use a função "Copy to clipboard" do Party Hunt.</li>
    <li>Aqui na calculadora, cole o Party Hunt.</li>
    <li>Se for necessário ajustar algum valor, faça as alterações.</li>
    <li>Agora é só acionar o botão Calcular.</li>
</ul>

<form id="analyser-form">
    <textarea placeholder="Cole o Party Hunt" class="ui-resizable"></textarea>
    <input id="btn-submit" type="submit" value="Calcular" class="ui-button ui-corner-all ui-widget">
</form>


<div id="result" class="ui-state-highlight"></div>