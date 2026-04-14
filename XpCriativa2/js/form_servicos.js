document.addEventListener("DOMContentLoaded", () => {
    const btnEnviar = document.getElementById("enviar");
    if(btnEnviar) btnEnviar.addEventListener("click", enviarFormulario);
});

async function enviarFormulario(event) {
    event.preventDefault(); // Evita recarregar a tela

    const form = document.getElementById("form-dados");
    const fd = new FormData(form);
    const origem = document.getElementById("origem").value; 

    try {
        const retorno = await fetch("../php/servicos_novo.php", { method: "POST", body: fd });
        const resposta = await retorno.json();

        if (resposta.status === "ok") {
            alert(resposta.mensagem);
            window.location.href = (origem === 'oferta') ? "prestador.html" : "contratante.html";
        } else {
            alert("Erro: " + resposta.mensagem);
        }
    } catch (erro) {
        alert("Erro de conexão com o servidor.");
    }
}