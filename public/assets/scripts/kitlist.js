const deleteBtns=document.querySelectorAll('.delete-btn');
const moveBtns=document.querySelectorAll('.btn-move');

const deletetKit=(id)=>{
    if(window.confirm("Voulez-vous vous séparez de ce kit ? cette action est irréversible")){
        const idToDelete=document.getElementById('id-delete');
        idToDelete.value=id;
        const formDelete=document.getElementById('form-delete');
        formDelete.submit();
    }
}

const moveKit=(id,stock)=>{
    if(stock===0) {
        return;
    }
    if(window.confirm("Voulez-vous déplacer ce kit ?")) {
        const idToMove=document.getElementById('id-move');
        idToMove.value=id;
        const stockToMove=document.getElementById('new-stock');
        stockToMove.value=stock;
        const formMove=document.getElementById('form-move');
        formMove.submit();
    }
}

deleteBtns.forEach((btn)=>{
    const id=btn.dataset.id;
    btn.addEventListener('click',()=>{
        deletetKit(id);
    });
});

moveBtns.forEach((btn)=>{
    const id=parseInt(btn.dataset.id);
    btn.addEventListener('click',()=>{
        const selector=document.getElementById(`newStock${id}`);
        moveKit(id,parseInt(selector.value));
    })
})