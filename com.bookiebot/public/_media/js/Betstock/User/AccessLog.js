var AccessLog = {

    table:$('#access_log'),

    getData:function() {
        var me = this;
        var user_id = Util.Cookie.get("user_id");
        API.call("user.session","getAccessLog",{user_id:user_id},function(response) {
            if(response.code == 10) {
                me.renderData(response.data);
            }
        });
    },

    renderData:function(data) {
        var me = this;
        var html = "";
        for(var index in data) {
            var current = data[index];

            var btn =  '<button class="btn btn-success btn-xs" onclick="IpBlock.openPopup(\''+current.ip+'\')">' +'Block Access' +'</button>'
            if(current.block_ip_id) {
                btn = '<button class="btn btn-danger btn-xs" onclick="IpBlock.unBlockIp(\''+current.block_ip_id+'\')">' +'UnBlock Access' +'</button>'
            }


            html+=

             '<tr>' +
                '<td>'+current.t+'</td>' +
                '<td>'+current.ip+'</td>' +
                '<td>' + btn+'</td>' +
            '</tr>';

        }
        me.table.find("tbody").html(html);
    }
};