if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
const fileUpdloader=document.getElementById('new-picture');
const formAdd=document.getElementById('form-add');
const selectsAdd=document.querySelectorAll('.new');

selectsAdd.forEach((select)=>{
    select.addEventListener('change',()=>{
        select.classList.remove('wrong');
    });
});

formAdd.addEventListener('submit',(e)=>{
    
    const childsSelect=formAdd.querySelectorAll('select');
    childsSelect.forEach((child)=>{
        if(parseInt(child.value)===0){
            child.classList.add('wrong');
            e.preventDefault();
        }
    });
});

//Drag and Drop file

const dropAreaOuter=document.getElementById('file-drop');
const inner=document.getElementById('box-inner');
dropAreaOuter.addEventListener('dragenter',()=>{
    dropAreaOuter.classList.add('outerHiglighted');
    inner.classList.add('innerHighlighted');
});
dropAreaOuter.addEventListener('dragleave',()=>{
    dropAreaOuter.classList.remove('outerHiglighted');
    inner.classList.remove('innerHighlighted');
});

dropAreaOuter.addEventListener('dragover',()=>{
    dropAreaOuter.classList.add('outerHiglighted');
    inner.classList.add('innerHighlighted');
});

dropAreaOuter.addEventListener('drop',()=>{
    dropAreaOuter.classList.remove('outerHiglighted');
    inner.classList.remove('innerHighlighted');
});

fileUpdloader.addEventListener('change',()=>{
    console.log(fileUpdloader.files)
    const file=fileUpdloader.files[0];
    const mimeType=file.type;
    if(!(mimeType==='image/jpeg') && !(mimeType==='image/png') ){
        console.log('pas bon');
    }
    const url=URL.createObjectURL(file);
    const image=document.getElementById('new-picture-display');
    image.src=url;
    image.classList.add('display-image');
});