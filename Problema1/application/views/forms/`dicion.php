          <div class="form-group <?php if form.email|length -?> has-error <?php- endif -?>">
            <label for="email" class="col-sm-2 co ntrol-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ? set_value('email') : form.usuario.email  ?>">
                <span><?= form.email|raw ?></span>
            </div>
           
          </div>         
          
                  
          <hr />
           <div class="form-group <?php if form.nombre|length -?> has-error <?php- endif -?>">
            <label for="nombre" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nombre" id="nombre" value="<?= set_value('nombre') ? set_value('nombre') : form.usuario.nombre  ?>">
               <span><?= form.nombre|raw ?></span>
            </div>
          </div>
           <div class="form-group <?php if form.apellidos|length -?> has-error <?php- endif -?>">
            <label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?= set_value('apellidos') ? set_value('apellidos') : form.usuario.apellidos ?>">
               <span><?= form.apellidos|raw ?></span>
            </div>
          </div>
          
          <div class="form-group <?php if form.dni|length -?> has-error <?php- endif -?>">
            <label for="dni" class="col-sm-2 control-label">DNI</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="dni" id="dni" value="<?= set_value('dni') ? set_value('dni') : form.usuario.dni ?>">
               <span><?= form.dni|raw ?></span>
            </div>
          </div>
          
          <div class="form-group <?php if form.direccion|length -?> has-error <?php- endif -?>">
            <label for="direccion" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="direccion" id="direccion" value="<?= set_value('direccion') ? set_value('direccion') : form.usuario.direccion ?>">
            </div>
          </div>
          
          <div class="form-group ">
          <label for="provincia" class="col-sm-2 control-label">Provincia</label>         
              <div class="col-sm-10">
                <select class="form-control" name="provincia" id="provincia">
                    <?php for provincia in provincias ?>
                    <option value="<?= provincia.idProvincia ?>" <?php if provincia.idProvincia == form.usuario.idProvincia ?>selected<?php endif ?>><?= provincia.provincia
                        ?></option> <?php endfor ?>
                </select>               
              </div>
          </div>
          
           <div class="form-group <?php if form.cp|length -?> has-error <?php- endif -?>">
            <label for="cp" class="col-sm-2 control-label">Código Postal</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="cp" id="cp" value="<?= set_value('cp') ? set_value('cp') : form.usuario.cp ?>">
               <span><?= form.cp|raw ?></span>
            </div>
          </div>
          
          <input type="hidden" value="<?= form.token ?>" name="token" />
           <input type="hidden" value="<?= form.id ?>" name="id" />
         
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-primary">Guardar datos</button>
            </div>
          </div>