document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Зупиняє стандартну поведінку відправки форми
        
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        // Виконуємо реєстрацію або авторизацію користувача
        axios.post('login.php', {
            username: username,
            email: email,
            password: password
        })
        .then(function(response) {
            // Якщо реєстрація/авторизація успішна, виконуємо відповідні дії
            if (response.data.success) {
                alert(response.data.message); // Показуємо повідомлення про успішний вхід або реєстрацію
                window.location.href = 'kittencafe.html'; // Перенаправляємо на іншу сторінку
            } else {
                alert(response.data.message); // Показуємо повідомлення про помилку
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Зупиняємо стандартну поведінку форми

        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Тут можна виконати перевірку даних та взаємодію з сервером для авторизації

        // Приклад перевірки на успішну авторизацію
        if (username === 'example' && password === 'password') {
            // Відображення повідомлення про успішну авторизацію
            alert('Login successful!');
            // Перенаправлення на головну сторінку
            window.location.href = 'kitttencafe.html';
        } else {
            // Відображення повідомлення про неуспішну авторизацію
            alert('Invalid username or password. Please try again.');
        }
    });
});
