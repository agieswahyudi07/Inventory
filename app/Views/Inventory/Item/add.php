<?php $this->extend('Layout/menu') ?>

<?php $this->section('content') ?>
<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('Item/Item'); ?>">Inventory</a></li>
            <li class="breadcrumb-item active">Add Item</li>
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
            <form class="row g-3" action="saveAdd" method="post">
                <?= csrf_field(); ?>
                <!-- Tampilkan Pesan Error -->
                <div class="col-12">
                    <label for="inputEmail4" class="form-label">Code<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtCategoryCode" name="txtItemCode" onkeyup="convertToUpperCase(this)" oninput="limitInputLength(this, 5)" value="<?= (!empty(session()->getFlashdata('txtItemCode'))) ? session()->getFlashdata('txtItemCode') : ""; ?>">
                </div>
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Item Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control " id="txtItemName" name="txtItemName" onkeyup="convertToUpperCase(this)" value="<?= (!empty(session()->getFlashdata('txtItemName'))) ? session()->getFlashdata('txtItemName') : ""; ?>" autofocus>
                </div>
                <div class="col-12">
                    <label for="inputPassword4" class="form-label">Price<span class="text-danger">*</span></label>
                    <?php (!empty(session()->getFlashdata('txtItemPrice'))) ? $price = session()->getFlashdata('txtItemPrice') : ""; ?>
                    <input type="text" onclick="this.select();" class="form-control" id="txtItemPrice" name="txtItemPrice" value="<?= (!empty($price)) ? $price : number_format((float)0); ?>">
                </div>
                <label class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="selItemCategory" name="selItemCategory">
                        <?php
                        if (!empty(session()->getFlashdata('txtItemCategory'))) {
                        ?>
                            <option value="<?= session()->getFlashdata('selItemCategory'); ?>" selected><?= session()->getFlashdata('txtItemCategory'); ?></option>
                        <?php
                        } else {
                        ?>
                            <option selected>Choose Item Category</option>
                        <?php
                        }
                        ?>
                        <?php
                        if (!empty($category)) {
                            foreach ($category as $ct) :
                        ?>
                                <option value="<?= $ct->category_id; ?>"><?= $ct->category_code . "-" . $ct->category_name; ?></option>
                        <?php
                            endforeach;
                        }
                        ?>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Brand</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="selItemBrand" name="selItemBrand">
                        <?php
                        if (!empty(session()->getFlashdata('txtItemBrand'))) {
                        ?>
                            <option value="<?= session()->getFlashdata('selItemBrand'); ?>" selected><?= session()->getFlashdata('txtItemBrand'); ?></option>
                        <?php
                        } else {
                        ?>
                            <option selected>Choose Item Brand</option>
                        <?php
                        }
                        ?>
                        <?php
                        if (!empty($brand)) {
                            foreach ($brand as $br) :
                        ?>
                                <option value="<?= $br->brand_id; ?>"><?= $br->brand_code . "-" . $br->brand_name; ?></option>
                        <?php
                            endforeach;
                        }
                        ?>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="selItemType" name="selItemType">
                        <?php
                        if (!empty(session()->getFlashdata('txtItemType'))) {
                        ?>
                            <option value="<?= session()->getFlashdata('selItemType'); ?>" selected><?= session()->getFlashdata('txtItemType'); ?></option>
                        <?php
                        } else {
                        ?>
                            <option selected>Choose Item Type</option>
                        <?php
                        }
                        ?>
                        <?php
                        if (!empty($type)) {
                            foreach ($type as $ty) :
                        ?>
                                <option value="<?= $ty->type_id; ?>"><?= $ty->type_code . "-" . $ty->type_name; ?></option>
                        <?php
                            endforeach;
                        }
                        ?>
                    </select>
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