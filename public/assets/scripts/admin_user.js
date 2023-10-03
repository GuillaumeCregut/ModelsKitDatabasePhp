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
    const myInit = {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
        body:JSON.stringify({idUser:id, newStatus:status})
      };
    console.log(id,status);
    fetch('http://modelskit:8080/api_userRank',myInit)
    .then((response)=>response.json())
    .then(json=>console.log(json));
}

const changeUserRole=(id,role)=>{

}