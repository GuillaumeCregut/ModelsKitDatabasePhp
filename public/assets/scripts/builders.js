const form=document.getElementById('form-add');
const closeModal=document.getElementById('close-modal');
const updateBtns=document.querySelectorAll('.single-update-btn');
const updateFormBtn=document.getElementById('update_single');
const inputName=document.getElementById('newNameMod');
const countrySelector=document.getElementById('countryBuilder');
const deleteBtn=document.querySelectorAll('.single-delete-btn');
const formDelete=document.getElementById('form-delete-builder');
const idDelete=document.getElementById('id_hidden');
const formSearch=document.querySelector('.form-search-builder');
const searchName=document.getElementById('searchName');

if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

countrySelector.addEventListener('change',(e)=>{
    if (parseInt(countrySelector.value)!==0){
        countrySelector.classList.remove('wrong');
    }
})

updateFormBtn.addEventListener('submit',(e)=>{
    if (inputName.value===''){
        e.preventDefault();
    }
})

const newName=document.getElementById('new-name');

form.addEventListener('submit',(event)=>{
    const countryId=parseInt(countrySelector.value);
    if ((newName.value==='')||countryId===0){
        event.preventDefault();
        if(newName.value==='')
            newName.classList.add('wrong');
        if (countryId===0){
            countrySelector.classList.add('wrong');
        }
    }
});

newName.addEventListener('keypress',()=>{
        newName.classList.remove('wrong');
})

const showModal=(id, name,country)=>{
    //Blur the page
    const page=document.querySelector('.params-container');
    page.classList.add('blured');
    //Set values in modal form
    inputName.value=name;
    const inputHiddenId=document.getElementById('modSingle');
    inputHiddenId.value=id;
    const selectCountry=document.getElementById('countryBuilderUpdate');
    let selected=0;
    for(let i=0;i<selectCountry.children.length;i++){
        if(selectCountry.children[i].value===country){
            selected=selectCountry.children[i].index;
        }
    }
    selectCountry.selectedIndex=selected;
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
    const countryId=btn.dataset.country;
    btn.addEventListener('click',()=>showModal(id,name,countryId))
});

deleteBtn.forEach((btn)=>{
    btn.addEventListener('click',()=>{
        const id=btn.dataset.id;
        const name=btn.dataset.name;
        if(confirm(`Voulez-vous supprimer le constructeur ${name} ?`)){
            idDelete.value=id;
            formDelete.submit();
        }
    })
})

formSearch.addEventListener('submit',(e)=>{
    if(searchName.value===''){
        e.preventDefault();
    }
})