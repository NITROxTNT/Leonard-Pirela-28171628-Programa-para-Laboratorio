function registrarResultados (formularioRecibido) {

    let formularioDatos = new FormData (document.getElementById('formDatos'));

    var solicitudHttp  = new XMLHttpRequest ();
    solicitudHttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            console.log(this.responseText);
            alert(this.responseText);

        }
    }

    solicitudHttp.open("POST",".\\modelos\\registrarResultados.php");
    solicitudHttp.send(formularioDatos);

}