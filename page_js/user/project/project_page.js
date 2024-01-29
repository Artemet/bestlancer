//project_change
function project_change(){
    const get_icon = document.querySelectorAll(".user_account .project_covers .change_icon");
    get_icon.forEach( (item) => {
        item.addEventListener("click", function (){
            let project_id = item.closest("a").id;
            window.location.href = "project_page.php?project_id=" + project_id;
        })
    });
}
project_change();