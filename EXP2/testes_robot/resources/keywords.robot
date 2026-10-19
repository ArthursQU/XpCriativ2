*** Settings ***
Library    SeleniumLibrary

*** Keywords ***
Iniciar Navegador
    Open Browser    about:blank    ${BROWSER}    options=add_argument("--headless=new"); add_argument("--window-size=1440,1080"); add_argument("--disable-gpu")
    Set Selenium Implicit Wait    0 seconds
    Set Selenium Speed    0 seconds

Encerrar Navegador
    Close All Browsers

Limpar Estado De Autenticacao
    Go To    ${LOGOUT_URL}
    Delete All Cookies
    Go To    ${LOGIN_URL}

Acessar Tela De Login
    Go To    ${LOGIN_URL}
    Wait Until Element Is Visible    id=usuario    10 seconds
    Wait Until Element Is Visible    id=senha    10 seconds

Credenciais De Teste Devem Estar Configuradas
    Should Not Be Empty    ${TEST_USERNAME}    Defina TEST_USERNAME com uma conta exclusiva para testes.
    Should Not Be Empty    ${TEST_PASSWORD}    Defina TEST_PASSWORD com a senha da conta exclusiva para testes.

Autenticar Com Usuario De Teste
    Credenciais De Teste Devem Estar Configuradas
    Acessar Tela De Login
    Input Text    id=usuario    ${TEST_USERNAME}
    Input Password    id=senha    ${TEST_PASSWORD}
    Click Button    id=enviar
    Alert Should Be Present    Login efetuado com sucesso!
    Wait Until Keyword Succeeds    10x    500 milliseconds    Location Should Contain    /home/html/index.html

Sair Da Aplicacao
    Click Button    id=logoff
    Wait Until Keyword Succeeds    10x    500 milliseconds    Location Should Contain    /home/html/login.html
