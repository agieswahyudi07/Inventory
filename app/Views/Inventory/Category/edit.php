<?php $this->extend('Layout/menu') ?>

<?php $this->section('content') ?>
<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('Category/Category'); ?>">Inventory</a></li>
            <li class="breadcrumb-item active">Edit Category</li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Vertical Form</h5>

            <!-- Vertical Form -->
            <?php if (!empty(session()->getFlashdata('errors'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
                    <strong>Error input</strong>
                    <br>
                    <?= session()->getFlashdata('errors'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            <?php endif; ?>
            <?php
            if ($result) {
            ?>
                <?php foreach ($result as $rs) :  ?>
                    <?php if (!empty(session()->getFlashdata('errors'))) { ?>
                        <form class="row g-3" action="<?= $rs['category_id']; ?>" method="post">
                        <?php } else { ?>
                            <form class="row g-3" action="saveEdit/<?= $rs['category_id']; ?>" method="post">
                            <?php } ?>
                            <div class="mt-2 mb-2">
                                <a href="<?php echo base_url('Category/Category'); ?>">
                                    <button type="button" class="btn btn-danger ">Back</button>
                                </a>
                            </div>
                            <?= csrf_field(); ?>
                            <input type="hidden" class="form-control" id="txtCategoryID" name="txtCategoryID" value="<?= (!empty(session()->getFlashdata('txtCategoryID'))) ? session()->getFlashdata('txtCategoryID') : $rs['category_id']; ?>">
                            <div class="col-12">
                                <label for="inputEmail4" class="form-label">Code</label>
                                <input type="text" class="form-control" id="txtCategoryCode" name="txtCategoryCode" onkeyup="convertToUpperCase(this)" oninput="limitInputLength(this, 5)" value="<?= (!empty(session()->getFlashdata('txtCategoryCode'))) ? session()->getFlashdata('txtCategoryCode') : $rs['category_code']; ?>">
                            </div>
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtCategoryName" name="txtCategoryName" onkeyup="convertToUpperCase(this)" value="<?= (!empty(session()->getFlashdata('txtCategoryName'))) ? session()->getFlashdata('txtCategoryName') : $rs['category_name']; ?>" autofocus>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            </form><!-- Vertical Form -->
                        <?php endforeach; ?>
                    <?php
                }
                    ?>
        </div>
    </div>
</div>

<script>
    function limitInputLength(inputElement, maxLength) {
        if (inputElement.value.length > maxLength) {
            inputElement.value = inputElement.value.slice(0, maxLength);
        }
    }

    function convertToUpperCase(inputElement) {
        inputElement.value = inputElement.value.toUpperCase();
    }
</script>
<?php $this->endSection() ?>