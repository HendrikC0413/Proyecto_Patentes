function Mostrar_datos(){
    var str = document.getElementById('placa').value;
    var spinner = document.getElementById("spin1"); 
    if (str=="") {
        document.getElementById("txtHint").innerHTML="";
        return;
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            document.getElementById("txtHint").innerHTML=this.responseText;
            spinner.style.display = "none"; 
        }
    }
    spinner.style.display = "block"; 
    xmlhttp.open("GET","datos.php?q="+str,true);
    xmlhttp.send();
}

function guardar_datos(){
    var prin = document.getElementById('rin').value;
    var pplc = document.getElementById('plc').value;
    var pphon = document.getElementById('phone').value;
    var ppcell = document.getElementById('cellphone').value;
    var ppml = document.getElementById('mail').value;
    var spinner = document.getElementById("spin1");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
            spinner.style.display = "none";
        }
    };
    document.getElementById('AcordeonMuestra').style.display = "none";
    spinner.style.display = "block"; 
    xhttp.open("POST", "guardado.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "paramPL="+ pplc +"&paramR=" + prin + "&paramPH=" + pphon + "&paramCL=" + ppcell + "&paramM=" + ppml;
    xhttp.send(params);
}

/**
 * Se encarga de validar el telefono
 * @returns true or false
 */
function ValidarTelefono(){
    var x = false;
    var patron = /^[0-9]{7,8}$/;
    var phone = document.getElementById('phone');
    var l_phone = document.getElementById('Lphone');
    if(phone.value != ""){
        if (!patron.test(phone.value)) {
            phone.className = "form-control text-center border-danger";
            l_phone.style.display="block";
        }else{
            x = true;
            phone.className = "form-control text-center border-success";
            l_phone.style.display="none";
        }
    }else{
        x = true;
        phone.className = "form-control text-center";
        l_phone.style.display="none";
    }
    return x;
}

/**
 * Se encarga de validar el email
 * @returns true or false.
 */
function ValidarEmail(){
    var x = false;
    var patron =/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    var mail = document.getElementById('mail');
    var l_mail = document.getElementById('Lemail');
    if(mail.value != ""){
        if (!patron.test(mail.value)) {
            mail.className = "form-control text-center border-danger";
            l_mail.style.display="block";
        }else{
            x = true;
            mail.className = "form-control text-center border-success";
            l_mail.style.display="none";
        }
    }else{
        x = true;
        mail.className = "form-control text-center";
        l_mail.style.display="none";
    }
    return x;
}

/**
 * Valida numeros celulares 8 caracteres
 * @returns true or false.
 */
function ValidarCelular(){
    var x = false;
    var patron = /^[0-9]{8}$/;
    var cellphone = document.getElementById('cellphone');
    var l_cphone = document.getElementById('LCphone');
    if(cellphone.value != ""){
        if (!patron.test(cellphone.value)) {
            cellphone.className = "form-control text-center border-danger";
            l_cphone.style.display="block";
        }else{
            cellphone.className = "form-control text-center border-success";
            x = true;
            l_cphone.style.display="none";
        }
    }else{
        cellphone.className = "form-control text-center";
        x = true;
        l_cphone.style.display="none";
    }
    return x;
}

/**
 * Valida una ultima vez los datos y cuantos de ellos estan vacios.
 */
function comprobarDatos(){
    ValidarCelular();
    ValidarEmail();
    ValidarTelefono();
    var cellphone = document.getElementById('cellphone').value;
    var phone = document.getElementById('phone').value;
    var email = document.getElementById('mail').value;
    var alerta = document.getElementById('alerta');
    var contador = 0;
    if( email== ""){
        contador += 1;
    }
    if(cellphone == ""){
        contador += 1;
    }
    if(phone == ""){
        contador += 1;
    }
    if (contador>2) {
        alerta.style.display = 'block';
        document.getElementById('AlertaP').innerHTML = "Por favor proporcione <strong>al menos UN método de CONTACTO </strong> para programar el servicio de su vehículo.";
    }else{
        if((ValidarCelular()==true) && (ValidarEmail()==true) && (ValidarTelefono()==true)){
            guardar_datos();
        }else{
            alerta.style.display = 'block';
            document.getElementById('AlertaP').innerHTML = "Por favor ingrese sus datos según el formato establecido";
        }
    }
}