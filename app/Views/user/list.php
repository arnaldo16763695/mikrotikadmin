<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="row  justify-content-center  min-vh-100">
    <div class="col col-12 col-md-10">
        <div class="card shadow-lg rounded mt-4">
            <div class="card-body py-4">
                <div class="card-header d-flex align-items-center  justify-content-between ">
                    <h1>Usuarios del sistema</h1>
                    <a href="<?= base_url('users/add') ?>" class="btn btn-primary">Nuevo</a>
                </div>
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>status</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $dato): ?>
                            <?php if ($dato['email'] != 'admin@movinet.cl') { ?>
                                <tr>
                                    <td><?= esc($dato['name']) ?></td>
                                    <td><?= esc($dato['email']) ?></td>
                                    <td><?= esc($dato['active'] ? '✔️' : '❌') ?></td>
                                    <td><a class="px-4" title="Editar este registro" href="<?= base_url() . 'users/edit/' . esc($dato['id']) ?>"><i class="bi bi-pencil-square"></i></a> <a title="Eliminar este registro" href="#" onclick="confirmarEliminacion('<?= base_url() . 'users/delete/' . esc($dato['id']) ?>')"><i class="bi bi-trash"></i></a></td>
                                </tr>
                            <?php
                            }
                            ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (session()->getFlashdata('errors') !== null): ?>
                    <div class="alert alert-danger my-3" role="alert">
                        <?= session()->getFlashdata(('errors'))  ?>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    let table = new DataTable('#myTable', {
        responsive: true,
        language: {
            "sEmptyTable": "No hay datos disponibles en la tabla",
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "sInfoFiltered": "(filtrado de _MAX_ entradas totales)",
            "sInfoPostFix": "",
            "sLengthMenu": "Mostrar _MENU_ entradas",
            "sLoadingRecords": "Cargando...",
            "sProcessing": "Procesando...",
            "sSearch": "Buscar:",
            "sZeroRecords": "No se encontraron resultados",
            "oPaginate": {
                "sFirst": "Primero",
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": activar para ordenar la columna de manera descendente"
            }
        }
    });

    function confirmarEliminacion(url) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Redirige a la URL de eliminación
            }
        });
    }
</script>
<?= $this->endSection('content'); ?>