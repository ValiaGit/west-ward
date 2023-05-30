MatchHeader = function(config){
    var me = this;
    me.config = config;

    return me;
};//end {}

MatchHeader.prototype.getHtml = function(){

    var me = this,
        config = me.config,
        header =
        '<div class="match-heading {{sport_code}}">' +
            '<div class="heading-bar">' +
                '<h2>{{group}} <span>- {{tournament}}</span></h2>' +
                '<a class="btn-close" id="GoToReferrer" href="#">' +
                    '<i class="icon-close-alt"></i>' +
                '</a>' +
            '</div>' +
            '<div class="data">' +
                '<div class="date" id="matchDate">{{date_time}}</div>' +
                '<div class="teams" id="matchTeams">{{home}} <span class="vs">VS</span> {{away}}</div>' +
            '</div>' +
        '</div>';



    return header = header.replace(/{{home}}/g, config.home)
        .replace(/{{away}}/g, config.away)
        .replace(/{{sport_code}}/g, config.sport_code)
        .replace(/{{date_time}}/g, moment(config.time).format('dddd DD MMM HH:mm'))
        //category data
        .replace(/{{group}}/g, config.group)
        .replace(/{{tournament}}/g, config.tournament);

};