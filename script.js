function carregarMedidas(){
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const xmlDocument = this.responseXML;
            const fases = xmlDocument.getElementsByTagName('fases');

            let bobinas = {
                0: {
                    tensao: document.querySelector('#tensao_u'),
                    corrente: document.querySelector('#corrente_u'),
                    potencia: document.querySelector('#potencia_u')
                },
                1: {
                    tensao: document.querySelector('#tensao_v'),
                    corrente: document.querySelector('#corrente_v'),
                    potencia: document.querySelector('#potencia_v')
                },
                2: {
                    tensao: document.querySelector('#tensao_w'),
                    corrente: document.querySelector('#corrente_w'),
                    potencia: document.querySelector('#potencia_w')
                }
            };

            for (let i = 0; i < fases.length; i++) {
                const fase = fases[i];
                const faseDescricao = fase.getAttribute('descrição');
                const tensao = fase.getElementsByTagName('Tensão')[0].textContent;
                const corrente = fase.getElementsByTagName('Corrente')[0].textContent;
                const potencia = fase.getElementsByTagName('Potência')[0].textContent;
                bobinas[i].tensao.value = tensao;
                bobinas[i].corrente.value = corrente;
                bobinas[i].potencia.value = potencia;
            }
        }
    };

    xhttp.open("GET", "medidasXML.xml", true);
    xhttp.send();

}

setInterval(carregarMedidas, 5000);