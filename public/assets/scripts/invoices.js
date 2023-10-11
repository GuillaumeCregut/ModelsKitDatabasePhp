const detailBtns=document.querySelectorAll('.detail-btn');
let mypopup=null;


const openDetailPopup=(ref,key)=>{
    console.log(ref);
    if(mypopup==null || mypopup.closed){
        mypopup=window.open(
           `./profil_popup?ref=${ref}&key=${key}`,
            'test',
            `popup,
            width=640px,
            height=480px,
            top=50px,
            left=100px,
            toolbar=no,
            status=no,
            menubar=no,
            scrollbars=yes`
        )
    }else{
        mypopup.focus();
    }
}

detailBtns.forEach((btn)=>{
    const ref=btn.dataset.id;
    const key=btn.dataset.key;
    btn.addEventListener('click',()=>{
        openDetailPopup(ref,key);
    })
})