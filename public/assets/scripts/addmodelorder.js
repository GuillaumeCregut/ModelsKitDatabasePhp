const addButton=document.getElementById('add-button');
const radioModel=document.querySelectorAll('.radio-model');
const qttyContainer=document.getElementById('qtty');
const priceContainer=document.getElementById('price');

let selectedModel=null;

addButton.addEventListener('click',()=>{
    //Vérfier si tous les champs sont OK;
    if(!selectedModel){
        return;
    }
    const qttyValue=parseInt(qttyContainer.value);
    const priceValue=parseFloat(priceContainer.value);
    let error=false;
    if(isNaN(qttyValue) || qttyValue<=0 ){
        qttyContainer.classList.add('wrong');
        error=true;
    }
    else{
        qttyContainer.classList.remove('wrong');
    }
    if(isNaN(priceValue) || priceValue<=0){
        priceContainer.classList.add('wrong');
        error=true;
    }
    else{
        priceContainer.classList.remove('wrong');
    }
    if(!error){
        selectedModel.price=priceValue;
        selectedModel.qty=qttyValue;
        window.opener.addModelToList(selectedModel);
        window.close();
    }
})

const setModel=(brand,name, scale,id)=>{
    selectedModel={
        name : name,
        id:id,
        brand: brand,
        scale:scale
    }
}

radioModel.forEach((rm)=>{
    const rmBrand=rm.dataset.brand;
    const rmScale=rm.dataset.scale;
    const rmName=rm.dataset.name;
    const rmId=parseInt(rm.value);
    rm.addEventListener('change',()=>{
        setModel(rmBrand,rmName,rmScale,rmId);
    })
})

