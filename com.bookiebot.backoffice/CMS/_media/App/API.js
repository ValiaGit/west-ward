var API = {};
API.url = api_href;
API.sault = sault;
API.lang = "en";

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

    var stringToBeHashed = service + method;


    for(i in params) {
        if(params[i]!=undefined) {
            if(typeof(params[i]) != 'object') {
                stringToBeHashed += params[i].toString();
            }
        }
    }
    //return md5(stringToBeHashed + API.sault);
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
API.call = function(service,method,params,callback,errorCallback,async,scope) {
    var me = this;

    if(!params) {
        params = {}
    }

    params.hash = API.generateHash(service, method, params);

    if(async == undefined) {
        async = true;
    }


    try {
        $.ajax({
            url: me.getUrl(service, method),
            data:params,
            method:"POST",
            dataType:"json",
            async:async
        })
            //Tu Data wamoigo
            .done(function(response) {
console.log(response);
                try {
                    if(response.hasOwnProperty('logout')) {
                        window.location.href = 'index.php';
                    }
                }catch(e) {

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
    }catch(e) {

    }

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

