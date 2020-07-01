<?php require APPROOT . '/views/inc/header.php'; ?>

<?php require APPROOT . '/views/inc/navbar.php'; ?>

<div class="app-body">

  <main class="main">
  
  <?php require APPROOT . '/views/inc/breadcrumbs.php'; ?>

    <div class="container-fluid">

    <form action="<?php echo URLROOT; ?>/partners/add" method="post">

    <?php flash('partner_message'); ?>

        <div class="card">
        <div class="card-header"><?php echo _company_add; ?>
        </div>
            <div class="card-body">

                    <div class="md-form">
                        <input type="text" name="partner" id="partner" value="<?php echo isset($_POST["partner"]) ? $_POST["partner"] : ''; ?>" class="form-control <?php echo (!empty($data['partner_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="partner"><?php echo _company; ?><sup>*</sup></label>
                        <div class="invalid-feedback"><?php echo (!empty($data['partner_err'])) ? $data['partner_err'] : ''; ?></div>
                    </div>

                    <div class="md-form">
                        <input type="text" name="contact" id="contact" value="<?php echo isset($_POST["contact"]) ? $_POST["contact"] : ''; ?>" class="form-control <?php echo (!empty($data['contact_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="contact">Kontakt</label>
                        <div class="invalid-feedback"><?php echo (!empty($data['contact_err'])) ? $data['contact_err'] : ''; ?></div>
                    </div>

                    <div class="md-form">
                        <input type="text" name="street" id="street" value="<?php echo isset($_POST["street"]) ? $_POST["street"] : ''; ?>" class="form-control <?php echo (!empty($data['street_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="street">Straße</label>
                        <div class="invalid-feedback"><?php echo (!empty($data['street_err'])) ? $data['street_err'] : ''; ?></div>
                    </div>

                    <div class="md-form">
                        <input type="number" name="zip" id="zip" value="<?php echo isset($_POST["zip"]) ? $_POST["zip"] : ''; ?>" class="form-control <?php echo (!empty($data['zip_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="zip">PLZ</label>
                        <div class="invalid-feedback"><?php echo (!empty($data['zip_err'])) ? $data['zip_err'] : ''; ?></div>
                    </div>

                    <div class="md-form">
                        <input type="text" name="city" id="city" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : ''; ?>" class="form-control <?php echo (!empty($data['city_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="city">Stadt</label>
                        <div class="invalid-feedback"><?php echo (!empty($data['city_err'])) ? $data['city_err'] : ''; ?></div>
                    </div>

                    <div class="md-form">
                        <input type="Text" name="country" id="country" value="Deutschland" class="form-control <?php echo (!empty($data['country_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="country">Land</label>
                        <div class="invalid-feedback"><?php echo (!empty($data['country_err'])) ? $data['country_err'] : ''; ?></div>
                    </div>

                    <div class="md-form">
                        <input type="text" name="mailre" id="mailre" value="<?php echo isset($_POST["mailre"]) ? $_POST["mailre"] : ''; ?>" class="form-control <?php echo (!empty($data['mailre_err'])) ? 'is-invalid' : ''; ?>">
                        <label for="mailre">E-Mail Empfänger für Belege (Mehrere mit Komma getrennt)</label>
                        <div class="invalid-feedback"><?php echo (!empty($data['mailre_err'])) ? $data['mailre_err'] : ''; ?></div>
                    </div>
                
            </div> <!-- card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="<?php echo _company_add; ?>">
        </div>	
          
        </div>   <!-- card -->

        </form>

<?php require APPROOT . '/views/inc/footer.php'; ?>