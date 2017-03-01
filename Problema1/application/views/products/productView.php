
<div>
	<p>Tienda Virtual</p>
	<div class="list-group">
		<?php foreach ($categoryList as $row) { ?> <a
			href="<?= base_url() ?>home/category/<?= $row.idCategoria?>"
			<?= $row.nombre ?></a> 
		<?php } ?>
	</div>
</div>

<div >
	<div>


		<h1>
			<a href="<?= base_url() ?>home/producto/<?= producto.idProducto?>"><?=
				producto.nombre ?></a>
		</h1>
	</div>

	<div>
		<div>
			<img src="<?= producto.imagen ?>" alt="">
		</div>
		<div>
			<address>
				<strong>Código Producto:</strong> <span><?= producto.codigo ?></span><br />
				<strong>Stock:</strong> <span>En Stock</span><br />
			</address>
		</div>
		<div>
			<h2>
				<strong>Precio: €<?= producto.precio ?></strong> <small>Iva incluído:
					<?= producto.iva ?>%</small><br /> <br />
			</h2>
		</div>
		<div>
			<?= form.form_open|raw ?>
			<div id="formAdd">
				<label for="cantidad">Unidades</label> <input type="text"
					id="cantidad" name="cantidad" placeholder="">
			</div>
			<!-- <button type="submit" class="btn btn-primary">Añadir al carro</button>-->
			<p id="add">Añadir al carro</p>
			<span id="errorCantidad"></span>
			</form>
		</div>		
	</div>
	
	<div>
			<div>
				<p><?= producto.anuncio ?></p>
			</div>
		</div>

</div>
<?php endblock ?> <?php block script ?>


<script type="text/javascript">

	$(document).ready(function(){

		$('#add').click(function(){
						
			var cantidad = parseInt($('#cantidad').val());  
			
			// filtramos valor
			if ($.isNumeric(cantidad) && cantidad > 0){
				$.get("<?= base_url() ?>carro/ajaxAddCart/"+cantidad+"/<?= producto.idProducto ?>","",function(data)
				{
				    var json = JSON.parse(data);
				    //console.log(json);
				   
			    	var html = "";
			    

			    	var articulos_total = json.articulos_total;
			    	var precio_total = json.precio_total;	
			    	

			    	$.each(json.items, function(key, value) {
			    	    console.log(key,value);
			    	    html += "<tr><td>"+value.nombre+"</td><td>"+value.precio+" € x " +value.cantidad+ "</td></tr>";				    	   	   		    		 			  	    
			    	    
				    });

			    	
			    	$('#cesta').html('<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>'+ 
					 ' Cesta '+articulos_total+'<span class="caret"></span> </a>');
			    	$('#table_cart').html(html);		    			 
				});
			}
			else
			{
			    // mostrar error 			    
			    $('#formAdd').addClass('has-error');
			    $('#errorCantidad').text('Introduce un valor correcto');
			}		
			
		});		

		$('#cantidad').click(function(){
			 if ($('#formAdd').hasClass('form-group has-error')){		    	
		    	 $('#formAdd').removeClass('form-group has-error').addClass('form-group');
		    	 $('#errorCantidad').text('');
			}
		});	
		
	});



</script>