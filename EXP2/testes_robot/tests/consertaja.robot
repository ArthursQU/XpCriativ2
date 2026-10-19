*** Settings ***
Documentation    Regressao funcional dos casos selecionados da planilha do RA2.
Resource         ../resources/keywords.robot
Library          DateTime
Library          SeleniumLibrary

Suite Setup      Iniciar Navegador
Test Setup       Limpar Estado De Autenticacao
Suite Teardown   Encerrar Navegador

*** Variables ***
${BASE_URL}         %{BASE_URL=http://localhost/EXP2}
${BROWSER}          chrome
${TEST_USERNAME}    %{TEST_USERNAME=}
${TEST_PASSWORD}    %{TEST_PASSWORD=}
${LOGIN_URL}        ${BASE_URL}/home/html/login.html
${PROFILE_URL}      ${BASE_URL}/home/html/perfil.html
${LOGOUT_URL}       ${BASE_URL}/home/php/usuario_logoff.php
${INVALID_PASSWORD}    senha-invalida-robot

*** Test Cases ***
TC-017 - Login com senha invalida
    [Documentation]    Planilha: Login, linha 18, ID 17. Particao de equivalencia negativa para senha.
    [Tags]    funcional    negativo    alta    login
    Credenciais De Teste Devem Estar Configuradas
    Acessar Tela De Login
    Input Text    id=usuario    ${TEST_USERNAME}
    Input Password    id=senha    ${INVALID_PASSWORD}
    Click Button    id=enviar
    Alert Should Be Present    Atenção: Usuário ou senha inválidos.
    Location Should Contain    /home/html/login.html

TC-018 - Login com usuario invalido
    [Documentation]    Planilha: Login, linha 19, ID 18. Particao de equivalencia negativa para usuario.
    [Tags]    funcional    negativo    alta    login    independente
    ${instante}=    Get Time    epoch
    Acessar Tela De Login
    Input Text    id=usuario    robot_usuario_inexistente_${instante}
    Input Password    id=senha    ${INVALID_PASSWORD}
    Click Button    id=enviar
    Alert Should Be Present    Atenção: Usuário ou senha inválidos.
    Location Should Contain    /home/html/login.html

TC-024 - Menu Servicos direciona para oferecendo
    [Documentation]    Planilha: Pagina inicial, linha 25, ID 24. Fluxo principal autenticado.
    [Tags]    funcional    alta    navegacao    autenticado
    Autenticar Com Usuario De Teste
    Click Element    css=button[data-bs-toggle="dropdown"]
    Wait Until Element Is Visible    css=.dropdown-menu.show a[href*="prestadores/html/prestador.html"]    5 seconds
    Click Element    css=.dropdown-menu.show a[href*="prestadores/html/prestador.html"]
    Wait Until Keyword Succeeds    10x    500 milliseconds    Location Should Contain    /servicos/prestadores/html/prestador.html

TC-042 - Pagina restrita redireciona usuario sem sessao
    [Documentation]    Planilha: Seguranca Global, linha 43, ID 42. Teste negativo de controle de acesso.
    [Tags]    seguranca    negativo    alta    sessao    independente
    Go To    ${PROFILE_URL}
    Wait Until Keyword Succeeds    10x    500 milliseconds    Location Should Contain    /home/html/login.html
    Page Should Contain Element    id=usuario

TC-047 - Encerrar sessao pelo botao Sair
    [Documentation]    Planilha: Sessao, linha 48, ID 47. Verifica invalidacao da sessao pelo fluxo de interface.
    [Tags]    funcional    alta    sessao    autenticado
    Autenticar Com Usuario De Teste
    Sair Da Aplicacao
    Page Should Contain Element    id=enviar

TC-048 - Acesso bloqueado apos encerrar sessao
    [Documentation]    Planilha: Sessao, linha 49, ID 48. Reutiliza o estado apos logoff para verificar autorizacao.
    [Tags]    seguranca    alta    sessao    autenticado
    Autenticar Com Usuario De Teste
    Sair Da Aplicacao
    Go To    ${PROFILE_URL}
    Wait Until Keyword Succeeds    10x    500 milliseconds    Location Should Contain    /home/html/login.html
    Page Should Contain Element    id=usuario
