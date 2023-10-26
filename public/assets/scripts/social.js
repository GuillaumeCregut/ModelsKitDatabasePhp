const likeBtns=document.querySelectorAll('.btn-friend-state');
const removeFriendBtns=document.querySelectorAll('.heart-container');

const USER_UNKNOWN=0;
let sentFlash=false;
let activeLikeBtn=null;

const toastDetails = {
    timer: 5000,
    success: {
        icon: "fa-circle-check",
        classname: "toast_success"
    },
    error: {
        icon: "fa-circle-xmark",
        classname: "toast_error"
    }
}

const removeFriend=(id)=>{
    console.log(id);
    const form=document.getElementById('process-friend');
    const idFriend=document.getElementById('idFriend');
    idFriend.value=id;
    form.submit();

}

removeFriendBtns.forEach((btn)=>{
    const id=btn.dataset.id;
    btn.addEventListener('click',()=>{
        removeFriend(id);
    })
})

const userChangeState=(id, status)=>{
    if(status!==USER_UNKNOWN){
        return;
    }
    const myInit = {
        method: "PUT",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
        body:JSON.stringify({idUser:id})
      };
    fetch('api_friend',myInit)
    .then((response)=>{
        if(response.ok){
            return response.json()
        }
        else{
            sentFlash=true;
            launchFlash(toastDetails.error,`Une erreur s'est produite ${response.statusText}`);
        }
    })
    .then((json)=>{
        if(json){
            if(json.result){
               const heart=activeLikeBtn.querySelector('.action-user');
               heart.classList.remove('action-user-unknown');
               heart.classList.add('action-user-waiting');
            }
            else{
                if(!sentFlash){
                    launchFlash(toastDetails.error,"Une erreur s'est produite");
                }
            }
        }
    });

}


likeBtns.forEach((btn)=>{
    const status=parseInt(btn.dataset.status);
    
    const id=parseInt(btn.dataset.id);
    btn.addEventListener('click',()=>{
        activeLikeBtn=btn;
        userChangeState(id, status);
    })
})

const launchFlash = (typeFlash, message) => {
    if (document.getElementsByClassName('toast_notifications').length === 0) {
        const flashContainer = document.createElement('ul');
        flashContainer.classList.add('toast_notifications');
        document.body.appendChild(flashContainer);
    }
    flashContainer = document.getElementsByClassName('toast_notifications')[0];
    const toast = document.createElement('li');
    toast.className = typeFlash.classname;
    toast.classList.add('toast');
    const divToast = document.createElement('div');
    divToast.className = "toast_column";
    const icon = document.createElement('i');
    icon.classList.add('fa-solid');
    icon.classList.add(typeFlash.icon);
    const spanMessage = document.createElement('span');
    spanMessage.innerText = message;
    divToast.appendChild(icon);
    divToast.appendChild(spanMessage);
    const closeIcon = document.createElement('i');
    closeIcon.classList.add('fa-solid');
    closeIcon.classList.add('fa-xmark');
    closeIcon.addEventListener('click', () => removeToast(toast));
    toast.appendChild(divToast);
    toast.appendChild(closeIcon);
    flashContainer.appendChild(toast);
    toast.timeouId = setTimeout(() => removeToast(toast), toastDetails.timer);
}