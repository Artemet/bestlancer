//file_choice
export function file_choice(){
    var selDiv = null;
    var storedFiles = [];
    let final_format = null;
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
    filesArr.forEach(function (f) {
        if (!isValidFileType(f)) {
            return;
        }
    
        storedFiles.push(f);
    
        const reader = new FileReader();
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
    
            let html = null;

            if (final_format === "zip"){
                html = '<div class="document_type"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM96 48c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16zm-6.3 71.8c3.7-14 16.4-23.8 30.9-23.8h14.8c14.5 0 27.2 9.7 30.9 23.8l23.5 88.2c1.4 5.4 2.1 10.9 2.1 16.4c0 35.2-28.8 63.7-64 63.7s-64-28.5-64-63.7c0-5.5 .7-11.1 2.1-16.4l23.5-88.2zM112 336c-8.8 0-16 7.2-16 16s7.2 16 16 16h32c8.8 0 16-7.2 16-16s-7.2-16-16-16H112z"/></svg></div>';
            } else if (final_format === "txt"){
                html = '<div class="document_type"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM112 256H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64H272c8.8 0 16 7.2 16 16s-7.2 16-16 16H112c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg></div>';
            } else{
                html =
                '<img src="' +
                e.target.result +
                "\" data-file='" +
                f.name +
                "' draggable='false'>";
            }
            selDiv.html(html);
        };
    
        reader.readAsDataURL(f);
    });
    
    function isValidFileType(file) {
        let allowedExtensions = ["png", "jpg", "txt", "doc", "pdf", "zip"];
        let extension = file.name.split(".").pop().toLowerCase();
    
        if (allowedExtensions.indexOf(extension) === -1) {
            document.querySelectorAll(".file")[document.querySelectorAll(".file").length - 1].remove();
            alert("Данный формат недоступен!");
            return false;
        } else{
            final_format = extension;
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