
<a href="<?php echo site_url(); ?>/Perfiles/" id="cancel-button" class="mdl-button mdl-js-button elemento" style="margin-left: 4px;">Cancelar</a>
<div class="mdl-tooltip mdl-tooltip--large" for="cancel-button" >Regresar al<br>listado de perfiles</div>
<?php if (isset($perfil_add)): ?>



<button id="add-button" style="margin-left: 4px;" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent elemento"><i class="material-icons" role="presentation">note_add</i> Finalizar</button>
<div class="mdl-tooltip mdl-tooltip--large" for="add-button">añadir perfil</div>

<?php endif ?>



<?php if (isset($perfil_edit)): ?>



<button id="edit-button" style="margin-left: 4px;" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent elemento"><i class="material-icons" role="presentation">edit</i> Modificar</button>
<div class="mdl-tooltip mdl-tooltip--large" for="edit-button">Finalizar <br>edición de perfil</div>




<?php endif ?>