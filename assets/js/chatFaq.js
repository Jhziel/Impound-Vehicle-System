$(document).ready(function () {
  $("#newConvo").on("click", "#satisfied_no", function () {
    $(this).addClass("d-none");
    $(this).parent().prev().addClass("d-none");
    $(this).parent().prev().prev().addClass("d-none");
    $(this).prev().addClass("d-none");
    $("#newConvo #followUp_staff").removeClass("d-none");
  });
  $("#newConvo").on("click", "#satisfied_yes", function () {
    $(this).addClass("d-none");
    $(this).parent().prev().addClass("d-none");
    $(this).parent().prev().prev().addClass("d-none");
    $(this).next().addClass("d-none");
    $("#newConvo #followUp_faq").removeClass("d-none");
  });
  $("#newConvo").on("click", "#faq_yes", function () {
    $(this).addClass("d-none");
    $(this).next().addClass("d-none");
    $("#newConvo #faq_follow").removeClass("d-none");
    $("#newConvo #followUp_staff").addClass("d-none");
  });
  $("#newConvo").on("click", "#faq_no", function () {
    $("#newConvo #followUp_faq").addClass("d-none");
  });
  $("#newConvo").on("click", "#staff_no", function () {
    $("#newConvo #followUp_staff").addClass("d-none");
  });

  $("#newConvo").on("click", ".faq", function () {
    var question = $(this).text().trim();
    var message = question;
    $('[name="message"]').val(message); // Set the selected question as a message
    $("#send_chat").submit();
    $("#newConvo #followUp_faq").addClass("d-none");
    $("#newConvo #followUp_staff").addClass("d-none");
    $("#newConvo #faq_follow").addClass("d-none");
    $("#newConvo #faq_follow").addClass("d-none");
    $("#newConvo #followUp").addClass("d-none");
    $("#newConvo #satisfied_no").removeClass("d-none");
    $("#newConvo #satisfied_yes").removeClass("d-none");
    $("#newConvo #sep").removeClass("d-none");
    $("#newConvo #ask").removeClass("d-none");
    $("#newConvo #faq_yes").removeClass("d-none");
    $("#newConvo #faq_no").removeClass("d-none");
  });
  $("#newConvo")
    .on("mouseenter", ".faq", function () {
      $(this).css("cursor", "pointer");
    })
    .on("mouseleave", ".faq", function () {
      $(this).css("cursor", "auto"); // Change cursor back to default
    });
});
