document.addEventListener("DOMContentLoaded", (event) => {
    console.log("DOM fully loaded and parsed");
    const flashes=document.querySelectorAll('li.toast');
    console.log(flashes);
    flashes.forEach((flashItem)=>{
        flashItem.timeOutId=setTimeout(()=>removeToast(flashItem),5000)
    })
  });

const removeToast=(toast)=>{
    toast.classList.add('toast_hide');
    console.log("hello");
    if(toast.timeOutId)
        clearTimeout(toast.timeOutId);
    setTimeout(()=>toast.remove(),500);
}

