<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Data Event &mdash; EventSync</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="section-header">
    <h1>Event</h1>
    <div class="section-header-button">
      <a href="<?= site_url('gawe/add'); ?>" class="btn btn-primary">Add New</a>
    </div>
  </div>

  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible show fade">
      <div class="alert body">
        <button class="close" data-dismiss="alert">x</button>
        <b>Success !</b>
        <?= session()->getFlashdata('success'); ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible show fade">
      <div class="alert body">
        <button class="close" data-dismiss="alert">x</button>
        <b>Error !</b>
        <?= session()->getFlashdata('error'); ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="section-body">

    <div class="card">

      <div class="card-header">
        <h4>Data Event / Acara</h4>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-striped table-md" id="table1">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Acara</th>
              <th>Tanggal Acara</th>
              <th>Info Acara</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($gawe as $key => $value) : ?>
              <tr>
                <td><?= $key + 1; ?></td>
                <td><?= $value->name_gawe; ?></td>
                <td><?= date('d/m/y', strtotime($value->date_gawe)); ?></td>
                <td><?= $value->info_gawe; ?></td>
                <td class="text-center" style="width: 15%;">
                  <a href="<?= site_url('gawe/edit/' . $value->id_gawe); ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                  <form action="<?= site_url('gawe/' . $value->id_gawe); ?>" method="post" class="d-inline" id="del-<?= $value->id_gawe?>">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button href="submit" class="btn btn-danger btn-sm" data-confirm="Hapus Data?|Apakah Anda Yakin?" data-confirm-yes="submitDel(<?= $value->id_gawe; ?>)"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>