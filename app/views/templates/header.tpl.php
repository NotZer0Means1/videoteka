<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$currentUser = $isLoggedIn ? $_SESSION : null;
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Videoteka' : 'Videoteka'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/recaptcha.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">🎬 Videoteka</div>
                <div class="menu">
                    <a href="?page=home">Početna</a>
                    <a href="?page=movies">Filmovi</a>
                    <a href="?page=contact">Kontakt</a>
                </div>
                <div class="auth-buttons">
                    <?php if ($isLoggedIn): ?>
                        <span class="user-welcome">Pozdrav, <?php echo htmlspecialchars($currentUser['first_name']); ?>!</span>
                        <a href="?page=profile" class="btn btn-outline">Profil</a>
                        <a href="?page=logout" class="btn btn-primary">Odjava</a>
                    <?php else: ?>
                        <a href="?page=login" class="btn btn-outline">Prijava</a>
                        <a href="?page=register" class="btn btn-primary">Registracija</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>