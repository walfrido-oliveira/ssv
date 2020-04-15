$(document).ready(function() {
    $('.select2').select2();
});

$(document).ready(function(){
    $(".input-search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".table-search tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });





