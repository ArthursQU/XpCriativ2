document.addEventListener("DOMContentLoaded", async () => {
    const usuarioLogado = await validarSessao();
    if (usuarioLogado) configurarNavbar(usuarioLogado);
    
    const btnSair = document.getElementById("btn-sair");
    if (btnSair) {
        btnSair.addEventListener("click", async () => {
            const retorno = await fetch('../php/usuario_logoff.php');
            const resposta = await retorno.json();
            if (resposta.status === 'ok') window.location.href = 'login.html';
        });
    }
});

async function validarSessao() {
    try {
        const retorno = await fetch('../php/valida_sessao.php');
        const resposta = await retorno.json();
        if (resposta.status === 'nok') { window.location.href = 'login.html'; return null; }
        return resposta.data[0]; 
    } catch (erro) { return null; }
}

function configurarNavbar(usuario) {
    const btnDinamico = document.getElementById("nav-btn-dinamico");
    if (!btnDinamico) return; 

    const tipo = String(usuario.tipo).toLowerCase().trim();
    btnDinamico.style.display = "block";
        
    if (tipo === "prestador") {
        btnDinamico.innerHTML = "<i class='bi bi-plus-lg'></i> Novo Serviço +";
        btnDinamico.href = "novo_servico.html";
    } else if (tipo === "contratante") {
        btnDinamico.innerHTML = "<i class='bi bi-plus-lg'></i> Novo Chamado +";
        btnDinamico.href = "novo_chamado.html";
    }
}