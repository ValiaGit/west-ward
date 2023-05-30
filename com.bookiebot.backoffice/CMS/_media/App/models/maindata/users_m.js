App.model('users', {

    fields: {

        core_users__id: {type: 'number', filter: {placeholder: 'Numeric only'}, column: {width: 100}},
        username: {type: 'string', filter: false, column: true},

        fullname: {column: true, filterable: false},
        nickname: {},
        email: {type: 'string', filter: true, column: true},
        gender: {type: 'case', values: {1: 'Male', 2: 'Female'}},
        balance: {
            convert: function (val) {
                if(val<=0) {
                    return 0;
                }
                return (val / 100).toFixed(2);
            },
            filter: {type: 'range'},
            column: true
        },
        address: {},
        birthdate: {},
        registration_date: {},
        core_countries_id: {},
        long_name: {},
        address_zip_code: {},
        city: {},
        phone: {},
        status: {
            type: 'case',
            values: {
                1: 'Active',
                2: 'Blocked',
                3: 'Suspended',
                4: 'Self Exluded',
                5: 'Inactive'
            },
            column: true
        },
        is_email_confirmed: {
            type: 'case', values: {0: 'No', 1: 'Yes'}, convert: function (val) {
                switch (val) {
                    case 0:
                    case "0":
                        return "No";
                        break;
                    case 1:
                    case "1":
                        return "No";
                        break;

                }
            }
        },
        is_passport_confirmed: {
            type: 'case', values: {0: 'No', 1: 'Yes'},
            convert: function (val) {
                switch (val) {
                    case 0:
                    case "0":
                        return "No";
                        break;
                    case 1:
                    case "1":
                        return "No";
                        break;

                }
            }
        },
        is_phone_confirmed: {
            type: 'case', values: {0: 'No', 1: 'Yes'},
            convert: function (val) {
                switch (val) {
                    case 0:
                    case "0":
                        return "No";
                        break;
                    case 1:
                    case "1":
                        return "No";
                        break;

                }
            }
        },
        last_login_date: {
            column: true
        }

    }//end fields

});//end {}