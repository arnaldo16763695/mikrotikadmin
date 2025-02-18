<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="row align-items-center justify-content-center min-vh-100 ">
    <div class="col col-12 col-md-6 col-lg-6  mt-4 ">
        <div class="card shadow-lg rounded">
            <div class="card-body p-4">
               
                <h5 class="card-title text-center fw-bold ">Agregar usuario</h5>
                <form action="<?= base_url('saveUser') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" class="form-control" id="rut" name="rut" placeholder="rut" value="<?= set_value('rut'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= set_value('email'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="pass" name="password" placeholder="*********">
                    </div>
                    <div class="mb-3">
                        <label for="repass" class="form-label">Repetir contraseña</label>
                        <input type="password" class="form-control" id="repass" name="repassword" placeholder="*********">
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