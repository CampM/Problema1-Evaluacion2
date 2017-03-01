
    <div>
        <?php foreach ($categoryList as $row) { ?> 
            <a href="<?= site_url('home/ShowProductList/' . $row->idCategory) ?> "> <?= $row->name ?></a> 
        <?php } ?>
    </div>

   
    <div>
        <?php foreach ($productList as $row) {?>
                <?php /*<!--<img src="<?= $row['image'] ?>">--> */ ?>
              

                    <h4>
                        <a href="<?= site_url('home/ShowProductById/' . $row->idProduct) ?>"><?=
                            $row->name ?></a>
                    </h4>

                    <h4><?= $row->price ?> €</h4>
        <?php } ?>
    <?= $pagination ?>
    </div>



