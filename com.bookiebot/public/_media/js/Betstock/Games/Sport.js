var Sport = {


    init: function () {

        var Provider = "dc204ed2-03b2-4c6d-a307-46f78797d623";
        var ScriptURL = "//sportsbook.betplanet.win/js/partnerinit.js?containerID=bcsportsbookcontainer&AuthToken={token}&callbackName=bettingCB&oddsType=decimal&type=prematch&sport=1&lang=" + bc_lang;

        var self = this;

        if (Session.userData) {
            Session.generateProviderToken(Provider, function (err, token) {
                if (err) {
                    return false;
                }


                ScriptURL = ScriptURL.replace("{token}", token);

                self.open(ScriptURL);

            });
        }

        else {
            ScriptURL = ScriptURL.replace("{token}", "anonymus");
            self.open(ScriptURL);
        }

    },


    open: function (url) {

        var s = document.createElement('script');
        s.setAttribute('src', url);
        s.setAttribute('id', "bcsportsbook");
        document.head.appendChild(s);

    },

    openNaxui: function () {
        var Provider = "dc204ed2-03b2-4c6d-a307-46f78797d623";
        var ScriptURL = "https://sportsbook.betplanet.win?AuthToken={token}&lang="+bc_lang;

        var self = this;

        if (Session.userData) {
            Session.generateProviderToken(Provider, function (err, token) {
                if (err) {
                    return false;
                }


                ScriptURL = ScriptURL.replace("{token}", token);

                window.open(ScriptURL,"width=1024,height=700");

            });
        }
    },


    events: function (name, value) {
        if (name === "balance") {
            console.log("balance:", value);
        } else if (name === "login") {
            console.log("login button clicked from ", value);
        } else if (name === "register") {
            console.log("register button clicked from ", value)
        } else if (name === "selectedGameOffset") {
            console.log("current displayed game has offset ­ x:",
                value.left, "y: ", value.top);
        } else if (name === "windowSize") {
            console.log("iframe size:",
                value.width + "x" + value.height);
        } else if (name === "bodyHeight") {
            console.log("iframe body height changed to:", value);
        }
    }


};