$(document).ready(function () {
  var id = $("#id").val();
  var parking = $("#parking_location").val().trim();

  $(".assignParkingSpot").each(function () {
    var assignParkingSpotId = $(this).attr("id");
    if (id !== "") {
      if (parking == assignParkingSpotId) {
        $(this)
          .removeClass("bg-danger")
          .removeClass("bg-success")
          .addClass("bg-warning")
          .addClass("selected");
        return false;
      }
    }
  });

  $(".assignParkingSpot").mouseover(function () {
    if ($(this).hasClass("bg-success") && !$(this).hasClass("selected")) {
      $(this).removeClass("bg-success").addClass("bg-warning");
    }
  });
  $(".assignParkingSpot").mouseout(function () {
    if ($(this).hasClass("bg-warning") && !$(this).hasClass("selected")) {
      $(this).removeClass("bg-warning").addClass("bg-success");
    }
  });

  $(".assignParkingSpot").click(function () {
    if ($(this).hasClass("bg-danger")) {
      $("#error_modal").modal("show");
    } else {
      var color = "bg-warning";
      $(".assignParkingSpot")
        .removeClass(color + " selected")
        .addClass("bg-success");
      $(this)
        .removeClass("bg-success")
        .addClass(color + " selected");
      $("#parking_location").val(this.id);
    }
  });
});
