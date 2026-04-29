<?php
/**
 * Header Partial
 * Website header with meta tags, charset, title, and CSS links
 */

$resolvedPageTitle = trim((string) ($pageTitle ?? ''));
$resolvedPageDescription = trim((string) ($pageDescription ?? ''));

if ($resolvedPageTitle === '') {
    $resolvedPageTitle = 'DatEdu - Online Course Platform';
}

if ($resolvedPageDescription === '') {
    $resolvedPageDescription = 'DatEdu is an online course platform for practical courses in programming, business, design, and more.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($resolvedPageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($resolvedPageDescription); ?>">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?php echo htmlspecialchars($resolvedPageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($resolvedPageDescription); ?>">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/courses.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/auth.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('css/checkout.css'); ?>">
</head>
<body>
