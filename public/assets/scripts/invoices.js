const detailBtns=document.querySelectorAll('.detail-btn');
const HideOrdersBtn=document.getElementById('order-show-btn');
const showNewModelModalBtn=document.querySelector('.new-model-add');

let mypopup=null;
let modelPopup=null;
let isOrdersShown=false;


const openDetailPopup=(ref,key)=>{
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
});

HideOrdersBtn.addEventListener('click',()=>{
    const listOrders=document.querySelector('.list-order-container');
    listOrders.classList.toggle('list-order-deployed');
    isOrdersShown=!isOrdersShown;
    if(isOrdersShown){
        HideOrdersBtn.textContent='Cacher';
    }else{
        HideOrdersBtn.textContent='Afficher';
    }
});

function addModelToList(model){
    console.log(model);
}


showNewModelModalBtn.addEventListener('click',()=>{
    if(modelPopup==null || modelPopup.closed){
        modelPopup=window.open(
           `./profil_model`,
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
        modelPopup.focus();
    }
})