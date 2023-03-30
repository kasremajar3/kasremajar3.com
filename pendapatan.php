<?php
require 'connection.php';
checkLogin();
$pendapatan = mysqli_query($conn, "SELECT * FROM pendapatan INNER JOIN user ON pendapatan.id_user = user.id_user");

if (isset($_POST['btnAddPendapatan'])) {
  if (addPendapatan($_POST) > 0) {
    setAlert("Pendapatan has been added", "Successfully added", "success");
    header("Location: pendapatan.php");
  }
}

if (isset($_POST['btnEditPendapatan'])) {
  if (editPendapatan($_POST) > 0) {
    setAlert("Pendapatan has been changed", "Successfully changed", "success");
    header("Location: pendapatan.php");
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <?php include 'include/css.php'; ?>
  <title>Pendapatan</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include 'include/navbar.php'; ?>

    <?php include 'include/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm">
              <h1 class="m-0 text-dark">Pendapatan</h1>
            </div><!-- /.col -->
            <div class="col-sm text-right">
              <?php if ($_SESSION['id_jabatan'] !== '3') : ?>
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahPendapatanModal"><i class="fas fa-fw fa-plus"></i> Tambah Pendapatan</button>
                <!-- Modal -->
                <div class="modal fade text-left" id="tambahPendapatanModal" tabindex="-1" role="dialog" aria-labelledby="tambahPendapatanModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form method="post">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="tambahPendapatanModalLabel">Tambah Pendapatan</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="jumlah_pendapatan">Jumlah Pendapatan</label>
                            <input type="number" name="jumlah_pendapatan" id="jumlah_pendapatan" required class="form-control" placeholder="Rp.">
                          </div>
                          <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" required class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Close</button>
                          <button type="submit" name="btnAddPendapatan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              <?php endif ?>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="table_id">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Username</th>
                      <th>Keterangan</th>
                      <th>Tanggal Pendapatan</th>
                      <th>Jumlah Pendapatan</th>
                      <?php if ($_SESSION['id_jabatan'] !== '3') : ?>
                        <th>Aksi</th>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($pendapatan as $dp) : ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $dp['username']; ?></td>
                        <td><?= $dp['keterangan']; ?></td>
                        <td><?= date("d-m-Y, H:i:s", $dp['tanggal_pendapatan']); ?></td>
                        <td>Rp. <?= number_format($dp['jumlah_pendapatan']); ?></td>
                        <?php if ($_SESSION['id_jabatan'] !== '3') : ?>
                          <td>
                            <a href="" class="badge badge-success" data-toggle="modal" data-target="#editPendapatanModal<?= $dp['id_pendapatan']; ?>"><i class="fas fa-fw fa-edit"></i> Ubah</a>
                            <div class="modal fade text-left" id="editPendapatanModal<?= $dp['id_pendapatan']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPendapatanModalLabel<?= $dp['id_pendapatan']; ?>" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form method="post">
                                  <input type="hidden" name="id_pendapatan" value="<?= $dp['id_pendapatan']; ?>">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editPendapatanModalLabel<?= $dp['id_pendapatan']; ?>">Ubah Pendapatan</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="form-group">
                                        <label for="jumlah_pendapatan<?= $dp['id_pendapatan']; ?>">Jumlah Pendapatan</label>
                                        <input type="number" name="jumlah_pendapatan" id="jumlah_pendapatan<?= $dp['id_pendapatan']; ?>" required class="form-control" placeholder="Rp." value="<?= $dp['jumlah_pendapatan']; ?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="keterangan<?= $dp['id_pendapatan']; ?>">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan<?= $dp['id_pendapatan']; ?>" required class="form-control"><?= $dp['keterangan']; ?></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-fw fa-times"></i> Close</button>
                                      <button type="submit" name="btnEditPendapatan" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Save</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <?php if ($_SESSION['id_jabatan'] == '1') : ?>
                              <a href="hapus_pendapatan.php?id_pendapatan=<?= $dp['id_pendapatan']; ?>" class="badge badge-danger btn-delete" data-nama="Pendapatan : Rp. <?= number_format($dp['jumlah_pendapatan']); ?> | <?= $dp['keterangan']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                            <?php endif ?>
                          </td>
                        <?php endif ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
    </footer>

  </div>
</body>

</html>