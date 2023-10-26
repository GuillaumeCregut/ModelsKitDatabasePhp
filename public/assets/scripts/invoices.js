const detailBtns=document.querySelectorAll('.detail-btn');
const HideOrdersBtn=document.getElementById('order-show-btn');
const showNewModelModalBtn=document.querySelector('.new-model-add');
const bodyOrder=document.getElementById('order-list-body');
const formAddOrder=document.getElementById('new-order-form');
const refOrder=document.getElementById('new-ref');
const orderSupplier=document.getElementById('new-provider');
const dateOrder=document.getElementById('new-date');


let mypopup=null;
let modelPopup=null;
let isOrdersShown=false;
let modelInArray=[];
const toastDetails={
    timer: 5000,
    success:{
        icon: "fa-circle-check",
        classname: "toast_success"
    },
    error:{
        icon: "fa-circle-xmark",
        classname:"toast_error"
    }
}

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

const removeRow=(id)=>{
    const rows=document.querySelectorAll('.new-order-row-item');
    let removeRowSel=null;
    rows.forEach((row)=>{
        if(parseInt(row.dataset.id)===id){
            removeRowSel=row;
        }
    })
    if(removeRowSel){
        bodyOrder.removeChild(removeRowSel);
        const tempArray=modelInArray.filter((idarray)=>idarray!==id);
        modelInArray=tempArray;
    }
}

const addQttyModel=(id,qty)=>{
    const spansQtty=document.querySelectorAll('.span-qtty-model');
    let span=null;
    spansQtty.forEach((spanQty)=>{
        if(parseInt(spanQty.dataset.id)===id){
            span=spanQty;
        }
    })
    const oldQty=parseInt(span.textContent);
    const newQty=oldQty+qty;
    if(newQty<=0){
        removeRow(id);
    }
    else{
        span.textContent=newQty;
    }
}


function addModelToList(model){
    if(modelInArray.includes(model.id)){
        addQttyModel(model.id,model.qty);
        return;
    }
    modelInArray.push(model.id);
    const newRow=document.createElement('tr');
    newRow.classList.add('new-order-row-item');
    newRow.dataset.id=model.id;
    const newName=document.createElement('td');
    const inputHidden=document.createElement('input');
    inputHidden.setAttribute("type","hidden");
    inputHidden.setAttribute('name','lines[]');
    const valueInput=`${model.id};${model.price};${model.qty}`;
    inputHidden.setAttribute("value",valueInput);
    inputHidden.className="hidden-line-values";
    newName.appendChild(inputHidden);
    newName.classList.add('orders-cell');
    const newNameSpan=document.createElement('span');
    newNameSpan.textContent=model.name;
    newName.appendChild(newNameSpan);
    newRow.appendChild(newName);
    const newBrand=document.createElement('td');
    newBrand.classList.add('orders-cell');
    newBrand.textContent=model.brand;
    newRow.appendChild(newBrand);
    const newScale=document.createElement('td');
    newScale.classList.add('orders-cell');
    newScale.textContent=model.scale;
    newRow.appendChild(newScale);
    const newQtty=document.createElement('td');
    newQtty.classList.add('orders-cell');
    newQtty.classList.add('orders-cell-qtty');
    const minusBtn=document.createElement('span');
    minusBtn.classList.add('minusQtty');
    minusBtn.textContent="-";
    minusBtn.addEventListener('click',()=>{
        addQttyModel(model.id,-1);
    })
    minusBtn.dataset.id=model.id;
    newQtty.appendChild(minusBtn);
    const newQttySpan=document.createElement('span');
    newQttySpan.className="span-qtty-model";
    newQttySpan.textContent=model.qty;
    newQttySpan.dataset.id=model.id;
    newQtty.appendChild(newQttySpan);
    const addQtyBtn=document.createElement('span');
    addQtyBtn.classList.add('addQtty');
    addQtyBtn.textContent="+";
    addQtyBtn.addEventListener('click',()=>{
        addQttyModel(model.id,1);
    })
    addQtyBtn.dataset.id=model.id;
    newQtty.appendChild(addQtyBtn);
    newRow.appendChild(newQtty);
    const newPrice=document.createElement('td');
    newPrice.classList.add('orders-cell');
    newPrice.textContent=model.price;
    newRow.appendChild(newPrice);
    bodyOrder.appendChild(newRow);
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
});


formAddOrder.addEventListener('submit',(e)=>{
    const supplierValue=orderSupplier.value;
    const dateValue=dateOrder.value;
    const refValue=refOrder.value;
    const orderLines=document.querySelectorAll('.hidden-line-values');
    if(orderLines.length===0 || refValue==='' || supplierValue==0 || dateOrder===''){
        e.preventDefault();
        launchFlash(toastDetails.error,'Veuillez remplir tous les champs');
    }
})

const launchFlash=(typeFlash,message)=>{
    if(document.getElementsByClassName('toast_notifications').length===0)
    {
        const flashContainer=document.createElement('ul');
        flashContainer.classList.add('toast_notifications');
        document.body.appendChild(flashContainer);
    }
    flashContainer=document.getElementsByClassName('toast_notifications')[0];
    const toast=document.createElement('li');
    toast.className=typeFlash.classname;
    toast.classList.add('toast');
    const divToast=document.createElement('div');
    divToast.className="toast_column";
    const icon=document.createElement('i');
    icon.classList.add('fa-solid');
    icon.classList.add(typeFlash.icon);
    const spanMessage=document.createElement('span');
    spanMessage.innerText=message;
    divToast.appendChild(icon);
    divToast.appendChild(spanMessage);
    const closeIcon=document.createElement('i');
    closeIcon.classList.add('fa-solid');
    closeIcon.classList.add('fa-xmark');
    closeIcon.addEventListener('click',()=>removeToast(toast));
    toast.appendChild(divToast);
    toast.appendChild(closeIcon);
    flashContainer.appendChild(toast);
    toast.timeouId=setTimeout(()=>removeToast(toast),toastDetails.timer);
}
