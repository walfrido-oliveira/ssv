$(document).ready(function() {
    $('.select2').select2();
    $('.select2-with-tag').select2({
        tags: true,
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
            return null;
            }

            return {
                id: term,
                text: term
            }
        }
    });
    $(".input-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table-search tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
});





