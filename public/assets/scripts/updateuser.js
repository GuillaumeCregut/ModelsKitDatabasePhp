const loginInput=document.getElementById('login');
const cross=document.querySelector('.login-invalid');
const checked=document.querySelector('.login-valid');
const cbDisplayPass=document.getElementById('change-pass');
const passContainer=document.querySelector('.password-container');
const pass1=document.getElementById('pass1');
const pass2=document.getElementById('pass2');
const crossPass1=document.getElementById('pass1-invalid');
const crossPass2=document.getElementById('pass2-invalid');
const checkPass2=document.getElementById('pass2-valid');
const checkPass1=document.getElementById('pass1-valid');
const infoPass=document.querySelector('.info-pass');
const infoLogin=document.querySelector('.info-login');
const validBtn=document.querySelector('.user-modif-btn');
const avatarContainer=document.querySelector('.avatar-image-container');
const avatarFile=document.getElementById('avatar-file');
let loginValue=true;

const PWD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).{8,24}$/;
const USER_REGEX = /^[A-z][A-z0-9-_]{3,23}$/;
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

loginInput.addEventListener('keyup',(e)=>{
    const result=USER_REGEX.test(e.target.value);
    if(result){
        //Hide cross show check
        checked.classList.remove('hide');
        cross.classList.add('hide');
        infoLogin.classList.remove('display');
        infoLogin.classList.add('hide');
        loginValue=true;
    }
    else{
        //Hide check, show cross
        cross.classList.remove('hide');
        checked.classList.add('hide');
        infoLogin.classList.add('display');
        infoLogin.classList.remove('hide');
        loginValue=false;
    }
    checkForm();
});

cbDisplayPass.addEventListener('change',(e)=>{
    passContainer.classList.toggle('hide');
    checkForm();
});

pass1.addEventListener('keyup',(e)=>{
    const result=PWD_REGEX.test(e.target.value);
    if(result){
        checkPass1.classList.remove('hide');
        crossPass1.classList.add('hide');
        infoPass.classList.add('hide');
        infoPass.classList.remove('display');
    }
    else{
        crossPass1.classList.remove('hide');
        checkPass1.classList.add('hide');
        infoPass.classList.remove('hide');
        infoPass.classList.add('display');
    }
    if(e.target.value!==pass2.value){
        crossPass2.classList.remove('hide');
        checkPass2.classList.add('hide');
    }
    else{
        checkPass2.classList.remove('hide');
        crossPass2.classList.add('hide');
    }
    if(e.target.value===''){
        checkPass1.classList.add('hide');
        crossPass1.classList.add('hide');
        infoPass.classList.add('hide');
        infoPass.classList.remove('display');
    }
    checkForm();
});

pass2.addEventListener('keyup',(e)=>{
    if(e.target.value===pass1.value){
        checkPass2.classList.remove('hide');
        crossPass2.classList.add('hide');
    }else{
        crossPass2.classList.remove('hide');
        checkPass2.classList.add('hide');
    }
    checkForm();
});

const checkForm=()=>{
    const p1=pass1.value;
    const p2=pass2.value;
    if((((p1==='') || (p1===p2)) ||!cbDisplayPass.checked)&&(loginValue)){
        validBtn.disabled=false;
    }else{
        validBtn.disabled=true;
    }
}

avatarFile.addEventListener('change',(e)=>{
    const file=avatarFile.files[0];
    const mimeType=file.type;
    if(!(mimeType==='image/jpeg') && !(mimeType==='image/png') ){
        launchFlash(toastDetails.error,"Le fichier doit être au format jpeg ou png");
        avatarFile.value='';
        return;
    }
    const fileSize=file.size;
    if(fileSize>maxFileSize){
        launchFlash(toastDetails.error,"Le fichier doit faire moins de 500ko");
        avatarFile.value="";
        return;
    }
    const url=URL.createObjectURL(file);
    updateAvatar(url);
})

const updateAvatar=(url)=>{
   if( avatarContainer.querySelector('.avatar-img')===null)
   {
        const image=document.createElement('img');
        image.classList.add('avatar-img');
        avatarContainer.textContent='';
        avatarContainer.appendChild(image);
   }
   const avatarImage=avatarContainer.querySelector('.avatar-img');
   avatarImage.src=url;
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
