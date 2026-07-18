<?php
class Auth {
    public static function check(): bool { return isset($_SESSION['user']); }
    public static function user(): ?array { return $_SESSION['user'] ?? null; }
    public static function isAdmin(): bool { return self::check() && $_SESSION['user']['role'] === 'admin'; }
    public static function requireLogin(): void {
        if (!self::check()) {
            $_SESSION['error'] = 'Debe iniciar sesión para continuar.';
            header('Location: index.php?route=login'); exit;
        }
    }
    public static function requireAdmin(): void {
        if (!self::isAdmin()) {
            http_response_code(403);
            $_SESSION['error'] = 'No tiene permiso para acceder a este módulo.';
            header('Location: index.php?route=home'); exit;
        }
    }
}
