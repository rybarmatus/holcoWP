<div class="login-form">
  <form method="post">
    <label for="login_email"><?= __('E-mailová adresa', 'goshop'); ?>
        <input type="email" class="form-control mb-1" name="username" id="login_email" required />
    </label>
    <label for="login_pass"><?= __('Vaše heslo', 'goshop'); ?>  <a href="<?= wp_lostpassword_url(); ?>" class="forgot-pass"><?= __('Nepamätáte si svoje heslo ?', 'goshop'); ?></a>
        <input type="password" class="form-control mb-1" name="password" id="login_pass" required />
    </label>
    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
    <button type="submit" name="login" class="btn btn-block btn-primary"><?= __('Prihlásiť sa do účtu', 'goshop'); ?></button>
    <input type="hidden" name="redirect" value="<?= THIS_PAGE_URL ?>" />
  </form>
  <div class="lines_through mt-1 mb-2">
    <span><?= __('alebo pokračujte pomocou', 'goshop'); ?></span>
  </div>
  <div class="row">
    <?php if($goshop_config['social_login']){ ?>
    <div class="col-5 pr-0">
      <span class="js-facebook-login pointer icon"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-square" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg></span>
      <span class="js-google-login pointer icon"><img title="<?= __('Google prihlasenie','goshop'); ?>" src="<?= get_template_directory_uri() ?>/images/google-logo.png" alt="google logo"></span>
    </div>
    <?php } ?>
    <div class="col-7">
      <a href="/registracia" class="btn btn-block btn-success registracia-button"><?= __('Vytvorte si účet', 'goshop'); ?></a>
    </div>
   </div>
</div>
