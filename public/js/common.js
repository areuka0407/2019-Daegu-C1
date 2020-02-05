/**
 * 질의자
 */

const $ = (s) => document.querySelector(s);


/**
 * 토스트 메세지
 */
function toast(message, background = "bg-red"){
    let current_queue = document.querySelectorAll(".toast-message");

    if(current_queue.length > 0){
        current_queue.forEach(item => {
            clearTimeout(item.current_anime);
            item.style.transition = "0.5s";
            item.style.bottom = "80px";
            item.style.opacity = "0";
    
            setTimeout(() => item.remove(), 500);
        });
    }

    message = Array.isArray(message) ? message : [message];

    message.forEach((item, i) => {
        let $box = document.createElement("div");
        $box.classList.add("toast-message");
        $box.classList.add(background);
        $box.innerText = item;

        const baseBottom = 60;
        const unitBottom = 60;
        $box.style.bottom = (unitBottom * i + baseBottom - 20) + "px";
        document.body.append($box);


        setTimeout(() => {
            $box.style.bottom = unitBottom * i + baseBottom + "px";
            $box.style.opacity = "1";
            $box.animateQueue = setTimeout(() => {
                $box.style.transition = "0.5s";
                $box.style.bottom = (unitBottom * i + baseBottom - 20) + "px";
                $box.style.opacity = "0";
                $box.animateQueue = setTimeout(() => {
                    $box.remove();
                    $box = null;
                }, 500);
            }, 2000);
        });
    });    
}

/**
 * 모달창
 */

function createModal(content){
    // 모달 생성
    let $modal = document.createElement("div");
    $modal.classList.add("modal-wrap");
    $modal.innerHTML = content;
    
    // 닫기 버튼
    let $close = document.createElement("button");
    $close.classList.add("btn-close");
    $close.innerHTML = `&times;`;

    let $contents = $modal.querySelector(".contents");
    if($contents) $contents.append($close);
    else $modal.append($close);
    $close.addEventListener("click", () => {
        jQuery($modal).fadeOut('fast', () => $modal.remove());
    });    

    return $modal;
 }

 function showModal($modal){
    // 기존의 모달은 삭제
    let existList = document.querySelectorAll(".modal-wrap");
    if(existList.length > 0){
        existList.forEach(exist => {
            jQuery(exist).clearQueue().fadeOut('fast', () => {
                exist.remove();
            });
        });
    }
    // 새로운 모달 추가
    document.body.append($modal);
    jQuery($modal).hide();
    jQuery($modal).fadeIn();
 }

 function hideModal($modal){
    jQuery($modal).clearQueue().fadeOut('fast', () => $modal.remove());
 }

/**
 * 에러 메세지 출력
 */

function error(target = null , message = []){
    let container = target ? jQuery(target).closest(".form-group") : null;  
    container && container[0].querySelectorAll(".error-message").forEach(x => x.remove());  // 기존의 메세지를 모두 삭제한다.
    
    // target: input 노드, container: form-group 노드, message: 출력할 메세지
    // 위 사항이 모두 존재할 때만 실행한다.
    if(target && container && message){
        let label = container[0].querySelector("label");        // 가장 첫번째 레이블을 찾는다
        message = Array.isArray(message) ? message : [message]; // 메세지가 배열이 아니면 배열로 바꾼다.
        message.reverse().forEach(msg => {
            let output = document.createElement("small");       // message의 개수만큼 메세지 노드를 생성한다.
            output.classList.add("error-message");
            output.innerText = msg;
            label.after(output);                                // 레이블 뒤에 끼워넣는다.
        });
    }
    return message.length === 0; // 에러 메세지가 없으면 TRUE
}


window.addEventListener("load", () => {
    let fileInput;
    if(fileInput = document.querySelector(".custom-file-input"))
        fileInput.addEventListener("change", e => {
            if(e.target.files.length > 0){
                let parent = e.target.parentElement;
                let label = parent.querySelector(".custom-file-label");
                label.innerText = e.target.files[0].name;
            }
        }); 
});