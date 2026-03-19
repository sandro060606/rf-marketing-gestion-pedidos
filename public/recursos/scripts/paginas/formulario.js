// ═══════════════════════════════════════════════════════════
// ARCHIVO: public/recursos/scripts/paginas/formulario.js
// Scripts del wizard de nuevo pedido del cliente
// ═══════════════════════════════════════════════════════════

// ── Navegación entre pasos ───────────────────────────────
function irPaso(num) {
  document
    .querySelectorAll(".wizard-panel")
    .forEach((p) => p.classList.remove("active"));
  document
    .querySelectorAll(".wizard-step")
    .forEach((s) => s.classList.remove("active", "completado"));
  document.getElementById("paso-" + num).classList.add("active");

  for (let i = 1; i <= 3; i++) {
    const ind = document.getElementById("ind-" + i);
    if (i < num) ind.classList.add("completado");
    if (i === num) ind.classList.add("active");
  }

  if (num === 3) actualizarResumen();
  window.scrollTo(0, 0);
}

// ── Validar antes de avanzar ─────────────────────────────
function validarYsiguiente(paso) {
  if (paso === 1) {
    const titulo = document.querySelector('[name="titulo"]').value.trim();
    const area = document.querySelector('[name="area"]').value.trim();
    const obj = document
      .querySelector('[name="objetivo_comunicacion"]')
      .value.trim();
    const fecha = document
      .querySelector('[name="fecharequerida"]')
      .value.trim();
    if (!titulo || !area || !obj || !fecha) {
      mostrarError(
        "Completa todos los campos obligatorios antes de continuar.",
      );
      return;
    }
  }
  if (paso === 2) {
    const tipo = document.querySelector('[name="tipo_requerimiento"]:checked');
    const desc = document.querySelector('[name="descripcion"]').value.trim();
    if (!desc || !tipo) {
      mostrarError(
        "Selecciona el tipo de requerimiento y completa la descripción.",
      );
      return;
    }
  }
  ocultarError();
  irPaso(paso + 1);
}

// ── Máximo 3 canales ─────────────────────────────────────
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".check-canal").forEach(function (check) {
    check.addEventListener("change", function () {
      const marcados = document.querySelectorAll(".check-canal:checked");
      if (marcados.length > 3) {
        this.checked = false;
        mostrarError("Puedes seleccionar máximo 3 canales de difusión.");
      } else {
        ocultarError();
      }
    });
  });

  // ── Bloquear envío si hay archivos subiendo ───────────
  const form = document.getElementById("wizardForm");
  if (form) {
    form.addEventListener("submit", function (e) {
      const subiendo = document.querySelectorAll(
        ".archivo-item .progreso-wrap",
      );
      if (subiendo.length > 0) {
        e.preventDefault();
        mostrarError("Espera a que terminen de subirse todos los archivos.");
      }
    });
  }

  // ── Drag & Drop zona archivos ─────────────────────────
  const zonaDrop = document.getElementById("zona-drop");
  const inputArchivos = document.getElementById("inputArchivos");

  if (zonaDrop && inputArchivos) {
    zonaDrop.addEventListener("dragover", (e) => {
      e.preventDefault();
      zonaDrop.classList.add("drag-over");
    });
    zonaDrop.addEventListener("dragleave", () =>
      zonaDrop.classList.remove("drag-over"),
    );
    zonaDrop.addEventListener("drop", (e) => {
      e.preventDefault();
      zonaDrop.classList.remove("drag-over");
      procesarArchivos(e.dataTransfer.files);
    });
    inputArchivos.addEventListener("change", () =>
      procesarArchivos(inputArchivos.files),
    );
  }
});

// ── Mostrar/ocultar campo Otros ───────────────────────────
function toggleOtros() {
  const campoOtros = document.getElementById("campoOtros");
  const otrosMarcado = document.querySelector(
    '[name="formatos_solicitados[]"][value="Otros"]',
  );
  campoOtros.style.display =
    otrosMarcado && otrosMarcado.checked ? "block" : "none";
}

// ── Prioridad ─────────────────────────────────────────────
function setPrioridad(valor, el) {
  document.getElementById("campoPrioridad").value = valor;
  document
    .querySelectorAll(".opcion-prioridad")
    .forEach((o) => o.classList.remove("active"));
  el.classList.add("active");
}

// ── Actualizar resumen paso 3 ─────────────────────────────
function actualizarResumen() {
  document.getElementById("res-titulo").textContent =
    document.querySelector('[name="titulo"]').value || "—";
  document.getElementById("res-area").textContent =
    document.querySelector('[name="area"]').value || "—";
  document.getElementById("res-fecha").textContent =
    document.querySelector('[name="fecharequerida"]').value || "—";

  const tipo = document.querySelector('[name="tipo_requerimiento"]:checked');
  document.getElementById("res-tipo").textContent = tipo ? tipo.value : "—";
}

