<div class="col-md-12">

	<div class="row">

		<h2>Contenido del Carrito de la Compra</h2>
		<hr />

		<table class="table table-bordered">
			<tr>
				<th>Código</th>
				<th>Concepto</th>
				<th>Precio</th>
				<th>Unidades</th>
				<th>Total</th>
			</tr>

			<?php if (isset($lineOrderList)){foreach ($lineOrderList as $row) { ?>
			<tr>
				<td><?= $row['product_idProduct'] ?></td>
				<td><?= $row['name'] ?></td>
				<td><?= $row['price'] ?> €</td>
				<td><?= $row['quantity'] ?></td>
				<td><?= $row['price'] * $row['quantity'] ?> €</td>
			</tr>
			<?php }} ?>
			<tr>
				<td></td>
				<td>Total</td>
				<td></td>
				<td><?= $order['quantity'] ?></td>
				<td><?= $order['price'] ?> €</td>
			</tr>
		</table>


		<h2>Datos de Facturacion</h2>
		<hr />

		<table class="table table-bordered">
			<tr>
				<td>Nombre</td>
				<td><?= $order['name'] ?> <?= $order['surnames'] ?></td>
			</tr>
			<tr>
				<td>Fecha del pedido</td>
				<td><?= $order['orderDate'] ?></td>
			</tr>
			<tr>
				<td>Direccion</td>
				<td><?= $order['address'] ?></td>
			</tr>
			<tr>
				<td>Codigo Postal</td>
				<td><?= $order['cp'] ?></td>
			</tr>
		</table>
	</div>
</div>