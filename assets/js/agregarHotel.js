// Función para confirmar publicación
function confirmarPublicacion() {
    const respuesta = confirm("¿Desea publicar el hotel inmediatamente?\n\nPresione 'Aceptar' para publicar ahora o 'Cancelar' para guardar como borrador.");
    
    // Establecer el valor según la respuesta
    document.getElementById('publicarField').value = respuesta ? '1' : '0';
    
    // Enviar el formulario
    document.getElementById('hotelForm').submit();
}

// Preview de imágenes
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    for (let i = 0; i < e.target.files.length; i++) {
        const file = e.target.files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'position-relative';
            div.style.width = '150px';
            div.style.height = '150px';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-100 h-100 object-fit-cover border rounded">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-1 lh-1" 
                        onclick="removeImage(this)" style="width: 25px; height: 25px;">&times;</button>
            `;
            preview.appendChild(div);
        };
        
        reader.readAsDataURL(file);
    }
});

function removeImage(btn) {
    btn.parentElement.remove();
}

function toggleInfo(id) {
  const el = document.getElementById(id);
  const checkbox = document.querySelector(`input[id="${id.replace('-info','')}"]`);
  if (checkbox.checked) {
    el.style.display = 'inline';
  } else {
    el.style.display = 'none';
  }
}

function agregarCampoImagen() {
    const contenedor = document.getElementById('camposImagenes');

    // Crear contenedor del input + preview
    const wrapper = document.createElement('div');
    wrapper.className = 'input-con-preview mb-3';

    // Crear input file
    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'imagenes[]';
    input.accept = 'image/*';
    input.className = 'form-control';
    input.required = true;
    input.onchange = function(event) { mostrarPrevia(event, input); };

    // Crear div para preview
    const previewDiv = document.createElement('div');
    previewDiv.className = 'preview-img mt-2';

    // Añadir input y preview al wrapper
    wrapper.appendChild(input);
    wrapper.appendChild(previewDiv);

    // Añadir todo al contenedor
    contenedor.appendChild(wrapper);
}

function mostrarPrevia(event, input) {
    const previewDiv = input.nextElementSibling; // div.preview-img
    previewDiv.innerHTML = ''; // limpiar preview previa

    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.height = '100px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '5px';
            previewDiv.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
}
