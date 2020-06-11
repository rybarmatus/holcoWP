<style>
.Cal-headDay {
    color: #122e98;
    padding-bottom: 1rem;
}
.Cal-day, .Cal-headDay {
    padding: .75rem .5rem;
    text-align: center;
}
.Cal-head {
    border-bottom: 1px solid #d1d9dd;
}
.Cal-table {
    width: 100%;
    max-width: 384px;
}
.Cal-day {
    position: relative;
    color: #757c84;
}
.Cal-dayDate {
    position: relative;
    z-index: 100;
    pointer-events: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.Cal-event.Cal-event--start {
    left: .25rem;
    border-top-left-radius: 2.25rem;
    border-bottom-left-radius: 2.25rem;
    border-right: 0px !important;
}
.Cal-event.Has-expo {
    background-color: #aad6ff;
}
.Cal-event {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    display: block;
    height: 2.25rem;
    margin-top: -1.125rem;
}
.Cal-day.has-event {
    color: white;
}
</style>


<?php 
$pocet_mesiacov = 5;

$dneska = date('m');
$today = date('Ymd');

var_dump($events);     die();


foreach($vystavy as $key=>$item){

  $informacie = get_field('vystava_informacie', $item->ID);
  $vystavy[$key]->datum_od = strtotime($informacie['datum_od']);
  $vystavy[$key]->datum_do = strtotime($informacie['datum_do']);
  $vystavy[$key]->farba = '#0149ff';
  $vystavy[$key]->typ = 1;

}                                
$vystavy = array_column($vystavy, NULL, 'ID');

?>

<div class="Hero-cal Cal">
  <div class="Cal-views js-calendar" data-initial="0">
    <?php for($m=0;$m<$pocet_mesiacov;$m++) { 
        
        $first_day_date = strtotime(date("Y-m-01", strtotime("+".$m." month", strtotime(date('Y-m-01')))));
        
        $first_day_number = date('N', $first_day_date); 
        $month_start = false;
        $counter = 0;
        $number_of_days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m', $first_day_date), date('Y', $first_day_date));

        ?>
        <section class="Cal-view <?php if(!$m) { ?> is-initial <?php } ?>">
          <h2 class="Cal-title h3" style="text-transform:capitalize"><?= date_i18n('M Y', $first_day_date); ?></h2>
          <table class="Cal-table">
            <thead class="Cal-head">
              <tr class="Cal-headRow">
                <th class="Cal-headDay">P</th>
                <th class="Cal-headDay">U</th>
                <th class="Cal-headDay">S</th>
                <th class="Cal-headDay">Š</th>
                <th class="Cal-headDay">P</th>
                <th class="Cal-headDay">S</th>
                <th class="Cal-headDay">N</th>
              </tr>
            </thead>
            <tbody class="Cal-body">
            <?php
            
            for($i=1;$i<=$number_of_days_in_month;$i++) {  
            
                if ($counter % 7 == 0) { ?>
                  <?php if($counter != 0) { ?></tr><?php } ?>
                  <tr class="Cal-week">
                <?php } ?>
              
              
              <?php if(($first_day_number == $i and !$month_start)){ $i = 1; $month_start = true; } else if(!$month_start) { ?><td class="Cal-day"></td> <?php } ?>
            
            <?php
            
            $date_this_day = strtotime("+".($i-1)." days", $first_day_date);
                        
            
            $events_same_date = array();
            $has_event = false;
            if($vystavy){
                foreach($vystavy as $key=>$vystava){
                    if($date_this_day >= $vystava->datum_od && $date_this_day <= $vystava->datum_do){
                          
                      $event_same_date['key'] = $key;
                      $event_same_date['type'] = $vystava->typ;
                      $event_same_date['name'] = $vystava->post_title;
                      $event_same_date['ID'] = $vystava->ID;
                      $event_same_date['datum_od'] = $vystava->datum_od;
                      $event_same_date['datum_do'] = $vystava->datum_do;
                      // $events_same_date[$key]['event_color'] = $vystava->farba;
                      
                      array_push($events_same_date, $event_same_date);   
                      $has_event = true;
                        
                      if($date_this_day == $vystava->datum_do){
                          unset($vystavy[$key]);
                      }
                  }
               }
            }
            $event_start = false;
            $event_end = false;
            $event_names = '';
            $pocet_eventov = count($events_same_date);
            $has_circle = false;
            $has_expo = false;  
            foreach($events_same_date as $event_same_day){
                
              if($event_same_day['type'] == 1){
                if($event_same_day['datum_od'] == $date_this_day ){
                $event_start = true;
                }
                if($event_same_day['datum_do'] == $date_this_day ){
                $event_end = true;
                }
                $has_expo = true;
              }else{
                $has_circle = true;
              }
              $event_names .= '<a href="'. get_permalink($event_same_day['ID']) .'">'.$event_same_day['name'].'</a>';
            
            }      
            
            $event_type = 1;
                                    
            ?>
              <?php if($month_start) { ?>
              <td class="multiple-events Cal-day<?php if($has_event) { echo ' has-event'; }; if($has_expo){echo ' Has-expo'; } ?>">
                   <span class="Cal-dayDate"><?= $i ?></span>
                    
                <?php if($has_event) { ?>
                  
                  <?php if($has_circle) { ?>
                      <span class="circle"></span>
                  <?php } ?>
             
                  <span class="Cal-event <?php if($has_expo){echo 'Has-expo'; } if($event_start) { echo ' Cal-event--start'; } if($event_end){ echo ' Cal-event--end'; } ?>"></span>
                  <div class="custom-tooltip">
                    <div class="arrow"></div>
                    <div class="custom-tooltip-inner">
                        <?= $event_names ?>
                    </div>    
                  </div>   
                
                <?php } ?>
              </td>
              <?php } ?>
              
              <?php
              $counter++; 
            }
            ?>
        
        </tbody>
      </table>
    </section>
    <?php } ?>
  </div>
</article>


