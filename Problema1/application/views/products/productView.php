<?php
	$iva = $product->iva;
	if ($iva == NULL)
	{
		$iva = 1;
	}

	$priceIVA = $product->price * $iva;
	$finalPrice = $priceIVA;

    if (($product->discount != NULL) && ($product->discount > 0)){ 
        $finalPrice = $finalPrice * (100 - $product->discount) / 100;
    }

    $priceIVA = round($priceIVA, 2);
    $finalPrice = round($finalPrice, 2);
?>
<div class="own-category">
    <?php foreach ($categoryList as $row) { ?> 
        <a href="<?= site_url('home/ShowProductList/' . $row->idCategory) ?> "> <?= $row->name ?></a> 
    <?php } ?>
</div>

<div>
	<div>

		<div class="pull-left">
			<img width="256" height="256" src="<?= base_url('assets/images/products/' . $product->image)?>" 
				onerror="this.src='<?= base_url('assets/images/products/' . 'unavailable.png')?>';" alt="">
		</div>

		<div class="pull-left" style="margin-left: 25px;">

			<h1 style="margin-lef">
				<?=$product->name ?>
			</h1>

			<div>
				<strong>Descripcion: </strong> <?= $product->description ?>
			</div>

			<div>
				<strong>Stock: </strong> <?= $product->stock ?>
			</div>

			<div>
				<strong>Precio: </strong> 
				<?php
				if (($product->discount != NULL) && ($product->discount > 0)){ 
				echo "<span class='old-price'>($priceIVA €)</span> $finalPrice €";
			    }else{
				echo $priceIVA . ' € IVA incluido.';
			    }
				?>
			</div>

			<?php if ($product->stock > 0){?>
			<div style="margin-top: 15px;">
				<input class="form-control" type="text" id="quantity" style="display:inline-block; width:50px;">
				<button class="btn btn-primary" id="add">
					<span class="glyphicon glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Añadir a la cesta
				</button>
			</div>
			<?php }	?>
		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function(){
		var maxQuantity = <?= $product->stock ?>;

		$('#add').click(function(){
			var currentQuantity = parseInt($('#quantity').val());
			
			// filtramos valor
			if ($.isNumeric(currentQuantity) && (currentQuantity > 0) && (currentQuantity <= maxQuantity)){

				$.ajax({
                    url: '<?= site_url('/cartController/AddItemCart/') ?>' + currentQuantity + '/' + <?= $product->idProduct ?>,
				}).done(function(isValid){
					if (isValid){
						ReloadCart();
					}
				});
			}	
		});	
		
	});

</script>