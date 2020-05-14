let getNovoItem = (cod, item1, item2) => {
    let linha = document.createElement('tr');
    linha.id = cod;            
    montaCedula(cod, item1, item2).forEach((novaLinha) => linha.appendChild(novaLinha));
    return linha;            
}
let montaCedula = (cod, val1, val2) => {
    let cedula = [];
    cedula[0] = document.createElement('td');
    cedula[0].textContent = val1;

    cedula[1] = document.createElement('td');
    cedula[1].textContent = val2;

    cedula[2] = document.createElement('td');
    let editar = document.createElement('button');
    editar.textContent = "Editar";
    editar.addEventListener('click', _ => makeEdit(cod));
    cedula[2].appendChild(editar);

    cedula[3] = document.createElement('td');
    let excluir = document.createElement('button');
    excluir.textContent = "Excluir";
    excluir.addEventListener('click', _ => makeDelete(cod));
    cedula[3].appendChild(excluir);

    return cedula;
}
