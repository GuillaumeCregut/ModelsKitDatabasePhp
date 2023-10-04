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


const checkboxes=document.querySelectorAll('input.cb_user_valid');
checkboxes.forEach((cb)=>{
    cb.addEventListener('change',()=>{
        changeUserStatus(cb.dataset.id,cb.checked,cb);
    })
})

const listRole=document.querySelectorAll('select.select_user_role');
listRole.forEach((list)=>{
    list.addEventListener('change',()=>{
        changeUserRole(list);
    })
})

const changeUserStatus=(id,status,caller)=>{
    const oldStatus=!status;
    let sentFlash=false;
    const idUser=parseInt(id);
    const myInit = {
        method: "PUT",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
        body:JSON.stringify({idUser:idUser, newStatus:status})
      };
    fetch('http://modelskit:8080/api_userRank',myInit)
    .then((response)=>{
        if(response.ok){
            return response.json()
        }
        else{
            caller.checked=oldStatus;
            sentFlash=true;
            launchFlash(toastDetails.error,`Une erreur s'est produite ${response.statusText}`);
            return response;
        }
    })
    .then((json)=>{
        if(json.result){
            launchFlash(toastDetails.success,"La modification a bien été effectuée");
        }
        else{
            caller.checked=oldStatus;
            if(!sentFlash){
                launchFlash(toastDetails.error,"Une erreur s'est produite");
            }
        }
    });
}

const changeUserRole=(list)=>{
    let sentFlash=false;
    const oldRole=parseInt(list.dataset.role);
    const id=parseInt(list.dataset.id);
    const newRole=parseInt(list.value);
    const myInit = {
        method: "PUT",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
        body:JSON.stringify({idUser:id, newRole:newRole})
      };
    //   list.value=oldRole;
    fetch('http://modelskit:8080/api_userRole',myInit)
    .then((response)=>{
        if(response.ok){
            return response.json()
        }
        else{
            list.value=oldRole;
            sentFlash=true;
            launchFlash(toastDetails.error,`Une erreur s'est produite ${response.statusText}`);
            return response;
        }
    })
    .then((json)=>{
        if(json.result){
            launchFlash(toastDetails.success,"La modification a bien été effectuée");
        }
        else{
            list.value=oldRole;
            if(!sentFlash){
                launchFlash(toastDetails.error,"Une erreur s'est produite");
            }
        }
    });

}

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
