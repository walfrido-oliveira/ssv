$(document).ready(function() {
    $('.select2').select2();

    $('#delete-modal').on('show.bs.modal', function(e) {

        var id = $(e.relatedTarget).data('id');

        var form = $('#delete-modal-form');
        var action = form.attr('action');
        var newAction = action.replace("#", id);
        form.attr('action', newAction);
    });
});

$(document).on('click', ".btn-add", function(e) {
    e.preventDefault();

    var controlContact = $('.contact:first'),
        currentEntry   = $(this).parents('.entry:first'),
        newEntry       = $(currentEntry.clone()).appendTo('.contact:first');

    newEntry.find('input').val('');

    var selector = newEntry.find('input').attr('name');
    var index_value = selector.match(/\d+/)[0];

    var nextIndexValue = parseInt(index_value,10)+1;

    newEntry.find('input').each(function(){
        this.name = this.name.replace(selector.match(/\d+/)[0],nextIndexValue)
    });

    controlContact.find('.entry:not(:last) .btn-add')
        .removeClass('btn-add').addClass('btn-remove')
        .removeClass('btn-success').addClass('btn-danger')
        .find('i')
        .removeClass('fa-plus').addClass('fa-minus');



}).on('click', '.btn-remove', function(e)
{
    $(this).parents('.entry:first').remove();

    e.preventDefault();
    return false;
});

$(document).on('click', "#remove-contact", function() {
    var contacts = document.getElementsByClassName('contact').length;

    var id = $(this).data('contact-id');
    var item = document.getElementById('contact-' + id);

    item.remove();
});

var profileImage = document.getElementById('profile_image'),
    preview = document.getElementById('preview_image_profile'),
    container = document.getElementById('image_profile_preview_container'),
    label = document.getElementById('custom-file-label');

profileImage.addEventListener('change', function() {
    var fileName = this.value.split("\\").pop();
    label.classList.add("selected")
    label.innerHTML = fileName;
    changeImageProfile(this);
})

function changeImageProfile(input) {
    var render;

    if (input.files && input.files[0]) {
        render = new FileReader();

        render.onload = function(e) {
            preview.setAttribute('src', e.target.result);
        }

        render.readAsDataURL(input.files[0]);
        container.style.display = 'block';
    }
}



