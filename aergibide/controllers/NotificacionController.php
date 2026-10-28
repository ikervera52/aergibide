<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/NotificacionModel.php';

class NotificacionController extends BaseController {

    public function listar() {
        $this->requireLogin();

        $notificaciones = NotificacionModel::getByUsuarioId($_SESSION['usuario']['id']);

        foreach ($notificaciones as $notificacion) {
            require __DIR__ . '/../views/components/notificacion.php';
        }

        if (empty($notificaciones)) {
            echo '<p class="sinNotificaciones">No tienes notificaciones.</p>';
        }
    }

    public function eliminar() {
        $this->requireLogin();

        $datos = json_decode(file_get_contents('php://input'), true);
        $id = (int)($datos['id'] ?? 0);

        $ok = NotificacionModel::deleteById($id, $_SESSION['usuario']['id']);

        $this->json(['ok' => $ok]);
    }
}