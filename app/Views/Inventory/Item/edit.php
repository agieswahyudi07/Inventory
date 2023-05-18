<?php $this->extend('Layout/menu') ?>

<?php $this->section('content') ?>
<div class="pagetitle">
    <h1><?= $title; ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('Item/Item'); ?>">Inventory</a></li>
            <li class="breadcrumb-item active">Edit Item</li>
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
                        <form class="row g-3" action="<?= $rs['item_id']; ?>" method="post">
                        <?php } else { ?>
                            <form class="row g-3" action="saveEdit/<?= $rs['item_id']; ?>" method="post">
                            <?php } ?>
                            <?= csrf_field(); ?>
                            <input type="hidden" class="form-control" id="txtItemID" name="txtItemID" value="<?= (!empty(session()->getFlashdata('txtItemID'))) ? session()->getFlashdata('txtItemID') : $rs['item_id']; ?>">
                            <div class="col-12">
                                <label for="inputEmail4" class="form-label">Code</label>
                                <input type="text" class="form-control" id="txtItemCode" name="txtItemCode" onkeyup="convertToUpperCase(this)" oninput="limitInputLength(this, 5)" value="<?= (!empty(session()->getFlashdata('txtItemCode'))) ? session()->getFlashdata('txtItemCode') : $rs['item_code']; ?>">
                            </div>
                            <div class="col-12">
                                <label for="inputNanme4" class="form-label">Item Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtItemName" name="txtItemName" onkeyup="convertToUpperCase(this)" value="<?= (!empty(session()->getFlashdata('txtItemName'))) ? session()->getFlashdata('txtItemName') : $rs['item_name']; ?>" autofocus>
                            </div>
                            <div class="col-12">
                                <label for="inputPassword4" class="form-label">Price</label>
                                <?php (!empty(session()->getFlashdata('txtItemPrice'))) ? $price = session()->getFlashdata('txtItemPrice') : ""; ?>
                                <input type="text" onclick="this.select();" class="form-control" id="txtItemPrice" name="txtItemPrice" value="<?= (!empty($price)) ? $price : number_format($rs['item_price']); ?>">
                                <!-- <input type="text" onclick="this.select();" class="form-control" id="txtItemPrice" name="txtItemPrice" value="<?= number_format($rs['item_price']); ?>"> -->
                                <!-- <input type="text" class="form-control" id="txtItemPrice" name="txtItemPrice" value="<?= number_format($rs['item_price']); ?>"> -->
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
                                        <?php
                                        if (!empty($category)) {
                                        ?>
                                            <option value="<?= $category['category_id']; ?>"><?= $category['category_code'] . "-" . $category['category_name']; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="">Choose Your Item Category</option>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($allCategory)) {
                                        foreach ($allCategory as $ct) :
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
                                        <?php
                                        if (!empty($brand)) {
                                        ?>
                                            <option value="<?= $brand['brand_id']; ?>"><?= $brand['brand_code'] . "-" . $brand['brand_name']; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="">Choose Your Item Category</option>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($allBrand)) {
                                        foreach ($allBrand as $br) :
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
                                        <?php
                                        if (!empty($type)) {
                                        ?>
                                            <option value="<?= $type['type_id']; ?>"><?= $type['type_code'] . "-" . $type['type_name']; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="">Choose Your Item Category</option>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (!empty($allType)) {
                                        foreach ($allType as $ty) :
                                    ?>
                                            <option value="<?= $ty->type_id; ?>"><?= $ty->type_code . "-" . $ty->type_name; ?></option>
                                    <?php
                                        endforeach;
                                    }
                                    ?>
                                </select>
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