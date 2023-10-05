const form=document.getElementById('form-add');
const closeModal=document.getElementById('close-modal');
const updateBtns=document.querySelectorAll('.single-update-btn');
const updateFormBtn=document.getElementById('update_single');
const inputName=document.getElementById('newNameMod');

updateFormBtn.addEventListener('submit',(e)=>{
    if (inputName.value===''){
        e.preventDefault();
    }
})

const newName=document.getElementById('new-name');
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
form.addEventListener('submit',(event)=>{
    if (newName.value===''){
        event.preventDefault();
        newName.classList.add('wrong');
    }
});

newName.addEventListener('keypress',()=>{
        newName.classList.remove('wrong');
})

const showModal=(id, name)=>{
    //Blur the page
    const page=document.querySelector('.params-container');
    page.classList.add('blured');
    //Set values in modal form
    inputName.value=name;
    const inputHiddenId=document.getElementById('modSingle');
    inputHiddenId.value=id;
    //show the modal div
    const modalDiv=document.querySelector('.singleModal')
    modalDiv.classList.remove('modal-hidden');
}

const hideModal=()=>{
    //UnBlur the page
    const page=document.querySelector('.params-container');
    page.classList.remove('blured');
    //Hide model div
    const modalDiv=document.querySelector('.singleModal');
    modalDiv.classList.add('modal-hidden');
}

closeModal.addEventListener('click',hideModal);
updateBtns.forEach((btn)=>{
    const id=btn.dataset.id;
    const name=btn.dataset.name;
    btn.addEventListener('click',()=>showModal(id,name))
});