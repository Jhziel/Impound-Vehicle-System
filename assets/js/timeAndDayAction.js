$(document).ready(function () {
  $("#showDataButton").click(function () {
    // Replace these variables with your PHP variables or data

    // Display the values in the output area with fade animation
    $("#output").fadeOut(400, function () {
      $(this)
        .html(
          "Based on our data analytics findings, a clear pattern emerges regarding the most common days and times for offenses in Cabuyao City. On " +
            days +
            " a notable surge in violations occurs around  " +
            top1 +
            " with a recorded count of  " +
            count1 +
            " instances. Follwed by  " +
            top2 +
            " with " +
            count2 +
            " reported cases. " +
            top3 +
            " ranks third in frequency, documented with " +
            count3 +
            " instances"
        )
        .fadeIn(400);
    });

    // Hide show button and display hide button with fade animation
    $("#showDataButton").fadeOut(400, function () {
      $("#hideDataButton").fadeIn(400);
    });
  });

  // Add click event for hide button
  $("#hideDataButton").click(function () {
    // Clear the output area with fade animation
    $("#output").fadeOut(400, function () {
      $(this).html("").fadeIn(400);
    });

    // Hide hide button and display show button with fade animation
    $("#hideDataButton").fadeOut(400, function () {
      $("#showDataButton").fadeIn(400);
    });
  });
});
