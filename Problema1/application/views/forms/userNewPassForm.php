<div class="row">
	<?php if (isset($form['error'])) { ?>

	<div class="alert alert-danger" role="alert"><?= $form['error'] ?></div>

	<?php } ?>

	<div class="col-md-5">
		<h3>Recuperar contraseña</h3>
		<hr />
		<?= $form['form_email'] ?>
		
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email: </label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="email" name="email" placeholder="">
				</div>
			</div>

			<input type="hidden" value="<?= $form['token'] ?>" name="tokenLogin" /> 

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Aceptar</button>
				</div>
			</div>
		</form>
	</div>
</div>