var Stats = {


    getUserStats:function() {
        var params = {
              user_id:Util.Cookie.get("user_id")
        };

        API.call("user.stats","getUserStats",params,function(response) {
            console.log(response);
        });
    }



}