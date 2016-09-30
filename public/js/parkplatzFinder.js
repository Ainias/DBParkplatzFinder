var parkplatzFinder = {

    parkingLotsUrl: null,

    init: function(parkingLotsUrl)
    {
        this.parkingLotsUrl = parkingLotsUrl;
    },

    requestParkingLots: function (trainStationValue) {
        $("#parkingLotWrapper").html("loading...");
        $.post(this.parkingLotsUrl, {
                trainStationId: trainStationValue
            },
            null,
            "html").done(function (data) {
            $("#parkingLotWrapper").html(data);
        }).fail(function () {
            $("#parkingLotWrapper").html("<i>Es gibt zu diesem Bahnhof leider keine Parkplätze.</i>");
        });
    }
};
