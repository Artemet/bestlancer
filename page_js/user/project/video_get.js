function get_iframe(){
    const get_video_link = document.querySelector(".project_container p.video_link").innerHTML;
    const final_link = get_video_link.replace(/\s/g, '');
    const get_video_block = document.querySelector(".video_part");
    fetch(final_link)
        .then(response => response.text())
        .then(data => {
            const parser = new DOMParser();
            const htmlDoc = parser.parseFromString(data, 'text/html');
            const iframe_video = htmlDoc.querySelector("textarea.tp-yt-iron-autogrow-textarea");
            
            if (iframe_video) {
            const content = iframe_video.value;
            get_video_block.innerHTML = content;
            } else {
                console.log('Видео не найдено!');
            }
        })
        .catch(error => {
            console.error('Произошла ошибка при запросе:', error);
            get_video_block.innerHTML = `<iframe width="560" height="315" src="https://www.youtube.com/embed/q321dYG_Z0g?si=pr4AF9ADfKuqCRBL" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
        });
}
get_iframe();