
<div class="row"> 
    <?php if (isset($userData['error'])) { ?>
       <div class="alert alert-danger" role="alert"><?= $$userData['error'] ?></div>
    <?php } ?>

    <div class="col-md-5">
    <h3>Editar Usuario</h3>
    <hr />
        <?= $form['form_edit'] ?>
            
        <div class="form-group">
          <label for="userName" class="col-sm-2 control-label">Username</label>
          <div class="col-sm-10">
            <p class="form-control"><?= $userData['userName'] ?></p>
          </div>
        </div>

        <!--
        <div class="form-group <?php if (isset($form['pass'])) { ?> has-error <?php } ?>">
            <label for="pass" class="col-sm-2 control-label">Nueva contraseña</label>
            <div class="col-sm-10">
                <input type="pass" class="form-control" id="pass"
                    name="pass" placeholder="Contraseña"> <span><?= isset($form['pass']) ? $form['pass'] : '' ?></span>
            </div>
        </div>

        <div class="form-group <?php if (isset($form['passConf'])) { ?> has-error <?php } ?>">
            <label for="passConf" class="col-sm-2 control-label">Repetir
                contraseña</label>
            <div class="col-sm-10">
                <input type="pass" class="form-control" name="passConf"
                    id="passConf" placeholder="Confirmar contraseña"> <span><?= isset($form['passConf']) ? $form['passConf'] : '' ?></span>
            </div>
        </div>
        -->

        <div
            class="form-group <?php if (isset($form['email'])) { ?> has-error <?php } ?>">
            <label for="email" class="col-sm-2 co ntrol-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="<?=$userData['email']?>"> <span><?= isset($form['email']) ? set_value($form['email']) : '' ?></span>
            </div>

        </div>

        <hr />
        <div
            class="form-group <?php if (isset($form['name'])) { ?> has-error <?php } ?>">
            <label for="name" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name"
                    value="<?=$userData['name']?>"> <span><?= isset($form['name']) ? $form['name'] : '' ?></span>
            </div>
        </div>
        <div
            class="form-group <?php if (isset($form['surnames'])) { ?> has-error <?php } ?>">
            <label for="surnames" class="col-sm-2 control-label">Apellidos</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="surnames"
                    id="surnames" value="<?=$userData['surnames']?>"> <span><?= isset($form['surnames']) ? $form['surnames'] : '' ?></span>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['dni'])) { ?> has-error <?php } ?>">
            <label for="dni" class="col-sm-2 control-label">DNI</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dni" id="dni" value="<?=$userData['dni']?>"> <span><?= isset($form['dni']) ? $form['dni'] : '' ?></span>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['address'])) { ?> has-error <?php } ?>">
            <label for="address" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address"
                    id="address" value="<?=$userData['address']?>"> <span><?= isset($form['address']) ? $form['address'] : '' ?></span>
            </div>
        </div>

        <div class="form-group ">
            <label for="province" class="col-sm-2 control-label">Provincia</label>
            <div class="col-sm-10">
                <select class="form-control" name="province" value="<?=$userData['idProvince']?>" id="province"> <?php foreach ($provinceList as $row) { ?>
                    <option value="<?= $row['idProvince'] ?>"><?= $row['provinceName'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['cp'])) { ?> has-error <?php } ?>">
            <label for="cp" class="col-sm-2 control-label">Código Postal</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cp" id="cp"
                   value="<?=$userData['cp']?>"> <span><?= isset($form['cp']) ? $form['cp'] : '' ?></span>
            </div>
        </div>

        <input type="hidden" value="<?= $form['token'] ?>" name="token" />
        <input type="hidden" value="<?= $form['id'] ?>" name="id" />

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
        </form>
    </div>   