<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="internal-search-box">

    <div class="input-group">
        <input type="text" name="input-internal-search" id="input-internal-search" class="form-control" placeholder="Indicadores, normas, etc...">
        <div class="input-group-btn">
            <input type="button" class="btn btn-primary" id="btn-internal-search" value="Buscar" alt="Buscar" title="Buscar">
        </div><!-- /input-group-btn -->
    </div><!-- /input-group -->

    <div>
    	<ul id="results">
    	</ul>

        <div class="loading" style="display: none;">Carregando</div>

        <div class="error" style="display: none;">Ops! Houve um erro.</div>

        <div class="nothing" style="display: none;">Ops! Houve um erro.</div>
    </div>

</div>