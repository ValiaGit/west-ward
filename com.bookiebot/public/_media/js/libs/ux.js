/**
 * Useful Functions for application
 * @type {{}}
 */
UX = {

    /**
     * Dont let user to press illegal keys for numeric input fields
     * @param event
     */
    filterNumericInput:function(event){
        var input = $(event.target ? event.target : event.srcElement),
            num = input.val();
        if(!isNaN(num)){
            if(num.indexOf('.') > -1){
                num = num.split('.');
                num[0] = num[0].toString().split('').reverse().join('').split('').reverse().join('').replace(/^[\,]/,'');
                if(num[1].length > 2){
                    num[1] = num[1].substring(0,num[1].length-1);
                }
                input.val(num[0]+'.'+num[1]);
            } else {
                input.val (num.toString().split('').reverse().join('').split('').reverse().join('').replace(/^[\,]/,''));
            }
        } else {
            input.val(num.substring(0,num.length-1));
        }
    },

    /**
     * Corrects input formatting as numeric with 2 digits after dot
     * @param event
     */
    correctNumericFormatting:function(event){

        var target = event.target ? event.target : event.srcElement;
        if(target){

            while(target.value.indexOf("0")==0) target.value=target.value.substring(1, target.value.length);
            var indx = target.value.indexOf(".");
            if(indx>=0){
                if(indx==0){
                    target.value = 0 + target.value;
                    indx = target.value.indexOf(".");
                }
                if(indx==target.value.length-1) target.value = target.value + "00";
                else if(indx==target.value.length-2) target.value = target.value + "0";
                else if(indx<target.value.length-3) target.value = target.value.substring(0,indx+3);
            }else{
                if(target.value.length != 0) target.value = target.value + ".00"; else target.value = target.value + "0.00";
            }
        }
    },

    /**
     * Returns formatted date
     * @param date
     */
    format_date: function(dateObject){

        var hr = dateObject.getHours();
        if (hr < 10) { hr = "0" + hr; }
        var min = dateObject.getMinutes();
        if (min < 10) { min = "0" + min; }
        var date = dateObject.getDate();
        if (date < 10) { date   = "0" + date; }
        var month = dateObject.getMonth()+1;
        if (month  < 10) { month  = "0" + month; }
        var ret = date + '-' + month + ' ' + hr + ':' + min;

    }//end format_date
}