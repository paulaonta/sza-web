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