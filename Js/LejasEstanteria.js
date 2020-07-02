function cargarLejasLibres(str) {
    var xmlhttp;
    if (str == "") {
        document.getElementById("lejasLibres").innerHTML = "";
        return;
    }

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
        /* Creamos el objeto request para conexiones http,
         compatible con los navegadores descritos*/
    } else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        /*Como el explorer va por su cuenta, el objeto es un ActiveX */
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("lejasLibres").innerHTML = xmlhttp.responseText;
            /*Seleccionamos el elemento que recibirá el flujo de datos*/
        }
    }
    xmlhttp.open("GET", "AjaxLejasLibres.php?estanteriasdisponibles=" + str, true);
    /*Mandamos al PHP encargado de traer los datos, el valor de referencia */
    xmlhttp.send();
}

