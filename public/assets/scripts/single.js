const form=document.getElementById('form-add');
const newName=document.getElementById('new-name');
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
form.addEventListener('submit',(event)=>{
    if (newName.value===''){
        event.preventDefault();
        newName.classList.add('wrong');
    }
});

newName.addEventListener('keypress',()=>{
        newName.classList.remove('wrong');
})