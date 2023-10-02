const PWD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).{8,24}$/;
const USER_REGEX = /^[A-z][A-z0-9-_]{3,23}$/;
let enableButton=false;
let enableLogin=false;
let enablePass=false;
let enablePassEqual=false;
let enableRgpd=false;

const login=document.getElementById('login');
const pass=document.getElementById('password1');
const pass2=document.getElementById('password2');
const loginMessage=document.getElementById('uidnote');
const passMessage=document.getElementById('pwdnote');
const checkLogin=document.getElementById('checkLogin');
const badLogin=document.getElementById('badLogin');
const chekPass=document.getElementById('checkPass1');
const badPass=document.getElementById('badPass1');
const checkPass2=document.getElementById('checkPass2');
const badPass2=document.getElementById('badPass2');
const SubmitButton=document.getElementById('submitButton');
const cbRgpd=document.getElementById('cbRGPD');

cbRgpd.addEventListener('change',function (e){
        enableRgpd=e.target.checked;
        evalButton();
})

login.addEventListener('keyup',function (e){
    const result=USER_REGEX.test(e.target.value);
    if(result){
        loginMessage.classList.remove('signup-instruction');
        loginMessage.classList.add('signup-err-off');
        checkLogin.classList.add('signup-valid');
        checkLogin.classList.remove('signup-hide');
        badLogin.classList.add('signup-hide');
        badLogin.classList.remove('signup-invalid');
        enableLogin=true;
         evalButton();
    }
    else{
        loginMessage.classList.add('signup-instruction');
        loginMessage.classList.remove('signup-err-off');
        checkLogin.classList.add('signup-hide');
        checkLogin.classList.remove('signup-valid');
        badLogin.classList.add('signup-invalid');
        badLogin.classList.remove('signup-hide');
        enableLogin=false;
        evalButton();
    }
})

login.addEventListener('focus',function (e){
    console.log(e.target.value);
    const result=USER_REGEX.test(e.target.value);
    if(result){
        loginMessage.classList.remove('signup-instruction');
        loginMessage.classList.add('signup-err-off');
    }
    else{
        loginMessage.classList.add('signup-instruction');
        loginMessage.classList.remove('signup-err-off')
    }
})

login.addEventListener('blur',function (e){
    loginMessage.classList.remove('signup-instruction');
    loginMessage.classList.add('signup-err-off');
})

pass.addEventListener('keyup',function (e){
    const result=PWD_REGEX.test(e.target.value);
    enablePassEqual=false;
    badPass2.classList.add('signup-invalid');
    badPass2.classList.remove('signup-hide');
    checkPass2.classList.add('signup-hide');
    checkPass2.classList.remove('signup-valid');
    if(result){
        passMessage.classList.add('signup-err-off');
        passMessage.classList.remove('signup-instruction');
        badPass.classList.add('signup-hide');
        badPass.classList.remove('signup-invalid');
        chekPass.classList.add('signup-valid');
        chekPass.classList.remove('signup-hide');
        enablePass=true;
        evalButton();
    }
    else{
        passMessage.classList.add('signup-instruction');
        passMessage.classList.remove('signup-err-off');
        badPass.classList.add('signup-invalid');
        badPass.classList.remove('signup-hide');
        chekPass.classList.add('signup-hide');
        chekPass.classList.remove('signup-valid');
        enablePass=false;
        evalButton();
    }
})

pass.addEventListener('blur',function (e){
    passMessage.classList.remove('signup-instruction');
    passMessage.classList.add('signup-err-off');
})

pass2.addEventListener('keyup',function (e){
    console.log(e.target.value,pass.value);
    const result=e.target.value===pass.value;
    if(result){
        passMessage.classList.add('signup-err-off');
        passMessage.classList.remove('signup-instruction');
        badPass2.classList.add('signup-hide');
        badPass2.classList.remove('signup-invalid');
        checkPass2.classList.add('signup-valid');
        checkPass2.classList.remove('signup-hide');
        enablePassEqual=true;
        evalButton();
    }
    else{
        passMessage.classList.add('signup-instruction');
        passMessage.classList.remove('signup-err-off');
        badPass2.classList.add('signup-invalid');
        badPass2.classList.remove('signup-hide');
        checkPass2.classList.add('signup-hide');
        checkPass2.classList.remove('signup-valid');
        enablePassEqual=false;
        evalButton();
    }
})

function evalButton(){
    console.log(enableLogin,enablePass,enablePassEqual,enableRgpd);
    const isEnable=enableLogin&&enablePass&&enablePassEqual&&enableRgpd;
    SubmitButton.disabled=!isEnable;
    if(isEnable){
        SubmitButton.classList.add('form-signup-btn-valid');
    }
    else{
        SubmitButton.classList.remove('form-signup-btn-valid');
    }
}