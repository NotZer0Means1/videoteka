<?php

$currentUser = null;
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

if ($isLoggedIn) {
    $currentUser = [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'first_name' => $_SESSION['first_name'],
        'last_name' => $_SESSION['last_name'],
        'role' => $_SESSION['user_role']
    ];
}

$pageTitle = isset($pageTitle) ? $pageTitle . ' - ' . SITENAME : SITENAME;
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo SITEDESC; ?>">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/responsive.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    <?php include 'header.php'; ?>
    
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="flash-message <?php echo $_SESSION['flash_type']; ?>" id="flashMessage">
            <div class="container">
                <span><?php echo htmlspecialchars($_SESSION['flash_message']); ?></span>
                <button type="button" class="flash-close">&times;</button>
            </div>
        </div>
        <?php 
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        ?>
    <?php endif; ?>

    <main class="main-content">
        <div class="container">
            <?php echo $content; ?>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
    
</body>
</html>