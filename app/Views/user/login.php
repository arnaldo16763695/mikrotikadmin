<?= $this->extend('layout/template'); ?>



<?= $this->section('content'); ?>
<div class="row align-items-center justify-content-center min-vh-100 ">
    <div class="col col-12 col-md-5 col-lg-4 ">
        <div class="card shadow-lg rounded">
            <div class="card-body p-4">
                <div class="pb-4">
                    <img src="<?= base_url('images/LogoGlobal-n.png') ?>" alt="Logo Globalsi" width="100" height="45">
                </div>
                <h5 class="card-title text-center fw-bold ">Inicio de Sesión</h5>
                <form action="<?= base_url('auth') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="pass" placeholder="*********">
                    </div>
                    <div class="mb-3">                        
                        <input type="submit" class="btn btn-primary" value="Entrar">
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