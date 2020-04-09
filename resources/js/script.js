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



