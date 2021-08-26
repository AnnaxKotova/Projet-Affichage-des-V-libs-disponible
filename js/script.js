let puces = document.getElementsByClassName('caseVelo');

let regex =new RegExp('\\d+');

let zoneInfos = document.getElementById('infos');

for(let i=0; i<puces.length; i++){
    let puce = puces[i];

    let puceID = regex.exec(puce.id)[0] ;
    let IdInfos = "infos"+puceID;

    let divInfos = document.getElementById(IdInfos);

    puce.addEventListener('mouseover', function(){

        zoneInfos.scrollTo({
            top: divInfos.offsetTop - 18,
            behavior: 'smooth'
          })

        divInfos.style.backgroundColor = "#dddddd";

        

    })

    puce.addEventListener('mouseout', function(){
        divInfos.style.backgroundColor = "white";
    })


}