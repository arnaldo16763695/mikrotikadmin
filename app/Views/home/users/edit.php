<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="row align-items-center justify-content-center min-vh-100 ">
    <div class="col col-12 col-md-6 col-lg-6  mt-4 ">
        <div class="card shadow-lg rounded">
            <div class="card-body p-4">

                <h5 class="card-title text-center fw-bold ">Editar usuario hotspot</h5>
                <form action="<?= base_url('patchUser') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Rut</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="rut" value="<?= esc($usuario[0]['name']) ?>">
                        <input type="hidden" id="id" name="id" value="<?= esc($usuario[0]['.id']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" autocomplete="off" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= isset($usuario[0]['email']) ? esc($usuario[0]['email']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="pass" name="password" placeholder="*********">
                        <div id="passwordHelpBlock" class="form-text">
                            Si no deseas cambiar la contraseña deja ambos campos vacíos.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="repass" class="form-label">Repetir contraseña</label>
                        <input type="password" class="form-control" id="repass" name="repassword" placeholder="*********">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="disabled" id="disabled1" value="false" <?= esc($usuario[0]['disabled']) === 'false'? 'checked':'' ?> >
                        <label class="form-check-label" for="disabled1">
                            Activo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="disabled" id="disabled2" value="true" <?= esc($usuario[0]['disabled']) === 'true'? 'checked':'' ?>>
                        <label class="form-check-label" for="disabled2">
                            Inactivo
                        </label>
                    </div>

                    <div class="mb-3 mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                  

                </form>
                <?php if (session()->getFlashdata('errors') !== null): ?>
                    <div class="alert alert-danger my-3" role="alert">
                        <?= session()->getFlashdata(('errors'))  ?>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>