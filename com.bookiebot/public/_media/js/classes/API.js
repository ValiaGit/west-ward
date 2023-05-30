var API = {};
API.url = api_url;
API.lang = cur_lang;

/**
 *
 * @param service
 * @param method
 * @returns {string}
 */
API.getUrl = function(service,method) {
    return this.url+service+"/"+method+".sr";
};


//API2.call("user.session","login",{username:"",password:""},function(response) {console.log(response);});

/**
 *
 * @param service
 * @param method
 * @param params
 * @param callback
 * @param errorCallback
 * @param async
 */
API.call = function(service,method,params,callback,errorCallback,async,scope,afterSession) {
    var me = this;

    if(!params) {
        params = {}
    }

    params.lang = me.lang;

    if(async == undefined) {
        async = true;
    }

    if(!params.user_id && Util.Cookie.get("user_id")) {
        params.user_id = parseInt(Util.Cookie.get("user_id"));
    }

    $.ajax({
        url: me.getUrl(service, method),
        data:params,
        method:"POST",
        dataType:"json",
        xhrFields: {
            withCredentials: true
        },
        async:async
    })
        //Tu Data wamoigo
        .done(function(response) {
            if(response.errCode == 1 && response.errDesc == "Wrong token!") {

                API.call(service,method,params,callback,errorCallback,async,scope,true);
                return false;
            }
            if(callback && typeof (callback) === "function") {
                callback(response,params,scope);
            }
        })
        //Tu Data ver wamoigo
        .fail(function() {
            if(errorCallback && typeof (errorCallback) === "function") {
                errorCallback();
            }
        });
};



/**
 *
 * @param service
 * @param method
 * @param params
 * @param callback
 * @param errorCallback
 * @param async
 */
API.callWithMimeFile = function(service,method,params,callback,errorCallback,async) {
    var me = this;

    if(!params) {
        params = {}
    }


    if(async == undefined) {
        async = true;
    }


    $.ajax({
        url: me.getUrl(service, method),
        type: 'POST',
        data:  params,
        mimeType:"multipart/form-data",
        contentType: false,
        xhrFields: {
            withCredentials: true
        },
        dataType:"json",
        cache: false,
        processData:false,
        success: function(data, textStatus, jqXHR)
        {

            if(callback && typeof (callback) === "function") {
                callback(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            if(errorCallback && typeof (errorCallback) === "function") {
                errorCallback();
            }
        }
    });


}
