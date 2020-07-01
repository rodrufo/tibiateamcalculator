const btnCalc = document.querySelector("#btn-calculator")
const analyserData = document.querySelector("#partyanalyser")


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




