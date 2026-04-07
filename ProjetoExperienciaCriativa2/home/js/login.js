document.getElementById("enviar").addEventListener("click", consulta);
document.getElementById("novo").addEventListener("click", () => {
    window.location.href = "../html/cadastro.html";
});

async function consulta() {
    const usuario = document.getElementById("usuario").value.trim();
    const senha = document.getElementById("senha").value.trim();

    if (!usuario || !senha) {
        alert("Preencha usuário e senha.");
        return;
    }

    const fd = new FormData();
    fd.append("usuario", usuario);
    fd.append("senha", senha);

    try {
        const retorno = await fetch("../php/usuario_login.php", {
            method: "POST",
            body: fd
        });

        const resposta = await retorno.json();

        if (resposta.status === "ok") {
            alert("Login efetuado com sucesso!");
            window.location.href = "../html/index.html";
        } else {
            alert("Usuário ou senha inválidos.");
        }
    } catch (erro) {
        console.error(erro);
        alert("Erro ao conectar com o servidor.");
    }
}
