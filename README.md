# Guía de Flujo de Trabajo Git (GitFlow Híbrido)

> Documentación oficial del flujo de trabajo y buenas prácticas para el desarrollo e integración de funcionalidades en el proyecto.

---

## Estructura de Ramas

```text
 main (producción) ───●──────────────────────────●───
                      \                        /
 develop (desarrollo)  ●──────●─────────●─────●────
                               \       /
 feature/mi-rama                ●─────●
```

| Rama | Descripción | Estado / Reglas |
| --- | --- | --- |
| **`main`** | Código estable en entorno de producción. | Protegida. Solo recibe merges desde `develop`. |
| **`develop`** | Rama principal de integración y pruebas. | Base de trabajo diaria. |
| **`feature/*`** | Ramas temporales para nuevas funcionalidades. | Se crean a partir de `develop` y se eliminan tras el merge. |

---

## Flujo de Trabajo Paso a Paso

### Paso 1: Iniciar una nueva funcionalidad (Feature)

Antes de empezar cualquier tarea, asegúrate de actualizar tu rama `develop` local y crear una rama propia:

```bash
# 1. Ir a la rama de desarrollo
git checkout develop

# 2. Descargar los últimos cambios del equipo
git pull origin develop

# 3. Crear y cambiar a la nueva rama de feature
git checkout -b feature/nombre-de-la-funcionalidad
```

> **Ejemplo de nombrado:** `feature/login-usuario` o `feature/pantalla-principal`

---

### Paso 2: Revisar el estado de los archivos

Una vez completado el desarrollo en tu máquina local, comprueba qué archivos se han modificado:

```bash
git status
```

---

### Paso 3: Preparar los archivos (Staging)

Añade **únicamente** los archivos relevantes para la funcionalidad realizada.

> **Atención:** No uses `git add .` de forma indiscriminada. Agrega solo lo necesario para evitar subir configuraciones locales o archivos temporales.

```bash
# Agregar un archivo específico
git add ruta/del/archivo.ext

# Agregar múltiples archivos específicos
git add ruta/archivo1.ext ruta/archivo2.ext
```

---

### Paso 4: Realizar el Commit

Escribe un mensaje de commit descriptivo y directo que explique los cambios integrados:

```bash
git commit -m "Módulo/Pantalla: Descripción breve del cambio"
```

> **Ejemplo:**
> ```bash
> git commit -m "Pantalla principal: arreglado impresion de preguntas"
> ```

---

### Paso 5: Subir cambios a GitHub y abrir Pull Request

Sube tu rama local al repositorio remoto:

```bash
git push origin feature/nombre-de-la-funcionalidad
```

#### Pasos finales en GitHub:

1. Navega al repositorio en **GitHub**.
2. Haz clic en **Compare & Pull Request**.
3. Selecciona la rama objetivo: **`develop`** (desde `feature/tu-funcionalidad` hacia `develop`).
4. Añade una breve descripción y solicita la revisión a tus compañeros.

---

> **Nota final:** Mantén commits limpios, sube solo el código necesario y evita trabajar directamente sobre `main` o `develop`.