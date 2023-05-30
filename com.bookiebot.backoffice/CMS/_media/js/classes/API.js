var API = {};
API.url = base_href+"/API/";
API.sault = sault;
API.lang = cur_lang;

/**
 *
 * @param service
 * @param method
 * @returns {string}
 */
API.getUrl = function(service,method) {
    return this.url+service+"/"+method;
};


API.generateHash = function(service, method, params) {

    var stringToBeHashed = "";

    if(API.reqType == "POST") {
        for(i in params) {
            if(params[i]) {
                if(typeof(params[i]) != 'object') {
                    stringToBeHashed += params[i].toString();
                }
            }
        }
        stringToBeHashed += (service + method).toString();
    }

    else {

        stringToBeHashed += (service + method).toString();
        for(i in params) {
            if(params[i]) {
                if(typeof(params[i]) != 'object') {
                    stringToBeHashed += params[i].toString();
                }

            }
        }
    }
    console.log(stringToBeHashed + API.sault);
    return md5(stringToBeHashed + API.sault);
}


/**
 *
 * @param service
 * @param method
 * @param params
 * @param callback
 * @param errorCallback
 * @param async
 */
API.call = function(service,method,params,callback,errorCallback,async,scope) {
    var me = this;

    if(!params) {
            params = {}
    }
    var user_id = $.cookie("user_id");
    if(user_id) {
        params.user_id = user_id;
    }
    params.hash = API.generateHash(service, method, params);

    if(async == undefined) {
        async = true;
    }



    $.ajax({
        url: me.getUrl(service, method),
        data:params,
        method:"POST",
        dataType:"json",
        async:async
    })
        //Tu Data wamoigo
        .done(function(response) {
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





