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

window.currencyFormatDE = function(num) {
    num = parseFloat(num);
    return (
      'R$ ' +
      num
        .toFixed(2) // always two decimal digits
        .replace('.', ',') // replace decimal point character with ,
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    ) // use . as a separator
}





