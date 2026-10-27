<?php
$editando = ($modo ?? "crear") === "editar";
?>
<form id="formUsuario" action="index.php" method="get" novalidate
      data-modo="<?= $editando ? "editar" : "crear" ?>">
    <fieldset>
        <legend><?= $editando ? "Editar usuario" : "Nuevo Usuario" ?></legend>

        <input type="text" name="nombre" placeholder="Nombre"
               value="<?= $editando ? htmlspecialchars($usuario->nombre) : "" ?>">
        <span class="error"></span>

        <input type="email" name="email" placeholder="Email"
               value="<?= $editando ? htmlspecialchars($usuario->email) : "" ?>">
        <span class="error"></span>

        <select name="tipo">
            <option value="admin" <?= ($editando && $usuario->tipo === "admin") || !$editando ? "selected" : "" ?>>admin</option>
            <option value="standar" <?= $editando && $usuario->tipo === "standar" ? "selected" : "" ?>>standar</option>
        </select>
        <span class="error"></span>

        <input type="password" name="password"
               placeholder="<?= $editando ? "Nueva password (vacío = no cambiar)" : "Password" ?>">
        <span class="error"></span>

        <button type="submit"><?= $editando ? "Guardar cambios" : "Registrar" ?></button>

        <input type="hidden" name="controller" value="UsuarioController">
        <input type="hidden" name="accion" value="<?= $editando ? "update" : "store" ?>">
        <?php if ($editando): ?>
            <input type="hidden" name="id" value="<?= $usuario->id ?>">
        <?php endif; ?>
    </fieldset>
</form>

<style>
    #formUsuario .error { display: block; color: red; font-size: 0.85em; min-height: 1.2em; }
</style>

<script>
    const reglas = {
        nombre:   /^[A-Z][a-z]{4,14}$/,
        email:    /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        tipo:     /^(admin|standar)$/,
        password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/
    };

    const form = document.getElementById("formUsuario");
    const esEdicion = form.dataset.modo === "editar";

    function validarCampo(nombre) {
        const campo = form.elements[nombre];
        const aviso = campo.nextElementSibling;

        // Al editar, la password puede dejarse vacía (se mantiene la actual)
        const valido = (nombre === "password" && esEdicion && campo.value === "")
            ? true
            : reglas[nombre].test(campo.value);

        aviso.textContent = valido ? "" : "Dato incorrecto";
        return valido;
    }

    form.addEventListener("submit", function (e) {
        let todoOk = true;
        for (const nombre in reglas) {
            if (!validarCampo(nombre)) todoOk = false;
        }
        if (!todoOk) e.preventDefault();
    });

    for (const nombre in reglas) {
        form.elements[nombre].addEventListener("blur", () => validarCampo(nombre));
    }
</script>