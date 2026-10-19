# Automacao Robot Framework - ConsertaJa

Esta pasta contem uma suite de regressao web com Robot Framework e SeleniumLibrary. Os casos foram selecionados na planilha de cenarios do RA2 por prioridade, risco e repetibilidade. Sao seis casos automatizados, portanto acima do minimo solicitado de cinco.

| ID da planilha | Cenario | Tecnica de teste | Automacao |
| --- | --- | --- | --- |
| 17 | Login com senha invalida | Particao de equivalencia negativa | Exibe erro e permanece no login |
| 18 | Login com usuario invalido | Particao de equivalencia negativa | Exibe erro e permanece no login |
| 24 | Botao Servicos na pagina inicial | Fluxo principal | Abre o menu e navega para "Oferecendo" |
| 42 | Pagina restrita sem login | Teste negativo de seguranca | Redireciona para login |
| 47 | Encerrar sessao por "Sair" | Transicao de estado | Invalida a sessao e abre login |
| 48 | Acesso apos encerramento | Transicao de estado e seguranca | Impede novo acesso ao perfil |

## Pre-requisitos

- Apache e MySQL do XAMPP em execucao.
- Banco `pf` carregado a partir dos scripts do projeto.
- Google Chrome instalado. O Selenium Manager obtem o driver compativel na primeira execucao.
- Uma conta exclusiva de teste ja cadastrada no banco. Ela deve ser de um usuario comum e nunca uma conta real.
- Python 3.10 ou superior.

## Instalacao

No PowerShell, a partir desta pasta:

```powershell
py -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install -r requirements.txt
```

## Execucao

Configure a URL sem barra ao final e as credenciais da conta de teste. A suite le essas variaveis diretamente do ambiente do PowerShell. Os testes que exigem autenticacao validam essas variaveis antes de interagir com a aplicacao.

```powershell
$env:BASE_URL = "http://localhost/EXP2"
$env:TEST_USERNAME = "usuario_de_teste"
$env:TEST_PASSWORD = "senha_da_conta_de_teste"
robot --outputdir resultados `
  tests
```

O Robot Framework gera `report.html`, `log.html` e `output.xml` em `resultados`. Para executar apenas os casos que nao exigem uma conta configurada, use `--include independente`. Para os testes autenticados, defina as credenciais e use `--include autenticado`.

Por padrao, a suite executa em modo headless para nao abrir uma janela do navegador.

## Estrutura

```text
testes_robot/
  requirements.txt
  resources/keywords.robot
  tests/consertaja.robot
```

Os casos nao criam, alteram ou excluem dados do banco. O isolamento e feito encerrando a sessao antes de cada teste. A conta informada e usada somente nos cenarios de login, navegacao autenticada e logoff.

## Observacao de execucao local

Durante a preparacao desta suite, `http://localhost/EXP2` recusou conexao. Portanto, a validacao de execucao depende de iniciar Apache e MySQL e informar as credenciais de teste antes do comando acima.
