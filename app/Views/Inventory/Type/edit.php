<?php $this->extend('Layout/menu') ?>

<?php $this->section('content') ?>
<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('Type/Type'); ?>">Type</a></li>
            <li class="breadcrumb-item active">Edit Type</li>
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
                        <form class="row g-3" action="<?= $rs['type_id']; ?>" method="post">
                        <?php } else { ?>
                            <form class="row g-3" action="saveEdit/<?= $rs['type_id']; ?>" method="post">
                            <?php } ?>
                            <div class="mt-2 mb-2">
                                <a href="<?php echo base_url('Type/Type'); ?>">
                                    <button type="button" class="btn btn-danger ">Back</button>
                                </a>
                            </div>
                            <?= csrf_field(); ?>
                            <input type="hidden" class="form-control" id="txtTypeID" name="txtTypeID" value="<?= (!empty(session()->getFlashdata('txtTypeID'))) ? session()->getFlashdata('txtTypeID') : $rs['type_id']; ?>">
                            <div class="col-12">
                                <label for="inputEmail4" class="form-label">Code</label>
                                <input type="text" class="form-control" id="txtTypeCode" name="txtTypeCode" onkeyup="convertToUpperCase(this)" oninput="limitInputLength(this, 5)" value="<?= (!empty(session()->getFlashdata('txtTypeCode'))) ? session()->getFlashdata('txtTypeCode') : $rs['type_code']; ?>">
                            </div>
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Type Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtTypeName" name="txtTypeName" onkeyup="convertToUpperCase(this)" value="<?= (!empty(session()->getFlashdata('txtTypeName'))) ? session()->getFlashdata('txtTypeName') : $rs['type_name']; ?>" autofocus>
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