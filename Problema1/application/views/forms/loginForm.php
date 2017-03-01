<div class="row">
	<?php if (isset($form['error'])) { ?>

	<div class="alert alert-danger" role="alert"><?= $form['error'] ?></div>

	<?php } ?>

	<div class="col-md-5">
		<h3>Acceso usuario</h3>
		<hr />
		<?= $form['form_login'] ?>
		
		<div class="form-group">
			<label for="userNameLogin" class="col-sm-2 control-label">Usuario: </label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="userNameLogin"
					name="userNameLogin" placeholder="">
			</div>
		</div>

		<div class="form-group">
			<label for="passLogin" class="col-sm-2 control-label">Contraseña: </label>
			<div class="col-sm-10">
				<input type="password" class="form-control" name="passLogin"
					id="passLogin" placeholder="">
			</div>
		</div>

		<input type="hidden" value="<?= $form['token'] ?>" name="tokenLogin" /> 

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Aceptar</button>
				<a href="<?= site_url('userController/ResetPass') ?>" class="pull-right">Recuperar contraseña</a>
				<p>
				<a href="<?= site_url('userController/CreateUserForm') ?>" class="pull-right">Nuevo usuario</a>
				</p>
			</div>
		</div>
		</form>
	</div>
</div>