function checkPasswords(event, id) {
  let newPwd = document.getElementById('password' + id).value;
  let confirmPwd = document.getElementById('password_confirm' + id).value;

  if (newPwd !== confirmPwd) {
    document.getElementById('pwdMatchError').style.display = 'block';
    event.preventDefault();
  } else {
    document.getElementById('pwdMatchError').style.display = 'none';
  }
}