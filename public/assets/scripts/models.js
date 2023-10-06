if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
const fileUpdloader=document.getElementById('new-picture');
const formAdd=document.getElementById('form-add');
const selectsAdd=document.querySelectorAll('.new');
const maxFileSize=500*1024;

const toastDetails={
    timer: 5000,
    success:{
        icon: "fa-circle-check",
        classname: "toast_success"
    },
    error:{
        icon: "fa-circle-xmark",
        classname:"toast_error"
    }
}

selectsAdd.forEach((select)=>{
    select.addEventListener('change',()=>{
        select.classList.remove('wrong');
    });
});

formAdd.addEventListener('submit',(e)=>{

    const childsSelect=formAdd.querySelectorAll('select');
    childsSelect.forEach((child)=>{
        if(parseInt(child.value)===0){
            child.classList.add('wrong');
            e.preventDefault();
        }
    });
    if(fileUpdloader.files[0].size>maxFileSize){
        launchFlash(toastDetails.error,"Le fichier doit faire moins de 500ko");
        e.preventDefault();
        return;
    }
});

//Drag and Drop file

const dropAreaOuter=document.getElementById('file-drop');
const inner=document.getElementById('box-inner');
dropAreaOuter.addEventListener('dragenter',()=>{
    dropAreaOuter.classList.add('outerHiglighted');
    inner.classList.add('innerHighlighted');
});
dropAreaOuter.addEventListener('dragleave',()=>{
    dropAreaOuter.classList.remove('outerHiglighted');
    inner.classList.remove('innerHighlighted');
});

dropAreaOuter.addEventListener('dragover',()=>{
    dropAreaOuter.classList.add('outerHiglighted');
    inner.classList.add('innerHighlighted');
});

dropAreaOuter.addEventListener('drop',()=>{
    dropAreaOuter.classList.remove('outerHiglighted');
    inner.classList.remove('innerHighlighted');
});

fileUpdloader.addEventListener('change',()=>{
    const image=document.getElementById('new-picture-display');
    console.log(fileUpdloader.files)
    const file=fileUpdloader.files[0];
    console.log(file);
    const mimeType=file.type;
    if(!(mimeType==='image/jpeg') && !(mimeType==='image/png') ){
        launchFlash(toastDetails.error,"Le fichier doit être au format jpeg ou png");
        fileUpdloader.value="";
        image.classList.remove('display-image');
        return;
    }
    
    const fileSize=file.size;
    if(fileSize>maxFileSize){
        launchFlash(toastDetails.error,"Le fichier doit faire moins de 500ko");
        fileUpdloader.value="";
        image.classList.remove('display-image');
        return;
    }
    const url=URL.createObjectURL(file);
   
    image.src=url;
    image.classList.add('display-image');
});

const launchFlash=(typeFlash,message)=>{
    if(document.getElementsByClassName('toast_notifications').length===0)
    {
        const flashContainer=document.createElement('ul');
        flashContainer.classList.add('toast_notifications');
        document.body.appendChild(flashContainer);
    }
    flashContainer=document.getElementsByClassName('toast_notifications')[0];
    const toast=document.createElement('li');
    toast.className=typeFlash.classname;
    toast.classList.add('toast');
    const divToast=document.createElement('div');
    divToast.className="toast_column";
    const icon=document.createElement('i');
    icon.classList.add('fa-solid');
    icon.classList.add(typeFlash.icon);
    const spanMessage=document.createElement('span');
    spanMessage.innerText=message;
    divToast.appendChild(icon);
    divToast.appendChild(spanMessage);
    const closeIcon=document.createElement('i');
    closeIcon.classList.add('fa-solid');
    closeIcon.classList.add('fa-xmark');
    closeIcon.addEventListener('click',()=>removeToast(toast));
    toast.appendChild(divToast);
    toast.appendChild(closeIcon);
    flashContainer.appendChild(toast);
    toast.timeouId=setTimeout(()=>removeToast(toast),toastDetails.timer);
}
