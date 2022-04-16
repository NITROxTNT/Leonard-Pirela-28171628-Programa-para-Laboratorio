function seleccionarFormulario (formularioPedido) {

var formResultados = document.getElementById('divResultados');

generarFormulario(formularioPedido, formResultados);

}


function generarFormulario (nombreFormulario, formResultados) {

    
    formResultados.innerHTML = "";

    var solicitudHttp  = new XMLHttpRequest ();
    solicitudHttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            formResultados.innerHTML = this.responseText;

        }
    }

    solicitudHttp.open("GET",".\\vistas\\" + nombreFormulario + ".html");
    solicitudHttp.send();


}