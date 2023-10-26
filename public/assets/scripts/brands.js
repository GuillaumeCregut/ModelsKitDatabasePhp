const deleteBtn=document.querySelectorAll('.single-delete-btn');
const formDelete=document.getElementById('form-delete-brand');
const idDelete=document.getElementById('id_hidden');

deleteBtn.forEach((btn)=>{
    btn.addEventListener('click',()=>{
        const id=btn.dataset.id;
        const name=btn.dataset.name;
        if(confirm(`Voulez-vous supprimer la marque ${name} ?`)){
            idDelete.value=id;
            formDelete.submit();
        }
    })
})

