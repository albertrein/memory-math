//Break o envio do formulá
document.querySelector('#cadastro-form').addEventListener('submit', (loginFormEvent) => loginFormEvent.preventDefault());
document.querySelector('#login-form').addEventListener('submit', (loginFormEvent) => loginFormEvent.preventDefault());

//Le campos de dialogo, trata dados e envia
let realizaAcaoUsuario = async (elemento) => {
    let usuario = elemento.querySelector('.name');
    let password = elemento.querySelector('.password');
    let alertError = elemento.querySelector('._error');
    
    if(usuario.value.length <= 1 || !isValideString(usuario.value)){
        alertError.textContent = "Campo Usuário não é válido!";
        alertError.style.display = "block";
        return;
    }
    if(password.value.length <= 1 || !isValideString(password.value)){
        alertError.textContent = "Campo Senha não é válida!";
        alertError.style.display = "block";
        return;
    }
    let resposta = await enviaRequisicao(elemento.id, sanitizeString(usuario.value), sanitizeString(password.value));
    console.log('Resposta',resposta);
    
    if(resposta){
        logaUsuario(usuario.value);
        document.querySelector('#dialog-login').close();
        window.location.reload();
        return;
    }
    if(elemento.id == "login-form"){
        alertError.textContent = "Este usuário não está cadastrado";
    }else{
        alertError.textContent = "Este usuário já está cadastrado";
    }
    alertError.style.display = "block";
}

//Envia dados para backend
let enviaRequisicao = (tipo, usuario, senha) => new Promise((resolve, reject) => {
    let params = {
        method: "POST",
        body: JSON.stringify({"tipo" : tipo, "usuario" : usuario, "senha" : senha})
    }
    
    fetch("./backend/login.php", params).then((response)=>{
        response.json().then((jsonResponse)=>{
            console.log(jsonResponse)
            if(!jsonResponse){
                resolve(false);
            }
            resolve(true);            
        });
    });
    
});

//Loga usuario
let logaUsuario = (usuario) => {
    localStorage.setItem("usuario",usuario);
}

//Limpa string
function sanitizeString(str){
    str = str.replace(/[^a-z0-9áéíóúñü \.,_-]/gim,"");
    return str.trim();
}

let isValideString = (string) => string.match(/^[\S][A-Za-z0-9\S]+[\S]+$/) != null;