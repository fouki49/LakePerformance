$(document).ready(() => {

    $('.txtPhone').mask('000-000-0000', { placeholder: '#: ___-___-____' });
    // TODO find a way to make a place holder for my email 
    // $('.txtEmail').placeholder('exemple@example.com');


    //Masque pour le code postal
    $('.txtPostalCode').mask('A0B-0B0', {
        placeholder: '___-___',
        translation: {
            A: { pattern: /[AaBbCcEeGgHhJjKkLlMmNnPpRrSsTtVvXxYy]/ },
            B: { pattern: /[AaBbCcEeGgHhJjKkLlMmNnPpRrSsTtVvWwXxYyZz]/ }
        }
    });

    $('.txtPostalCode').keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });

    const registrationForm = document.querySelectorAll('.needs-validation-register');

    addValidationToForm(registrationForm);

});

function addValidationToForm(forms) {
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });
}