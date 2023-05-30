/**
 *
 * @param options
 * @return {TreeRenderer}
 * @constructor
 */
TreeRenderer = function(options){

    var me = this,
        config = {

        };

    jQuery.extend(me, config, options);

    if(me.renderTo)
    this.renderTo = me.renderTo;

    return this;

};//end constructor();

/**
 * Renders a tree to
 * renderTo is specified
 * or/and returns html
 */
TreeRenderer.prototype.render = function(){

    var me = this;
    var html = this.levelRenderer(0,Object.keys(me.tree[0].store));

    me.html = $(html);

    me.html.find('a.expand').collapsible({
        defaultOpen: 'second-level,third-level',
        cssOpen: 'expanded',
        cssClose: 'collapsed',
        speed: 150
    });
    Util.removeLoader(me.renderTo);
    if(me.renderTo){
        $(me.renderTo).html(me.html);



    }//end render

    me.addListeners();

    return html;

};//end render();


TreeRenderer.prototype.levelRenderer = function(level,data){

    var me = this,
        info = me.tree[level],
        item, i = 0, sub,
        html, item_html,
        cls = info.cls?info.cls:info.index,
        item_cls = info.item_cls?info.index+' '+info.item_cls:info.index;


        data.sort(function(a,b){
            a = info.store[a], b = info.store[b];

            if(a.name && b.name)
            return a.name.localeCompare(b.name);
        });

    html = '<ul class="'+cls+'">';

    for(i; i<data.length; i++){

        item = info.store[data[i]];
        sub = item[info.sub]?item[info.sub]:[];

        //Open item tag
        item_html = '<li data-id="'+item.id+'" class="'+item_cls+'">';

        //Add item tag content by tpl
        item_html += me.tpl(item,info.tpl);

        //Add sub tree if available;
        if(sub.length){
            item_html += me.levelRenderer(level+1,sub);
        }

        //Close item tag
        item_html += '</li>';

        html += item_html;

    }//end data loop

    html += '</ul>';
    return html;


};//end levelRenderer();

TreeRenderer.prototype.tpl = function(item, tpl){
    var ret = tpl, reg;
    for(var indx in item){
        reg = new RegExp('{{'+indx+'}}', 'g');
        //noinspection JSUnfilteredForInLoop
        ret = ret.replace(reg, item[indx]);
    }//end loop
    return ret;
};//end buildTpl();


TreeRenderer.prototype.addListeners = function(){

    //Localize
    var me = this,
        tree = me.tree,
        info,
        listeners,
        i = 0, selector, ev;

    //Loop tree
    for(i; i<tree.length; i++){

        //localize
        info = tree[i];

        //If tree level has listneres
        if(info.listeners){

            //localize
            listeners = info.listeners;

            for(ev in listeners){

                //build selector
                selector = '.'+info.index+' > a';

                //noinspection JSUnfilteredForInLoop
                me.html.on(ev,selector,function(e){
                    //noinspection JSReferencingMutableVariableFromClosure,JSUnfilteredForInLoop
                    listeners[ev]($(e.target).parent().data('id'),e);
                });

            }//end for

        }//end if

    }//end for

};//end AddListeners();