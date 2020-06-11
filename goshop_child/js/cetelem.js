$(document).ready(function(){

  $('#cetelem_calc').click(function(){
  
      $.ajax({
         type: "GET",
         url: 'https://online.cetelem.sk/online/ws_xmlcalc+JSON.php',
         data: $('#cetelem_calc_form').serialize(),
         success: function(response){
           
            var xml = $(response);
            var status = xml.find("status").text();
            var sprava = xml.find("info").find("sprava").text();
          
            if(sprava){
              $('#cetelem-calculator-warning').text(sprava).fadeIn();
            }else{
              $('#cetelem-calculator-warning').hide();
            }
            
            if(status != 'error'){
           
               var vysledok = xml.find("vysledok");
               var vyskaSplatky = vysledok.find('vyskaSplatky').text()
               var vyskaUveru = vysledok.find('vyskaUveru').text();
               var RPMN = vysledok.find('RPMN').text();
               var ursadz = vysledok.find('ursadz').text();
               var cenaUveru = vysledok.find('CCKZ').text();
               var odklad = vysledok.find('odklad').text();   
               var pocetSplatok = vysledok.find('pocetSplatok').text();
               var priamaPlatba = vysledok.find('priamaPlatba').text();
               var cenaTovaru = vysledok.find('cenaTovaru').text();
               var kodPoistenia = vysledok.find('kodPoistenia').text(); 
               var kodPredajcu = vysledok.find('kodPredajcu').text();
               var kodBaremu = vysledok.find('kodBaremu').text();
               var kodMaterialu = vysledok.find('kodMaterialu').text(); 
               
               /* vyplni inputy v kalkulacke */
               $('#cetelem-vyska-splatky').val(vyskaSplatky);
               $('#cetelem-vyska-uveru').val(vyskaUveru);
               $('#cetelem-rpmn').val(RPMN);
               $('#cetelem-urokova-sadzba').val(ursadz);
               $('#cetelem-celkova-cena').val( cenaUveru );
               $('#cetelem-doba-splatnosti').val(vysledok.find('pocetSplatok').text());
               $('#cetelem-odklad').val( odklad );
               
               $('#cetelem_done').removeAttr('disabled')
               $('#billing_celetem_data').val('');
           
               var data_pre_ziadost = {
                kodPredajcu: kodPredajcu,
                kodBaremu: kodBaremu,
                kodPoistenia: kodPoistenia,
                kodMaterialu: kodMaterialu,
                cenaTovaru: cenaTovaru,
                priamaPlatba: priamaPlatba,
                vyskaUveru: vyskaUveru,
                pocetSplatok: pocetSplatok,
                odklad: odklad,
                zdarma: 0,
                vyskaSplatky: vyskaSplatky,
                cenaUveru: cenaUveru,
                ursadz: ursadz,
                RPMN: RPMN,
              };
              
              $('#cetelem_data_json').val( JSON.stringify(data_pre_ziadost) );
           }   
         }
     });
     return false;
  
  })
  
    $('#cetelem_done').click(function(){
               
      $('#billing_celetem_data').val( $('#cetelem_data_json').val() );    
      notif('success', $('#cetelem-pozicia-nastavena').val()  );              
      $('.payment_method_goshop_custom_payment_method_cetelem .js-modal').text( $('#cetelem-upravit-parametre').val() );
   })
   
   
})    
   
   