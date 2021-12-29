var _timerHandler = 0;
 _timerHandler = setInterval( "MyTimer()" , 1000);
 
 
function MyTimer()
{
   var valueTimer = jQuery('#hdnTimer').val(); 
   
   if(valueTimer > 0)
   {
       valueTimer = valueTimer - 1; 
       
       hours = (valueTimer/3600).toString().split('.')[0];
       mins  = ((valueTimer % 3600) / 60).toString().split('.')[0]; 
       secs  = ((valueTimer % 3600) % 60).toString(); 
       
       if(hours.length == 1) hours = '0' + hours; 
       if(mins.length  == 1) mins  = '0' + mins; 
       if(secs.length  == 1) secs  = '0' + secs; 
       
       jQuery('#idTimerLCD').text( hours + ':' +  mins + ':'  + secs);
       jQuery('#hdnTimer').val( valueTimer );  
   }
    else
   {
     //alert("STOP");
   }
  
}
