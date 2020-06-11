<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
                                                    
							<tr>
								<td valign="top" style="padding: 0px 48px 0;font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif;">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
                                            <td colspan="2" style="text-align:center;font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif;font-size:15px;">
                                                <h2 style="text-align:center;margin-bottom:5px;color:#636363"><?= get_option('option_company'); ?></h2>
                                                <?= get_option('option_adresa'); ?>
                                                <br />
                                                <?php
                                                $ico = get_option('option_ico');
                                                if($ico){
                                                    echo __('IČO','goshop'). ': '. $ico; 
                                                }
                                                ?>
                                                 
                                                <?php
                                                $dic = get_option('option_dic');
                                                if($dic){
                                                    echo '<br>'.__('DIČ','goshop'). ': '. $dic; 
                                                }
                                                ?>
                                                
                                                <?php
                                                $ic_dph = get_option('option_ic_dph');
                                                if($ic_dph){
                                                    echo '<br>'.__('IČ DPH','goshop'). ': '. $ic_dph; 
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:50%;text-align:center;font-size: 15px;">
                                                <a href="mailto: <?= $email = get_option('option_e_mail'); ?>">
                                                <p style="margin-bottom:15px"><img src="<?= IMAGES; ?>/email-images/envelope.png" title="Email"></p>
                                                <?= $email; ?>
                                            </td>
                                            <td style="width:50%;text-align:center;font-size: 15px;">
                                                <a href="tel:<?= $tel = get_option('option_tel_kontakt'); ?>">
                                                <p style="margin-bottom:15px"><img src="<?= IMAGES; ?>/email-images/telephone.png" title="Phone"></p>
                                                <?= $tel; ?>
                                            </td>
                                        </tr>    
                                        <tr>
                                          <td style="text-align:center;padding-top:40px;font-size:15px;" colspan="2">
                                            <a href="<?= wc_get_page_permalink( 'terms' ); ?>" title="<?= __('Obchodné podmienky', 'goshop'); ?>"><?= __('Obchodné podmienky', 'goshop'); ?></a>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="text-align:center;padding-top:20px;font-size:15px;" colspan="2">
                                            <a href="<?= get_privacy_policy_url() ?>" title="<?= __('Zásady ochrany osobných údajov', 'goshop'); ?>"><?= __('Zásady ochrany osobných údajov', 'goshop'); ?></a>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="text-align:center;padding-top:40px;font-size:15px;" colspan="2">
                                            <?= __('Sledujte nás','goshop'); ?>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;padding-top:20px;padding-bottom:30px;font-size:15px;" colspan="2">
                                                <?php 
                                                $fb = get_option('option_facebook');
                                                $tw = get_option('option_twitter');
                                                $in = get_option('option_instagram');
                                                $yt = get_option('option_youtube');
                                                $ln = get_option('option_linkedln'); 
                                                if(!empty($fb)){
                                                  echo '<a style="text-decoration:none;margin-right:7px;" target="_blank" rel="nofollow" href="'.$fb.'">
                                                    <img src="'.IMAGES.'/email-images/facebook.png" title="Facebook">
                                                  </a>';
                                                }
                                                if(!empty($tw)){
                                                  echo '<a style="text-decoration:none;margin-right:7px;" target="_blank" rel="nofollow" href="'.$tw.'">
                                                    <img src="'.IMAGES.'/email-images/twitter.png" title="twitter">
                                                  </a>';
                                                }
                                                if(!empty($ln)){
                                                  echo '<a style="text-decoration:none;margin-right:7px;" target="_blank" rel="nofollow" href="'.$ln.'">
                                                    <img src="'.IMAGES.'/email-images/linkedln.png" title="linkedln">
                                                  </a>';
                                                }
                                                if(!empty($yt)){
                                                  echo '<a style="text-decoration:none;margin-right:7px;" target="_blank" rel="nofollow" href="'.$yt.'">
                                                    <img src="'.IMAGES.'/email-images/youtube.png" title="youtube">
                                                  </a>';
                                                }
                                                if(!empty($in)){
                                                  echo '<a style="text-decoration:none;" target="_blank" rel="nofollow" href="'.$in.'">
                                                    <img src="'.IMAGES.'/email-images/instagram.png" title="instagram">
                                                  </a>';
                                                } 
                                                ?>
                                            </td>
                                        </tr>
                                </table>
								<!-- End Footer -->
								</td>
                            </tr>
                            <tr style="background-color: #2c2c2c;font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif;">
							 <td valign="top" style="text-align:center;padding:30px 0;font-size:15px;" colspan="4">
							   <a style="color:white;" href="<?= get_site_url(); ?>" target="_blank"><?= get_site_url(); ?></a>
							 </td>
								
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>