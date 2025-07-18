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