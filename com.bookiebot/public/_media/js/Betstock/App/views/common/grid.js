/**
 *
 * @param options
 * @constructor
 */
Grid = function(options){


    var me = this;

    me.renderTo = options.renderTo;

    me.columns = options.columns;
    me.data = options.data;

    me.cls = options.cls?options.cls:'';



    if(!options.no_data_text) {
        me.no_data_text = "No Data to Render";
    } else {
        me.no_data_text = options.no_data_text;
    }


};//end {}

Grid.prototype.render = function() {

    var me = this,
        html = '';

    /*-------------------*/
    html += '<table class="'+me.cls+'">';
    /*-------------------*/

    //Get header html
    html += me.getHeader();


    //Get content html
    html += me.getContent();



    /*-------------------*/
    html += '</table>';
    /*-------------------*/



    if(!me.data) {
        $(me.renderTo).html("<tr><td>"+me.no_data_text+"</td></tr>").addClass("no-data-table");
    } else {
        $(me.renderTo).html(html);
    }

};//end render();

/**
 *
 */
Grid.prototype.getHeader = function() {

    var me = this,
        html = '';

    /*-------------------*/
    html += '<thead><tr>';
    /*-------------------*/


    var i= 0,
        col;
    for(i; i<me.columns.length; i++) {
        col = me.columns[i];

        html+='<th>'

        switch(col.type){
            default:
                html += col.title;
        }

        html+='</th>';
    }


    /*-------------------*/
    html += '</tr></thead>';
    /*-------------------*/

    return html;
};//end getheader();


/**
 *
 */
Grid.prototype.getContent = function(){

    var me = this,
        html = '';

    /*-------------------*/
    html += '<tbody>';
    /*-------------------*/


    var i, k,
        row, col, inner;


        for(k in me.data){

            row = me.data[k];

            html += '<tr>';


            for(i=0; i<me.columns.length; i++){


                col = me.columns[i],
                    inner = '';

                switch(col.type){
                    case 'case':
                        inner = col.values[row[col.mapping]];
                        break;
                    case 'time':
                            inner = row[col.mapping] +" <br/>UTC+01:00";
                        break;
                    default:
                        inner = row[col.mapping];
                }


                try {
                    if(col.renderer){
                        inner = col.renderer(inner,row);
                    }
                }catch(e) {
                    console.log(col);
                    console.log(e);
                }





                html+='<td>' + inner + '</td>';



            }//end loop cols

            html += '</tr>'

        }//end loop data





    /*-------------------*/
    html += '</tbody>';
    /*-------------------*/



    return html;
};//end getheader();