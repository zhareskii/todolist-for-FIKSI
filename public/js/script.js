const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

document.addEventListener('DOMContentLoaded', function() {
    const addTaskBtn = document.getElementById('addTaskBtn');
    const overlay = document.getElementById('overlay');
    const taskForm = document.getElementById('taskForm');
    const closeForm = document.getElementById('closeForm');

    addTaskBtn.addEventListener('click', () => {
        overlay.style.display = 'block';
        taskForm.style.display = 'block';
    });

    closeForm.addEventListener('click', () => {
        overlay.style.display = 'none';
        taskForm.style.display = 'none';
    });

    overlay.addEventListener('click', () => {
        overlay.style.display = 'none';
        taskForm.style.display = 'none';
    });
});
