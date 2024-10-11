$(document).ready(function() {
    // Sélectionner tous les éléments avec la classe "modifier"
    $('.modifier').click(function(event) {
        event.preventDefault();
        const userId = $(this).data('id');

        // Afficher le modal
        $('#modalChangePassword').modal('show');

        // Nettoyer les champs de mot de passe à chaque ouverture du modal
        $('#currentPassword').val('');
        $('#newPassword').val('');

        // Délier les précédents événements de soumission pour éviter les doublons
        $('#modalChangePassword form').off('submit').submit(function(event) {
            event.preventDefault();

            const currentPassword = $('#currentPassword').val();
            const newPassword = $('#newPassword').val();

            // Requête AJAX pour envoyer les données au serveur via GET
            $.ajax({
                url: 'modifier_password.php',
                type: 'GET',
                data: {
                    id: userId,
                    currentPassword: currentPassword,
                    newPassword: newPassword
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#modalChangePassword').modal('hide');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Erreur lors de la requête AJAX.');
                }
            });
        });
    });
});

function togglePassword() {
    var passwordInput = document.getElementById("currentPassword");
    var showBtn = document.querySelector(".show-btn");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
        </svg>`;
    } else {
        passwordInput.type = "password";
        showBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
  <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
  <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
</svg>`;
    }
}


function togglePassword1() {
    var passwordInput = document.getElementById("newPassword");
    var showBtn = document.querySelector(".show-btn1");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
        </svg>`;
    } else {
        passwordInput.type = "password";
        showBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
  <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
  <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
</svg>`;
    }
}







