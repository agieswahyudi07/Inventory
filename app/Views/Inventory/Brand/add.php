<?php $this->extend('Layout/menu') ?>

<?php $this->section('content') ?>
<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('Brand/Brand'); ?>">Brand</a></li>
            <li class="breadcrumb-item active">Add Brand</li>
        </ol>
    </nav>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Brand Form</h5>

            <!-- Vertical Form -->
            <?php if (!empty(session()->getFlashdata('errors'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
                    <strong>Error input</strong>
                    <br>
                    <?= session()->getFlashdata('errors'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            <?php endif; ?>
            <form class="row g-3" action="saveAdd" method="post">
                <div class="mt-2 mb-2">
                    <a href="<?php echo base_url('Brand/Brand'); ?>">
                        <button type="button" class="btn btn-danger ">Back</button>
                    </a>
                </div>
                <?= csrf_field(); ?>
                <div class="col-12">
                    <label for="inputEmail4" class="form-label">Code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtBrandCode" name="txtBrandCode" onkeyup="convertToUpperCase(this)" oninput="limitInputLength(this, 5)" value="<?= (!empty(session()->getFlashdata('txtBrandCode'))) ? session()->getFlashdata('txtBrandCode') : ""; ?>">
                </div>
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Brand Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control " id="txtBrandName" name="txtBrandName" onkeyup="convertToUpperCase(this)" value="<?= (!empty(session()->getFlashdata('txtBrandName'))) ? session()->getFlashdata('txtBrandName') : ""; ?>" autofocus>
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form><!-- Vertical Form -->

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

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function updatePriceInput(input) {
        let value = input.value.replace(/[^\d\.]/g, '');

        value = value.replace(/(\..*)\./g, '$1');

        let number = parseFloat(value);

        let formattedNumber = formatNumber(number);

        input.value = formattedNumber;
    }

    let inputElement = document.getElementById('txtItemPrice');
    inputElement.addEventListener('input', function() {
        updatePriceInput(this);
    });
</script>
<?php $this->endSection() ?>