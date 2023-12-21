document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const addNoteForm = document.getElementById("addNoteForm");


    document.getElementById("showLoginForm").addEventListener("click", function() {
    loginForm.style.display = "block";
    registerForm.style.display = "none";
    addNoteForm.style.display = "none";
    document.getElementById("actionType").value = "login";
});

document.getElementById("showRegisterForm").addEventListener("click", function() {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
    addNoteForm.style.display = "none";
    document.getElementById("actionType").value = "register";
});

document.getElementById("showAddNoteForm").addEventListener("click", function() {
    loginForm.style.display = "none";
    registerForm.style.display = "none";
    addNoteForm.style.display = "block";
    document.getElementById("actionType").value = "addNote";
});

});
