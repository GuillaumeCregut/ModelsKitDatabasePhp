const flipperCards=document.querySelectorAll('.card-flip'); //Replace with all
const likeButtons=document.querySelectorAll('.like-card-btn');
const addCartButtons=document.querySelectorAll('.cart-add-card');
const removeButtons=document.querySelectorAll('.delete-card');
const updateButtons=document.querySelectorAll('.update-card');

//Redirect to update page
const updateCart=(id)=>{
    location.href = `/?model=${id}`;
}

//Send to Api like info
const sendLike=(id,value,btn)=>{
    const heart=btn.querySelector('.model-like');
    heart.classList.toggle('model-like-true');
}

//Send to Api cart info
const sendCart=(id)=>{

    console.log(id);
};

//Send deleteCard
const sendDelete=(id, name)=>{
    if(confirm(`Voulez-vous supprimer ${name} ?`)){
        const formDelete=document.getElementById('form-delete-model');
        const hiddenId=document.getElementById('id_hidden');
        hiddenId.value=id;
        formDelete.submit();
        console.log(id);
    }
}

//Flip card
flipperCards.forEach((flipperCard)=>{
    flipperCard.addEventListener('click',()=>{
        const innerCard=flipperCard.children[0];
        innerCard.classList.toggle('turned');
    });
});

//Like Button
likeButtons.forEach((likeBtn)=>{
    likeBtn.addEventListener('click',()=>{
        const id=likeBtn.dataset.id;
        const oldLike=likeBtn.dataset.like;
        let like=false;
        if(oldLike==='false'){
            like=true;
        }
        sendLike(id,like,likeBtn);
    });
});


//Cart buttons
addCartButtons.forEach((cartBtn)=>{
    cartBtn.addEventListener('click',()=>{
        const id=cartBtn.dataset.id;
        sendCart(id);
    });
});


//RemoveCard
removeButtons.forEach((removeBtn)=>{
    removeBtn.addEventListener('click',()=>{
        const id=removeBtn.dataset.id;
        const name=removeBtn.dataset.name;
        sendDelete(id,name);
    });
});


//Update buttons
updateButtons.forEach((updateBtn)=>{
    updateBtn.addEventListener('click',()=>{
        const id=updateBtn.dataset.id;
        updateCart(id);
    });
});
