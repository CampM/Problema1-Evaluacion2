<div class="col-md-12">

	<div class="row">
		<?php if (isset($form['error'])) { ?>

		<div class="alert alert-danger" role="alert"><?= $form['error'] ?></div>

		<?php } ?>

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

			<?php if (isset($cart['cartProductList'])){foreach ($cart['cartProductList'] as $row) { ?>
			<tr>
				<td><?= $row['idProduct'] ?></td>
				<td><?= $row['name'] ?></td>
				<td><?= $row['price'] ?>€</td>
				<td><?= $row['quantity'] ?></td>
				<td><?= $row['price'] * $row['quantity'] ?> €</td>
			</tr>
			<?php }} ?>
			<tr>
				<td></td>
				<td>Total</td>
				<td></td>
				<td><?= $cart['totalProduct'] ?></td>
				<td><?= $cart['totalPrice'] ?> €</td>
			</tr>
		</table>

		<p>
			<a href="<?= site_url('orderController/ProcessorSendForm') ?>" class="btn btn-primary">
				Confirmar pedido
			</a>
		</p>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function(){    

		$('[name="update"]').click(function(){
			var source = $(this);
			var tr = source.closest('tr');
			var id = tr.find('[name="idProduct"]').val();
			var quantity = tr.find('[name="quantity"]').val();

			if ($.isNumeric(quantity) && quantity > 0){
				$.ajax({
					url: '<?= site_url('/cartController/UpdateItemCart/') ?>' + quantity + '/' + id,
				}).done(function(data){
					ReloadCart();
					tr.find('[data-section="total"]').html(data.newTotalRow + ' €');
					$('#tableTotalNProducts').html(data.totalProduct);
					$('#tableTotalPrice').html(data.totalPrice + ' €');
				});
			}

		});
	});



</script>