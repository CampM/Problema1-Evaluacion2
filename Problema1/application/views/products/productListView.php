
    <div class="own-category">
        <?php foreach ($categoryList as $row) { ?> 
            <a href="<?= site_url('home/ShowProductList/' . $row->idCategory) ?> "> <?= $row->name ?></a> 
        <?php } ?>
    </div>

   
    <div style="margin-top: 15px;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($productList as $row) {?>
                <?php /*<!--<img src="<?= $row['image'] ?>">--> */ ?>
              

                <tr>
                    <td style="width: 64px;">
                        <img width="64" height="64" src="<?= base_url('assets/images/products/' . $row->image)?>" 
                            onerror="this.src='<?= base_url('assets/images/products/' . 'unavailable.png')?>';" alt="">
                    </td>
                    <td style="padding-left: 15px;">
                        <a href="<?= site_url('home/ShowProductById/' . $row->idProduct) ?>">
                            <?= $row->name ?>
                        </a>
                    </td>
                    <td style="padding-left: 15px;">
                        <?= $row->price ?> €
                    </td>
                </tr>

                    
        <?php } ?>
            </tbody>
        </table>
        <div class="own-pagination">
            <?= $pagination ?>
        </div>
    </div>



