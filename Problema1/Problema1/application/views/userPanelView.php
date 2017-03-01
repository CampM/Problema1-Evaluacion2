<div class="col-md-12">
    <?php if (isset($form['error'])) { ?>
       <div class="alert alert-danger" role="alert"><?= $form['error'] ?></div>
    <?php } ?>
	<h1>
		<small>Datos Personales</small>
	</h1>
	<label for=""> 
		<a href="<?= site_url('userController/EditUserForm/' . $user['idUser']) ?>">Editar usuario</a>
	</label>
	<div class="well">
		<p>Nombre: <?= $user['name'] . ' ' . $user['surnames'] ?></p>
		<p>DNI: <?= $user['dni'] ?></p>
		<p>Provincia: <?= $user['provinceName'] ?></p>
		<p>Dirección: <?= $user['address'] ?></p>
		<p>Código postal: <?= $user['cp'] ?></p>
	</div>


	<h1>
		<small>Pedidos en proceso</small>
	</h1>
	<table class="table table-hover">
		<tr>

			<th>Código</th>
			<th>Fecha de creación</th>
			<th>Fecha de entrega</th>
			<th>Estado Actual</th>
			<th>Operaciones</th>
		</tr>
		<?php foreach ($unprocessedOrder as $row) { ?>
			<tr>
				<form
					action="<?= site_url('orderController/CancelOrder/') ?><?= $unprocessedOrder['idOrder']  ?>">
				
				<td><?= $unprocessedOrder['idOrder'] ?></td>
				<td><?= $unprocessedOrder['dateOrder'] ?></td>
				<td>--</td>
				<td>Pendiente de procesar</td>
				<td><a class="btn btn-default"
					href="<?= base_url() ?>orderController/Invoice/<?= $unprocessedOrder['idOrder']  ?>">Ver</a>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-default" data-toggle="modal"
						data-target="#deleteModal">Eliminar</button>
				</td>

				<!-- Modal -->
				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
					aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">
									<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">Confirmación</h4>
							</div>
							<div class="modal-body">Este pedido será eliminado,
								¿estás seguro?</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default"
									data-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-primary" onclick=""
									id="confirmacion">Confirmar</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</tr>

		<?php } ?>
	</table>


	<h1>
		<small>Historial pedidos</small>
	</h1>
	<table class="table table-hover">
		<tr>
			<th>Código</th>
			<th>Fecha creación</th>
			<th>Fecha entrega</th>
			<th>Factura</th>
			<th>Estado Actual</th>
			<th>Operaciones</th>
		</tr>
		<?php foreach ($orderList as $row) { ?>
			<tr>
				<td><?= $row['idOrder'] ?></td>
				<td><?= $row['dateOrder'] ?></td>
				<td><?= $row['deliveredDate'] ?>-</td>
				<td><a href="<?= base_url() ?>orderController/Invoice/<?= $row['idOrder']  ?>/0"><span
						class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></td>
				<td><?= $row['stay'] ?></td>
				<td><a href="<?= base_url() ?>orderController/Invoice/<?= $row['idOrder']  ?>/1">Ver</a></td>
			</tr>

		<?php } ?>
	</table>


</div>

<script type="text/javascript">

</script>