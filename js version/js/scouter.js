var api_key = "cead18d4-28d4-4c90-8ea6-3cfcc6eaa18b";
var pill = "<ul class=\"nav nav-pills nav-center\" id=\"myPill\"><li role\"><a class=\"white\" data-toggle=\"tab\" href=\"#ingame\">InGame</a></li><li class=\"active\" role=\"presentation\"><a class=\"white\" data-toggle=\"tab\" href=\"#profile\">Profile</a></li></ul>";

    function get_data() {
        var region = "";
        var summoner_name = "";

        if (!$("#euselector").hasClass("active")) {
            region = "NA";
        }
        else if (!$("#naselector").hasClass("active")) {
            region = "EU";
        }
        summoner_name = $('#summonername').val();
        append_data(region, summoner_name);
    }

    function append_data(region, summoner_name) {
        if (summoner_name == "") {
            console.log("no summoner name speicfied");
        }
        else {
            if (region == "NA") {
                $.ajax({
                    url: 'https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' + summoner_name + '?api_key=' + api_key,
                    type: 'GET',
                    dataType: 'json',
                    data: {

                    },
                    success: function (json) {
                        $("#results").html(pill);
                        console.log(json);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("error getting Summoner data!");
                    }
                });
            }
            else if (region == "EU") {
                console.log("bientot :p");
            }
        }
    }