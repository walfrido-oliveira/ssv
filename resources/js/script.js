$(document).ready(function() {
    $('.select2').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
    });
    $('.select2-with-tag').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
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
    $(".show-contact-info").click( function() {
        $('.contact-info').toggle("slow", function() {
            if($('.contact-info').is(":hidden")) {
                $('.contact-info').hide();
            } else {
                $('.contact-info').show();
            }
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

window.dateToDMY = function(date) {
    let parts = date.split('-');
    let dateResult = new Date(parts[0], parts[1] - 1, parts[2]);
    var d = dateResult.getDate();
    var m = dateResult.getMonth() + 1;
    var y = dateResult.getFullYear();
    return '' + (d <= 9 ? '0' + d : d) + '/' + (m<=9 ? '0' + m : m) + '/' + y;
}





