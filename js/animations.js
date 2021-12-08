async function showKredituak(pID){
    var text = document.getElementById(pID);
    let kontPos = -20.0;
    while(kontPos < 7.0){
        await sleep(1)
        text.style.right = kontPos + "%";
        kontPos += 0.5;
    }
}

async function unshowKredituak(pID){
    var text = document.getElementById(pID);
    let kontPos = 7.0;
    while(kontPos > -20.0){
        await sleep(1)
        text.style.right = kontPos + "%";
        kontPos -= 0.5;
    }
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function enterAzalaAlerta(){
    var azalaF = document.getElementById("azala");
    var azala = document.getElementById("azalaAlerta");
    azala.style.cssText = "color:red; display:inline; font-size: 20px; "
    azala.style.fontFamily =" Times, serif, cursive, fantasy";
    azalaF.style.marginBottom = "7%";
}

function outAzalaAlerta(){
    var azalaF = document.getElementById("azala");
    var azala = document.getElementById("azalaAlerta");
    azala.style.cssText = " display:none; "
    azalaF.style.marginBottom = "0%";
}