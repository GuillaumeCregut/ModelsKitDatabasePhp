document.addEventListener("DOMContentLoaded", (event) => {
    console.log("DOM fully loaded and parsed");
  });

const buttons=document.querySelectorAll(".toast_buttons .toast_btn");
const notifications=document.getElementById('toast_notifications');

const toastDetails={
    success:{
        icon: "fa-circle-check",
        text: "Mon texte"
    },
    error:{
        icon: "fa-circle-xmark",
        text: "Mon texte"
    },
    warning:{
        icon: "fa-triangle-exclamation",
        text: "Mon texte"
    },
    info:{
        icon: "fa-circle-info",
        text: "Mon texte"
    },
};

buttons.forEach(btn=>{
    btn.addEventListener('click',(e)=>{
        createToast(btn.id);
    })
})

const removeToast=(toast)=>{
    toast.classList.add('toast_hide');
    console.log("hello");
    if(toast.timeOutId)
        clearTimeout(toast.timeOutId);
    setTimeout(()=>toast.remove(),500);
}

const createToast=(id)=>{
    const toast=document.createElement('li');
    const {icon,text}=toastDetails[id];
    toast.className=`toast toast_${id}`;
    toast.innerHTML=`<div class="toast_column">
         <i class="fa-solid ${icon}"></i>
         <span>${text}</span>
         </div>
         <i class="fa-solid fa-xmark"></i>`;
    notifications.appendChild(toast);
    toast.timeOutId=setTimeout(()=>removeToast(toast),5000)
}

