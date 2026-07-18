<?php
class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewFile)) { throw new Exception('Vista no encontrada.'); }
        require __DIR__ . '/../views/layouts/header.php';
        require $viewFile;
        require __DIR__ . '/../views/layouts/footer.php';
    }

    protected function redirect(string $route): void {
        $config = require __DIR__ . '/../config/config.php';
        header('Location: ' . $config['base_url'] . '/index.php?route=' . $route);
        exit;
    }
}
