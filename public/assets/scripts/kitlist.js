const deleteBtns=document.querySelectorAll('.delete-btn');

const deletetKit=(id)=>{
    if(window.confirm("Voulez-vous vous séparez de ce kit ? cette action est irréversible")){
        const idToDelete=document.getElementById('id-delete');
        idToDelete.value=id;
        const formDelete=document.getElementById('form-delete');
        formDelete.submit();
    }
}

deleteBtns.forEach((btn)=>{
    const id=btn.dataset.id;
    btn.addEventListener('click',()=>{
        deletetKit(id);
    });
});