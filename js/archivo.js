var nivel2 = false
function eliminar(index) {
    if (nivel2) {
        alert("no se puede eliminar");
    } else {
        $("#fila" + index).remove();
    }
}

function comprobacion() {
    var valor = document.getElementById("si").checked;
    var nommbre = document.getElementById("Inputnombre2").disabled;
    var tipo = document.getElementById("Inputtipo2").disabled;
    var n2=document.getElementsByName("nombre2")

    if (valor) {
        n2.disabled = false;
        tipo.disabled = false;
        return "hecho";
    } else {
        nommbre.disabled = true;
        tipo.disabled = true;
        return "no hecho";
    }
}
document.getElementById("si").addEventListener("click",function comprobacion() {
    var valor = document.getElementById("si").checked;
    var nommbre = document.getElementById("Inputnombre2").disabled;
    var tipo = document.getElementById("Inputtipo2").disabled;

    if (valor) {
        nommbre.disabled = false;
        tipo.disabled = false;
        return "hecho";
    } else {
        nommbre.disabled = true;
        tipo.disabled = true;
        return "no hecho";
    }
});