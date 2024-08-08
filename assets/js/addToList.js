function rem_item(_this) {
  _this.closest("tr").remove();
  calculate_total();
}

function calculate_total() {
  var total = 0;
  $('#fine-list input[name="fine[]"]').each(function () {
    var fine = $(this).val();
    total += parseFloat(fine);
  });
  $("#total_amount").text(
    "₱" + parseFloat(total).toLocaleString("en-US") + ".00"
  );
  $('input[name="total_amount"]').val(parseFloat(total));
}

$(document).ready(function () {
  $("#add_to_list").click(function () {
    var offense_id = $("#offense_id").val();
    var fine = $('#offense_id option[value="' + offense_id + '"]').attr(
      "data-fine"
    );
    var name = $('#offense_id option[value="' + offense_id + '"]').attr(
      "data-name"
    );
    var code = $('#offense_id option[value="' + offense_id + '"]').attr(
      "data-code"
    );
    var tr = $("<tr>");
    tr.append(
       '<td class="text-center">' +
        code +
        '<input type="hidden" name="offense_id[]" value="' +
        offense_id +
        '"><input type="hidden" name="fine[]" value="' +
        fine +
        '"></td>'
    );
    tr.append(
      '<td class="text-center">'+
        name +
        '<input type="hidden" name="offense_name[]" value="' +
        name +
        '"></td>'
    );
    tr.append(
      '<td class="text-center">' +"<b>₱ </b>"+
        parseFloat(fine).toLocaleString("en-US") +
        "</td>"
    );
    tr.append(
      '<td class="text-center"><button class="btn  btn-sm btn-default text-danger" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button></td>'
    );
    $("#fine-list tbody").append(tr);
    if ($("#td-none").length > 0) $("#td-none").remove();
    calculate_total();
    $("#offense_id").val("").trigger("change");
  });
});
