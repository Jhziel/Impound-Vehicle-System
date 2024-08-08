$(document).ready(function(){
    $("#offense-form").submit(function (e) {
      e.preventDefault();
      var _this = $(this);
      $(".err-msg").remove();
      start_loader();
      if ($('[name="offense_id[]"]').length <= 0) {
        alert_toast("Please add atleast 1 offense item first", "error");
        end_loader();
        return false;
      }
      if ($('[name="ticket_no"]').hasClass("is-invalid")) {
        alert_toast("Please check your input before proceeding", "error");
        end_loader();
        return false;
      }
      $.ajax({
        url: _base_url_ + "classes/Master.php?f=save_offense_record",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: "POST",
        type: "POST",
        dataType: "json",
        error: (err) => {
          console.log(err);
          alert_toast("An error occured", "error");
          end_loader();
        },
        success: function (resp) {
          if (typeof resp == "object" && resp.status == "success") {
              location.href = "./?page=offenses";
              end_loader();
          } else if (resp.status == "failed" && !!resp.msg) {
            var el = $("<div>");
            el.addClass("alert alert-danger err-msg").text(resp.msg);
            _this.prepend(el);
            el.show("slow");
            $("html, body").animate(
              {
                scrollTop: _this.closest(".card").offset().top,
              },
              "fast"
            );
            end_loader();
          } else {
            alert_toast("An error occured", "error");
            end_loader();
            console.log(resp);
          }
        },
      });
    });
})