App.model('results',{

    fields: {

        "id":                    {   type: 'number', column: {width: 100}   },
        "match_id":              {   column: true    },
        "BetradarMatchId":       {   column: true    },
        "BetFairEventId":        {   column: true    },
        "result_receive_time":   {   type: 'time', column: true    },
        "queueStatus":           {   column: true    },
        "home":                  {   column: true    },
        "away":                  {   column: true    },
        "sport_title":           {   column: true    }

    }//end fields

});//end {}