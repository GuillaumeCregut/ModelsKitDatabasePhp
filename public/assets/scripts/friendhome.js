const cards=document.querySelectorAll('.friend-model-card');

cards.forEach((card)=>{
    const id=card.dataset.id;
    card.addEventListener('click',()=>{
        const input=document.getElementById('id_build');
        input.value=id;
        const form=document.getElementById('form-go');
        form.submit();
    })
})