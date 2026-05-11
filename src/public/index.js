function irParaLogin() {
    window.location.href = "/viacoes/login#";
}
function irParaBuscarPassagens() {
    window.location.href = "BuscarPassagens.php";
}
function irParaHome() {
    window.location.href = "index.php";
}
function irParaLista() {
    window.location.href = "/viacoes";
}

//Autocomplete
const cidades = [
    "Curitiba", "São Paulo",
    "Rio de Janeiro", "Belo Horizonte",
    "Florianópolis", "Porto Alegre",
    "Brasília", "Goiânia",
    "Londrina", "Campinas"
];
const input = document.getElementById("input-partida");
const sugestoesBox = document.getElementById("sugestoes-partida");

input.addEventListener("input", function() {
    const valor = this.value.toLowerCase();
    sugestoesBox.innerHTML = "";
    if (!valor) return;

    const filtradas = cidades.filter(cidade =>
        cidade.toLowerCase().includes(valor)
    );

    filtradas.forEach(cidade => {
        const div = document.createElement("div");
        div.classList.add("sugestao-item");
        div.textContent = cidade;

        div.addEventListener("click", () => {
            input.value = cidade;
            sugestoesBox.innerHTML = "";
        });
        sugestoesBox.appendChild(div);
    });
});