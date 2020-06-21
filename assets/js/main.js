const Url = 'http://tibiateamcalculator.test/api/analyser/getdata';

const btnsubmit = document.querySelector("#btn-submit");

btnsubmit.addEventListener("click", event => {
    event.preventDefault();

    const analyserData = document.querySelector("#analyser-form input").value;

    

    if( analyserData === '' ){

        alert("Dados do analyser não encontrados");

    }else{

        
        fetch(Url,{
          method: 'POST',
          headers: {        
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
          body: `analyserData=${analyserData}`
        })
        .then(res => res.json())        
        .then(data => {
          var html = "<table><thead><tr><th>Nome</th><th>Loot</th><th>supply</th><th>balance</th><th>damage</th><th>healing</th></tr></thead><tbody>";

          let sessiondate = `<p><strong>Session Date: </strong>${data.sessiondate} | <strong>Session Start: </strong>${data.sessionstart} | <strong>Session End: <strong> ${data.sessionend}</p>`;

          document.querySelector("#sessiondate").innerHTML = sessiondate;
          

          data.players.forEach(element => {

            html+= "<tr>";
            
            html += `<th>${element.nome}</th>`
            html += `<th>${element.loot}</th>`
            html += `<th>${element.supplies}</th>`
            html += `<th>${element.balance}</th>`
            html += `<th>${element.damage}</th>`
            html += `<th>${element.healing}</th>`
            

            html+= "</tr>";
          });


     /* <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      </tr>
      */

          html += "</tbody></table>";
          
          
          let tabledata = document.querySelector("#table-data");

          tabledata.insertAdjacentHTML('beforeend',html);
          
        })
        .catch(error => console.log(error))


    }


});




