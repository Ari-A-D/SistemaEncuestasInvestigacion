document.querySelector('#togglePassword').addEventListener('click', function (e) {
    var passwordInput = document.querySelector('#password');
    var passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    
    passwordInput.setAttribute('type', passwordType);
    
    var eyeIcon = this.querySelector('i');
    if (passwordType === 'text') {
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
    } else {
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
    }
});
   
document.querySelector('#toggleConfirmPassword').addEventListener('click', function (e) {
    var confirmPasswordInput = document.querySelector('#confirm-password');
    var passwordType = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    
    confirmPasswordInput.setAttribute('type', passwordType);
    
    if (passwordType === 'text') {
      this.querySelector('i').classList.remove('fa-eye');
      this.querySelector('i').classList.add('fa-eye-slash');
    } else {
      this.querySelector('i').classList.remove('fa-eye-slash');
      this.querySelector('i').classList.add('fa-eye');
    }
   });

function checkPasswordMatch() {
 var passwordInput = document.querySelector('#password');
 var confirmPasswordInput = document.querySelector('#confirm-password');
 var passwordAlert = document.getElementById('passwordAlert');
 if (passwordInput.value !== '' && confirmPasswordInput.value !== '' && passwordInput.value !== confirmPasswordInput.value) {
   passwordAlert.style.display = 'block';
 } else {
   passwordAlert.style.display = 'none';
 }
}

document.querySelector('#password').addEventListener('input', checkPasswordMatch);
document.querySelector('#confirm-password').addEventListener('input', checkPasswordMatch);


//BLOQUEO EN PASSWORD
function checkInput(event) {
    var keyCode = event.which;
    var isValid = (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode >= 48 && keyCode <= 57) || keyCode == 35 || keyCode == 42 || keyCode == 64;
   
    var inputError = document.getElementById('inputError');
    if (!isValid && event.target.value.trim() !== '') {
      inputError.style.display = 'block';
    } else {
      inputError.style.display = 'none';
    }
   
    return isValid;
   }
  