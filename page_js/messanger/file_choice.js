//file_choice
export function file_choice(){
    var selDiv = null;
    var storedFiles = [];
    const get_file_line = document.querySelector(".user_chat .file_line");
    function create_file(){
        document.querySelectorAll("#selectedIcon").forEach( (item) => {
            item.removeAttribute("id");
        });
        const create_wrapper = document.createElement("div");
        create_wrapper.classList = "file";
        const create_delete_icon = document.createElement("div");
        create_delete_icon.classList = "delete_file";
        create_delete_icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>';
        const create_object = document.createElement("div");
        create_object.classList = "object_wrapper";
        create_object.id = "selectedIcon";
        get_file_line.appendChild(create_wrapper);
        create_wrapper.appendChild(create_delete_icon);
        create_wrapper.appendChild(create_object);

        for (let i = 0; i < get_file_line.querySelectorAll(".file").length; i++){
            get_file_line.querySelectorAll(".file")[i].id = i;
        }
    }
    $(document).ready(function () {
        $("#icon_choice").on("change", handleFileSelect);
    });
    function handleFileSelect(e) {
    var files = e.target.files;
    var filesArr = Array.prototype.slice.call(files);
    if (filesArr.length !== 0){
        create_file();
        selDiv = $("#selectedIcon");
    }
    let file_warning = false;
    filesArr.forEach(function (f) {
        if (!isValidFileType(f)) {
            return;
        }
    
        storedFiles.push(f);
    
        var reader = new FileReader();
        reader.onload = function (e) {
            if (document.querySelectorAll(".file").length >= 2) {
                document.querySelectorAll(".file")[document.querySelectorAll(".file").length - 1].remove();
                setTimeout(() => {
                    alert("You have reached the maximum number of files!");
                }, 100);
                return;
            } else if (document.querySelectorAll(".file").length >= 1){
                document.querySelector(".user_chat .chat_menu").classList.add("chat_menu_none");
            }
    
            var html =
                '<img src="' +
                e.target.result +
                "\" data-file='" +
                f.name +
                "' draggable='false'>";
            selDiv.html(html);
        };
    
        reader.readAsDataURL(f);
    });
    
    function isValidFileType(file) {
        let allowedExtensions = ["png", "jpg", "txt", "doc", "pdf"];
        let extension = file.name.split(".").pop().toLowerCase();
    
        if (allowedExtensions.indexOf(extension) === -1) {
            document.querySelectorAll(".file")[document.querySelectorAll(".file").length - 1].remove();
            alert("Данный формат недоступен!");
            return false;
        }
    
        return true;
    }    
    if (document.querySelectorAll(".file").length >= 1){
        get_file_line.classList.add("file_line_active");
    }
    //delete_file
    const get_close_icons = document.querySelectorAll(".user_chat .delete_file svg");
    get_close_icons.forEach( (item) => {
        item.addEventListener("click", function (){
            item.closest(".file").remove();
            document.querySelector(".user_chat .chat_menu").classList.remove("chat_menu_none");
            if (document.querySelectorAll(".file").length === 0){
                get_file_line.classList.remove("file_line_active");
            }
        });
    });
    }
}