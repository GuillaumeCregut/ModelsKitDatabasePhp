const checkboxes=document.querySelectorAll('input.cb_user_valid');
checkboxes.forEach((cb)=>{
    cb.addEventListener('change',()=>{
        changeUserStatus(cb.dataset.id,cb.checked);
    })
})

const listRole=document.querySelectorAll('select.select_user_role');
listRole.forEach((list)=>{
    list.addEventListener('change',()=>{
        changeUserRole(list.dataset.id, list.value);
    })
})

const changeUserStatus=(id,status)=>{
    console.log(id,status);
}

const changeUserRole=(id,role)=>{
    
}