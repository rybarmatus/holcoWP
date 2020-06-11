<?php
global $goshop_config;

delete_transient('socials');

?>
<div class="wrap">
    <h1>Nastavenie témy</h1>
    <form method="post" action="options.php">
      <?php settings_fields( 'option-page-group' ); ?>
      <?php do_settings_sections( 'option-page-group' ); ?>
      
      <div id="dashboard-widgets" class="metabox-holder">
	       <div id="postbox-container-1" class="postbox-container">

            <table class="form-table">
              <tr valign="top">
                <th scope="row">Logo v hlavičke</th>
                <td> 
                    <input type="hidden" class="option_logo" data="header" value="<?= esc_attr( get_option('option_header_logo') ); ?>" name="option_header_logo" />
                    <img class="logo" data="header" src="<?= esc_attr( get_option('option_header_logo') ); ?>">
                    <br />
                    <div style="float:right">
                        <button style="margin-top:10px;margin-right:25px;" class="button upload_logo" data="header">Upload</button>
                    </div>
                    <input type="hidden" id="helper" value="">
                    <div style="clear:both"></div>
                </td> 
              </tr>
              <?php if($goshop_config['footer_logo']){ ?>
              <tr valign="top">
                <th scope="row">Footer logo</th>
                <td> 
                    <input type="hidden" class="option_logo" data="footer" value="<?= esc_attr( get_option('option_footer_logo') ); ?>" name="option_footer_logo" />
                    <img class="logo" data="footer" style="max-width:90%" src="<?= esc_attr( get_option('option_footer_logo') ); ?>">
                    <br />
                    <div style="float:right">
                        <button style="margin-top:10px;margin-right:25px;" class="button upload_logo" data="footer">Upload</button>
                    </div>
                    
                </td>
              </tr>
              <?php } ?>
              </table>
              <h2>Kontakty</h2>
              <table class="form-table">
              <tr valign="top">
                <th scope="row">Názov firmy</th>
                <td><input type="text" name="option_company" value="<?= esc_attr( get_option('option_company') ); ?>" /></td>
              </tr>
              <?php if($goshop_config['woo_export_pre_slovensku_postu']){ ?>
              <tr valign="top">
                <th scope="row">Zodpovedná osoba</th>
                <td><input type="text" name="option_zodpovedna_osoba" value="<?= esc_attr( get_option('option_zodpovedna_osoba') ); ?>" /></td>
              </tr>
              <?php } ?>
              <tr valign="top">
                <th scope="row">Ulica</th>
                <td><input type="text" name="option_adresa_ulica" value="<?= esc_attr( get_option('option_adresa_ulica') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">Psč</th>
                <td><input type="text" name="option_adresa_psc" value="<?= esc_attr( get_option('option_adresa_psc') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">Mesto</th>
                <td><input type="text" name="option_adresa_mesto" value="<?= esc_attr( get_option('option_adresa_mesto') ); ?>" /></td>
              </tr>
              <tr>
                <td colspan="2"><small>Príklad: Kominárska 3/A, 831 04 Bratislava</small></td>
              </tr>
              <tr valign="top">
                <th scope="row">Tel. kontakt</th>
                <td><input type="text" name="option_tel_kontakt" value="<?= esc_attr( get_option('option_tel_kontakt') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">E-mail</th>
                <td><input type="email" name="option_e_mail" value="<?= esc_attr( get_option('option_e_mail') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">E-mail pre kont. formulár</th>
                <td><input type="email" name="option_e_mail_form" value="<?= esc_attr( get_option('option_e_mail_form') ); ?>" /></td>
              </tr>
              <tr valign="top">
                <th scope="row">IČO</th>
                <td><input type="text" name="option_ico" value="<?= esc_attr( get_option('option_ico') ); ?>" /></td>
              </tr>
              
              <tr valign="top">
                <th scope="row">DIČ</th>
                <td><input type="text" name="option_dic" value="<?= esc_attr( get_option('option_dic') ); ?>" /></td>
              </tr>
              
              <tr valign="top">
                <th scope="row">IC DPH</th>
                <td><input type="text" name="option_ic_dph" value="<?= esc_attr( get_option('option_ic_dph') ); ?>" /></td>
              </tr>
              
              <tr valign="top">
                <th scope="row">Bankové spojenie - IBAN</th>
                <td><input type="text" name="option_bankove_spojenie" value="<?= esc_attr( get_option('option_bankove_spojenie') ); ?>" /></td>
              </tr>
              <?php if($goshop_config['bacs_payment']){ ?>
                <tr valign="top">
                  <th scope="row">Názov banky</th>
                  <td><input type="text" name="option_nazov_banky" value="<?= esc_attr( get_option('option_nazov_banky') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Swift bankového účtu</th>
                  <td><input type="text" name="option_swift" value="<?= esc_attr( get_option('option_swift') ); ?>" /></td>
                </tr>
              <?php } ?>
              <?php if($goshop_config['contact_show_map']) { ?>
                <tr valign="top">
                  <th scope="row">Google maps iframe</th>
                  <td>
                    <textarea rows="4" style="width: 258px;" name="option_google_maps"><?= esc_attr( get_option('option_google_maps') ); ?></textarea>
                  </td>
                </tr>
              <?php } ?>
              
              
           </table>
         </div>
         <div id="postbox-container-2" class="postbox-container">
          <?php if($goshop_config['socials']){ ?>
          <h2>Sociálne siete</h2>
          <table class="form-table">
            <tr valign="top">
              <th scope="row">Facebook</th>
              <td><input type="url" name="option_facebook" value="<?= esc_attr( get_option('option_facebook') ); ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Twitter</th>
              <td><input type="url" name="option_twitter" value="<?= esc_attr( get_option('option_twitter') ); ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Instagram</th>
              <td><input type="url" name="option_instagram" value="<?= esc_attr( get_option('option_instagram') ); ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Youtube</th>
              <td><input type="url" name="option_youtube" value="<?= esc_attr( get_option('option_youtube') ); ?>" /></td>
            </tr>
            <tr valign="top">
              <th scope="row">Linkedln</th>
              <td><input type="url" name="option_linkedln" value="<?= esc_attr( get_option('option_linkedln') ); ?>" /></td>
            </tr>
          </table>
          <?php } ?>

          <?php if($goshop_config['opening_hours']){ ?>
              <h2>Otváracie hodiny</h2>
              <table class="form-table">
                <tr valign="top">
                  <th scope="row">Pondelok</th>
                  <td><input type="text" name="option_opening_hours_1" value="<?= esc_attr( get_option('option_opening_hours_1') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Utorok</th>
                  <td><input type="text" name="option_opening_hours_2" value="<?= esc_attr( get_option('option_opening_hours_2') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Streda</th>
                  <td><input type="text" name="option_opening_hours_3" value="<?= esc_attr( get_option('option_opening_hours_3') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Štvrtok</th>
                  <td><input type="text" name="option_opening_hours_4" value="<?= esc_attr( get_option('option_opening_hours_4') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Piatok</th>
                  <td><input type="text" name="option_opening_hours_5" value="<?= esc_attr( get_option('option_opening_hours_5') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Sobota</th>
                  <td><input type="text" name="option_opening_hours_6" value="<?= esc_attr( get_option('option_opening_hours_6') ); ?>" /></td>
                </tr>
                <tr valign="top">
                  <th scope="row">Nedeľa</th>
                  <td><input type="text" name="option_opening_hours_7" value="<?= esc_attr( get_option('option_opening_hours_7') ); ?>" /></td>
                </tr>
              </table>

          <?php } ?>

         </div>

         <div id="postbox-container-3" class="postbox-container">
          <table class="form-table">
            <tr valign="top">
              <td>
                <h2>Koniec "Head"</h2>
                <textarea style="width:100%" rows="6" size="100%" name="option_head_end"><?= esc_attr( get_option('option_head_end') ); ?></textarea>
              </td>
            </tr>
            <tr valign="top">
              <td>
                <h2>Začiatok "body"</h2>
                <textarea style="width:100%" rows="6" size="100%" name="option_body_start"><?= esc_attr( get_option('option_body_start') ); ?></textarea>
              </td>
            </tr>
          </table>
          <!-- 
          <h2>Remarketing kód</h2>
          <table class="form-table">
            <tr valign="top">
              <td>
                <textarea style="width:100%" rows="5" size="100%" name="option_google_remarketing">
                    <?= esc_attr( get_option('option_google_remarketing') ); ?>
                </textarea>
              </td>
            </tr>
            <tr>
              <th>Dynamický remarketing</th>
              <td>
                  <?= esc_attr( get_option('option_google_remarketing') ); ?>
              </td>
            </tr>
          </table>
          -->
          <?php if($goshop_config['woocommerce']){ ?>
          <h2>E-shop</h2>
          <table class="form-table">
            <tr>
              <th>
                Heureka overené zákazníkmi api klúc
                <input class="mt-1" type="text" name="option_heureka_overene_zakaznikmi_api" value="<?= esc_attr( get_option('option_heureka_overene_zakaznikmi_api') ); ?>" />
              </th>
            </tr>
            <tr>
                <td colspan="2"><small>Služba sa automaticky zapne po vložení api klúcu</small></td>
            </tr>
            <tr>
              <th scope="row">Minimálna hodnota pre dopravu zadarmo
                <input class="mt-1" type="number" min="0" step="0.1" name="option_shipping_free" value="<?= esc_attr( get_option('option_shipping_free') ); ?>" />
              </th>
            </tr>
            <tr>
              <th scope="row">Poplatok za dobierku 
                <input class="mt-1" type="number" min="0" step="0.1" name="option_cod_fee" value="<?= esc_attr( get_option('option_cod_fee') ); ?>" />
              </th>
            </tr>
            <tr>
              <th scope="row">Dobierka zadarmo od sumy 
                <input class="mt-1" type="number" min="0" step="0.1" name="option_cod_fee_limit" value="<?= esc_attr( get_option('option_cod_fee_limit') ); ?>" />
              </th>
            </tr>
          </table>
          <?php } ?>
          
         </div>
      </div>

      <div style="clear:both"></div>

      <style>
        .form-table th{
        width:110px;
        }
        .form-table input{
        width:90%;
        }
        .mt-1{
        margin-top:1em;
        }
        .logo{
        max-width: 210px;
        max-height: 66px;
        float: left;
        }
      </style>

      <?php submit_button(); ?>

    </form>
  </div>