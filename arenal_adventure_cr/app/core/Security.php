<?php
class Security {
    public static function e(?string $value): string {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
    public static function csrfToken(): string {
        if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
        return $_SESSION['csrf_token'];
    }
    public static function validateCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            throw new Exception('La solicitud no es válida. Inténtelo nuevamente.');
        }
    }
    public static function post(string $name): string { return trim(filter_input(INPUT_POST, $name) ?? ''); }
}
