<style>
.Cal-headDay {
    color: #122e98;
    padding-bottom: 1rem;
}
.Cal-day, .Cal-headDay {
    padding: 10px 4px;
    text-align: center;
}
.Cal-head {
    border-bottom: 1px solid #d1d9dd;
}
.Cal-table {
    width: 100%;
    max-width: 384px;
    margin: 0 auto;
}
.Cal-day {
    position: relative;
    color: #757c84;
}
.Cal-dayDate {
    position: relative;
    pointer-events: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    z-index: 2;
}
.Cal-event.Cal-event--start {
    left: .25rem;
    border-top-left-radius: 2.25rem;
    border-bottom-left-radius: 2.25rem;
    border-right: 0px !important;
}
.Cal-event.Cal-event--end {
    right: .25rem;
    border-top-right-radius: 2.25rem;
    border-bottom-right-radius: 2.25rem;
    border-left: 0px !important;
}
.Cal-day.Has-event{
color:white;
}
.Cal-event {
position: absolute;
top: 50%;
z-index: 1;
left: 0;
right: 0;
display: block;
height: 2.25rem;
margin-top: -1.125rem;
background-color: #4760d0;
}
</style>

<?php 
global $events;
global $mesiace_start;
global $mesiace_end;



$dneska = date('m');
$today = date('Ymd');


foreach($events as $key=>$item){

  $events[$key]->datum_od = strtotime(get_field('datum_od', $item->ID));
  $events[$key]->datum_do = strtotime(get_field('datum_do', $item->ID));

}                                
$events = array_column($events, NULL, 'ID');
?>


  <?php for($m=$mesiace_start; $m < $mesiace_end; $m++) { 

      $first_day_date = strtotime(date("Y-m-01", strtotime("+".$m." month", strtotime(date('Y-m-01')))));
      
      $first_day_number = date('N', $first_day_date); 
      $month_start = false;
      $counter = 0;
      $number_of_days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m', $first_day_date), date('Y', $first_day_date));

      ?>
      <section class="col-md-4 mb-1">
        <h2 class="Cal-title h3" style="text-transform:capitalize"><?= date_i18n('M Y', $first_day_date); ?></h2>
        <table class="Cal-table">
          <thead class="Cal-head">
            <tr class="Cal-headRow">
              <th class="Cal-headDay"><?= __('P','goshop'); ?></th>
              <th class="Cal-headDay"><?= __('U','goshop'); ?></th>
              <th class="Cal-headDay"><?= __('S','goshop'); ?></th>
              <th class="Cal-headDay"><?= __('Š','goshop'); ?></th>
              <th class="Cal-headDay"><?= __('P','goshop'); ?></th>
              <th class="Cal-headDay"><?= __('S','goshop'); ?></th>
              <th class="Cal-headDay"><?= __('N','goshop'); ?></th>
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
          $event_start = false;
          $event_end = false;            
          $event_today = array();
          
          $has_event = false;
          if($events){
              foreach($events as $key=>$event){
                  if($date_this_day >= $event->datum_od && $date_this_day <= $event->datum_do){
                        
                    $event_today['key'] = $key;
                    
                    $event_today['name'] = $event->post_title;
                    $event_today['ID'] = $event->ID;
                    $event_today['datum_od'] = $event->datum_od;
                    $event_today['datum_do'] = $event->datum_do;
                    
                    $has_event = true;   
                    
                      
                    if($event_today['datum_od'] == $date_this_day ){
                        $event_start = true;
                    }
                    
                    if($event_today['datum_do'] == $date_this_day ){
                      $event_end = true;
                    }
                      
                    if($date_this_day == $event->datum_do){
                        unset($events[$key]);
                    }
                }
             }
          }
          ?>
            <?php if($month_start) { ?>
            <td class="multiple-events Cal-day<?php if($has_event) { echo ' Has-event'; }; ?>" <?php if($has_event) { ?> title="<?= $event_today['name']; ?>" <?php } ?> >
                 <span class="Cal-dayDate"><?= $i ?></span>
                  
              <?php if($has_event) { ?>
                
                <span class="Cal-event<?php if($event_start) { echo ' Cal-event--start'; } if($event_end){ echo ' Cal-event--end'; } ?>"></span>
              
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

