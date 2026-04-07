document.getElementById("enviar").addEventListener("click", cadastrar);

document.getElementById("voltar").addEventListener("click", () => {
    window.location.href = "../html/contratante.html";
});

async function cadastrar() {
    const nome = document.getElementById("nome").value.trim();
    const descricao = document.getElementById("descricao").value.trim();
    const tipo = document.getElementById("tipo").value;
    const valor = document.getElementById("valor").value;
    const localidade = document.getElementById("localidade").value.trim();

    if (!nome || !descricao || !tipo || !valor || !localidade) {
        alert("Preencha todos os campos.");
        return;
    }

    const fd = new FormData();
    fd.append("nome", nome);
    fd.append("descricao", descricao);
    fd.append("tipo", tipo);
    fd.append("valor", valor);
    fd.append("localidade", localidade);

    const retorno = await fetch("../php/contratantes_novo.php", {
        method: "POST",
        body: fd
    });

    const resposta = await retorno.json();

    if (resposta.status == "ok") {
        alert("Serviço cadastrado com sucesso!");
        window.location.href = "../html/contratante.html";
    } else {
        alert("Erro: " + resposta.mensagem);
    }
}