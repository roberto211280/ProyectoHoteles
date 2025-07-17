registrar.addEventListener("click", () => {
    const resultadoValidacion = validarFormulario(frm);

    if (!resultadoValidacion.valido) {
        Swal.fire({
            icon: "error",
            title: "Error de validación",
            text: resultadoValidacion.mensaje
        });
        return;
    }
    
    fetch("crud.php", {
        method: "POST",
        body: new FormData(frm)
    }).then(response => response.text()).then(response => {
        if (response == "ok") {
            Swal.fire({
                icon: "success",
                title: "Usuario Registrado",
                showConfirmButton: false,
                timer: 1500
            });
            frm.reset();
            ListarUsuarios();
        } else if (response == "modificado") {
            Swal.fire({
                icon: "success",
                title: "Usuario Modificado",
                showConfirmButton: false,
                timer: 1500
            });
            registrar.value = "Registrar";
            idUsuario.value = "";
            frm.reset();
            ListarUsuarios();
        } else {
            // Mostrar error específico
            Swal.fire({
                icon: "error",
                title: "Error",
                text: response.replace("error: ", "")
            });
        }
    })
});

// Función para dar de baja usuario
function DarDeBajaUsuario(id) {
    Swal.fire({
        title: '¿Estás seguro de dar de baja este usuario?',
        text: "El usuario será desactivado pero sus datos se conservarán",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'SÍ, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("crud.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ accion: "dar_baja", id: id })
            }).then(response => response.text()).then(response => {
                if (response == "ok") {
                    ListarUsuarios();
                    Swal.fire({
                        icon: "success",
                        title: "Usuario dado de baja",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error al dar de baja",
                        text: response.replace("error: ", "")
                    });
                }
            })
        }
    });
}

// Función para reactivar usuario
function ReactivarUsuario(id) {
    Swal.fire({
        title: '¿Reactivar este usuario?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#6c757d",
        confirmButtonText: 'SÍ, reactivar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("crud.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ accion: "reactivar", id: id })
            }).then(response => response.text()).then(response => {
                if (response == "ok") {
                    ListarUsuarios();
                    Swal.fire({
                        icon: "success",
                        title: "Usuario reactivado",
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error al reactivar",
                        text: response.replace("error: ", "")
                    });
                }
            })
        }
    });
}

// Función para editar usuario
function EditarUsuario(id) {
    fetch("crud.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ accion: "obtener", id: id })
    }).then(response => response.json()).then(response => {
        idUsuario.value = response.id;
        nombre.value = response.nombre;
        email.value = response.email;
        password.value = ""; // No mostrar contraseña por seguridad
        rol.value = response.rol;
        registrar.value = "Actualizar";
        
        // Scroll al formulario
        frm.scrollIntoView({ behavior: 'smooth' });
    })
}

// Event listener para búsqueda
buscar.addEventListener("keyup", () => {
    const valor = buscar.value;
    if (valor == "") {
        ListarUsuarios();
    } else {
        ListarUsuarios(valor);
    }
});

// Cargar usuarios al inicio
document.addEventListener("DOMContentLoaded", () => {
    ListarUsuarios();
});