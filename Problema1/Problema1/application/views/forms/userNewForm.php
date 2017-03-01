<div class="col-md-12">
    <?php if (isset($form['error'])) { ?>
       <div class="alert alert-danger" role="alert"><?= $form['error'] ?></div>
    <?php } ?>
    <div class="col-md-5">

        <h3>Nuevo Usuario</h3>
        <hr />
        <?= $form['form_signup'] ?>
        <div class="form-group <?php if (isset($form['userName'])) { ?> has-error <?php } ?>">

            <label for="userName" class="col-sm-2 control-label">Usuario</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="userName"
                    name="userName" value="<?= set_value('userName') ?>"> <span><?= isset($form['userName']) ? $form['userName'] : '' ?></span>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['pass'])) { ?> has-error <?php } ?>">
            <label for="pass" class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
                <input type="pass" class="form-control" id="pass"
                    name="pass" placeholder="Nueva contraseña"> <span><?= isset($form['pass']) ? $form['pass'] : '' ?></span>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['passConf'])) { ?> has-error <?php } ?>">
            <label for="passConf" class="col-sm-2 control-label">Repetir
                contraseña</label>
            <div class="col-sm-10">
                <input type="pass" class="form-control" name="passConf"
                    id="passConf" placeholder="Convirmar contraseña"> <span><?= isset($form['passConf']) ? $form['passConf'] : '' ?></span>
            </div>
        </div>


        <div
            class="form-group <?php if (isset($form['email'])) { ?> has-error <?php } ?>">
            <label for="email" class="col-sm-2 co ntrol-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= set_value('email') ?>"> <span><?= isset($form['email']) ? $form['email'] : '' ?></span>
            </div>

        </div>

        <hr />
        <div
            class="form-group <?php if (isset($form['name'])) { ?> has-error <?php } ?>">
            <label for="name" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name"
                    value="<?= set_value('name') ?>"> <span><?= isset($form['name']) ? $form['name'] : '' ?></span>
            </div>
        </div>
        <div
            class="form-group <?php if (isset($form['surnames'])) { ?> has-error <?php } ?>">
            <label for="surnames" class="col-sm-2 control-label">Apellidos</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="surnames"
                    id="surnames" value="<?= set_value('surnames') ?>"> <span><?= isset($form['surnames']) ? $form['surnames'] : '' ?></span>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['dni'])) { ?> has-error <?php } ?>">
            <label for="dni" class="col-sm-2 control-label">DNI</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="dni" id="dni"
                    value="<?= set_value('dni') ?>"> <span><?= isset($form['dni']) ? $form['dni'] : '' ?></span>
            </div>
        </div>

        <div
            class="form-group <?php if (isset($form['address'])) { ?> has-error <?php } ?>">
            <label for="address" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address"
                    id="address" value="<?= set_value('address') ?>">
            </div>
        </div>

        <div class="form-group ">
            <label for="province" class="col-sm-2 control-label">Provincia</label>
            <div class="col-sm-10">
                <select class="form-control" name="province" id="province"> <?php foreach ($provinceList as $row) { ?>
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
                    value="<?= set_value('cp') ?>"> <span><?= isset($form['cp']) ? $form['cp'] : '' ?></span>
            </div>
        </div>

        <input type="hidden" value="<?= $form['token'] ?>" name="token" /> 
        <?php if (isset($form['id'])) { ?> 
            <input type="hidden" value="<?= $form['id'] ?>" name="id" />
        <?php } ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
        </form>
    </div>