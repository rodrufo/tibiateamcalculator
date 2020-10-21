const btnCalc = document.querySelector("#btn-calculator")
const analyserData = document.querySelector("#partyanalyser")
const copyToElement = document.querySelectorAll(".copyToClipboard")
const balanceMsg = document.querySelector(".calculator-balance")
const copyAll = document.querySelector("#copyAll")

copyAll.addEventListener("click", element => {
    
    copyToClipboard(copyAll.value, true)

})


copyToElement.forEach( ( transferMsg, key )  => {

    transferMsg.addEventListener("click", event => copyToClipboard( transferMsg.value) )

})

function copyToClipboard( transferMsg, allMsg = false ){

if( allMsg ){

transferMsg = `${balanceMsg.innerText.trim()}

Os seguintes pagamentos devem ser feitos:
    
${transferMsg}`

}
    
let attrid = "copytoclipboard"  
let container = document.querySelector("#container")     
let element = document.createElement("textarea")

//input.type = "text"
element.id = attrid
element.className = "hiddeninput"
element.value = transferMsg
container.appendChild(element)

let textToCopy = document.querySelector(`#${attrid}`)
    
textToCopy.select(); 

document.execCommand("copy")

textToCopy.remove()
}



//home
if( analyserData ){

    btnCalc.addEventListener('click', event =>  {
        event.preventDefault();

        if( analyserData.value == "" ){

            analyserData.classList.add('error');
            
            console.log("analyser data not found")
        
        }else{
            
            document.getElementById("toresult").submit();
        }

})
}
