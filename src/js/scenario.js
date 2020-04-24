let adherents = document.getElementById("listeAdherents");
let emprunts = document.getElementById("listeLivresEmpruntes");
let livres = document.getElementById("listeLivresDisponibles");

afficher_adherent();
afficher_emprunt();
afficher_livre();

function afficher_adherent() {
    let url = 'php/Routeur.php?action=recup_adherent';
    let xhr = new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.addEventListener("load",function() {
        callback(xhr);
    });
    xhr.send(null);
}

function afficher_livre(){
    let url = 'php/Routeur.php?action=recup_livre';
    let xhr = new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.addEventListener("load",function() {
        callback2(xhr);
    });
    xhr.send(null);
}

function afficher_emprunt(){
    let url = 'php/Routeur.php?action=recup_emprunt';
    let xhr = new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.addEventListener("load",function() {
        callback1(xhr);
    });
    xhr.send(null);
}

function ajout_de_ladherent(){
    let url = 'php/Routeur.php?action=ajout_adherent&nom='+document.getElementById("nomAdherent").value;
    console.log(document.getElementById("nomAdherent").value);
    let xhr = new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.addEventListener("load",function() {
        afficher_adherent();
    });
    xhr.send(null);
}
document.getElementById("ajouterAdherent").addEventListener("click", function(){
    if(document.getElementById("nomAdherent").value !== "") {
        ajout_de_ladherent();
        document.getElementById("nomAdherent").value = "";
    }
});

function ajout_du_livre(){
    let url = 'php/Routeur.php?action=ajout_livre&livre='+document.getElementById("titreLivre").value;
    console.log(document.getElementById("nomAdherent").value);
    let xhr = new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.addEventListener("load",function() {
        afficher_livre();
    });
    xhr.send(null);
}
document.getElementById("ajouterLivre").addEventListener("click", function(){
    if(document.getElementById("titreLivre").value !== "") {
        ajout_du_livre();
        document.getElementById("titreLivre").value = "";
    }
});

function callback(req) {
    let tab = JSON.parse(req.responseText);
    let tabAdherents = new Array();
    for(let i = 0; i < tab.length; i++) {
        if (tab[i].nbEmprunt > 0){
            tabAdherents.push(tab[i].idAdherent + "-" + tab[i].nomAdherent + "(" + tab[i].nbEmprunt + "emprunt(s))");
        }
        else {
            tabAdherents.push(tab[i].idAdherent + "-" + tab[i].nomAdherent);
        }
    }
    while (adherents.children.length > 0){
        adherents.removeChild(adherents.children[0]);
    }
    let ul = document.createElement('ul');
    for (let i = 0; i < tabAdherents.length; i++){
        let nouv = document.createElement('li');
        nouv.setAttribute('id', "adherents"+ i);
        nouv.innerHTML = tabAdherents[i];
        ul.appendChild(nouv);
    }
    adherents.appendChild(ul);
    ul.addEventListener("click", function(){
        click_info();
    });
}

function callback1(requ){
    let tab1 = JSON.parse(requ.responseText);
    let tabEmprunts = new Array();
    for(let i = 0; i < tab1.length; i++) {
        tabEmprunts.push(tab1[i].idLivre + "-" + tab1[i].titreLivre);
    }
    let ul = document.createElement('ul');
    ul.setAttribute("id", "idd");
    for (let i = 0; i < tabEmprunts.length; i++){
        let nouveaux = document.createElement('li');
        nouveaux.setAttribute('id', "emprunts"+ i);
        nouveaux.innerHTML = tabEmprunts[i];
        ul.appendChild(nouveaux);
    }
    emprunts.appendChild(ul);
}

function callback2(req){
    let tab = JSON.parse(req.responseText);
    let tabLivres = new Array();
    for(let i = 0; i < tab.length; i++) {
        tabLivres.push(tab[i].idLivre + "-" + tab[i].titreLivre);
    }
    while (livres.children.length > 0){
        livres.removeChild(livres.children[0]);
    }
    let ul = document.createElement('ul');
    ul.setAttribute("id","iddd");
    for (let i = 0; i < tabLivres.length; i++){
        let nouveaux = document.createElement('li');
        nouveaux.setAttribute('id', "livres"+ i);
        nouveaux.innerHTML = tabLivres[i];
        ul.appendChild(nouveaux);
    }
    livres.appendChild(ul);
}

function click_info(){
    let tab1 = event.target.innerHTML;
    let index = tab1.indexOf("-");
    let id = tab1.substring(0, index);
    let url = 'php/Routeur.php?action=info_adherent&idAdherent='+ id;
    let xhr = new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.addEventListener("load",function() {
        afficher_info_adherent(xhr);
    });
    xhr.send(null);
}

function afficher_info_adherent(req2){
    let tab2 = JSON.parse(req2.responseText);
    let description = "";
    for (let i = 0; i < tab2.length ; i++){
        description += "-" + tab2[i].titreLivre + " ;";
    }
    alert(tab2[0].nomAdherent + " a " + tab2.length + " emprunt(s) en ce moment :" + description);
}