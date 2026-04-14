document.addEventListener("DOMContentLoaded", async () => {
    const usuarioLogado = await validarSessao();
    const divLista = document.getElementById("lista");
    
    if (usuarioLogado && divLista) {
        const origemDesejada = divLista.getAttribute("data-origem");
        carregarCards(origemDesejada, usuarioLogado);
    }
});

async function carregarCards(origem, usuario) {
    try {
        const retorno = await fetch(`../php/servicos_get.php?origem=${origem}`);
        const resposta = await retorno.json();

        if (resposta.status === 'ok') {
            let html = "";
            resposta.data.forEach(obj => {
                const fotoUrl = (obj.foto) ? `../php/uploads/${obj.foto}` : 'https://placehold.co/300x180/e9ecef/6c757d?text=Sem+Foto';
                
                let btnAcao = "";
                if ((usuario.tipo === 'prestador' && origem === 'oferta') || 
                    (usuario.tipo === 'contratante' && origem === 'chamado')) {
                    btnAcao = `<button class="btn btn-warning btn-sm w-100 fw-bold">Gerenciar Anúncio</button>`;
                } else {
                    btnAcao = `<button class="btn btn-success btn-sm w-100 fw-bold">Entrar em Contato</button>`;
                }

                html += `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        <img src="${fotoUrl}" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-success bg-opacity-10 text-success mb-2 w-50">${obj.tipo || 'Geral'}</span>
                            <h5 class="fw-bold">${obj.nome}</h5>
                            <p class="text-muted small">${obj.descricao}</p>
                            <h5 class="text-success fw-bold mt-auto mb-3">R$ ${obj.valor}</h5>
                            ${btnAcao}
                        </div>
                    </div>
                </div>`;
            });
            document.getElementById('lista').innerHTML = html;
        } else {
            document.getElementById('lista').innerHTML = `<h5 class='text-muted mt-4 w-100 text-center'>Nenhum anúncio encontrado.</h5>`;
        }
    } catch (e) { console.error("Erro ao carregar lista", e); }
}