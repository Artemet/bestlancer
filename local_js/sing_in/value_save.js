//value_save
const get_sing_value = document.querySelectorAll(".sing_in input.right_in");
if (localStorage.getItem("nik")) {
    get_sing_value[0].value = localStorage.getItem("nik");
}
get_sing_value[0].addEventListener("input", function () {
    localStorage.setItem("nik", get_sing_value[0].value);
});