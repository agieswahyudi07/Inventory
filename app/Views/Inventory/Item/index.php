<?php $this->extend('Layout/menu') ?>

<?php $this->section('content') ?>
<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('Item/Item'); ?>">Inventory</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active">Data</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <div class="mb-3">
                        <h5 class="card-title">Item</h5>
                        <a href="<?php echo base_url('Item/add'); ?>"><button type="button" class="btn btn-success rounded-pill" id="add" name="add" value="add">ADD DATA +</button></a>
                    </div>

                    <!-- Table with stripped rows -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Code</th>
                                <th scope="col">Price</th>
                                <th scope="col">Last Modified</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($item) {
                                foreach ($item as $dt) :
                            ?>
                                    <tr>
                                        <td><?= $dt->item_name; ?></td>
                                        <td><?= $dt->item_code; ?></td>
                                        <td><?= $dt->item_price; ?></td>
                                        <td><?= (!empty($dt->updated_at)) ? $dt->updated_at : $dt->created_at; ?></td>
                                        <td>
                                            <a href="<?= base_url('Item/edit/' . $dt->item_id); ?>"> <button type="button" class="btn btn-primary rounded-pill" id="edit" name="edit" value="edit">Edit</button></a>
                                            |
                                            <a href="/Item/delete/<?= $dt->item_id; ?>"> <button type="button" class="btn btn-danger rounded-pill" id="delete" name="delete" value="delete" onclick="return confirmDelete()">Delete</button></a>

                                        </td>
                                    </tr>
                            <?php endforeach;
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function confirmDelete() {
        var x = confirm("Are you sure want to delete this item ?");
        if (x)
            return true;
        else
            return false;
    }
</script>
<?php $this->endSection() ?>