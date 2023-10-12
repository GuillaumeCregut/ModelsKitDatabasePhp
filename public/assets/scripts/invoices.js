const detailBtns=document.querySelectorAll('.detail-btn');
const HideOrdersBtn=document.getElementById('order-show-btn');
const showNewModelModalBtn=document.querySelector('.new-model-add');
const bodyOrder=document.getElementById('order-list-body');
const test=document.getElementById('test');

let mypopup=null;
let modelPopup=null;
let isOrdersShown=false;
let modelInArray=[];

const openDetailPopup=(ref,key)=>{
    if(mypopup==null || mypopup.closed){
        mypopup=window.open(
           `./profil_popup?ref=${ref}&key=${key}`,
            'test',
            `popup,
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
        //Remove form array
        const tempArray=modelInArray.filter((idarray)=>idarray!==id);
        modelInArray=tempArray;
        console.log(modelInArray);
    }
}

const addQttyModel=(id,qty)=>{
    //Find Span Qtty with Id;
    const spansQtty=document.querySelectorAll('.span-qtty-model');
    let span=null;
    spansQtty.forEach((spanQty)=>{
        console.log(spanQty);
        if(parseInt(spanQty.dataset.id)===id){
            span=spanQty;
        }
    })
    console.log(span);
    //Get value
    const oldQty=parseInt(span.textContent);
    const newQty=oldQty+qty;
    //If value ==0 delete row
    if(newQty<=0){
        /*todo*/
        removeRow(id);
    }
    //Change Value
    else{
        span.textContent=newQty;
        console.log('change qtty',id,qty)
    }
}


function addModelToList(model){
    //Check if model added is in table before
    if(modelInArray.includes(model.id)){
        addQttyModel(model.id,model.qty);
        return;
    }
    modelInArray.push(model.id);
    const newRow=document.createElement('tr');
    newRow.classList.add('new-order-row-item');
    newRow.dataset.id=model.id;
    const newName=document.createElement('td');
    newName.classList.add('orders-cell');
    newName.textContent=model.name;
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
    //to do =>action
    addQtyBtn.dataset.id=model.id;
    newQtty.appendChild(addQtyBtn);
    newRow.appendChild(newQtty);
    const newPrice=document.createElement('td');
    newPrice.classList.add('orders-cell');
    newPrice.textContent=model.price;
    newRow.appendChild(newPrice);
    //Add those info to form
    /*todo*/
    bodyOrder.appendChild(newRow);
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