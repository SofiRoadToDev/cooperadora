document.addEventListener("DOMContentLoaded", () => {
    const conceptoBlock = document.getElementById("concepto-block");
    var quitarBtn = document.getElementById("quitar");
    const addConceptoBtn = document.getElementById("addConcepto");
    const conceptoContainer = document.getElementById("concepto-container");
    var index = 0;
    addConceptoBtn.addEventListener("click", () => {
        const cloned = conceptoBlock.cloneNode(true);
        index++;
        cloned.setAttribute("id", cloned.id + "-" + index);
        const btnCloned = quitarBtn.cloneNode(true);
        btnCloned.setAttribute("id", index);
        btnCloned.removeAttribute("hidden");
        conceptoBlock.appendChild(btnCloned);
        conceptoContainer.appendChild(cloned);
    });

    quitarBtn.addEventListener("click", () => {
        console.log(quitarBtn.parentElement.id);
    });

    // Obtener el alumno

    var alumnoInput = document.getElementById("alumnoInput");
    var alumnoIdInput = document.querySelector("#alumno_id");
    const alumnoBuscarBtn = document.getElementById("buscarAlumno-btn");
    var dniInput = document.querySelector("#dni");

    var url = "http://cooperadora.test/api/alumnos";

    dniInput.addEventListener(
        "change",
        () => (url = `http://cooperadora.test/api/alumnos/${dniInput.value}`)
    );

    alumnoBuscarBtn.addEventListener("click", () => {
        //console.log(url);
        if (dniInput.value != "") {
            fetch(url)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Alumno no encontrado");
                    }
                    return response.json();
                })
                .then((data) => {
                    alumnoInput.value = `${data.apellido} ${data.nombre}`;
                    alumnoIdInput.value = data.id;
                })
                .catch((error) => console.error(error));
        }
    });

    // recuperando conceptos
});
