 <div class="modal cetelem-calc">
    <div class="modal-dialog modal-large">

      <div class="modal-content">
        <div class="modal-header">
            <?php // __('Cetelem', 'goshop') ?>
            <img style="max-height:115px" src="<?= IMAGES.'/cetelem.png'; ?>">
            <button type="button" class="close js-modal-close pointer">
              <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                    
                    <form id="cetelem_calc_form">
                      <table>
                        <tbody>
                          <tr>
                          	<th><label for="frm-cena">Cena tovaru</label></th>
                              <td><input type="number" step="0.01" name="cenaTovaru" min="100" class="form-control" value="<?= WC()->cart->total ?>" class="text"></td>
                          </tr>
                          <tr>
                          	<th><label for="frm-program">Splátkový program (barem)</label></th>
                              <td>
                                  <select name="kodBaremu" class="form-control">
                                      <option value="104">Akcia 10%+10x10%</option>
                                      <option value="506" selected="">Flexi splátky 13 – 48 mesiacov</option>
                                  </select>
                              </td>
                          </tr>
                          <tr>
                          	<th><label for="frm-poistenie">Poistenie splácania</label></th>
                              <td><select name="kodPoistenia" id="frm-poistenie" class="form-control" id="frm-pojisteni">
                                      <option value="M1" selected="">Komplexný balík poistenia</option>
                                      <option value="M2">Komplexný balík poistenia plus</option>
                                      <option value="S0">Úver bez poistenia</option>
                                  </select>
                              </td>
                          </tr>
                          <tr>
                          	<th><label for="frm-priama_platba">Priama platba</label></th>
                              <td>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="frm-priama_platba" name="priamaPlatba" value="0">
                                  <div class="input-group-append">
                                    <span class="input-group-text">
                                    Akontácia
                                    </span>
                                  </div>
                                </div>
                              </td>
                          </tr>
                          <tr>
                          	<th><label for="frm-pocet_splatek">Počet splátok</label></th>
                              <td><input type="number" max="48" min="10" class="form-control" id="frm-pocet_splatek" name="pocetSplatok" value="48"></td>
                          </tr>
                          
                          <tr>
                            	<th><label for="frm-odklad">Odklad</label></th>
                              <td>
                                <div class="input-group">
                                  <input type="text" class="form-control" name="odklad" id="frm-odklad" value="0">
                                  <div class="input-group-append">
                                    <span class="input-group-text">
                                    v mesiacoch
                                    </span>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          <tr>
                          	<th></th>
                              <td><input type="submit" id="cetelem_calc" class="btn btn-primary btn-lg button" value="Prepočítať splátky"></td>
                          </tr>
                          <?php
                          $cetelem_class = new WC_Gateway_Cetelem();
                          ?>
                          <input type="hidden" value="<?= $cetelem_class->kod_predajcu; ?>" name="kodPredajcu">
                        </tbody>
                      </table>
                    </form>
                 
              </div>
              <div class="col-md-6">
                  <table class="mb-3">
                    <tr>
                    	<th><label for="cetelem-vyska-splatky">Výška splátky</label></th>
                        <td><input type="text" name="vyse_splatky" size="7" id="cetelem-vyska-splatky" disabled=""class="text"></td>
                    </tr>

                    <tr>
                    	<th><label for="cetelem-vyska-uveru">Výška úveru</label></th>
                        <td><input type="text" name="vyse_uveru" size="7" id="cetelem-vyska-uveru" disabled="" class="text"></td>
                    </tr>
                    
                    <tr>
                    	<th><label for="cetelem-rpmn">RPMN</label></th>
                        <td><input type="text" name="rpsn" size="7" id="cetelem-rpmn" disabled="" class="text"></td>
                    </tr>
                    
                    <tr>
                    	<th><label for="cetelem-urokova-sadzba">Úroková sadzba</label></th>
                        <td><input type="text" name="urokova_sazba" size="7" id="cetelem-urokova-sadzba" disabled=""class="text"></td>
                    </tr>
                    
                    <tr>
                    	<th style="padding-right:10px"><label for="cetelem-celkova-cena">Celková cena k zaplateniu</label></th>
                        <td><input type="text" name="celkova_cena" size="7" id="cetelem-celkova-cena" disabled=""  class="text"></td>
                    </tr>
                    <tr>
                    	<th><label for="cetelem-doba-splatnosti">Doba splatnosti</label></th>
                      <td><input type="text" name="doba_splatnosti" size="7" id="cetelem-doba-splatnosti" disabled="" class="text"></td>
                    </tr>
                    <tr>
                    	<th><label for="frm-odklad">Odklad</label></th>
                      <td><input type="text" name="odklad" size="7" id="cetelem-odklad" disabled="" class="text"></td>
                    </tr>
                    
                    
                  </table>
                  <button id="cetelem_done" class="btn btn-success btn-lg button js-modal-close" disabled>
                    Potvrdiť
                  </button>
                  <input type="hidden" id="cetelem_data_json" value="">
              </div>
          </div>
          <div id="cetelem-calculator-warning" class="alert alert-danger d-none mt-2"></div>
        </div>
      </div>
     
    </div>
  </div>
