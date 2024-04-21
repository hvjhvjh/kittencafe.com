<?php

// Підключення до бази даних PostgreSQL
$host = 'localhost'; // Адреса сервера бази даних
$dbname = 'KittenCafe'; // Назва бази даних
$username = 'postgres'; // Ім'я користувача бази даних
$password = ''; // Пароль користувача бази даних

// Встановлення з'єднання з базою даних
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Функція для реєстрації нового користувача
function registerUser($pdo, $username, $email, $password) {
    try {
        // Вставка нового користувача в базу даних
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        return true; // Реєстрація успішна
    } catch (PDOException $e) {
        return false; // Реєстрація не вдалася
    }
}

// Функція для авторизації користувача
function loginUser($pdo, $username, $password) {
    try {
        // Пошук користувача за ім'ям та паролем
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            return true; // Авторизація успішна
        } else {
            return false; // Авторизація не вдалася
        }
    } catch (PDOException $e) {
        return false; // Авторизація не вдалася
    }
}

// Обробка запиту на реєстрацію або авторизацію
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Виконання реєстрації або авторизації користувача
    if (isset($_POST['register'])) {
        if (registerUser($pdo, $username, $email, $password)) {
            $response['success'] = true;
            $response['message'] = 'Registration successful. You can now login.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Registration failed. Please try again.';
        }
    } elseif (isset($_POST['login'])) {
        if (loginUser($pdo, $username, $password)) {
            $response['success'] = true;
            $response['message'] = 'Login successful.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Login failed. Incorrect username or password.';
        }
    }
    
    // Вивід результатів у форматі JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
