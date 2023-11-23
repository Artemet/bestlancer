//change_page
function change_page(){
    const get_arrows = document.querySelectorAll(".my_responses .pagination svg"); 
    const get_pages = document.querySelectorAll(".my_responses .pagination b.page_number");
    if (get_pages[0].innerHTML.trim() === get_pages[1].innerHTML.trim()){
        get_arrows[1].closest("a").classList.add("none_active");
    } else if (parseInt(get_pages[0].innerHTML.trim(), 10) === 1){
        get_arrows[0].closest("a").classList.add("none_active");
    } else{
        get_arrows.forEach( (item) => {
            item.closest("a").classList.remove("none_active");
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const get_content = document.querySelector(".content");
        const get_links = document.querySelectorAll(".pagination a");
        for (let i = 0; i < get_links.length; i++){
            get_links[i].id = i;
        }

        const load_page = (url) => {
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const new_content = doc.querySelector(".content");
                    if (new_content) {
                        get_content.innerHTML = new_content.innerHTML;
                        //arrow_check
                        const get_active_page = document.querySelectorAll(".my_responses .pagination b")[0];
                        const get_page_number = document.querySelector(".my_responses .pagination b.page_number");
                        const page_resolt = parseInt(get_active_page.innerHTML.trim(), 10);
                        const end_page_resolt = parseInt(get_page_number.innerHTML.trim(), 10);
                        if (page_resolt === 1){
                            document.querySelectorAll(".arrow a")[0].classList.add("none_active");
                        } else if (page_resolt === end_page_resolt){
                            document.querySelectorAll(".arrow a")[1].classList.add("none_active");
                        } else{
                            document.querySelectorAll(".arrow a").forEach( (item) => {
                                item.classList.remove("none_active");
                            });
                        }

                        history.pushState({}, '', url);
                        setupEventListeners();
                    } else {
                        console.error("Content not found in the loaded page.");
                    }
                })
                .catch(error => {
                    console.error("Error loading page:", error);
                });
        };
    
        const setupEventListeners = () => {
            const updated_links = document.querySelectorAll(".pagination a");
            updated_links.forEach((item) => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = e.currentTarget.getAttribute('href');
                    load_page(url);
                });
            });
        };
    
        get_links.forEach((item) => {
            item.addEventListener('click', (e) => {
                const get_line = document.querySelector(".my_responses .loading_line");
                e.preventDefault();
                const url = e.currentTarget.getAttribute('href');
                load_page(url);
                if (document.querySelectorAll(".my_responses .pagination b")[0].innerHTML.trim() === "1"){
                    get_line.style.width = 100 + "%";
                    if (parseInt(item.id, 10) === 0){
                        setTimeout( () => {
                            get_line.style.left = 0;
                        }, 500);
                    } else if (parseInt(item.id, 10) === 1){
                        setTimeout( () => {
                            get_line.style.right = 0;
                        }, 500);
                    }
                    setTimeout( () => {
                        get_line.style.width = 0;
                    }, 500);
                }
            });
        });
    });
}
change_page();