// ── Mensajes de error ─────────────────────────────────────
function mostrarError(msg) {
  let el = document.getElementById("wizard-error");
  if (!el) {
    el = document.createElement("div");
    el.id = "wizard-error";
    el.className = "alerta-error mb-3";
    document.getElementById("wizardForm").prepend(el);
  }
  el.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + msg;
  el.style.display = "block";
  window.scrollTo(0, 0);
}

function ocultarError() {
  const el = document.getElementById("wizard-error");
  if (el) el.style.display = "none";
}

// ═══════════════════════════════════════════════════════════
// SUBIDA DE ARCHIVOS con barra de progreso via AJAX
// ═══════════════════════════════════════════════════════════

const archivosSubidos = [];
const extensionesPermitidas = [
  "jpg",
  "jpeg",
  "png",
  "gif",
  "pdf",
  "ai",
  "psd",
  "mp4",
  "zip",
];

function procesarArchivos(files) {
  Array.from(files).forEach((file) => subirArchivo(file));
}

function subirArchivo(file) {
  const ext = file.name.split(".").pop().toLowerCase();

  if (!extensionesPermitidas.includes(ext)) {
    agregarItemLista(file.name, "error", 0, "Extensión no permitida");
    return;
  }

  if (file.size > 500 * 1024 * 1024) {
    agregarItemLista(file.name, "error", 0, "Supera 500MB");
    return;
  }

  // ID único para el item en la lista
  const itemId = "arch-" + Date.now() + Math.random().toString(36).substr(2, 5);
  agregarItemLista(file.name, "subiendo", file.size, "", itemId);

  const formData = new FormData();
  formData.append("archivo", file);

  // CSRF — el token se inyecta desde el meta tag
  const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute("content");
  const csrfName = document
    .querySelector('meta[name="csrf-name"]')
    ?.getAttribute("content");
  if (csrfName && csrfToken) formData.append(csrfName, csrfToken);

  const xhr = new XMLHttpRequest();

  // Barra de progreso
  xhr.upload.addEventListener("progress", (e) => {
    if (e.lengthComputable) {
      const pct = Math.round((e.loaded / e.total) * 100);
      const barra = document.querySelector(`#${itemId} .progreso-barra`);
      const label = document.querySelector(`#${itemId} .progreso-pct`);
      if (barra) barra.style.width = pct + "%";
      if (label) label.textContent = pct + "%";
    }
  });

  xhr.addEventListener("load", () => {
    try {
      const res = JSON.parse(xhr.responseText);
      if (res.status === 201) {
        archivosSubidos.push(res.data.ruta);
        document.getElementById("archivos_rutas").value =
          JSON.stringify(archivosSubidos);
        actualizarItemLista(itemId, "ok");
      } else {
        actualizarItemLista(itemId, "error", res.mensaje || "Error al subir");
      }
    } catch {
      actualizarItemLista(itemId, "error", "Error inesperado");
    }
  });

  xhr.addEventListener("error", () =>
    actualizarItemLista(itemId, "error", "Error de red"),
  );

  // Endpoint de subida temporal
  xhr.open("POST", window.BASE_URL + "cliente/subir-archivo-temp");
  xhr.send(formData);
}

function agregarItemLista(nombre, estado, tamano, msg = "", id = "") {
  const lista = document.getElementById("lista-archivos");
  const kb = tamano ? (tamano / 1024).toFixed(0) + " KB" : "";
  const item = document.createElement("div");
  item.className = "archivo-item";
  if (id) item.id = id;

  item.innerHTML = `
        <div class="archivo-item-info">
            <i class="bi bi-paperclip"></i>
            <span class="archivo-nombre">${nombre}</span>
            <span class="archivo-peso">${kb}</span>
        </div>
        ${
          estado === "subiendo"
            ? `
        <div class="progreso-wrap">
            <div class="progreso-track">
                <div class="progreso-barra" style="width:0%"></div>
            </div>
            <span class="progreso-pct">0%</span>
        </div>`
            : ""
        }
        ${estado === "error" ? `<span class="archivo-estado error"><i class="bi bi-x-circle-fill"></i> ${msg}</span>` : ""}
    `;
  lista.appendChild(item);
}

function actualizarItemLista(id, estado, msg = "") {
  const item = document.getElementById(id);
  if (!item) return;
  const progresoWrap = item.querySelector(".progreso-wrap");
  if (progresoWrap) progresoWrap.remove();

  const span = document.createElement("span");
  span.className = "archivo-estado " + estado;
  span.innerHTML =
    estado === "ok"
      ? '<i class="bi bi-check-circle-fill"></i> Subido'
      : `<i class="bi bi-x-circle-fill"></i> ${msg}`;
  item.appendChild(span);
}
