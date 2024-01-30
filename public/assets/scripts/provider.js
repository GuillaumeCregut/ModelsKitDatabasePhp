const deleBtns=document.querySelectorAll('.provider-delete-btn');
const FormDelete=document.getElementById('delete-provider');
const IdDelete=document.getElementById('deleteId');
const updateBtns=document.querySelectorAll('.provider-update-btn');
const modalDiv=document.querySelector('.provider-modal');
const modalNameInput=document.getElementById('newNameMod');
const closeModalBtn=document.querySelector('.fa-xmark');
const formupdate=document.querySelector('#update_provider');

const deleteProvider=(id,name)=>{
    if(confirm(`Voulez-vous supprimer le fournisseur ${name} ?`)){
        console.log(id);
        IdDelete.value=id;
        FormDelete.submit();
    }
}

const showModal=(id,name)=>{
    //Blur the page
    const page=document.querySelector('.provider-container');
    page.classList.add('blured');
    //Set values in modal form
    modalNameInput.value=name;
    const inputHiddenId=document.getElementById('mod-provider');
    inputHiddenId.value=id;
    //show the modal div
    modalDiv.classList.remove('modal-hidden');
}

const hideModal=()=>{
    //UnBlur the page
    const page=document.querySelector('.provider-container');
    page.classList.remove('blured');
    //Hide model div
    modalDiv.classList.add('modal-hidden');
}

deleBtns.forEach((button)=>{
    const id=button.dataset.id;
    const name=button.dataset.name;
    button.addEventListener('click',(e)=>{
        deleteProvider(id,name);
    })
})

closeModalBtn.addEventListener('click',()=>{
    hideModal();
})

updateBtns.forEach((btn)=>{
    const id=btn.dataset.id;
    const name=btn.dataset.name;
    btn.addEventListener('click',()=>showModal(id,name))
});

formupdate.addEventListener('submit',(e)=>{
    const name=document.getElementById('newNameMod').value;
    console.log(name);
    if(name===''){
        e.preventDefault();
    }

})
/* Order details Btn */
let mypopup=null;
const detailItemBtns=document.querySelectorAll('.order-item');

const openDetailPopup=(ref,key)=>{
    if(mypopup==null || mypopup.closed){
        mypopup=window.open(
           `./profil_popup?ref=${ref}&key=${key}`,
            'test',
            `popup,
            top=50px,
            left=100px,
            width=640px,
            height=480px,
            toolbar=no,
            status=no,
            menubar=no,
            scrollbars=yes`
        )
    }else{
        mypopup.focus();
    }
}



detailItemBtns.forEach((btn)=>{
    const ref=btn.dataset.id;
    const key=btn.dataset.key;
    btn.addEventListener('click',()=>{
        openDetailPopup(ref,key);
    })
});

//Details buttons
const detailsBtn=document.querySelectorAll('.details-btn');

const toggleDetails=(id)=>{
    const allDetailsDiv=document.querySelectorAll(".hidden-details");
    allDetailsDiv.forEach((div)=>{
        if(div.dataset.id!=id)
            div.classList.remove('displayDetails');
    });
    const divDetails=document.querySelector(`[data-id="${id}"]`);
    divDetails.classList.toggle('displayDetails');
}

detailsBtn.forEach((btn)=>{
    const id=btn.dataset.supplier;
    btn.addEventListener('click',()=>{
        toggleDetails(id);
    })
})