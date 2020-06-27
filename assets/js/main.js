const Url = 'http://huntcalc.localhost/api/analyser/getdata';

const btnsubmit = document.querySelector("#btn-submit");

btnsubmit.addEventListener("click", event => {
    event.preventDefault();

    const analyserData = document.querySelector("#analyser-form textarea").value;

    if (analyserData === '') {

        alert("Dados do analyser não encontrados.");

    } else {


        fetch(Url, {
            method: 'POST',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: `analyserData=${analyserData}`
        })
                .then(res => res.json())
                .then(data => {

                    let html = `<h4>RESULTADO DO CÁLCULO</h4>`;

                    situation = data.payments.totalbalance > 0 ? 'LUCRO' : 'PREJUÍZO';

                    html += `<p>O ${situation} da hunt foi de ${data.payments.totalbalance}.</p>`;
                    html += `<p>O ${situation} INDIVIDUAL foi de ${data.payments.individualBalance}.</p>`;
                    html += '<ul>';

                    data.payments.payments.forEach(payment => {

                        html += `<li>${payment.payer}: transfer ${payment.value} to ${payment.receiver}</li>`;

                    });

                    html += '</ul>';

                    html += generateTopList(data.topListDamage, 'TOP DAMAGE');
                    html += generateTopList(data.topListHealing, 'TOP HEALING');
                    html += generateTopList(data.topListBalance, 'TOP BALANCE');
                    html += generateTopList(data.topListLoot, 'TOP LOOT');
                    html += generateTopList(data.topListSupplies, 'TOP SUPPLIES');

                    document.querySelector("#result").innerHTML = html;
                    document.querySelector("#result").style = 'display:block';
                    window.location.href = '#btn-submit';
                })
                .catch(error => console.log(error));


    }

});

function generateTopList(list, title) {
    let html = `<h4>${title}</h4>`;
    html += '<ul>';
    list.forEach(player => {
        html += `<li>${player.name} (${player.value})</li>`;
    });
    html += '</ul>';
    return html;
}




