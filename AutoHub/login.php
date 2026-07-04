<?php
session_start();
include 'db_connect.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['logged_in'] = true;
        header("Location: admin_hub.php");
        exit();
    } else {
        $error = "Invalid Authorized Credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AutoHub Elite | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #f8fafc; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: sans-serif; }
        .login-card { background: white; padding: 50px; border-radius: 30px; width: 100%; max-width: 400px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="login-card">
        <h1 class="text-2xl font-black text-slate-900 italic mb-8">ELITE <span class="text-blue-600">ACCESS</span></h1>
        <?php if(isset($error)) echo "<p class='text-red-500 text-xs mb-4'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full p-4 bg-slate-100 rounded-xl mb-4 outline-none border-2 focus:border-blue-600" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-4 bg-slate-100 rounded-xl mb-6 outline-none border-2 focus:border-blue-600" required>
            <button type="submit" name="login" class="w-full bg-blue-600 text-white p-4 rounded-xl font-bold uppercase tracking-widest shadow-lg shadow-blue-200">Authorize</button>
        </form>
    </div>
</body>
</html>