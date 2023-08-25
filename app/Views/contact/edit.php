<?= $this->extend('layout/default') ?>

<?= $this->section('title') ?>
<title>Update &mdash; EventSync</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="<?= site_url('contacts'); ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Contact</h1>
  </div>

  <div class="section-body">

    <div class="card">

      <div class="card-header">
        <h4>Edit Kontak</h4>
      </div>
      <div class="card-body col-md-6">
        <form action="<?= site_url('contacts/'. $contact->id_contact); ?>" method="post" autocomplete="off">
          <?= csrf_field(); ?>
          <input type="hidden" name="_method" value="PUT">
          <div class="form-group">
            <label for="">Group *</label>
            <select name="id_group" id="" class="form-control" required>
              <option value="" hidden></option>
              <?php foreach ($group_data as $key => $value) : ?>
                <option value="<?= $value->id_group; ?>" <?= $contact->id_group == $value->id_group ? 'selected' : null ?> ><?= $value->name_group; ?></option>
              <?php endforeach; ?>
              <option value=""></option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Nama Contact *</label>
            <input type="text" name="name_contact" value="<?= $contact->name_contact; ?>" class="form-control" required autofocus>
          </div>
          <div class="form-group">
            <label for="">Nama Alias</label>
            <input type="text" name="name_alias" value="<?= $contact->name_alias; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="">Telepon</label>
            <input type="text" name="phone" value="<?= $contact->phone; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" value="<?= $contact->email; ?>" class="form-control">
          </div>
          <div class="form-group">
            <label for="">Alamat</label>
            <textarea name="address" class="form-control"><?= $contact->address; ?></textarea>
          </div>
          <div class="form-group">
            <label for="">Info (Kota / Instansi / dll)</label>
            <textarea name="info_contact" class="form-control"><?= $contact->info_contact; ?></textarea>
          </div>
          <div>
            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>