// DELETE CONFIRMATION
let deleteLinks = document.querySelectorAll('.delete-button');

for (var i = 0; i < deleteLinks.length; i++) {
  deleteLinks[i].addEventListener('click', function(event) {
      event.preventDefault();

      var choice = confirm(this.getAttribute('data-confirm'));

      if (choice) {
        window.location.href = this.getAttribute('href');
      }
  });
}

// Show password on User Edit and Add User Form
let passwordCheckbox = document.getElementById("user-password");

function showPassword() {
    if (passwordCheckbox.type === "password") {  
      passwordCheckbox.type = "text";
    } else {
      passwordCheckbox.type = "password";
    }
}

passwordCheckbox.addEventListener("click", showPassword);

