<div class="modal login">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <?= __('Prihlásenie do účtu', 'goshop') ?>
          <button type="button" class="close js-modal-close pointer">
            <span aria-hidden="true">×</span>
          </button>    
      </div>
      <div class="modal-body">
          <?php require(CONTENT. '/login-form.php'); ?>    
      </div>
    </div>
  </div>    
</div>