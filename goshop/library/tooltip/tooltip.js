/* ak chcem aby tooltip ostal na hover */
$('.js-tooltip').mouseleave(function(){
    if(!$('.goshop-tooltip').is(":hover")){
        toolTipHide();
    }
 });              
 $('.goshop-tooltip').mouseleave(function(){
    toolTipHide();
 });