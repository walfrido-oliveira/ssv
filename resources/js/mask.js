var options =  {
    onKeyPress: function(clientID, e, field, options) {
      var masks = ['00.000.000/0000-00', '000.000.000-00'];
      var mask = (clientID.length>11) ? masks[0] : masks[1];
      $('.cnpj-cpf').mask(mask, options);
}};
$('.cnpj-cpf').mask('00.000.000/0000-00', options);

$('.cep').mask('00000-000');

$('.phone').mask('0000-0000');
$('.mobile-phone').mask('00000-0000');
$('.phone-with-ddd').mask('(00) 0000-0000');
$('.mobile-phone-with-ddd').mask('(00) 00000-0000');
