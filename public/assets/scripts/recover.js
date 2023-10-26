const pass=document.getElementById('password1');
const pass2=document.getElementById('password2');
const passMessage=document.getElementById('pwdnote');
const chekPass=document.getElementById('checkPass1');
const badPass=document.getElementById('badPass1');
const checkPass2=document.getElementById('checkPass2');
const badPass2=document.getElementById('badPass2');
const SubmitButton=document.getElementById('submitButton');

const PWD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).{8,24}$/;
let enableButton=false;
let enablePass=false;
let enablePassEqual=false;

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
        passMessage.classList.remove('signup-instruction');
        badPass2.classList.add('signup-invalid');
        badPass2.classList.remove('signup-hide');
        checkPass2.classList.add('signup-hide');
        checkPass2.classList.remove('signup-valid');
        enablePassEqual=false;
        evalButton();
    }
})

function evalButton(){
    const isEnable=enablePass&&enablePassEqual;
    SubmitButton.disabled=!isEnable;
    if(isEnable){
        SubmitButton.classList.add('form-signup-btn-valid');
    }
    else{
        SubmitButton.classList.remove('form-signup-btn-valid');
    }
}