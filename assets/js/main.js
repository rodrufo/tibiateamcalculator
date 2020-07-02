const btnCalc = document.querySelector("#btn-calculator")
const analyserData = document.querySelector("#partyanalyser")
const copyToElement = document.querySelectorAll(".copyToClipboard")

copyToElement.forEach( ( transferMsg, key )  => {

    transferMsg.addEventListener("click", event => copyToClipboard(transferMsg.value) )

})




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



function copyToClipboard( transferMsg ){ 

    
    let attrid = "copytoclipboard"  
    let container = document.querySelector("#container")     
    let input = document.createElement("input")

    input.type = "text"
    input.id = attrid
    input.className = "hiddeninput"
    input.value = transferMsg
    container.appendChild(input)

    let textToCopy = document.querySelector(`#${attrid}`)
    
    text_to_copy.select(); 
       
    document.execCommand("copy")

    text_to_copy.remove()
}



