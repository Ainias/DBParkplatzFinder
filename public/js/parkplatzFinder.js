var parkplatzFinder = {

    parkingLotsUrl: null,
    currentRequest: null,

    init: function (parkingLotsUrl) {
        this.parkingLotsUrl = parkingLotsUrl;
    },

    requestParkingLots: function (trainStationValue) {
        if (trainStationValue != this.currentRequest) {
            $("#parkingLotWrapper").html("loading...");
            this.currentRequest = trainStationValue;

            $.post(this.parkingLotsUrl, {
                    trainStationId: trainStationValue
                },
                null,
                "html").done(function (data) {
                    if (trainStationValue == parkplatzFinder.currentRequest) {
                        $("#parkingLotWrapper").html(data);
                        parkplatzFinder.currentRequest = null;
                    }
            }).fail(function () {
                if (trainStationValue == parkplatzFinder.currentRequest) {
                    $("#parkingLotWrapper").html("<i>Es gibt zu diesem Bahnhof leider keine Parkplätze.</i>");
                    parkplatzFinder.currentRequest = null;
                }
            });
        }
    }
};
