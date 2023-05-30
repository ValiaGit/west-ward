App.store('users',{

    model: 'users',

    proxy: {
        list: {
            service: 'user.user',
            method: 'getUserList',
            root: 'data'
        },
        verifyPassport:{
            service: 'user.user',
            method: 'verifyPassport'
        },
        unVerifyPassport:{
            service: 'user.user',
            method: 'unVerifyPassport'
        },

        verifyDocument:{
            service: 'user.documents',
            method: 'verifyDocument'
        },
        unVerifyDocument:{
            service: 'user.documents',
            method: 'unVerifyDocument'
        },


        verifyMoneyAccount:{
            service: 'user.moneyaccounts',
            method: 'verifyMoneyAccount'
        },
        unVerifyMoneyAccount:{
            service: 'user.moneyaccounts',
            method: 'unVerifyMoneyAccount'
        },


        blockUser:{
            service: 'user.user',
            method: 'blockUser'
        },
        unBlockUser:{
            service: 'user.user',
            method: 'unBlockUser'
        },


        getDocuments:{
            service: 'user.documents',
            method: 'getDocuments'
        },
        getMoneyAccounts:{
            service: 'user.moneyaccounts',
            method: 'getMoneyAccounts'
        },

        suspendPermanently:{
            service: 'user.user',
            method: 'suspendPermanently'
        }

    },

    store: [],

    listeners: {
        afterdataload: 'users.afterDataLoad'
    },

    getListData: function(){

        var me = this;

        me.requestData({proxy: 'list'});
    },

    /**
     * Initialize Categories store
     */
    init: function(){

    }//end init();

});//end {}